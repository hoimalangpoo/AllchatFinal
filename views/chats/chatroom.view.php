<?php
foreach ($fromline as $line) {
    $getalluser = $db->getAllid($line['lineOAid'], $db);
    $chats = $db->lineOAgetchats($userid, $line['id'], $getalluser, $db);
    // check($agency_id);

?>

    <div class="content col-6 collapse" id="collapse<?= $line['lineOAid'] ?>" aria-labelledby="heading<?= $line['lineOAid'] ?>" data-parent="#accordionExample">
        <div class="card">
            <div class="contact-profile card-header bg-transparent" id="userSection">
                <img src="<?= $line['profile'] ?>" class="img-fluid rounded-circle" alt="" />
                <span> <?= $line['lineOaDisplayName'] ?> </span>
                <span id="<?= $line['lineOAid'] ?>" class="getiduser<?= $line['lineOAid'] ?>" name="<?= $line['lineOAid'] ?>"> </span>
            </div>

            <div class="card-body shadow p-4 rounded d-flex flex-column messages" id="conversation<?= $line['lineOAid'] ?>">
                <?php
                foreach ($chats as $chat) {

                    if (($chat['sender_id'] == $_SESSION['user']) || strpos($chat['chat_id'], 'announce')){ ?>
                        <p class="rtext align-self-end border rounded p-2 mb-2">
                            <?= $chat['messages'] ?>
                            <small class="d-block">
                                <?= date("h:i a", strtotime($chat['created_at'])) ?>
                            </small>
                        </p>


                        <?php } else {
                        if ($chat['reply'] == 1) { ?>

                            <div class="ltext align-self-start border rounded p-2 mb-2 msglist bg-success text-white" id="chatuser<?= $chat["chat_id"] ?>lineOAid<?= $chat['recieve_id'] ?>" data-touserid="<?= $chat["chat_id"] ?>" data-toggle="collapse" data-target="#collapse<?= $chat["chat_id"] ?>" aria-expanded="true" aria-controls="collapse<?= $chat["chat_id"] ?>">
                                <p class="mb-0">
                                    <?= $chat['messages'] ?>
                                    <small class="d-block">
                                        <?= date("h:i a", strtotime($chat['created_at'])) ?>
                                    </small>
                                </p>
                            </div>
                        <?php } else { ?>
                            <div class="ltext align-self-start border rounded p-2 mb-2 msglist" id="chatuser<?= $chat["chat_id"] ?>lineOAid<?= $chat['recieve_id'] ?>" data-touserid="<?= $chat["chat_id"] ?>" data-toggle="collapse" data-target="#collapse<?= $chat["chat_id"] ?>" aria-expanded="true" aria-controls="collapse<?= $chat["chat_id"] ?>">
                                <p class="mb-0">
                                    <?= $chat['messages'] ?>
                                    <small class="d-block">
                                        <?= date("h:i a", strtotime($chat['created_at'])) ?>
                                    </small>
                                </p>
                            </div>
                        <?php } ?>

                        <?php require base_path('controllers/chats/reply.php'); ?>

                <?php
                    }
                }
                ?>

            </div>

            <div class="message-input" id="replySection">
                <div class="message-input" id="replyContainer">
                    <div class="d-flex justify-content-center align-items-center">
                        <button id="toggleButton" class="btn btn-warning">ประกาศ</button>
                    </div>
                    <div class="wrap d-none" id="inputField">
                        <input type="text" class="chatMessage " id="message<?= $line['lineOAid'] ?>lineOAid<?= $line['id'] ?>" placeholder="ประกาศถึงทุกคน" />

                        <button class="chatButton" id="<?= $line['lineOAid'] ?>lineOAid<?= $line['id'] ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
}
