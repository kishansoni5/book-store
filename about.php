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
    <title>About Page</title>

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

    <section class="about_cont">
        <img src="about1.jpg" alt="">
        <div class="about_descript">
            <h2>Why Choose Us?</h2>
            <p>With our extensive collection of books spanning various genres, you'll find the perfect read to satisfy your cravings. Our knowledgeable staff of passionate book enthusiasts is always ready to offer personalized recommendations and guide you toward hidden gems. We take pride in fostering an inclusive community, hosting engaging events, book clubs, and author meet-ups. Additionally, our seamless online presence allows you to browse, explore, and order books from the comfort of your home, ensuring secure transactions and timely deliveries.</p>
        </div>
    </section>

    <section class="questions_cont">
        <div class="questions">
            <h2>Have Any Queries?</h2>
            <p>At BookBank, we value your satisfaction and strive to provide exceptional customer service. If you have any questions, concerns, or inquiries, our dedicated team is here to assist you every step of the way.</p>
            <button class="product_btn" onclick="window.location.href='contact.php'">Contact Us</button>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <!-- Custom Register Modal -->
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
