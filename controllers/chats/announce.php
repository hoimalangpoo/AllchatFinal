<?php 
$userid = $_SESSION['user'];

$announces = $db->query("SELECT * FROM announceqa")->findAll();

include base_path("views/chats/announce.view.php");