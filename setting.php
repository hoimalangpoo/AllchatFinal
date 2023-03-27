<?php 
session_start();
require_once 'model/db.php';
if(!isset($_SESSION['user'])){
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<body>
  <section class=" min-vh-100">
  <?php
    include ('navbar/nav-page.php');?>
    <div class="container-fluid">
      <div class="row mt-3">
      <?php include ('slidebar/slidebar-connect-page1.php');?>
        <div class="col">
            <div class="card-sm">
                <div class="card-body">
                <div class="row">
                    <div class="social-login">
                        
                        <div class="social-login-element">
                            <img src="ภาพ/facebook.png" alt="facebook-image" class="rounded-circle">
                            <span>เข้าสู่ระบบด้วย Facebook Page</span>
                        </div>
                    </div>  
                </div>  
                <div class="row mt-3">
                    <div class="social-login">
                        
                        <div class="social-login-element">
                            <img src="ภาพ/line-OA.jpg" alt="facebook-image" class="rounded-circle">
                            <span>เข้าสู่ระบบด้วย LINE Official Account</span>
                        </div>
                    </div>  
                </div>      
            </div>
        </div>
  </section>

  <script src="js/bootstrap.esm.min.js"></script>

</body>
<style>
  body{
    background-image: url(ภาพ/background.jpg);
  }
  .social-login-element {
            width: 27rem;
            height: 3.75rem;
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            border-radius: 5px;
            border: 0.5px solid gray;
            display: flex;
            justify-content: center;
            align-items: center;
            
        }

        .social-login-element img {
            width: 1.875rem;
            height: 1.875rem;
            position: relative;
            top: 0;
            left: -0.625rem;
        }

        .social-login-element:hover {
            background-color: #fff9c4;
        }
</style>
</html>