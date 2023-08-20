<?php
    session_start();
    require_once '../model/db.php';
    if(isset($_SESSION['user'])){
        $friend_id = $_GET['id'];
        $user_id = $_SESSION['user'];
    }
   
    try {
        $check_friend = $conn->prepare("SELECT * FROM friend WHERE _from = :friend_id AND _to = :user_id");
        $check_friend->bindParam(":user_id", $user_id);
        $check_friend->bindParam(":friend_id", $friend_id);
        $check_friend->execute();
        $row = $check_friend->fetch(PDO::FETCH_ASSOC);
        if($check_friend-> rowCount() > 0){
            $faccept = $conn->prepare("UPDATE friend SET status='F' WHERE status='P' AND _from = :friend_id AND _to = :user_id");
            $faccept->bindParam(":user_id", $user_id);
            $faccept->bindParam(":friend_id", $friend_id);
            $faccept->execute();
            header("location: ../chat.php");
            if($row['status'] == 'D'){
                $fdecline = $conn->prepare("UPDATE friend SET deleted_at = NULL, status = 'F' WHERE _from = :user_id AND _to = :friend_id");
                $fdecline->bindParam(":user_id", $user_id);
                $fdecline->bindParam(":friend_id", $friend_id);
                $fdecline->execute();
                header("location: ../chat.php");
            }
        }else{
            $faccept = $conn->prepare("INSERT INTO friend(_from,_to,status)VALUES(:friend_id, :user_id, 'F')");
            $faccept->bindParam(":user_id", $user_id);
            $faccept->bindParam(":friend_id", $friend_id);
            $faccept->execute();
            header("location: ../chat.php");
        }


        $check_friend = $conn->prepare("SELECT * FROM friend WHERE _from = :user_id AND _to = :friend_id");
        $check_friend->bindParam(":user_id", $user_id);
        $check_friend->bindParam(":friend_id", $friend_id);
        $check_friend->execute();
        $row = $check_friend->fetch(PDO::FETCH_ASSOC);
        if($check_friend-> rowCount() > 0){
            $faccept = $conn->prepare("UPDATE friend SET status='F' WHERE status='P' AND _from = :user_id AND _to = :friend_id");
            $faccept->bindParam(":user_id", $user_id);
            $faccept->bindParam(":friend_id", $friend_id);
            $faccept->execute();
            header("location: ../chat.php");
            if($row['status'] == 'D'){
                $fdecline = $conn->prepare("UPDATE friend SET deleted_at = NULL, status = 'F' WHERE _from = :user_id AND _to = :friend_id");
                $fdecline->bindParam(":user_id", $user_id);
                $fdecline->bindParam(":friend_id", $friend_id);
                $fdecline->execute();
                header("location: ../chat.php");
            }
        }else{
            $faccept = $conn->prepare("INSERT INTO friend(_from,_to,status)VALUES(:user_id, :friend_id, 'F')");
            $faccept->bindParam(":user_id", $user_id);
            $faccept->bindParam(":friend_id", $friend_id);
            $faccept->execute();
            header("location: ../chat.php");
        }
       
 
        
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>