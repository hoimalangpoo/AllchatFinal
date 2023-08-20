<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$friend_id = $_GET['id'];
$user_id = $_SESSION['user'];

try {
    $check_friend = $db->query("SELECT * FROM friend WHERE _from = :friend_id AND _to = :user_id", [
        "user_id" => $user_id,
        "friend_id" => $friend_id
    ])->find();
    if ($check_friend) {
        $faccept = $db->query("UPDATE friend SET status='F' WHERE status='P' AND _from = :friend_id AND _to = :user_id", [
            "user_id" => $user_id,
            "friend_id" => $friend_id
        ]);
        header("location: /chatfriend");
        if ($check_friend['status'] == 'D') {
            $fdecline = $db->query("UPDATE friend SET deleted_at = NULL, status = 'F' WHERE _from = :friend_id AND _to = :user_id", [
                "user_id" => $user_id,
                "friend_id" => $friend_id
            ]);
            header("location: /chatfriend");
        }
    } else {
        $faccept = $db->query("INSERT INTO friend(_from,_to,status)VALUES(:friend_id, :user_id, 'F')", [
            "user_id" => $user_id,
            "friend_id" => $friend_id
        ]);
        header("location: /chatfriend");
    }


    $check_friend2 = $db->query("SELECT * FROM friend WHERE _from = :user_id AND _to = :friend_id", [
        "user_id" => $user_id,
        "friend_id" => $friend_id
    ])->find();
    if ($check_friend2) {
        $faccept2 = $db->query("UPDATE friend SET status='F' WHERE status='P' AND _from = :user_id AND _to = :friend_id", [
            "user_id" => $user_id,
            "friend_id" => $friend_id
        ]);
        header("location: /chatfriend");
        if ($check_friend2['status'] == 'D') {
            $fdecline2 = $db->query("UPDATE friend SET deleted_at = NULL, status = 'F' WHERE _from = :user_id AND _to = :friend_id", [
                "user_id" => $user_id,
                "friend_id" => $friend_id
            ]);
            header("location: /chatfriend");
        }
    } else {
        $faccept2 = $db->query("INSERT INTO friend(_from,_to,status)VALUES(:user_id, :friend_id, 'F')", [
            "user_id" => $user_id,
            "friend_id" => $friend_id
        ]);
        header("location: /chatfriend");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
