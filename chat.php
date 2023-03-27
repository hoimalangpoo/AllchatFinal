<?php
session_start();
require_once 'model/db.php';

if (!isset($_SESSION['user'])) {
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
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/chat.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

</head>

<body>
  <section class=" min-vh-100">
    <?php
    include('navbar/nav-page.php'); ?>
    <div class="container-fluid">
      <div class="row mt-3" id="accordionExample">
        <?php
        include('slidebar/slide-chat.php'); ?>
        <div class="col">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5>เพื่อน</h5>
            </div>

            <?php
            echo '<ul class="list-group list-group-flush ">';
            $userid = $_SESSION['user'];
            if (isset($_SESSION['user'])) {
              $friend = $conn->prepare("SELECT * FROM friend WHERE _from = :userid OR _to = :userid AND status='F' AND deleted_at IS NULL");
              $friend->bindParam(":userid", $userid);
              $friend->execute();
              if ($friend->rowCount() > 0) {
                foreach ($friend as $result) { ?>
                  <?php
                  $request = $result[0];
                  $data = $conn->prepare("SELECT * FROM users WHERE _id = :fid");
                  $data->bindParam(":fid", $request);
                  $data->execute();
                  $row = $data->fetch(PDO::FETCH_ASSOC);
                  $id = $row['_id']; ?>
                  <?php if ($id == $_SESSION['user']) { ?>
                  <?php } else { ?>

                    <li class="list-group-item friendlist" id="<?php echo $id ?>" data-touserid="<?php echo $id ?>" data-toggle="collapse" data-target="#collapse<?php echo $id ?>" aria-expanded="true" aria-controls="collapse<?php echo $id ?>"><i class="fs-4 bi-person-circle"></i> <?php echo $row['name'] ?>
                      <a href="back/unfriend.php?id=<?php echo $id ?>"><button type="button" class="btn btn-danger text-dark pull-right">ลบเพื่อน</button></a>
                    </li>

              <?php }
                }
              } ?>
              </ul>
            <?php } ?>
          </div>
        </div>
        <?php include('chatroom.php'); ?>

        <?php include('announceQA/announce.php'); ?>
      </div>

    </div>
  </section>


</body>
<script src="js/chat.js"></script>


</html>