<?php 
$userid = $_SESSION['user'];

$friends = $db->query("SELECT users._id, users.name FROM friend 
JOIN users ON friend._from = users._id WHERE (friend._from = :userid OR friend._to = :userid)AND users._id NOT IN (:userid)  
AND friend.status='F' AND friend.deleted_at IS NULL",[
    "userid" => $userid
])->findAll();



include base_path("views/friends/chatroom.view.php");