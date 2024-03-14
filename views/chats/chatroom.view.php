<?php
foreach ($fromline as $line) {
    $getalluser = $db->getAllid($line['lineOAid'], $db);
    $chats = $db->lineOAgetchats($userid, $line['id'], $getalluser, $db);
    $lastchatNotans = $db->getlastchatsNotans($chats, $line['id'], $db);


    // check($line);
?>

    <div class="content col-5 collapse" id="collapse<?= $line['lineOAid'] ?>" aria-labelledby="heading<?= $line['lineOAid'] ?>" data-parent="#accordionExample">
        <div class="card">
            <div class="contact-profile card-header bg-transparent" id="userSection">
                <img src="<?= $line['profile'] ?>" class="img-fluid rounded-circle" alt="" />
                <span> <?= $line['lineOaDisplayName'] ?> </span>
                <span id="<?= $line['lineOAid'] ?>" class="getiduser<?= $line['lineOAid'] ?>" name="<?= $line['lineOAid'] ?>"> </span>
            </div>
            <div class="bg-light align-center text-center">
                <p class="searchchat m-1" id="lastchat<?= $lastchatNotans[0]['chat_id'] ?>line<?= $lastchatNotans[0]['recieve_id'] ?>boxforline<?=  $line['lineOAid'] ?>" style="cursor: pointer;">กดเพื่อค้นหาคำถามที่ยังไม่ได้ตอบ</p>
            </div>
            <div class="card-body shadow p-4 rounded d-flex flex-column messages" id="conversation<?= $line['lineOAid'] ?>">

                <?php
                foreach ($chats as $chat) {
                    // check($chat);
                    $chat_id = strpos($chat['chat_id'], 'announce');
                    $linech = $chat['recieve_id'];


                    if (($chat['sender_id'] == $_SESSION['user']) || $chat_id) { ?>
                        <p class="rtext align-self-end border rounded p-2 mb-2" >
                            <?= $chat['messages'] ?>
                            <small class="d-block">
                                <?= date("h:i a", strtotime($chat['created_at'])) ?>
                            </small>
                        </p>


                    <?php } else {
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
                                
                                    <button type="submit" id="searchqa<?= $chat['messages'] ?>">ค้นหา</button>
                                
                            <?php endif; ?>
                        </div>





                        <?php require base_path('controllers/chats/reply.php'); ?>

                <?php
                    }
                }

                ?>

            </div>

            <div class="message-input" id="replySection">
                <div class="message-input" id="replyContainer">
                    <div class="d-flex justify-content-center align-items-center">
                        <button id="toggleButton<?= $line['id'] ?>" class="btn btn-warning" style="width: 100%;">ประกาศ</button>
                    </div>
                    <div class="wrap d-none" id="inputField<?= $line['id'] ?>">
                        <input type="text" class="chatMessage " id="message<?= $line['lineOAid'] ?>lineOAid<?= $line['id'] ?>" placeholder="ประกาศถึงทุกคน" />

                        <button class="chatButton" id="<?= $line['lineOAid'] ?>lineOAid<?= $line['id'] ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
}