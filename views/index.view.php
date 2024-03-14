<!doctype html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>รวมแชท</title>

  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

</head>

<body>
  <?php if ($_SESSION['user'] ?? false) { ?>

    <section class=" min-vh-100">
      <?php require base_path('views/navbar/navbar.php'); ?>
      <div class="container-fluid">
        <div class="row mt-3" id="accordionExample" >
          <?php require base_path('views/navbar/slidebar.php'); ?>
          <div class="col ">
                <div>
                    <img src="ภาพ/logocolor.JPG" alt="img-fluid" alt="" id="imglogoin">
                </div>
                
            </div>
        </div>

      </div>
    </section>


  <?php } else { ?>
    <section class=" min-vh-100">
      <?php
      include('navbar/navbar.php'); ?>
      <div class="col ">
                <div>
                    <img src="ภาพ/logocolor.JPG" alt="img-fluid" alt="" id="imglogoout">
                </div>
                
            </div>
     
    </section>


  <?php } ?>


  <script src="js/bootstrap.esm.min.js"></script>

</body>
<script src="js/line_chat.js"></script>
<style>
  * {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
  }

  body {
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

#imglogoin{
  margin-left:25%;
  margin-top: 5%;
}

#imglogoout{
  margin-left:35%;
  margin-top: 5%;
}
        

</style>

</html>