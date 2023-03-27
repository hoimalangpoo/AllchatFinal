<?php
session_start();
require_once '../model/db.php';

if (!isset($_SESSION['user'])) {
    header("location: login.php");
}


if (isset($_POST['message']) && isset($_POST['recieve'])) {
    $messages = $_POST['message'];
    $recieve_id = $_POST['recieve'];
    $sender_id = $_SESSION['user'];
    $sendmsg = $conn->prepare("INSERT INTO chat(messages, sender_id, recieve_id)VALUES(:messages, :sender_id, :recieve_id)");
    $sendmsg->bindParam(":messages", $messages);
    $sendmsg->bindParam(":sender_id", $sender_id);
    $sendmsg->bindParam(":recieve_id", $recieve_id);
    $result = $sendmsg->execute();
    if ($result) {
        $msg = $conn->prepare("SELECT * FROM conversations WHERE (user1 = :sender_id AND user2 = :recieve_id)
                                                                OR  (user2 = :recieve_id AND user1 = :sender_id)");
        $msg->bindParam(":sender_id", $sender_id);
        $msg->bindParam(":recieve_id", $recieve_id);
        $msg->execute();

        define('TIMEZONE', 'Asia/Bangkok');
        date_default_timezone_set(TIMEZONE);

        $time = date("h:i a");
        if ($msg->rowCount() == 0) {
            $conver = $conn->prepare("INSERT INTO conversations (user1, user2)VALUES(:user1, :user2)");
            $conver->bindParam(":user1", $sender_id);
            $conver->bindParam(":user2", $recieve_id);
            $conver->execute();
        }
?>

        <p class="rtext align-self-end border rounded p-2 ">
            <?= $messages ?>
            <small class="d-block"><?= $time ?> </small>
        </p>

<?php
    }
}
