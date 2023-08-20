<?php 
use Core\App;
use Core\Database;
$db = App::resolve(Database::class);


    $userid = $_SESSION['user'];

    $fromline = $db->query("SELECT * FROM line_oa WHERE by_user = :userid",[
        "userid" => $userid
    ])->findAll();  
   
    


include base_path("views/chats/chat.view.php");