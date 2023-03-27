<?php

session_start();
require_once 'model/db.php';
if (!isset($_SESSION['user'])) {
    header("location: login.php");
}


if ($_POST['action'] == 'insert_chat') {

    $user_id = $_SESSION['user'];
    $recieve_id = $_POST['to_user_id'];
    $messages = $_POST['chat_message'];

    try {
        $sendchat = $conn->prepare("INSERT INTO chat(messages, sender_id, recieve_id, status)
        VALUES(:messages, :user_id, :recieve_id, 1)");

        $sendchat->bindParam(":messages", $messages);
        $sendchat->bindParam(":sender_id", $user_id);
        $sendchat->bindParam(":recieve_id", $recieve_id);
        $sendchat->execute();
?>
       
<?php } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>