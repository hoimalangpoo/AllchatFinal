<?php

function getchats($id1, $id2, $conn)
{
    $msg = $conn->prepare("SELECT * FROM chat WHERE (sender_id = :sender_id AND recieve_id = :recieve_id)
                                                OR  (sender_id = :recieve_id AND recieve_id = :sender_id)
                                                ORDER BY chat_id ASC");
    $msg->bindParam(":sender_id", $id1);
    $msg->bindParam(":recieve_id", $id2);
    $msg->execute();

    if ($msg->rowCount() > 0) {
        $chat = $msg->fetchAll();
        return $chat;
    } else {
        $chat = [];
        return $chat;
    }
}

function opened($id_1, $conn, $chats)
{
    foreach ($chats as $chat) {
        if ($chat['opened'] == 0) {
            $opened = 1;
            $chat_id = $chat['chat_id'];
            $checkopen = $conn->prepare("UPDATE chat SET opened = :opened WHERE sender_id = :sender_id AND chat_id = :chat_id");
            $checkopen->bindParam(":opened", $opened);
            $checkopen->bindParam(":sender_id", $id_1);
            $checkopen->bindParam(":chat_id", $chat_id);
            $checkopen->execute();
            
        }
    }
}
