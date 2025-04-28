<?php
include 'config.php';
session_start();


require 'vendor/autoload.php';
use Razorpay\Api\Api;

$keyId = "rzp_test_5ibSUgMDlbF8SS";
$keySecret = "QBWC2BUAnMAVNDP3Y4XeaV7d";
$api = new Api($keyId, $keySecret);

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
    exit;
}

if (isset($_POST['order_btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = $_POST['number'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products = [];

    
    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('Query failed');
    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }
    $total_products = implode(', ', $cart_products);

    if ($cart_total == 0) {
        echo "<script>alert('Your cart is empty');</script>";
    } else {
        if ($method == "cash on delivery") {
          
            mysqli_query($conn, "INSERT INTO `orders` (user_id, name, number, email, method, address, total_products, total_price, placed_on, payment_status) 
            VALUES ('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on', 'Pending')") 
            or die('Query failed');
            mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('Query failed');
            echo "<script>alert('Order placed successfully!'); window.location.href='orders.php';</script>";
        } else {

            $orderData = [
                'receipt' => 'order_' . time(),
                'amount' => $cart_total * 100, 
                'currency' => 'INR',
                'payment_capture' => 1
            ];
            $order = $api->order->create($orderData);
            $razorpay_order_id = $order['id'];
            mysqli_query($conn, "INSERT INTO `orders` (user_id, name, number, email, method, address, total_products, total_price, placed_on, payment_status, razorpay_order_id) 
            VALUES ('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on', 'completed', '$razorpay_order_id')") 
            or die('Query failed');
            mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('Query failed');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="home.css">

</head>
<body>
<?php include 'user_header.php'; ?>
<section class="display_order">
  <h2>Ordered Products</h2>
  <?php
    $grand_total = 0;
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('Query failed');

    if(mysqli_num_rows($select_cart) > 0){
      while($fetch_cart = mysqli_fetch_assoc($select_cart)){
        $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
        $grand_total += $total_price;
  ?>
  <div class="single_order_product">
    <img src="./uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
    <div class="single_des">
      <h3><?php echo $fetch_cart['name']; ?></h3>
      <p>Rs. <?php echo $fetch_cart['price']; ?></p>
      <p>Quantity: <?php echo $fetch_cart['quantity']; ?></p>
    </div>
  </div>
  <?php
      }
    } else {
      echo '<p class="empty">Your cart is empty</p>';
    }
  ?>
  <div class="checkout_grand_total"> GRAND TOTAL: <span>Rs. <?php echo $grand_total; ?>/-</span> </div>
</section>
<section class="contact_us">
    <form action="" method="post" id="checkout-form">
        <h2>Add Your Details</h2>
        <input type="text" name="name" required placeholder="Enter your name">
        <input type="phone" name="number" required placeholder="Enter your number">
        <input type="email" name="email" required placeholder="Enter your email">
        <select name="method" id="payment_method">
            <option value="cash on delivery">Cash on Delivery</option>
            <option value="razorpay">Razorpay</option>
        </select>
        <textarea name="address" placeholder="Enter your address" required></textarea>
        <input type="submit" value="Place Your Order" name="order_btn" class="product_btn">
    </form>
</section>

<?php include 'footer.php'; ?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<?php if (isset($razorpay_order_id)) { ?>
  <script>
    var options = {
        key: "<?php echo $keyId; ?>",
        amount: "<?php echo $cart_total * 100; ?>",
        currency: "INR",
        name: "Book Bank",
        description: "Purchase Books",
        order_id: "<?php echo $razorpay_order_id; ?>",
        handler: function (response) {
            window.location.href = 'orders.php';
        }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
</script>
<?php } ?>

</body>
</html>
