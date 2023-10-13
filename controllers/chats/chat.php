<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);



$userid = $_SESSION['user'];

$fromline = $db->query("SELECT line_oa.* FROM line_oa 
JOIN groups ON line_oa.id = groups.for_line 
JOIN group_users ON groups.group_id = group_users.group_id
WHERE group_users.user_id = :userid",[
    "userid" => $userid
])->findAll();







include base_path("views/chats/chat.view.php");
