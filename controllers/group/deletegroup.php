<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$user_id = $_SESSION['user'];
if(isset($_POST['id_for_del'])){
    date_default_timezone_set("Asia/Bangkok");
    $date = date('Y-m-d H:i:s');

    $group_id = $_POST['id_for_del'];

    $del_group = $db->query("UPDATE groups SET deleted_at = :timedelete WHERE group_id = :group_id ",[
        "group_id" => $group_id,
        "timedelete" => $date
    ]);

    header("location: /chatgroup");
}