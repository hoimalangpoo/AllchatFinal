<div class="ltext align-self-start border rounded p-2 collapse mb-2" id="collapse<?php echo $chat['chat_id'] ?>" aria-labelledby="heading<?php echo $chat['chat_id'] ?>" data-parent="#chatuser<?php echo $chat['chat_id'] ?>lineOAid<?= $chat['recieve_id'] ?>">
    <div id="conversation<?php echo $chat['chat_id'] ?>">

        
    </div>
    <div class="message-input" id="replySection">
        <div class="message-input" id="replyContainer">
            <div class="wrap">

                <input type="text" class="chatMessage" id="reply<?php echo $chat['chat_id'] ?>chat_id<?= $chat['recieve_id'] ?>" placeholder="Reply to ..." />

                <button class="replyButton" id="<?php echo $chat['chat_id'] ?>chat_id<?= $chat['recieve_id'] ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

            </div>
        </div>
    </div>
</div>


