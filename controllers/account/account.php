<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);


$user_id = $_SESSION['user'];
$account = $db->query("SELECT users.name, users.email, users.telephone, agency.agency, agency.id, users.profile FROM users 
                       JOIN agency ON users.agency = agency.id
                       WHERE users._id = $user_id", [
    "user_id" => $user_id
])->find();

$imageUrl = base64_encode($account['profile']);


// check($imageUrl);

include base_path("views/account/account.view.php");