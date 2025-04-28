<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) && !isset($_SESSION['guest'])) {
    header('location:login.php');
    exit();
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (isset($_POST['add_to_cart'])) {
    if (!$user_id) {
        echo "<script>showRegisterModal();</script>";
    } else {
        $pro_name = $_POST['product_name'];
        $author_name = $_POST['author_name'];
        $pro_price = $_POST['product_price'];
        $pro_quantity = $_POST['product_quantity'];
        $pro_image = $_POST['product_image'];

        $check = mysqli_query($conn, "SELECT * FROM `cart` WHERE name='$pro_name' AND user_id='$user_id'") or die('Query failed');

        if (mysqli_num_rows($check) > 0) {
            $message[] = 'Already added to cart!';
        } else {
            mysqli_query($conn, "INSERT INTO `cart`(user_id, name,author,price, quantity, image) VALUES ('$user_id','$pro_name','$author_name','$pro_price','$pro_quantity','$pro_image')") or die('Query failed');
            $message[] = 'Product added to cart!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Page</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="home.css">

    <style>
        /* Custom Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 350px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-content h2 {
            font-size: 22px;
            margin-bottom: 10px;
        }

        .modal-content p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .modal-btn {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .modal-btn button {
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        .register-btn {
            background: #007BFF;
            color: white;
        }

        .close-btn {
            background: #ccc;
            color: black;
        }
        
    </style>
</head>

<body>

    <?php include 'user_header.php'; ?>

    <section class="products_cont">
        <div class="pro_box_cont">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('Query failed');

            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                    <form action="" method="post" class="pro_box">
                        <img src="./uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                        <h3><?php echo $fetch_products['name']; ?></h3>
                        <h4><?php echo $fetch_products['author']; ?></h4>
                        <p>Rs. <?php echo $fetch_products['price']; ?>/-</p>

                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name'] ?>">
                        <input type="number" name="product_quantity" min="1" value="1">
                        <input type="hidden" name="author_name" value="<?php echo $fetch_products['author'] ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">

                        <?php if (!$user_id) { ?>
                            <button type="button" class="product_btn" onclick="showRegisterModal();">
                                Add to Cart
                            </button>
                        <?php } else { ?>
                            <input type="submit" value="Add to Cart" name="add_to_cart" class="product_btn">
                        <?php } ?>
                    </form>
            <?php
                }
            } else {
                echo '<p class="empty">No Products Added Yet!</p>';
            }
            ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <h2>Want to Add to Cart?</h2>
            <p>You need to register or log in first.</p>
            <div class="modal-btn">
                <button class="register-btn" onclick="window.location.href='register.php';">Register</button>
                <button class="close-btn" onclick="closeRegisterModal();">Close</button>
            </div>
        </div>
    </div>

    <script>
        function showRegisterModal() {
            document.getElementById('registerModal').style.display = 'flex';
        }

        function closeRegisterModal() {
            document.getElementById('registerModal').style.display = 'none';
        }
    </script>

    <script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>
    <script src="script.js"></script>

</body>

</html>
