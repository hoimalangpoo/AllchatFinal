<?php
    session_start();
    require_once '../model/db.php';
    if(isset($_SESSION['user']) && isset($_POST['rename'])){
        $rename = $_POST['renameuser'];
        $agency = $_POST['agency'];
        $userid = $_SESSION['user'];
    }
   
    try {
        $updateuser = $conn->prepare("UPDATE users set name = :rename, agency = :agency WHERE _id = :userid");
        $updateuser->bindParam(":userid", $userid);
        $updateuser->bindParam(":rename", $rename);
        $updateuser->bindParam(":agency", $agency);
        $updateuser->execute();
        $row = $updateuser->fetch(PDO::FETCH_ASSOC);
        if($updateuser-> rowCount() > 0){
            echo "<script>alert('แก้ไขชื่อสำเร็จ');window.location.replace('../account.php');</script>";
            
        }
        
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>