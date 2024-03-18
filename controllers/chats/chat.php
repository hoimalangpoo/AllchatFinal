<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);



$userid = $_SESSION['user'];

$fromline = $db->query("
SELECT line_oa.*
FROM line_oa
JOIN group_data ON line_oa.id = group_data.for_line
JOIN group_users ON group_data.group_id = group_users.group_id
WHERE (group_data.created_by != 46 AND group_users.user_id = 46) AND group_data.deleted_at IS NULL AND group_users.deleted_at IS NULL

UNION

SELECT line_oa.*
FROM line_oa
WHERE line_oa.by_user = 46 AND line_oa.id NOT IN (SELECT for_line FROM group_data)

UNION

SELECT line_oa.*
FROM line_oa
JOIN group_data ON line_oa.id = group_data.for_line
WHERE group_data.created_by = 46;
",[
    "userid" => $userid
])->findAll();

// check($fromline);





include base_path("views/chats/chat.view.php");