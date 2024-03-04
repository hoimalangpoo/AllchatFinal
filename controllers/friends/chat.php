<?php 
use Core\App;
use Core\Database;
$db = App::resolve(Database::class);


    $userid = $_SESSION['user'];

    $friends = $db->query("SELECT  users._id, users.name, users.email, users.telephone, agency.agency, users.profile FROM friend 
    JOIN users ON friend._from = users._id 
    JOIN agency ON users.agency = agency.id WHERE (friend._from = :userid OR friend._to = :userid)AND users._id NOT IN (:userid)  
    AND friend.status='F' AND friend.deleted_at IS NULL",[
        "userid" => $userid
    ])->findAll();
   
    // check($friends);




include base_path("views/friends/chat.view.php");