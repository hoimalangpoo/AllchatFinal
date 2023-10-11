<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$userid = $_SESSION['user'];
if (isset($group['group_id'])) {
    $members = $db->query("SELECT users.name, users._id, group_users.role FROM users JOIN group_users 
    ON users._id = group_users.user_id WHERE group_id = :groupid;", [
        "groupid" => $group['group_id']
    ])->findAll();
}


// check($member);

include base_path("views/group/chatgroupinfo.view.php");
