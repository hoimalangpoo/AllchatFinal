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
 
    $default_image_path = "ภาพ/default_user.jpg";
    $default_image_data = file_get_contents($default_image_path);
  
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
                $db->query("INSERT INTO users(email,password,name,telephone,agency,profile)VALUES(:email, :password, :name, :telephone, :agency, :default_image_data)",[
                    "email" => $email,
                    "password"=> $passHash,
                    "name"=> $name,
                    "telephone"=> $telephone,
                    "agency"=> $agency,
                    "default_image_data" => $default_image_data
                ]);

                header("location: /login");
                exit();
            }
       
    }
}