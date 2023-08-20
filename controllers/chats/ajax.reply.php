<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);


$userid = $_SESSION['user'];



include base_path("views/chats/reply.ajax.php");