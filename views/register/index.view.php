<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>รวมแชท</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <?php require base_path('views/navbar/navbar.php'); ?>
</head>

<body>
    <section class="Form my-4 mx-5">
        <div class="container">
            <div class="row ">
                <div class="col-lg-5">
                    <img src="ภาพ/logocolor.JPG" alt="img-fluid" alt="">
                </div>
                <div class="col-lg-7 my-2">
                    <h1 class="font-weight-bold py-3 pl-5">เริ่มใช้งาน รวมแชท</h1>
                    <h4 class="pl-5">ระบบจัดการแชท</h4>

                    <div class="social-login">

                        <div class="social-login-element ml-5">
                            <img src="ภาพ/line-icon.png" alt="line-image">
                            <span>เข้าสู่ระบบด้วย Line</span>
                        </div>
                    </div>
                    <p class="or pl-5">หรือ</p>
                    <form action="/register" method="POST">
                        <div class="form-row">
                            <div class="col-lg-7 pl-5">
                                <input name="email" type="email" placeholder="อีเมล" class="form-control my-2 p-2">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-7 pl-5">
                                <input name="name" type="name" placeholder="ชื่อ-นามสกุล" class="form-control p-2 my-2">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-7 pl-5">
                                <input name="tel" type="tel" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" placeholder="เบอร์โทรศัพท์" class="form-control p-2 ">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-7 pl-5">
                                <input name="password" type="password" placeholder="รหัสผ่าน" class="form-control p-2 my-2">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-7 pl-5">
                                <input name="c_password" type="password" placeholder="ยืนยันรหัสผ่าน" class="form-control p-2 my-2">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-7 pl-5">
                                <select name="agency" class="form-select" aria-label="Default select example">
                                    <option disabled selected>แผนก</option>
                                    <option value="1">งานบริหารและสารสนเทศ</option>
                                    <option value="2">งานรับเข้าศึกษาและการตลาด</option>
                                    <option value="3">งานบริการและทะเบียนการศึกษา</option>
                                    <option value="4">งานหลักสูตรและสหกิจศึกษา</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="col-lg-7 pl-5">
                                <button name="register" type="submit" class="btn1 mt-3 mb-5">สมัครสมาชิก</button>
                            </div>
                        </div>
                        <p class="pl-5">หากมีบัญชีอยู่แล้ว <a href="login.php">เข้าสู่ระบบ</a>ที่นี่</p>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <script src="js/bootstrap.esm.min.js"></script>

</body>


<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        background-image: url(ภาพ/background.jpg);
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




    .social-login-element {
        width: 20rem;
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
        width: 2rem;
        height: 2rem;
        position: relative;
        border-radius: 5px;
        top: 0;
        left: -0.625rem;
    }

    .social-login-element:hover {
        background-color: #fff9c4;
    }

    .or {
        margin-top: 1rem;
    }
</style>

</html>