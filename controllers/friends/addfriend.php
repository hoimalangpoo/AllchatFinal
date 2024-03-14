<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$userid = $_SESSION['user'];
$r_friend = $db->query("SELECT * FROM friend WHERE _to = :userid AND status='P' AND deleted_at IS NULL", [
    "userid" => $userid
])->findAll();






include base_path("views/friends/addfriend.view.php");
