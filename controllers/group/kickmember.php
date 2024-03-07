<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

if (isset($_POST['groupid_kick_user']) && isset($_POST['userid_kick'])) {
    date_default_timezone_set("Asia/Bangkok");
    $date = date('Y-m-d H:i:s');

    $group_id = $_POST['groupid_kick_user'];

    $user_id = $_POST['userid_kick'];
    // check($group_id);
    $del_group = $db->query("UPDATE group_users SET deleted_at = :timedelete WHERE group_id = :group_id AND user_id = :user_id", [
        "group_id" => $group_id,
        "timedelete" => $date,
        "user_id" => $user_id
    ]);

    header("location: /chatgroup");
}
