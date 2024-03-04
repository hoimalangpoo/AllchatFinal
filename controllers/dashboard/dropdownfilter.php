<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
if (isset($_POST['selectedValue'])) {
    $lineOA_id = $_POST['selectedValue'];

    $sqlContacts = "SELECT COUNT(*) AS totalContacts FROM line_contact WHERE lineOAid = :lineOAid";

    $sqlQuestion = "SELECT COUNT(*) AS totalQuestion FROM line_chat WHERE recieve_id = :lineOAid";

    $sqlReplies = "SELECT COUNT(*) AS totalReplies FROM line_reply WHERE from_ch = :lineOAid";

    $resultContacts = $db->query($sqlContacts, ['lineOAid' => $lineOA_id])->findAll();
    $resultQuestion = $db->query($sqlQuestion, ['lineOAid' => $lineOA_id])->findAll();
    $resultReplies = $db->query($sqlReplies, ['lineOAid' => $lineOA_id])->findAll();


    $BarchartData = $db->query("SELECT CONCAT(MONTHNAME(created_at),' 
    ',YEAR(created_at)) AS month_year, 
    COUNT(*) AS message_count FROM line_reply WHERE from_ch = :lineOAid GROUP BY month_year ORDER BY created_at", [
        "lineOAid" => $lineOA_id
    ])->findAll();


    $LinechartData = $db->query("SELECT CONCAT(MONTHNAME(created_at),' 
    ',YEAR(created_at)) AS month_year, 
    COUNT(*) AS message_count FROM line_chat WHERE recieve_id = :lineOAid GROUP BY month_year ORDER BY created_at ", [
        "lineOAid" => $lineOA_id
    ])->findAll();


    $userData = $db->query("SELECT users._id, users.name, COUNT(*) as message_count, groups.for_line as lineOAid FROM line_reply 
                JOIN group_users ON group_users.user_id = line_reply.sender_id
                JOIN users ON group_users.user_id = users._id
                JOIN groups ON groups.group_id = group_users.group_id
                WHERE groups.for_line = :lineOAid OR line_reply.from_ch = :lineOAid
                GROUP BY users._id, users.name ORDER BY message_count DESC", [
        "lineOAid" => $lineOA_id
    ])->findAll();
    // check($userData);
    echo json_encode([
        "totalContacts" => $resultContacts[0]['totalContacts'] ?? 0,
        "totalQuestion" => $resultQuestion[0]['totalQuestion'] ?? 0,
        "totalReplies" => $resultReplies[0]['totalReplies'] ?? 0,
        "BarchartData" => $BarchartData,
        "LinechartData" => $LinechartData,
        "userData" => $userData
    ]);

    // check($LinechartData);
} else {
    $sqlContacts = "SELECT COUNT(*) AS totalContacts FROM line_contact";

    $sqlQuestion = "SELECT COUNT(*) AS totalQuestion FROM line_chat";

    $sqlReplies = "SELECT COUNT(*) AS totalReplies FROM line_reply";

    $resultContacts = $db->query($sqlContacts)->findAll();
    $resultQuestion = $db->query($sqlQuestion)->findAll();
    $resultReplies = $db->query($sqlReplies)->findAll();

    echo json_encode([
        "totalContacts" => $resultContacts[0]['totalContacts'] ?? 0,
        "totalQuestion" => $resultQuestion[0]['totalQuestion'] ?? 0,
        "totalReplies" => $resultReplies[0]['totalReplies'] ?? 0
    ]);
}
