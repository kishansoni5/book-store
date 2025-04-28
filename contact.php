<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) && !isset($_SESSION['guest'])) {
    header('location:login.php');
    exit();
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (isset($_POST['send'])) {
    if (!isset($_SESSION['user_id'])) {
        echo "<script>showRegisterModal();</script>";
    } else {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $number = $_POST['number'];
        $msg = mysqli_real_escape_string($conn, $_POST['message']);

        $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

        if (mysqli_num_rows($select_message) > 0) {
            $message[] = 'Message sent already!';
        } else {
            mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
            $message[] = 'Message sent successfully!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Page</title>

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

    <section class="contact_us">
        <form action="" method="post" onsubmit="return checkGuest();">
            <h2>Contact Us!</h2>
            <input type="text" name="name" pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed" required placeholder="Enter your name">
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="phone" name="number" required pattern="[0-9]{10}" title="Enter a 10-digit number" placeholder="Enter your number">
            <textarea name="message" required placeholder="Enter your message" id="" cols="30" rows="10"></textarea>
            <input type="submit" value="Send Message" name="send" class="product_btn">
        </form>
    </section>

    <?php include 'footer.php'; ?>

    <!-- Guest Register/Login Modal -->
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <h2>Want to Send a Message?</h2>
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

        function checkGuest() {
            var isGuest = <?php echo isset($_SESSION['user_id']) ? 'false' : 'true'; ?>;
            if (isGuest) {
                showRegisterModal();
                return false;
            }
            return true;
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
