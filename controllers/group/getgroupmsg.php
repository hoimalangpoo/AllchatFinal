<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

if (isset($_POST['id_group'])) {
    $user_id  = $_SESSION['user'];
    $group_id  = $_POST['id_group'];
    $msg = $db->query("SELECT group_messages.*, users.name FROM group_messages 
    JOIN users ON group_messages.user_id = users._id
    WHERE (user_id != :user_id AND group_id = :group_id)
                                                  ORDER BY group_msg_id ASC", [
        "group_id" => $group_id,
        "user_id" => $user_id
    ])->findAll();

    foreach ($msg as $chat) {
        if ($chat['opened'] == 0) {
            $opened = 1;
            $group_msg_id = $chat['group_msg_id'];
            $checkopen = $db->query("UPDATE group_messages SET opened = :opened WHERE group_msg_id = :group_msg_id", [
                "opened" => $opened,
                "group_msg_id" => $group_msg_id
            ]);
?>

            <p class="ltext align-self-start border rounded p-2 ">
                <span class="sender-name"><?= $chat['name'] ?>: </span>
                <?= $chat['messages'] ?>
                <small class="d-block">
                    <?= date("h:i a", strtotime($chat['send_at'])) ?>
                </small>
            </p>

<?php
        }
        
    }
}