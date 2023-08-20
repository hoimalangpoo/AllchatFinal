<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

if (isset($_POST['id_2'])) {
    $sender_id  = $_SESSION['user'];
    $recieve_id  = $_POST['id_2'];
    $msg = $db->query("SELECT * FROM chat WHERE (sender_id = :recieve_id AND recieve_id = :sender_id)
                                                  ORDER BY chat_id ASC", [
        "sender_id" => $sender_id,
        "recieve_id" => $recieve_id
    ])->findAll();

    foreach ($msg as $chat) {
        if ($chat['opened'] == 0) {
            $opened = 1;
            $chat_id = $chat['chat_id'];
            $checkopen = $db->query("UPDATE chat SET opened = :opened WHERE chat_id = :chat_id", [
                "opened" => $opened,
                "chat_id" => $chat_id
            ]);
?>

            <p class="ltext align-self-start border rounded p-2 ">
                <?= $chat['messages'] ?>
                <small class="d-block">
                    <?= date("h:i a", strtotime($chat['created_at'])) ?>
                </small>
            </p>

<?php
        }
    }
}
