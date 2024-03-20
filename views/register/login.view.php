<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รวมแชท</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/validation.js" defer></script>


    <?php require base_path('views/navbar/navbar.php'); ?>
</head>

<body>
    <section class="Form my-4 mx-5">
        <div class="container" style="margin-top: 5rem;">
            <div class="row ">
                <div class="col-lg-5">
                    <img src="/image_folder/logocolor.jpg" alt="img-fluid" alt="">
                </div>
                <div class="col-lg-7 my-4">
                    <h1 class="font-weight-bold py-4 pl-5">เข้าสู่ระบบ รวมแชท</h1>
                    <h4 class="pl-5">ระบบจัดการแชท</h4>



                    <form action="/login" method="POST">
                        <div class="form-row">
                            <div class="col-lg-7 pl-5">
                                <input name="email" type="email" placeholder="อีเมล" class="form-control my-3 p-2">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-7 pl-5">
                                <input name="password" type="password" placeholder="รหัสผ่าน" class="form-control p-2">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-7 pl-5">
                                <button name="login" type="submit" class="btn1 mt-3 mb-5">เข้าสู่ระบบ</button>
                            </div>
                        </div>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalForResetpass">ลืมรหัสผ่าน</a>
                        
                        <p class="pl-5">หากยังไม่มีบัญชีผู้ใช้กรุณา <a href="/register">สมัครสมาชิก</a>ที่นี่</p>
                    </form>
                </div>
            </div>
        </div>
    </section>




    <!-- Modal -->
    <div class="modal fade" id="modalForResetpass" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

   x
</body>


<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        background-image: url(../image_folder/background.jpg);
    }

    .row {
        background: white;
        border-radius: 30px;
        box-shadow: 10px 10px 10px gray;
    }

    img {
        border-top-left-radius: 30px;
        border-bottom-left-radius: 30px;
    }

    .btn1 {
        border: none;
        outline: none;
        height: 50px;
        width: 100%;
        background-color: #ffc107;
        color: black;
        border-radius: 4px;
        font-weight: bold;
    }

    .btn1:hover {
        background: #fff176;
        border: 1px solid;
        color: black;
    }
</style>

</html>