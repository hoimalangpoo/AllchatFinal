<?php
foreach ($groups as $group) {
    $groupchat = $db->getgroupchats($userid, $group['group_id'], $db);
    $db->openedgroup($userid, $db, $groupchat);
    // check($groupchat);

?>

    <div class="content col collapse" id="collapse<?= $group['group_id'] ?>" aria-labelledby="heading<?= $group['group_id'] ?>" data-parent="#accordionExample">
        <div class="card">
            <div class="contact-profile card-header bg-transparent" id="userSection">
            
                <span> <?= $group['group_name'] ?> </span>
                <span id="<?= $group['group_id'] ?>" class="getiduser<?= $group['group_id'] ?>" group_name="<?= $group['group_id'] ?>"> </span>
                <button id="friendinfo<?= $group['group_id'] ?>" class="friendinfo" data-toggle="collapse" data-target="#groupinfo<?= $group['group_id'] ?>">
                    <i class="bi bi-list"></i>
                </button>
            </div>

            <div class="card-body shadow p-4 rounded d-flex flex-column messages" id="conversation<?= $group['group_id'] ?>">
                <?php
                foreach ($groupchat as $msg) {

                    if ($msg['user_id'] == $_SESSION['user']) { ?>
                        <p class="rtext align-self-end border rounded p-2 ">
                            <?= $msg['messages'] ?>
                            <small class="d-block">
                                <?= date("h:i a", strtotime($msg['send_at'])) ?>
                            </small>
                        </p>
                    <?php } else { ?>
                        <p class="ltext align-self-start border rounded p-2 ">
                            <span class="sender-name"><?= $msg['name_user'] ?>: </span>
                            <?= $msg['messages'] ?>
                            <small class="d-block">
                                <?= date("h:i a", strtotime($msg['send_at'])) ?>
                            </small>
                        </p>
                <?php }
                }
                ?>
            </div>

            <div class="message-input" id="replySection">
                <div class="message-input" id="replyContainer">
                    <div class="wrap">
                        <input type="text" class="chatMessage" id="message<?= $group['group_id'] ?>" style="width: 86%;" placeholder="Write your message..." />

                        <button class="chatButton" id="<?= $group['group_id'] ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
}