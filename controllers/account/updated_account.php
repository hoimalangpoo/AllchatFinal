<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
// check($_FILES['profileImage']["name"] );
if (!empty($_FILES['profileImage']['name'])) {
    $rename = $_POST['renameuser'];
    $agency = $_POST['agency'];
    $email = $_POST['reemail'];
    $phone = $_POST['rephone'];
    $userid = $_SESSION['user'];

    $maxFileSize = 524288000;
    if ($_FILES['profileImage']['size'] > $maxFileSize) {
        echo "<script>alert('ไฟล์รูปภาพมีขนาดใหญ่เกิน 500 MB');window.location.replace('/account');</script>";
        exit();
    }
    if ($_FILES['profileImage']['type'] == 'image/jpeg') {
        $imageContent = file_get_contents($_FILES['profileImage']['tmp_name']);
        $profileImageName = $_FILES['profileImage']['name'];
        $profileImageDestination = "ภาพ/" . $profileImageName;
        move_uploaded_file($imageContent, $profileImageDestination);
        $profile = $imageContent;
        
    try {
        $updateuser = $db->query("UPDATE users set name = :rename, agency = :agency, email = :email, telephone = :phone, profile = :profile WHERE _id = :userid", [
            "userid" => $userid,
            "rename" => $rename,
            "email" => $email,
            "phone" => $phone,
            "agency" => $agency,
            "profile" => $profile
        ]);

        if ($updateuser) {
            echo "<script>alert('แก้ไขสำเร็จ');window.location.replace('/account');</script>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    } else {
        echo "<script>alert('กรุณาเลือกไฟล์ JPEG');window.location.replace('/account');</script>";
        exit();
        
    }

} else {
    $rename = $_POST['renameuser'];
    $agency = $_POST['agency'];
    $email = $_POST['reemail'];
    $phone = $_POST['rephone'];
    $userid = $_SESSION['user'];

    try {
        $old_pic = $db->query("SELECT profile FROM users WHERE _id = :userid", [
            "userid" => $userid
        ])->findAll();

        $updateuser = $db->query("UPDATE users set name = :rename, agency = :agency, email = :email, telephone = :phone WHERE _id = :userid", [
            "userid" => $userid,
            "rename" => $rename,
            "email" => $email,
            "phone" => $phone,
            "agency" => $agency
        ]);

        if ($updateuser) {
            echo "<script>alert('แก้ไขสำเร็จ');window.location.replace('/account');</script>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}