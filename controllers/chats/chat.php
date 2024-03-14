<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);



$userid = $_SESSION['user'];

$fromline = $db->query("
-- กรณีที่มีกลุ่มและเป็นสมาชิกในกลุ่ม
SELECT line_oa.*
FROM line_oa
JOIN groups ON line_oa.id = groups.for_line
JOIN group_users ON groups.group_id = group_users.group_id
WHERE (groups.created_by != :userid AND group_users.user_id = :userid) AND groups.deleted_at IS NULL AND group_users.deleted_at IS NULL

UNION

-- กรณีที่ไม่มีกลุ่มและเป็นคนสร้าง
SELECT line_oa.*
FROM line_oa
WHERE line_oa.by_user = :userid AND line_oa.id NOT IN (SELECT for_line FROM groups)

-- กรณีที่มีกลุ่มและเป็นคนสร้าง
UNION

SELECT line_oa.*
FROM line_oa
JOIN groups ON line_oa.id = groups.for_line
WHERE groups.created_by = :userid ",[
    "userid" => $userid
])->findAll();

// check($fromline);





include base_path("views/chats/chat.view.php");