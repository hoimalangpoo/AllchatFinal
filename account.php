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
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
  <?php
  if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user'];
    $stmt = $conn->query("SELECT * FROM users WHERE _id = $user_id");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  ?>
  <section class=" min-vh-100">
    <?php
    include('navbar/nav-page.php'); ?>
    <div class="container-fluid">
      <div class="row mt-3">
        <?php
        include('slidebar/slide-account.php'); ?>
        <div class="col d-flex justify-content-center align-items-center ">
          <div class="card-sm  ">
            <div class="card-body ">
              <div class="row d-flex justify-content-center">
                <div class="col-sm-5">
                  <img src="ภาพ/avatar2.png" class="w-100 rounded-circle">
                </div>
              </div>
              <h2 class="data mt-5">ข้อมูลส่วนตัว</h2>
              <hr>
              <table class="table table-borderless my-4">
                <tbody>
                  <tr>
                    <td>
                      <h5>ชื่อผู้ใช้</h5>
                    </td>
                    <td><?php echo $row['name'] ?></td>
                    <td>
                      <button type="button" class="btn bg-warning" data-bs-toggle="modal" data-bs-target="#modalEditname">
                        แก้ไข
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h5>อีเมล</h5>
                    </td>
                    <td><?php echo $row['email'] ?></td>
                  </tr>
                  <tr>
                    <td>
                      <h5>เบอร์โทรศัพท์</h5>
                    </td>
                    <td><?php echo $row['telephone'] ?></td>
                  </tr>
                  <tr>
                    <td>
                      <h5>แผนก</h5>
                    </td>
                    <td><?php echo $row['agency'] ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-----------------Modal Add friend---------------------------------------->

  <div class="modal fade" id="modalEditname" tabindex="-1" aria-labelledby="modalEditnameLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditnameLabel">แก้ไขชื่อและหน่วยงาน</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="back/updated_account.php" method="POST">
          <div class="modal-body">
            <div class="mb-3">
              <input type="text" name="renameuser" class="form-control" id="FormControlInput1" placeholder="กรอกชื่อผู้ใช้ใหม่" value="<?php echo $row['name'] ?>">
              <select name="agency" class="form-select" aria-label="Default select example">
                <option disabled selected><?php echo $row['agency'] ?></option>
                <option value="งานบริหารและสารสนเทศ">งานบริหารและสารสนเทศ</option>
                <option value="งานรับเข้าศึกษาและการตลาด">งานรับเข้าศึกษาและการตลาด</option>
                <option value="งานบริการและทะเบียนการศึกษา">งานบริการและทะเบียนการศึกษา</option>
                <option value="งานหลักสูตรและสหกิจศึกษา">งานหลักสูตรและสหกิจศึกษา</option>
              </select>
            </div>
          </div>

          <div class="modal-footer">
            <button name="rename" type="submit" class="btn btn-warning">เสร็จสิ้น</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="js/bootstrap.esm.min.js"></script>

</body>
<style>
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
</style>

</html>