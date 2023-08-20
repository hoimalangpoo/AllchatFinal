<?php 
use Core\App;
use Core\Database;
$db = App::resolve(Database::class);


    $userid = $_SESSION['user'];

    $friends = $db->query("SELECT DISTINCT users._id, users.name FROM friend 
    INNER JOIN users ON friend._from = users._id OR friend._to = users._id WHERE 
    (friend._from = :userid OR friend._to = :userid)AND users._id NOT IN (:userid)  
    AND friend.status='F' AND friend.deleted_at IS NULL",[
        "userid" => $userid
    ])->findAll();
   



include base_path("views/friends/chat.view.php");