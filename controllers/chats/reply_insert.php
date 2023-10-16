<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
if (isset($_POST['message']) && isset($_POST['chat_id']) && isset($_POST['linech'])) {

    $messages = $_POST['message'];
    $chat_id = $_POST['chat_id'];
    $user_id = $_SESSION['user'];
    $linech = $_POST['linech'];

    $sendmsg = $db->query("INSERT INTO line_reply(messages, sender_id, chat_id, from_ch)VALUES(:messages, :user_id, :chat_id, :linech)", [
        "messages" => $messages,
        "user_id" => $user_id,
        "chat_id" => $chat_id,
        "linech" => $linech,
    ]);

    $reply = $db->query("UPDATE line_chat SET reply = 1 WHERE chat_id = :chat_id",[
        "chat_id" => $chat_id
    ]);


    define('TIMEZONE', 'Asia/Bangkok');
    date_default_timezone_set(TIMEZONE);
    $time = date("h:i a");




?>

    <p class="align-self-end border rounded p-2 mb-2">
        <?= $messages ?>
        <small class="d-block"><?= $time ?> </small>
    </p>

<?php
}
