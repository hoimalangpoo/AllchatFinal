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

            <?php 
                    // โดยที่ $ชื่อตัวแปร = new mysqli($servername, $username, $password, $dbname)
                    $connect = new mysqli('localhost', 'root', '', 'allchat');

                    // ทำการ check connection ว่าถูกต้องหรือไม่
                    if ($connect->connect_error) {
                            die("Something wrong.: " . $connect->connect_error);
                    }?>


                <?php 
                    $sql = "SELECT * FROM users";
                    $result = $connect->query($sql);
                ?>

<body>
  <section class=" min-vh-100">
    <?php require base_path('views/navbar/navbar.php'); ?>
    <div class="container-fluid">
      <div class="row mt-3" id="accordionExample">
        <?php require base_path('views/navbar/slidebar.php'); ?>
        <div class="col">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5>สร้างกลุ่ม</h5>
            </div>
                
            <span>สร้างชื่อกลุ่ม<br>
                    <input type="text" class="namegroup col-3 align-center" placeholder="พิมพ์ชื่อกลุ่ม"></a>
                </span>
                <div class="container">
                    
                    <table >
                        <thead>
                            <tr>
                                <th class="choose bg-warning " width="5%">เลือกเพื่อน</th>
                                
                            </tr>
                            </thead>
                        
                        
                    
                    <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr >
                            
                            <th class="name " style="width: 90%;">
                                <?php echo $row['name']; ?>
                                
                                
                            </th>
                            <th style="width: 10%;">
                            <input type="checkbox" class="check  pull-right" check="checked">
                            </th>
                            
                            </tr>
                           
                            
                            
                            
                            <?php endwhile ?>
                        </tbody>
                        
                    </table>
                
                </div>
                <span>
                <button type="button" class="btn  text-dark bg-warning  ">สร้างกลุ่ม</button>
                </span>
                
          </div>
        </div>
        

      </div>

    </div>
  </section>


</body>
<script src="js/chat.js"></script>  

<style>
  body {
    background-image: url(ภาพ/background.jpg);
  }

  

  .btn:hover {
    background-color: #ffffff;

  }
  * {
    margin: 0;
    padding: 0;
    box-sizing: 0;
    }

    body {
        font-size: 16px;
        font-family: Arial, Helvetica, sans-serif;
        background-color: #F2F3F4;
        color: #273746;
    }

    .container {
        align-items: center;
        margin-top: 3rem;
        width: 700px;
        
    }
    h4 {
        margin-top: 20px;
        margin-bottom: 20px;
        
    }
    thead {
        
        position: sticky;
        top: 0px;
        
    }
    table {
        border: 1px solid #5D6D7E;
        text-align: center;
    }
    th {
        height: 50px;
        vertical-align: center;
        
    }
    .name {
        text-align: left;
        padding-left: 30px;
    }
    tr th .check {
        margin: 0 auto;
        margin-right: 10rem;
        
    }
    span {
        font-size: 25px;
        margin-top: 20px;
        text-align: center;
    }

    span .namegroup {
        font-size: 15px;
        margin-top: 10px;
    }
    button {
        margin-top: 16px;
        align-items: center;
        width: 500px;
    }
    tbody {
    max-height: 200px; /* กำหนดความสูงสูงสุดของ tbody */
    overflow-y: auto; /* ทำให้ tbody เป็น scrollable ในแนวตั้ง */
    display: block; /* ทำให้ tbody เป็น block element */
}
</style>

</html>