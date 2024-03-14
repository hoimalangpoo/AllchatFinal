<?php

use Core\App;
use Core\Database;
$db = App::resolve(Database::class);

$friend_id = $_GET['id'];
$user_id = $_SESSION['user'];
try {
    $check_friend = $db->query("SELECT * FROM friend WHERE (_from = :user_id AND _to = :friend_id) OR (_from = :friend_id AND _to = :user_id)", [
        "user_id" => $user_id,
        "friend_id" => $friend_id
    ])->find();
    
    if ($check_friend['status'] == 'F') {
    
        echo "<script>alert('คุณเป็นเพื่อนกันอยู่แล้ว');window.location.replace('/addfriend');</script>";
    
    } else if ($check_friend['_from'] == $user_id && $check_friend['_to'] == $friend_id && $check_friend['status'] == 'P') {
    
        echo "<script>alert('คุณส่งคำขอเป็นเพื่อนแล้ว');window.location.replace('/addfriend');</script>";
    
    } else if ($check_friend['status'] == 'D') {
    
        $fdecline = $db->query("UPDATE friend SET deleted_at = NULL, status = 'P' WHERE _from = :user_id AND _to = :friend_id",[
            "user_id" => $user_id,
            "friend_id" => $friend_id
        ]);
        echo "<script>alert('ส่งคำขอเป็นเพื่อนเรียบร้อย');window.location.replace('/addfriend');</script>";
    
    } else if (($check_friend['_from'] == $user_id && $check_friend['_to'] == $friend_id && $check_friend['status'] == 'P') || 
    ($check_friend['_from'] == $friend_id && $check_friend['_to'] == $user_id && $check_friend['status'] == 'P')) {
    
        echo "<script>alert('มีการส่งคำขอแล้วกรุณาตรวจสอบอีกครั้ง');window.location.replace('/addfriend');</script>";
        
    } else {
        
        $stmt = $db->query("INSERT INTO friend(_from,_to,status)VALUES(:user_id, :friend_id, 'P')",[
            "user_id" => $user_id,
            "friend_id" => $friend_id
        ]);
        echo "<script>alert('ส่งคำขอเป็นเพื่อนเรียบร้อย');window.location.replace('/addfriend');</script>";
    
    }
} catch (\Throwable $th) {
    // echo $e->getMessage();
}

