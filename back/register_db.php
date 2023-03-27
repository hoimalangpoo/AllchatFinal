<?php 
    session_start();
    require_once '../model/db.php';
    if (isset($_POST['register'])){
        $email = $_POST['email'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $confirm_password = $_POST['c_password'];
        $telephone = $_POST['tel'];
        $agency = $_POST['agency'];
      
        if($password != $confirm_password){
            $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
            header("location: ../register.php");
        }else{
            try {
                $check_email = $conn->prepare("SELECT email FROM users WHERE email = :email");
                $check_email->bindParam(":email", $email);
                $check_email->execute();
                $row = $check_email->fetch(PDO::FETCH_ASSOC);
                if($row['email']==$email){
                    $_SESSION['warning'] = 'อีเมลนี้มีอยู่แล้วกรุณากรอกอีเมลอื่น';
                    header("location: ../register.php");
                } else if(!isset($_SESSION['error'])){
                    $passHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO users(email,password,name,telephone,agency)VALUES(:email, :password, :name, :telephone, :agency)");
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":password", $passHash);
                    $stmt->bindParam(":name", $name);
                    $stmt->bindParam(":telephone", $telephone);
                    $stmt->bindParam(":agency", $agency);
                    $stmt->execute();
                    $_SESSION['success'] = "สมัครสมาชิกสำเร็จ! <a href='login.php'>เข้าสู่ระบบ</a>";
                    header("location: ../register.php");
                }else{
                    $_SESSION['error'] = "สมัครสมาชิกไม่สำเร็จ";
                    header("location: ../register.php");
                }
                
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

?>