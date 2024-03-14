<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

if (isset($_POST['lineOAid'])) {
    $lineOAid = $_POST['lineOAid'];

    $access_token = $db->query("SELECT access_token FROM line_oa WHERE lineOAid = :lineOAid", [
        "lineOAid" => $lineOAid
    ])->find();


    header('Content-Type: application/json');
    echo json_encode($access_token);
}
