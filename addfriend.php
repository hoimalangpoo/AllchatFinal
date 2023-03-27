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
      <?php
        include ('slidebar/slide-friend.php');?>
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
            $userid = $_SESSION['user'];
            if(isset($_SESSION['user'])){
                    $r_friend = $conn->prepare("SELECT * FROM friend WHERE _to = :userid AND status='P' AND deleted_at IS NULL");
                    $r_friend->bindParam(":userid", $userid);
                    $r_friend->execute();
                    if($r_friend-> rowCount() > 0){ 
                        foreach ($r_friend as $result) { ?>
                            <?php 
                                 $request = $result[0];
                                 $data = $conn->prepare("SELECT * FROM users WHERE _id = :fid");
                                 $data->bindParam(":fid", $request);
                                 $data->execute();
                                 $row = $data->fetch(PDO::FETCH_ASSOC);
                                 $id = $row['_id']; ?>
                                <li class="list-group-item mb-3"><i class="fs-4 bi-person-circle"></i> <?php echo $row['name'] ?> 
                                <a href="back/faccept.php?id=<?php echo $id ?>"><button type="button" class="btn btn-success btn-lg text-dark" >รับคำขอ</button></a>
                                <a href="back/fdecline.php?id=<?php echo $id ?>"><button type="button" class="btn btn-danger btn-lg text-dark" >ไม่ยอมรับคำขอ</button></a>
                                </li>
                                
                            <?php        
                        } 
        
               } ?>
            </ul>
            <?php } ?>
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
                    <form method="POST" action="addfriend.php">
                      <div class="form-group">
                          <input type="text" name="friendSearch" class="form-control mb-2" id="FormControlInput1" placeholder="ค้นหาด้วยอีเมลหรือเบอร์โทรศัพท์">
                          <input type="submit" name="search" class="btn btn-warning text-dark" value="ค้นหา">
                      </div>
                    </form> 
                        
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                <?php
         if (isset($_POST['search'])){
            $search = $_POST['friendSearch'];
          
                try {
                    $data = $conn->prepare("SELECT * FROM users WHERE email LIKE :search OR telephone LIKE :search");
                    $data->bindParam(":search", $search);
                    $data->execute();
                    if($data-> rowCount() > 0){ 
                        foreach ($data as $result) {
                            $id = $result['_id'] ?>
                            <?php if($result['_id']==$_SESSION['user']) {?>
                                <li class="list-group-item"><i class="fs-4 bi-person-circle"></i> ไม่พบข้อมูลในระบบ </li>
                            <?php }else{ ?>
                            <li class="list-group-item"><i class="fs-4 bi-person-circle"></i> 
                                <?php echo $result['name'] ?>
                                <a href="back/friend_request.php?id=<?php echo $id ?>" class="btn btn-success btn-lg text-dark ml-2" role="button" aria-disabled="true">Add</a>
                            </li>
                                
              <?php }}}else{ ?>
                        <li class="list-group-item"><i class="fs-4 bi-person-circle"></i> ไม่พบข้อมูลในระบบ </li>
              <?php }
                    
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            
        }
        ?>
        </ul>


    
</body>

<style>
  body{
    background-image: url(ภาพ/background.jpg);
  }
  .btn:hover{
    background-color: #ffffff;
    
  }
</style>
</html>