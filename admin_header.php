<?php


if (isset($message) && is_array($message)): ?>
    <?php foreach ($message as $msg): ?>
        <div class="message">
            <span><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
    <?php endforeach; ?>

    <script>
       
        setTimeout(() => {
            document.querySelectorAll('.message').forEach(msg => {
                msg.classList.add('fade-out'); 
                setTimeout(() => msg.remove(), 1000);
            });
        }, 3000);
    </script>

    <style>
        .message {
            position: fixed;
            top: 100px;
            left: 50%;
            transform: translateX(-50%);
            background: #dc3545; 
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            z-index: 1000;
            opacity: 1;
            transition: opacity 1s ease-out, transform 1s ease-out;
        }

        .fade-out {
            opacity: 0;
            transform: translate(-50%, -30px); 
        }
       
    </style>
<?php endif; ?>

<header class="admin_header">
    <div class="header_navigation">
        <a href="admin_page.php" class="header_logo">Admin <span>Dashboard</span></a>

        <nav class="header_navbar">
            <a href="admin_page.php">Home</a>
            <a href="admin_products.php">Products</a>
            <a href="admin_orders.php">Orders</a>
            <a href="admin_users.php">Users</a>
            <a href="admin_messages.php">Messages</a>
        </nav>
        <div class="header_icons">
            <div id="menu_btn" class="fas fa-bars"></div>
            <div id="user_btn" class="fas fa-user"></div>
        </div>
        <div class="header_acc_box">
            <p>Username : <span><?php echo htmlspecialchars($_SESSION['admin_name'] ?? ''); ?></span></p>
            <p>Email : <span><?php echo htmlspecialchars($_SESSION['admin_email'] ?? ''); ?></span></p>
            <a href="logout.php" class="delete-btn">Logout</a>
        </div>
    </div>
</header>
