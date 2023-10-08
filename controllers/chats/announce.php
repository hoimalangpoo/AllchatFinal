<?php 
$userid = $_SESSION['user'];

$announces = $db->query("SELECT announceqa.* FROM announceqa JOIN users ON users.agency = announceqa.by_agency
WHERE users._id = :userid;",[
    "userid" => $userid
])->findAll();

include base_path("views/chats/announce.view.php");