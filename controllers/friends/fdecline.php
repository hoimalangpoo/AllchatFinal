<?php
 use Core\App;
 use Core\Database;
 
 $db = App::resolve(Database::class);
 $friend_id = $_GET['id'];
 $user_id = $_SESSION['user'];
   
    try {
        date_default_timezone_set("Asia/Bangkok");
        $date = date('Y-m-d H:i:s');

        $fdecline = $db->query("UPDATE friend SET deleted_at = :timedelete, status = 'D' WHERE _from = :friend_id AND _to = :user_id",[
            "user_id" => $user_id,
            "friend_id" => $friend_id,
            "timedelete" => $date,
        ]);
     
        $fdecline =$db->query("UPDATE friend SET deleted_at = :timedelete, status = 'D' WHERE _from = :user_id AND _to = :friend_id",[
            "user_id" => $user_id,
            "friend_id" => $friend_id,
            "timedelete" => $date,
        ]);

        header("location: /chatfriend");
        
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>