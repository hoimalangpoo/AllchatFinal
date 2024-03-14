<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
if (isset($_POST['message']) && isset($_POST['group_id'])) {
    $messages = $_POST['message'];
    $group_id = $_POST['group_id'];
    $user_id = $_SESSION['user'];
    $sendmsg = $db->query("INSERT INTO group_messages(group_id, user_id, messages)VALUES(:group_id, :user_id, :messages)", [
        "group_id" => $group_id,
        "user_id" => $user_id,
        "messages" => $messages,
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