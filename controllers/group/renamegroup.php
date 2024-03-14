<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$user_id = $_SESSION['user'];
if (isset($_POST['renamegroup']) && isset($_POST['groupid'])) {
    $namegroup = $_POST['renamegroup'];
    $group_id = $_POST['groupid'];

    $del_group = $db->query("UPDATE groups SET group_name = :namegroup WHERE group_id = :group_id ", [
        "namegroup" => $namegroup,
        "group_id" => $group_id
    ]);

    header("location: /chatgroup");
}