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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

</head>

<body>
  <section class=" min-vh-100">
    <?php require base_path('views/navbar/navbar.php'); ?>
    <div class="container-fluid">
      <div class="row mt-3" id="accordionExample">
        <?php require base_path('views/navbar/slidebar.php'); ?>
        <div class="col">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5>เพื่อน</h5>
            </div>
            <ul class="list-group list-group-flush ">
              <?php foreach ($friends as $friend) { ?>
                <li class="list-group-item friendlist " id="<?php echo $friend["_id"] ?>" data-touserid="<?php echo $friend["_id"] ?>" data-toggle="collapse" data-target="#collapse<?php echo $friend["_id"] ?>" aria-expanded="true" aria-controls="collapse<?php echo $friend["_id"] ?>"><i class="fs-4 bi-person-circle"></i> <?php echo $friend["name"] ?>
                  <a href="unfriend.php?id=<?php echo $friend["_id"] ?>"><button type="button" class="btn btn-danger text-dark pull-right">ลบเพื่อน</button></a>
                </li>

              <?php } ?>
            </ul>

          </div>
        </div>
        <?php require base_path('controllers/friends/chatroom.php'); ?>

      </div>

    </div>
  </section>


</body>
<script src="js/chat.js"></script>  


</html>