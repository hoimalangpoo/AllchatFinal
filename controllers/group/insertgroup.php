<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

if (isset($_POST['selected_values']) && isset($_POST['groupname'])) {
    unset($_SESSION['error']);

    $userid = $_SESSION['user'];
    $groupname = $_POST['groupname'];
    $selectedfriend = $_POST['selected_values'];

    $addgroup = $db->query("INSERT INTO groups (group_name, created_by) VALUES (:groupname, :userid)", [
        "groupname" => $groupname,
        "userid" => $userid,
    ]);

    if ($addgroup) {
        $group_id = $db->lastInsertId();

        $db->query("INSERT INTO group_users (user_id, group_id, role) VALUES (:userid, :group_id, 'head')",[
            "userid" => $userid,
            "group_id" => $group_id
        ]);
        
        foreach($selectedfriend as $friendId){
            $db->query("INSERT INTO group_users (user_id, group_id, role) VALUES (:friendId, :group_id, 'member')",[
                "friendId" => $friendId,
                "group_id" => $group_id
            ]);
        }

       

        header("location: /chatgroup");
    }


} else {
    $_SESSION['error'] = "กรุณาเลือกเพื่อนอย่างน้อย 1 คน";
    header("location: /creategroup");
}
