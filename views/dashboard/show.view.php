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
  <link rel="stylesheet" href="css/dashboard.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
              <h5>แดชบอร์ด</h5>
              <div class="item-1">

                <select name="lineOa" id="lineOaDropdown">
                  <option value="0">เลือกบัญชีไลน์</option>
                  <?php
                  $filterlineOA = $db->query("SELECT * FROM line_oa")->findAll();

                  foreach ($filterlineOA as $lineOA) {
                    echo "<option value='" . $lineOA["id"] . "'>" . $lineOA["lineOaDisplayName"] . "</option>";
                  }

                  ?>
                </select>
                <button id="resetButton">ข้อมูลทั้งหมด</button>
                <script>
                  document.getElementById('resetButton').addEventListener('click', function() {

                    location.reload();
                  });
                </script>
              </div>

            </div>
            <div class="container">

              <div class="item item-2">

                <p> จำนวนผู้สอบถามทั้งหมด</p> <br>
                <span id="totalContacts"></span>

              </div>

              <div class="item item-3">

                <p>จำนวนคำถามทั้งหมด</p><br>
                <span id="totalQuestion"></span>

              </div>

              <div class="item item-4">

                <p>จำนวนการตอบกลับทั้งหมด</p><br>
                <span id="totalReplies"></span>

              </div>

            </div>
            <div class="col-3">
              <div class="item item-5">
                <P class="linechart">จำนวนคำถามในแต่ละเดือน</P>
                <canvas id="linechart"></canvas><br>
              </div>
              <div class="item item-7">
                <P class="barchart">จำนวนตอบกลับในแต่ละเดือน</P>
                <canvas id="barchart"></canvas><br>
              </div>
              <div class="item item-6">
                <p class="topmost clickable">รายชื่อผู้ตอบกลับข้อความทั้งหมด</p>
                <p>คลิกชื่อเพื่อดูกราฟการตอบกลับในแต่ละเดือน</p>
                <div id="result">
                  <table id="userTable" class="scrolldown">
                    <thead>
                      <tr>
                        <th>ชื่อผู้ใช้</th>
                        <th>จำนวนตอบกลับ</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php

                      $top_users = $db->query("SELECT u._id, u.name, COUNT(*) as message_count FROM line_reply r
                                              JOIN users u ON r.sender_id = u._id
                                              GROUP BY r.sender_id
                                              ORDER BY message_count DESC")->findAll();


                      // check($top_users);
                      foreach ($top_users as $top_user) {
                      ?>
                        <tr>
                          <td class="userlist" id="<?= $top_user["_id"] ?>"> <?= $top_user['name'] ?> </td>
                          <td class="numuserlist"> <?= $top_user['message_count'] ?></td>
                        </tr>
                      <?php
                      } ?>
                    </tbody>
                  </table>
                </div>



              </div>
            </div>

            <script src="js/dashboard.js"></script>
          </div>
        </div>


      </div>


  </section>





</body>
<script src="js/bootstrap.esm.min.js"></script>




</html>