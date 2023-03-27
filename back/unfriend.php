<?php
    session_start();
    require_once '../model/db.php';
    if(isset($_SESSION['user'])){
        $friend_id = $_GET['id'];
        $user_id = $_SESSION['user'];
    }
   
    try {
        date_default_timezone_set("Asia/Bangkok");
        $date = date('Y-m-d H:i:s');

        $fdecline = $conn->prepare("UPDATE friend SET deleted_at = :timedelete, status = 'D' WHERE _from = :friend_id AND _to = :user_id");
        $fdecline->bindParam(":user_id", $user_id);
        $fdecline->bindParam(":friend_id", $friend_id);
        $fdecline->bindParam(":timedelete", $date);
        $fdecline->execute();
        $fdecline = $conn->prepare("DELETE FROM friend WHERE _from = :user_id AND _to = :friend_id");
        $fdecline->bindParam(":user_id", $user_id);
        $fdecline->bindParam(":friend_id", $friend_id);
        $fdecline->execute();

        header("location: ../chat.php");
        
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>