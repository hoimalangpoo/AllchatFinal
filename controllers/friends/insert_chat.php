<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
    if (isset($_POST['message']) && isset($_POST['recieve'])) {
        $messages = $_POST['message'];
        $recieve_id = $_POST['recieve'];
        $sender_id = $_SESSION['user'];
        $sendmsg = $db->query("INSERT INTO chat(messages, sender_id, recieve_id)VALUES(:messages, :sender_id, :recieve_id)", [
            "messages" => $messages,
            "sender_id" => $sender_id,
            "recieve_id" => $recieve_id,
        ]);

        if ($sendmsg) {

            $msg = $db->query("SELECT * FROM conversations WHERE (user1 = :sender_id AND user2 = :recieve_id)
                                                            OR  (user2 = :recieve_id AND user1 = :sender_id)", [
                "sender_id" => $sender_id,
                "recieve_id" => $recieve_id,
            ])->findAll();


            define('TIMEZONE', 'Asia/Bangkok');
            date_default_timezone_set(TIMEZONE);
            $time = date("h:i a");                                             
            if(!$msg){
                $conver = $db->query("INSERT INTO conversations (user1, user2)VALUES(:user1, :user2)", [
                    "user1" => $sender_id,
                    "user2" => $recieve_id
                ]);
            }                                                   
          

?>

            <p class="rtext align-self-end border rounded p-2 ">
                <?= $messages ?>
                <small class="d-block"><?= $time ?> </small>
            </p>

<?php
        }
    }

