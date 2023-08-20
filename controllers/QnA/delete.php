<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$qa_id = $_GET['id'];

try {
    $addQA = $db->query("DELETE FROM announceqa WHERE qa_id = :qa_id",[
        "qa_id" => $qa_id
    ]);

    header("location: /chat");
} catch (PDOException $e) {
    echo $e->getMessage();
}
