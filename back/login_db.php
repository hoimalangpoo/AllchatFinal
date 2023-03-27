<?php 
    session_start();
    require_once '../model/db.php';
    if (isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
      
            try {
                $data = $conn->prepare("SELECT * FROM users WHERE email = :email");
                $data->bindParam(":email", $email);
                $data->execute();
                $row = $data->fetch(PDO::FETCH_ASSOC);
                if($data-> rowCount() > 0){
                    
                    if($email == $row['email']){
                        if (password_verify($password, $row['password'])){
                            $_SESSION['user'] = $row['_id'];
                            header("location: ../connect_page1.php");
                        }else{
                            $_SESSION['error'] = 'รหัสผ่านผิด';
                            header("location: ../login.php");
                        }
                    }
                }else{
                    $_SESSION['error'] = "ไม่พบข้อมูลในระบบ";
                    header("location: ../login.php");
                }
                
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        
    }

?>