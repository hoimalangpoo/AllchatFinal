<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$qa_id = $_GET['id'];

try {
    date_default_timezone_set("Asia/Bangkok");
    $date = date('Y-m-d H:i:s');

    $del_QA = $db->query("UPDATE announceqa SET deleted_at = :timedelete WHERE qa_id = :qa_id ",[
        "qa_id" => $qa_id,
        "timedelete" => $date
    ]);


    header("location: /chat");
} catch (PDOException $e) {
    echo $e->getMessage();
}
