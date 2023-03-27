<?php

include 'function/chat.php';

$userid = $_SESSION['user'];



if (isset($_SESSION['user'])) {
    $friend = $conn->prepare("SELECT * FROM friend WHERE _from = :userid OR _to = :userid AND status='F' AND deleted_at IS NULL");
    $friend->bindParam(":userid", $userid);
    $friend->execute();
    if ($friend->rowCount() > 0) {
        foreach ($friend as $result) { ?>
            <?php
            $request = $result[0];
            $data = $conn->prepare("SELECT * FROM users WHERE _id = :fid");
            $data->bindParam(":fid", $request);
            $data->execute();
            $row = $data->fetch(PDO::FETCH_ASSOC);
            $id = $row['_id'];
            $recieve_id = $id;
            ?>

            <?php if ($id == $_SESSION['user']) { ?>
            <?php } else {
                $chat = getchats($userid, $id, $conn);
                opened($id, $conn, $chat);
            ?>
                
                <div class="content col-6 collapse" id="collapse<?php echo $id ?>" aria-labelledby="heading<?php echo $id ?>" data-parent="#accordionExample">
                    <div class="card">
                        <div class="contact-profile card-header bg-transparent" id="userSection">
                            <img src="ภาพ/avatar2.png" alt="" />
                            <span> <?= $row['name'] ?> </span>
                            <span id="<?php echo $id ?>" class="getiduser<?php echo $id ?>" name="<?php echo $id ?>"> </span>
                        </div>

                        <div class="card-body shadow p-4 rounded d-flex flex-column messages" id="conversation<?php echo $id ?>">
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
                                    <p class="ltext border rounded p-2 ">
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
                                    <input type="text" class="chatMessage" id="message<?php echo $id ?>" placeholder="Write your message..." />

                                    <button class="chatButton" id="<?php echo $id ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

    <?php
        } 
   } 
 } ?>