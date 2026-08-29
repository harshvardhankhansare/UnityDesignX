<?php 
include('security.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <title>UnityDesignX</title>
  </head>
  <body>
    <nav class="main-navbar">
      <div class="navbar-container">
        <input type="checkbox" name="" id="checkbox" />
        <div class="hamburger-lines">
          <span class="line line1"></span>
          <span class="line line2"></span>
          <span class="line line3"></span>
        </div>
        <ul class="menu-items">
          <li><a href="index.php">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="design.php">Design</a></li>
          <li><a href="product.php">Product</a></li>
          <li><a href="#contact">Contact</a></li>
          <div class="right">
            <li>
              <a href="cart_page.php">
                <i class="fa-solid fa-cart-shopping">
                <?php 
                  $today = date('Y-m-d');
                  $id = $_SESSION['uid'];
                  $sql = "SELECT * FROM cart_info WHERE u_id='$id' AND c_time = '$today'";
                  $result = mysqli_query($conn , $sql);
                  $row_count = mysqli_num_rows($result);
                  echo $row_count;
                ?>
                </i>
              </a>
            </li>
            <li>
              <a href="profile.php">
                <?php
                $id= $_SESSION['uid'];

                $sql = "SELECT * FROM user_info WHERE uid='$id'";
                $res = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($res);
                echo $row['uname'];
                ?>
              </a>
            </li>
            <li>
              <a href="Logout_DB.php" style="font-size:20px;" >Logout</a>
            </li>
          </div>
        </ul>
        <div class="logo">
          <img src="assets/images/logo.png" alt="" />
        </div>
      </div>
    </nav>