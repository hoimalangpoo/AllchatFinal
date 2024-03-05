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
    <?php require base_path('views/navbar/navbar.php'); ?>
    <div class="container-fluid">
      <div class="row mt-3">
        <?php require base_path('views/navbar/slidebar.php'); ?>
        <div class="col">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center mb-3">
              <h5>คำขอเป็นเพื่อน</h5>
              <button type="button" class="btn bg-warning" data-bs-toggle="modal" data-bs-target="#modalAdd">
                + เพิ่มเพื่อน
              </button>
            </div>
            <ul class="list-group list-group-flush ">

              <?php
              foreach ($r_friend as $result) {
                $request = $result['_from'];
                $friend = $db->query("SELECT * FROM users WHERE _id = :fid", [
                  "fid" => $request
                ])->find();
                $id = $friend['_id']; 
                 ?>
                <li class="list-group-item mb-3 shadow-sm bg-body rounded ">  <?= $friend['name'] ?>
                  <div class="text-right">
                    <a href="/faccept?id=<?= $id ?>"><button type="button" class=" btn btn-success btn-lg text-dark">รับคำขอ</button></a>
                    <a href="/fdecline?id=<?= $id ?>"><button type="button" class="btn btn-danger btn-lg text-dark pull-right">ไม่ยอมรับคำขอ</button></a>
                  </div>

                </li>

              <?php
              }
              ?>
            </ul>

          </div>


        </div>

      </div>
    </div>
  </section>

  <!-----------------Modal Add friend---------------------------------------->
  <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAddLabel">เพิ่มเพื่อน</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <a href="#" class="list-group-item list-group-item-action fs-1 bi bi-person-plus-fill"></a>
          <div class="mb-3 mt-3">
            <form method="POST" action="/searchfriend">
              <div class="form-group">
                <input type="text" name="friendSearch" class="form-control mb-2" id="FormControlInput1" placeholder="ค้นหาด้วยอีเมลหรือเบอร์โทรศัพท์">
                <input type="submit" name="search" class="btn btn-warning text-dark" value="ค้นหา">
              </div>
            </form>

          </div>
        </div>
        <ul class="list-group list-group-flush">

          <?php
          if ($searchFriend) {
            foreach ($searchFriend as $sFriend) {
          ?>
              <li class="list-group-item"><i class="fs-4 bi-person-circle"></i>
                <?= $sFriend['name'] ?>
                <a href="/friend_req?id=<?= $sFriend['_id'] ?>" class="btn btn-success btn-lg text-dark ml-2" role="button" aria-disabled="true">ส่งคำขอ</a>
              </li>
            <?php }
          } else if ($searchFriend == NULL){   
          }else { ?>
            <li class="list-group-item"><i class="fs-4 bi-person-circle"></i> ไม่พบข้อมูลในระบบ </li>
          <?php }
          ?>
        </ul>


</body>

<style>
  body {
    background-image: url(ภาพ/background.jpg);
  }

  .btn:hover {
    background-color: #ffffff;

  }
</style>

</html>