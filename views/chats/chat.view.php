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
              <h5>บัญชีไลน์</h5>
            </div>
            <ul class="list-group list-group-flush ">
              <?php foreach ($fromline as $line) {
                $lineOA_id = $line["id"];
                $not_reply = $db->query("SELECT COUNT(*) as not_reply FROM line_chat where (reply = 0 AND recieve_id = :lineOA_id)", [
                  "lineOA_id" => $lineOA_id
                ])->find();

              ?>
                <li class="list-group-item linelist" id="<?= $line["lineOAid"] ?>lineOAid<?= $line["id"] ?>" data-touserid="<?= $line["lineOAid"] ?>" data-toggle="collapse" data-target="#collapse<?= $line["lineOAid"] ?>" aria-expanded="true" aria-controls="collapse<?= $line["lineOAid"] ?>">
                  <img src="<?= $line["profile"] ?>" class="img-fluid rounded-circle" alt="Responsive image"> <?= $line["lineOaDisplayName"] ?>
                  <span class="badge badge-secondary text-warning rounded-circle bg-dark mx-2"><?= $not_reply["not_reply"] ?></span>
                </li>

              <?php } ?>
            </ul>

          </div>
        </div>
        <?php require base_path('controllers/chats/chatroom.php'); ?>

        <?php require base_path('controllers/chats/announce.php'); ?>


      </div>

    </div>
  </section>


</body>
<script src="js/line_OA_chat.js"></script>
<script src="js/reply.js"></script>
<script src="js/search.js"></script>
<style>
  body {
    background-image: url(ภาพ/background.jpg);
  }

  .btn:hover {
    background-color: #ffffff;

  }
</style>

</html>