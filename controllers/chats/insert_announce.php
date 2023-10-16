<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
if (isset($_POST['message']) && isset($_POST['linech'])) {
    $sender_id = $_SESSION['user'];
    $messages = $_POST['message'];
    $recieve_id = $_POST['linech'];
    $linech = $_POST['linech'];
    $prefix = "announce";

    $sendmsg = $db->query("INSERT INTO line_announce(messages, prefix, sender_id, recieve_id, to_line)VALUES(:messages, :prefix, :sender_id, :recieve_id, :linech)", [
        "messages" => $messages,
        "sender_id" => $sender_id,
        "recieve_id" => $recieve_id,
        "linech" => $linech,
        "prefix" => $prefix
    ]);

    define('TIMEZONE', 'Asia/Bangkok');
    date_default_timezone_set(TIMEZONE);
    $time = date("h:i a");


?>

    <p class="rtext align-self-end border rounded p-2 mb-2">
        ประกาศ : <?= $messages ?>
        <small class="d-block"><?= $time ?> </small>
    </p>

<?php
}
