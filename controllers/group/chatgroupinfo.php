<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$userid = $_SESSION['user'];
if (isset($group['group_id'])) {

    $friends = $db->query("SELECT users.name, users._id FROM users 
    LEFT JOIN group_users ON users._id = group_users.user_id AND group_users.group_id = :groupid
    JOIN friend ON users._id = friend._from 
    WHERE friend.status = 'F' AND friend._to = :userid 
    AND users._id != :userid 
    AND group_users.user_id IS NULL ", [
        "userid" => $userid,
        "groupid" => $group['group_id']
    ])->findAll();
}


// check($member);

include base_path("views/group/chatgroupinfo.view.php");
