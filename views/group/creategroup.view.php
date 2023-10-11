<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/chat.css">
  <link rel="stylesheet" href="css/index.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>



</head>

<body>
  <section class=" min-vh-100">
    <?php require base_path('views/navbar/navbar.php'); ?>
    <div class="container-fluid">
      <div class="row" id="accordionExample">
        <?php require base_path('views/navbar/slidebar.php'); ?>
        <div class="col">
          <div class="card">
            <?php if (isset($_SESSION['error'])) { ?>
              <div class="alert alert-danger">
                <?= $_SESSION['error'] ?>
              </div>
            <?php } ?>
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5>สร้างกลุ่ม</h5>
            </div>
            <form action="/insertgroup" method="post" class="text-center">

              <div class="container">
                <span>สร้างชื่อกลุ่ม<br>
                  <input type="text" name="groupname" class="namegroup col-3 align-center mb-3" placeholder="พิมพ์ชื่อกลุ่ม" required>
                </span>
                <table>
                  <thead>
                    <tr>
                      <th class="choose bg-warning " width="5%">เลือกเพื่อน</th>

                    </tr>
                  </thead>



                  <tbody>
                    <?php foreach ($friends as $friend) { ?>
                      <tr>

                        <th class="name " style="width: 90%;">
                          <?php echo $friend['name']; ?>


                        </th>
                        <th style="width: 10%;">
                          <input type="checkbox" class="check pull-right" name="selected_values[]" value="<?= $friend['_id'] ?>" check="checked">
                        </th>

                      </tr>




                    <?php } ?>
                  </tbody>

                </table>

                <button type="submit" class="btn text-dark bg-warning align-center mb-5">สร้างกลุ่ม</button>

              </div>


            </form>
          </div>
        </div>

     
      </div>

    </div>
  </section>


</body>
<script src="js/chat.js"></script>

</html>