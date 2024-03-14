<?php 
$announces = $db->query("SELECT * FROM announceqa WHERE deleted_at IS NULL")->findAll();

include base_path("views/chats/announce.view.php");