<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$userid = $_SESSION['user'];

$groups = $db->query("SELECT DISTINCT group_users.*, groups.* , users.profile FROM group_users 
JOIN users ON group_users.user_id = users._id 
JOIN groups ON group_users.group_id = groups.group_id
WHERE user_id = :userid AND groups.deleted_at IS NULL AND group_users.deleted_at IS NULL",[
    "userid" => $userid
])->findAll();

include base_path("views/group/chatgroup.view.php");