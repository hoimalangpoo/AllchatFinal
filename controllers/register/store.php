<?php
use Core\App;
use Core\Database;
$db = App::resolve(Database::class);

if (isset($_POST['register'])){
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['c_password'];
    $telephone = $_POST['tel'];
    $agency = $_POST['agency'];
  
    if($password != $confirm_password){
        header("location: /");
    }else{
            $check_email = $db->query("SELECT * FROM users WHERE email = :email",[
                "email" => $email
            ])->find();
            if($check_email){
                header('location: /');
                exit();
            }else{
                $passHash = password_hash($password, PASSWORD_DEFAULT);
                $db->query("INSERT INTO users(email,password,name,telephone,agency)VALUES(:email, :password, :name, :telephone, :agency)",[
                    "email" => $email,
                    "password"=> $passHash,
                    "name"=> $name,
                    "telephone"=> $telephone,
                    "agency"=> $agency,
                ]);

                header("location: /login");
                exit();
            }
       
    }
}