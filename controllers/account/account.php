<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);


$user_id = $_SESSION['user'];
$account = $db->query("SELECT * FROM users WHERE _id = $user_id",[
    "user_id" => $user_id
])->find();





include base_path("views/account/account.view.php");
