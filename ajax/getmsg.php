<?php

session_start();
require_once '../model/db.php';

if (!isset($_SESSION['user'])) {
    header("location: login.php");
}
if (isset($_POST['id_2'])) {
    $sender_id  = $_SESSION['user'];
    $recieve_id  = $_POST['id_2'];
    $msg = $conn->prepare("SELECT * FROM chat WHERE (sender_id = :recieve_id AND recieve_id = :sender_id)
                                              ORDER BY chat_id ASC");
    $msg->bindParam(":sender_id", $sender_id);
    $msg->bindParam(":recieve_id", $recieve_id);
    $msg->execute();
    if ($msg->rowCount() > 0) {
        $chats = $msg->fetchAll();
        foreach ($chats as $chat) {
            if ($chat['opened'] == 0) {
                $opened = 1;
                $chat_id = $chat['chat_id'];
                $checkopen = $conn->prepare("UPDATE chat SET opened = :opened WHERE chat_id = :chat_id");
                $checkopen->bindParam(":opened", $opened);
                $checkopen->bindParam(":chat_id", $chat_id);
                $checkopen->execute(); ?>

                <p class="ltext border rounded p-2 ">
                    <?= $chat['messages'] ?>
                    <small class="d-block">
                        <?= date("h:i a", strtotime($chat['created_at'])) ?>
                    </small>
                </p>

            <?php
            } 
        }
    }
}
