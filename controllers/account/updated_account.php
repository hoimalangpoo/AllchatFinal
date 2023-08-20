<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

    if(isset($_SESSION['user']) && isset($_POST['rename'])){
        $rename = $_POST['renameuser'];
        $agency = $_POST['agency'];
        $userid = $_SESSION['user'];

        try {
            $updateuser = $db->query("UPDATE users set name = :rename, agency = :agency WHERE _id = :userid",[
                "userid" => $userid,
                "rename" => $rename,
                "agency" => $agency
            ]);
        
            if($updateuser){
                echo "<script>alert('แก้ไขสำเร็จ');window.location.replace('/account');</script>";
            }
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

    
?>