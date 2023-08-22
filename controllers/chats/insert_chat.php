<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
if (isset($_POST['message']) && isset($_POST['lineOAid']) && isset($_POST['linech'])) {
    $messages = $_POST['message'];
    $lineOAid = $_POST['lineOAid'];
    $linech = $_POST['linech'];
    $sender_id = $_SESSION['user'];

    $check_id = $db->query("SELECT MAX(line_contact.id) as id FROM line_contact JOIN line_oa 
    ON line_contact.lineOAid = line_oa.id
    WHERE line_oa.lineOAid = :lineOAid", [
        "lineOAid" => $lineOAid,
    ])->findAll();

    $line_user_id = $check_id[0]['id'];
    $sendmsg = $db->query("INSERT INTO line_chat(messages, sender_id, recieve_id, from_ch)VALUES(:messages, :sender_id, :line_user_id, :linech)", [
        "messages" => $messages,
        "sender_id" => $sender_id,
        "line_user_id" => $line_user_id,
        "linech" => $linech,
    ]);

    define('TIMEZONE', 'Asia/Bangkok');
    date_default_timezone_set(TIMEZONE);
    $time = date("h:i a");




?>

    <p class="rtext align-self-end border rounded p-2 mb-2">
        <?= $messages ?>
        <small class="d-block"><?= $time ?> </small>
    </p>

<?php
}
