<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

if (isset($_POST['filter_user_id'])) {
    $filter_user_id = $_POST['filter_user_id'];
    
    $count_msg = $db->query("SELECT CONCAT(MONTHNAME(created_at),' 
    ',YEAR(created_at)) AS month_year, 
    COUNT(*) AS message_count FROM line_reply WHERE sender_id = :filter_user_id GROUP BY month_year ORDER BY created_at",[
        'filter_user_id' => $filter_user_id
    ])->findAll();
    // check($count_msg);   
    header('Content-Type: application/json');
    echo json_encode($count_msg);
}
else if (isset($_POST['filter_group_userid']) && isset($_POST['filter_group_lineOAid'])) {
    $filter_group_userid = $_POST['filter_group_userid'];
    $filter_group_lineOAid = $_POST['filter_group_lineOAid'];

    $count_msg = $db->query("SELECT COUNT(*) as message_count, 
    CONCAT(MONTHNAME(line_reply.created_at),' ',YEAR(line_reply.created_at)) AS month_year  FROM line_reply 
    JOIN group_users ON group_users.user_id = line_reply.sender_id
    JOIN users ON group_users.user_id = users._id
    JOIN groups ON groups.group_id = group_users.group_id
    WHERE groups.for_line = :filter_group_lineOAid AND line_reply.from_ch = :filter_group_lineOAid AND users._id = :filter_group_userid
    GROUP BY month_year ORDER BY line_reply.created_at;",[
        'filter_group_lineOAid' => $filter_group_lineOAid,
        'filter_group_userid' => $filter_group_userid
    ])->findAll();

    header('Content-Type: application/json');
    echo json_encode($count_msg);

} 
else {
    $count_msg = $db->query("SELECT CONCAT(MONTHNAME(created_at),' 
    ',YEAR(created_at)) AS month_year, 
    COUNT(*) AS message_count FROM line_reply GROUP BY month_year ORDER BY created_at")->findAll();
    // check($count_msg);   
    header('Content-Type: application/json');
    echo json_encode($count_msg);
}