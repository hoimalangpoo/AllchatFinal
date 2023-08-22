<?php 
$announces = $db->query("SELECT * FROM announceqa")->findAll();

include base_path("views/chats/announce.view.php");