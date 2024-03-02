<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

if (isset($_POST['chat_id']) && isset($_POST['linech'])) {
    $sender_id  = $_SESSION['user'];
    $chat_id  = $_POST['chat_id'];
    $linech = $_POST['linech'];


    $msg = $db->query("SELECT line_reply.*
    FROM line_reply
    WHERE 
        (line_reply.sender_id = :sender_id AND line_reply.chat_id = :chat_id AND line_reply.from_ch = :linech)
        OR
        ((SELECT by_user FROM line_oa WHERE by_user = :sender_id) 
        AND line_reply.from_ch = :linech AND line_reply.chat_id = :chat_id);", [
        "sender_id" => $sender_id,
        "chat_id" => $chat_id,
        "linech" => $linech
    ])->findAll();

    
    foreach ($msg as $chat) {
        
?>

        <p class="align-self-start border rounded p-2 ">
            <?= $chat['messages'] ?>
            <small class="d-block">
                <?= date("h:i a", strtotime($chat['created_at'])) ?>
            </small>
        </p>

<?php

    }
}