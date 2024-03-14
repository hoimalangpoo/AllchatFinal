<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

if (isset($_POST['selected_values']) && isset($_POST['group_id'])) {

    $group_id = $_POST['group_id'];
    $selectedfriend = $_POST['selected_values'];
    // check($selectedfriend);

    foreach ($selectedfriend as $friendId) {
        $check_old_member = $db->query("SELECT user_id FROM group_users WHERE user_id = :friendId", [
            "friendId" => $friendId
        ])->find();
        // check($check_old_member);
        if ($check_old_member) {
            $db->query("UPDATE group_users SET deleted_at = NULL WHERE group_id = :group_id AND user_id = :friendId", [
                "group_id" => $group_id,
                "friendId" => $friendId
            ]);
        } else {
            $db->query("INSERT INTO group_users (user_id, group_id, role) VALUES (:friendId, :group_id, 'member')", [
                "friendId" => $friendId,
                "group_id" => $group_id
            ]);
        }
    }



    header("location: /chatgroup");
    exit;
    
}