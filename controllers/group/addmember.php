<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

if (isset($_POST['selected_values']) && isset($_POST['groupid'])) {

    $groupid = $_POST['groupid'];
    $selectedfriend = $_POST['selected_values'];


    foreach ($selectedfriend as $friendId) {
        $db->query("INSERT INTO group_users (user_id, group_id, role) VALUES (:friendId, :groupid, 'member')", [
            "friendId" => $friendId,
            "groupid" => $groupid
        ]);
    }



    header("location: /chatgroup");
}
