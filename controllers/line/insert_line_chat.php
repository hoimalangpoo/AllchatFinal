<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
if (isset($_POST['message']) && isset($_POST['recieve'])) {
    $messages = $_POST['message'];
    $recieve_id = $_POST['recieve'];
    $sender_id = $_SESSION['user'];

    $check_id = $db->query("SELECT * FROM line_contact WHERE user_id = :recieve_id", [
        "recieve_id" => $recieve_id,
    ])->findAll();
    
    $line_user_id = $check_id['id'];
    $sendmsg = $db->query("INSERT INTO line_chat(messages, sender_id, recieve_id)VALUES(:messages, :sender_id, :line_user_id)", [
        "messages" => $messages,
        "sender_id" => $sender_id,
        "line_user_id" => $line_user_id,
    ]);

    define('TIMEZONE', 'Asia/Bangkok');
    date_default_timezone_set(TIMEZONE);
    $time = date("h:i a");




?>

    <p class="rtext align-self-end border rounded p-2 ">
        <?= $messages ?>
        <small class="d-block"><?= $time ?> </small>
    </p>

<?php
}
