<?php
use Core\App;
use Core\Database;
$db = App::resolve(Database::class);

if (isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
  
    $check_email = $db->query("SELECT * FROM users WHERE email = :email",[
        "email" => $email
    ])->find();
    if($check_email){
        if (password_verify($password, $check_email['password'])){
            $_SESSION['user'] = $check_email['_id'];
            header("location: /");
            exit();
        }else{
            header("location: /login");
            exit();
        }
       
    }
    
}