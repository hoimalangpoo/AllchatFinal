<?php
foreach ($friends as $friend) {
    $chat = $db->getchats($userid, $friend['_id'], $db);
    $db->opened($friend['_id'], $db, $chat);
    $imageData = base64_encode($friend['profile']);
    // check($chat);
?>

    <div class="content col collapse" id="collapse<?php echo $friend['_id'] ?>" data-parent="#accordionExample">
        <div class="card">
            <div class="contact-profile card-header bg-transparent" id="userSection">
                <img src="data:image/png;base64,<?= $imageData ?>" alt="" class="logolineOA rounded-circle" />
                <span> <?= $friend['name'] ?> </span>
                <span id="<?php echo $friend['_id'] ?>" class="getiduser<?php echo $friend['_id'] ?>" name="<?php echo $friend['_id'] ?>"> </span>
                <button id="friendinfo" class="friendinfo" data-toggle="collapse" data-target="#friendinfo<?php echo $friend['_id'] ?>">
                    <i class="bi bi-list"></i>
                </button>
            </div>

            <div class="card-body shadow p-4 rounded d-flex flex-column messages" id="conversation<?php echo $friend['_id'] ?>">
                <?php
                foreach ($chat as $msg) {

                    if ($msg['sender_id'] == $_SESSION['user']) { ?>
                        <p class="rtext align-self-end border rounded p-2 ">
                            <?= $msg['messages'] ?>
                            <small class="d-block">
                                <?= date("h:i a", strtotime($msg['created_at'])) ?>
                            </small>
                        </p>
                    <?php } else { ?>
                        <p class="ltext align-self-start border rounded p-2 ">
                            <?= $msg['messages'] ?>
                            <small class="d-block">
                                <?= date("h:i a", strtotime($msg['created_at'])) ?>
                            </small>
                        </p>
                <?php }
                }
                ?>

            </div>

            <div class="message-input" id="replySection">
                <div class="message-input" id="replyContainer">
                    <div class="wrap">
                        <input type="text" class="chatMessage" id="message<?php echo $friend['_id'] ?>" style="width: 86%;" placeholder="Write your message..." />

                        <button class="replyButton" id="<?php echo $chat['chat_id'] ?>chat_id<?= $chat['recieve_id'] ?>"><i class="fa fa-paper-plane " aria-hidden="true"></i></button>

                    </div>
                </div>
            </div>
        </div>


    </div>

<?php
}

?>