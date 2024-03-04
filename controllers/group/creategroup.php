<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$userid = $_SESSION['user'];

$friends = $db->query("SELECT users.name, users._id FROM users JOIN friend ON users._id = friend._from 
WHERE friend.status = 'F' AND friend._to = :userid AND users._id != :userid",[
    "userid" => $userid
])->findAll();

$forline = $db->query("SELECT * FROM line_oa WHERE by_user = :userid",[
    "userid" => $userid
])->findAll();;
// check($friends);


include base_path("views/group/creategroup.view.php");