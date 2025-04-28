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
              msg.style.opacity = '0';
              setTimeout(() => msg.remove(), 500); 
          });
      }, 2000);
  </script>
<?php endif; ?>

<style>
        .message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #669bbc;
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
<header class="user_header">
  <div class="header_1">
    <div class="user_flex">
      <div class="logo_cont">
        <img src="book_logo.png" alt="">

        <a href="home.php" class="book_logo">BookBank</a>
      </div>


      <nav class="navbar">
        <a href="home.php">Home</a>
        <a href="about.php">About</a>
        <a href="shop.php">Shop</a>
        <a href="contact.php">Contact</a>
        <a href="orders.php">Orders</a>
      </nav>

      <div class="last_part">
        <div class="loginorreg">
          <p>New <a href="login.php">Login</a> | <a href="register.php">Register</a></p>
        </div>

        <div class="icons">
       
          <a class="fa-solid fa-magnifying-glass" href="search_page.php"></a>

          <div class="fas fa-user" id="user_btn"></div>
        
          <?php
          $select_cart_number=mysqli_query($conn,"SELECT * FROM `cart` where user_id='$user_id'") or die('query failed');
          $cart_row_number=mysqli_num_rows($select_cart_number);
          ?>

      <?php if(isset($_SESSION['user_id'])): ?>
      <a href="cart.php"><i class="fas fa-shopping-cart"></i><span class="quantity">(<?php echo $cart_row_number?>)</span></a>
      <?php else: ?>
      <a href="#" onclick="showRegisterModal(); return false;">
        <i class="fas fa-shopping-cart"></i><span class="quantity">(0)</span>
      </a>
<?php endif; ?>


          <div class="fas fa-bars" id="user_menu_btn"></div>

        </div>

      </div>
      <?php if (isset($_SESSION['guest'])): ?>
        <div class="header_acc_box">
        <p>Username : <span><?php echo "Guest"?></span></p>
        <p>Email : <span><?php echo ""?></span></p>
        <a href="logout.php" class="delete-btn">Logout</a>
        </div>
           
<?php endif; ?>
<div class="header_acc_box">
        <p>Username : <span><?php echo $_SESSION['user_name'];?></span></p>
        <p>Email : <span><?php echo $_SESSION['user_email'];?></span></p>
        <a href="logout.php" class="delete-btn">Logout</a>
      </div>



    </div>

  </div>

</header>