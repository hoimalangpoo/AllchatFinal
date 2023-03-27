<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=allchat", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected Database";
    } catch (PDOException $e) {
        echo "Connected Fail : " . $e->getMessage();
    }
?>