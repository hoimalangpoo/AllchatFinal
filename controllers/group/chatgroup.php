<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$userid = $_SESSION['user'];

$groups = $db->query("SELECT DISTINCT group_users.*, group_data.* , users.profile FROM group_users 
JOIN users ON group_users.user_id = users._id 
JOIN group_data ON group_users.group_id = group_data.group_id
WHERE user_id = :userid AND group_data.deleted_at IS NULL AND group_users.deleted_at IS NULL",[
    "userid" => $userid
])->findAll();

include base_path("views/group/chatgroup.view.php");