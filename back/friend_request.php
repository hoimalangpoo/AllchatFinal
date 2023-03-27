<?php
    session_start();
    require_once '../model/db.php';
    if(isset($_SESSION['user'])){
        $friend_id = $_GET['id'];
        $user_id = $_SESSION['user'];
    }
   
    try {
        $check_friend = $conn->prepare("SELECT * FROM friend WHERE _from = :user_id AND _to = :friend_id");
        $check_friend->bindParam(":user_id", $user_id);
        $check_friend->bindParam(":friend_id", $friend_id);
        $check_friend->execute();
        $row = $check_friend->fetch(PDO::FETCH_ASSOC);
        if($row['status'] == 'F'){
            echo "<script>alert('คุณเป็นเพื่อนกันอยู่แล้ว');window.location.replace('../addfriend.php');</script>";
            
        }else if($row['status'] == 'P'){
            echo "<script>alert('คุณส่งคำขอเป็นเพื่อนแล้ว');window.location.replace('../addfriend.php');</script>";
        }else if($row['status'] == 'D'){
            $fdecline = $conn->prepare("UPDATE friend SET deleted_at = NULL, status = 'P' WHERE _from = :user_id AND _to = :friend_id");
            $fdecline->bindParam(":user_id", $user_id);
            $fdecline->bindParam(":friend_id", $friend_id);
            $fdecline->execute();
            echo "<script>alert('ส่งคำขอเป็นเพื่อนเรียบร้อย');window.location.replace('../addfriend.php');</script>";
        }
        else{
            $stmt = $conn->prepare("INSERT INTO friend(_from,_to,status)VALUES(:user_id, :friend_id, 'P')");
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":friend_id", $friend_id);
            $stmt->execute();
            echo "<script>alert('ส่งคำขอเป็นเพื่อนเรียบร้อย');window.location.replace('../addfriend.php');</script>";
        }
        
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>