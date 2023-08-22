<?php
foreach ($friends as $friend) {
$chat = $db->getchats($userid, $friend['_id'], $db);
$db->opened($friend['_id'], $db, $chat);
     ?>

    <div class="content col-6 collapse" id="collapse<?php echo $friend['_id'] ?>" aria-labelledby="heading<?php echo $friend['_id'] ?>" data-parent="#accordionExample">
        <div class="card">
            <div class="contact-profile card-header bg-transparent" id="userSection">
                <img src="ภาพ/avatar2.png" alt="" />
                <span> <?= $friend['name'] ?> </span>
                <span id="<?php echo $friend['_id'] ?>" class="getiduser<?php echo $friend['_id'] ?>" name="<?php echo $friend['_id'] ?>"> </span>
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
                        <input type="text" class="chatMessage" id="message<?php echo $friend['_id'] ?>" placeholder="Write your message..." />

                        <button class="chatButton" id="<?php echo $friend['_id'] ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
}
