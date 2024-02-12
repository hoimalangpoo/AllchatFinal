<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

if (isset($_POST['lineOAid']) && isset($_POST['linech'])) {
    $lineOAid  = $_POST['lineOAid'];
    $linech = $_POST['linech'];

    $line_id = $db->query("SELECT line_contact.id FROM line_contact JOIN line_oa 
    ON line_contact.lineOAid = line_oa.id
    WHERE line_oa.lineOAid = :lineOAid", [
        "lineOAid" => $lineOAid,
    ])->findAll();

    $msg = [];

    foreach ($line_id as $all_id) {
        $user_fromLine = $all_id['id'];
        $messages = $db->query("SELECT * FROM line_chat WHERE (sender_id = :user_fromLine AND recieve_id =  :linech)
        ORDER BY chat_id ASC", [
            "user_fromLine" => $user_fromLine,
            "linech" => $linech
        ])->findAll();

        $msg[] = $messages;
    }


    foreach ($msg as $chats) {
        foreach ($chats as $chat) {
            if ($chat['opened'] == 0) {
                $opened = 1;
                $chat_id = $chat['chat_id'];
                $checkopen = $db->query("UPDATE line_chat SET opened = :opened WHERE chat_id = :chat_id", [
                    "opened" => $opened,
                    "chat_id" => $chat_id
                ]);

                $backgroundColor = '';
                if ($chat['reply'] == 1) {
                    $backgroundColor = 'bg-success text-white';
                } else if ($chat['match_qa'] > 3 && $chat['reply'] == 0) {
                    $backgroundColor = 'bg-warning text-black';
                } ?>

                <div class="ltext align-self-start border rounded p-2 mb-2 msglist <?= $backgroundColor ?> " id="chatuser<?= $chat["chat_id"] ?>lineOAid<?= $chat['recieve_id'] ?>" data-touserid="<?= $chat["chat_id"] ?>" data-toggle="collapse" data-target="#collapse<?= $chat["chat_id"] ?>" aria-expanded="true" aria-controls="collapse<?= $chat["chat_id"] ?>">
                    <p class="mb-0">
                        <?= $chat['messages'] ?>
                        <small class="d-block">
                            <?= date("h:i a", strtotime($chat['created_at'])) ?>
                        </small>
                    </p>
                    <?php if ($chat['match_qa'] > 3 && $chat['reply'] == 0) : ?>
                                <form method="POST" action="/search">
                                    <input type="hidden" name="match_message" value="<?= $chat['messages'] ?>">
                                    <button type="submit">ค้นหา</button>
                                </form>
                            <?php endif; ?>
                </div>

                <?php require base_path('controllers/chats/ajax.reply.php'); 

            }
        }
    }
    
}
?>