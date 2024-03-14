<?php $reply = $db->getreply($_SESSION['user'], $chat['chat_id'], $linech, $db); ?>
<div class="ltext align-self-start border rounded p-2 collapse mb-2" id="collapse<?= $chat['chat_id'] ?>" aria-labelledby="heading<?= $chat['chat_id'] ?>" data-parent="#conversation<?= $line['lineOAid'] ?>">
    <div id="conversation<?= $chat['chat_id'] ?>">
        <?php
        // check($reply);
        

       
        if(isset($reply)) {
            foreach ($reply as $reply_msg){
        ?>
        <p class="align-self-start border rounded p-2 ">
            <?= $reply_msg['messages'] ?>
            <small class="d-block">
                <?= date("h:i a", strtotime($reply[0]['created_at'])) ?>
            </small>
        </p>
        <?php } 
         }?>

        
    </div>
    <div class="message-input" id="replySection">
        <div class="message-input" id="replyContainer">
            <div class="wrap" style="display: flex;">

                <input type="text" class="chatMessage" id="reply<?= $chat['chat_id'] ?>chat_id<?= $chat['recieve_id'] ?>lineid<?= $line['lineOAid'] ?>" placeholder="Reply to ..." />

                <button class="replyButton" id="buttonreply<?= $chat['chat_id'] ?>chat_id<?= $chat['recieve_id'] ?>lineid<?= $line['lineOAid'] ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

            </div>
        </div>
    </div>
</div>
