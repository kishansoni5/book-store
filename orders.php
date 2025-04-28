<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) && !isset($_SESSION['guest'])) {
    header('location:login.php');
    exit();
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Page</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="home.css">

    <style>
        /* Modal Styling */
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

        .modal-btn {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .register-btn {
            background: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        .close-btn {
            background: #ccc;
            color: black;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }
    </style>
</head>

<body>

    <?php include 'user_header.php'; ?>

    <section class="orders">
        <h2>Placed Orders</h2>
        <div class="orders_cont">
            <?php
            $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id='$user_id'") or die('query failed');

            if (mysqli_num_rows($order_query) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($order_query)) {
            ?>
                    <div class="orders_box">
                        <p>Placed on: <span><?php echo $fetch_orders['placed_on']; ?></span></p>
                        <p>Name: <span><?php echo $fetch_orders['name']; ?></span></p>
                        <p>Number: <span><?php echo $fetch_orders['number']; ?></span></p>
                        <p>Email: <span><?php echo $fetch_orders['email']; ?></span></p>
                        <p>Address: <span><?php echo $fetch_orders['address']; ?></span></p>
                        <p>Payment Method: <span><?php echo $fetch_orders['method']; ?></span></p>
                        <p>Your Orders: <span><?php echo $fetch_orders['total_products']; ?></span></p>
                        <p>Total Price: <span>Rs.<?php echo $fetch_orders['total_price']; ?>/-</span></p>
                        <p>Payment Status: 
                            <span style="color:<?php echo ($fetch_orders['payment_status'] == 'pending') ? 'red' : 'green'; ?>;">
                                <?php echo $fetch_orders['payment_status']; ?>
                            </span>
                        </p>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">No orders placed yet!</p>';
            }
            ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <!-- Guest Register/Login Modal -->
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <h2>Want to View Orders?</h2>
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

        // Automatically show modal for guests
        <?php if (!isset($_SESSION['user_id'])) { ?>
            showRegisterModal();
        <?php } ?>
        
    document.addEventListener("DOMContentLoaded", () => {
        let userBtn = document.getElementById("user_btn");
        let accbox = document.querySelector(".header_acc_box");
        let usernav = document.querySelector('.user_header .header_1 .user_flex .navbar');

        if (userBtn && accbox) {
            userBtn.addEventListener("click", () => {
                accbox.classList.toggle("active");
                usernav.classList.remove("active");
            });
        }
    });
    </script>

</body>

</html>
