<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);


$userid = $_SESSION['user'];


$fromline = $db->query("SELECT line_oa.*
    FROM users
    JOIN line_oa ON users.agency = line_oa.by_agency
    WHERE users._id = :userid;", [
    "userid" => $userid
])->findAll();







include base_path("views/chats/chat.view.php");
