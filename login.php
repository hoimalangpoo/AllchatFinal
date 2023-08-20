<?php 
session_start();
require_once 'model/db.php';
?>
<!doctype html>
<html lang="en">
  <head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>รวมแชท</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <?php
    include ('navbar/nav-login.php');?>
  </head>
  
  <body>
    <section class="Form my-4 mx-5">
        <div class="container">
            <div class="row ">
                <div class="col-lg-5">
                    <img src="ภาพ/yellow-bg.JPG" alt="img-fluid" alt="" >
                </div>
                <div class="col-lg-7 my-4">
                    <h1 class="font-weight-bold py-4">เข้าสู่ระบบ รวมแชท</h1>
                    <h4>ระบบจัดการแชท</h4>
                
                <div class="social-login">
                    
                    <div class="social-login-element">
                        <img src="ภาพ/facebook.png" alt="facebook-image">
                        <span>เข้าสู่ระบบด้วย Facebook</span>
                    </div>
                </div>
                <p class="or">หรือ</p>
                    <form action="back/login_db.php" method="POST">
                    <?php if(isset($_SESSION['error'])) { ?>
                        <div class="alert alert-danger col-lg-7" role="alert">
                            <?php 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php } ?>
                    <?php if(isset($_SESSION['success'])) { ?>
                        <div class="alert alert-success col-lg-7" role="alert">
                            <?php 
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                            ?>
                        </div>
                    <?php } ?>
                        <div class="form-row">
                            <div class="col-lg-7">
                                <input name="email" type="email" placeholder="อีเมล" class="form-control my-3 p-2">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-7">
                                <input name="password" type="password" placeholder="รหัสผ่าน" class="form-control p-2" >
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-7">
                                <button name="login" type="submit" class="btn1 mt-3 mb-5">เข้าสู่ระบบ</button>
                            </div>
                        </div>
                        <a href="#">ลืมรหัสผ่าน</a>
                        <p>หากยังไม่มีบัญชีผู้ใช้กรุณา <a href="register.php">สมัครสมาชิก</a>ที่นี่</p>
                    </form>
                </div>
            </div>
        </div>
    </section>  

    <script src="js/bootstrap.esm.min.js"></script>
    
  </body>


  <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body{
            background-image: url(ภาพ/background.jpg);
        }
        .row{
            background: white;
            border-radius: 30px;
            box-shadow: 10px 10px 10px gray;
        }
        img{
            border-top-left-radius: 30px;
            border-bottom-left-radius: 30px;
        }
        .btn1{
            border: none;
            outline: none;
            height: 50px;
            width: 100%;
            background-color: #ffc107;
            color: black;
            border-radius: 4px;
            font-weight: bold;
        }
        .btn1:hover{
            background: #fff176;
            border: 1px solid;
            color: black;
        }


       

        .social-login-element {
            width: 20rem;
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
        .or{
            margin-top: 1rem;
        }

    </style>

</html>