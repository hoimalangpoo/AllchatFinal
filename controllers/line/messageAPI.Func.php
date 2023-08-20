<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
/////////////////////////////////////////////////////////FUNCTION///////////////////////////////////////
function saveContact($user_id, $display_name, $lineOAid, $db){
    $check_id = $db->query("SELECT line_contact.id AS sender_id, line_oa.by_user AS recieve_id 
    FROM line_contact JOIN line_oa 
    ON line_contact.lineOAid = line_oa.id
    WHERE line_contact.user_id = :user_id AND line_oa.lineOAid = :lineOAid", [
        "user_id" => $user_id,
        "lineOAid" => $lineOAid,
    ])->find();
    if ($check_id){
        exit;

    }else{
        $OAid = $db->query("SELECT id FROM line_oa WHERE lineOAid = :lineOAid", [
            "lineOAid" => $lineOAid,
        ])->find();

        $id = $OAid['id'];

        $db->query("INSERT INTO line_contact(user_id, display_name, lineOAid)
        VALUES(:user_id, :display_name, :id)", [
            "user_id" => $user_id,
            "display_name" => $display_name,
            "id" => $id

        ]);

        exit;
    }
}
function saveChat($user_id, $message_type, $message_text, $lineOAid, $db)
{
    //////////////////////////////////////////Line_USER/////////////////////////
    $check_id = $db->query("SELECT line_contact.id AS sender_id, line_oa.by_user AS recieve_id, line_oa.id AS linech
    FROM line_contact JOIN line_oa 
    ON line_contact.lineOAid = line_oa.id
    WHERE line_contact.user_id = :user_id AND line_oa.lineOAid = :lineOAid ", [
        "user_id" => $user_id,
        "lineOAid" => $lineOAid,
    ])->find();
    if ($check_id) {
        $sender_id = $check_id['sender_id'];
        $recieve_id = $check_id['recieve_id'];
        $linech = $check_id['linech'];

        $db->query("INSERT INTO line_chat(messages, message_type, sender_id, recieve_id, from_ch)
        VALUES(:message_text, :message_type, :sender_id, :recieve_id, :linech)", [
            "message_text" => $message_text,
            "message_type" => $message_type,
            "sender_id" => $sender_id,
            "recieve_id" => $recieve_id,
            "linech" => $linech,

        ]);

        exit();
    } else {
      
        exit();

    }
}

function getUsersFromDatabase($lineOAid, $db)
{
    $all_user = $db->query("SELECT line_contact.user_id FROM line_contact JOIN line_oa 
    ON line_contact.lineOAid = line_oa.id
    WHERE line_oa.lineOAid = :lineOAid", [
        "lineOAid" => $lineOAid,
    ])->findAll();

    $users = [];
    foreach ($all_user as $user) {
        $users[] = $user;
    }

    return $users;
}

function getUserID($chat_id, $db)
{
    $all_user = $db->query("SELECT line_contact.user_id FROM line_chat 
    JOIN line_contact ON line_chat.sender_id = line_contact.id
    WHERE line_chat.chat_id = :chat_id", [
        "chat_id" => $chat_id,
    ])->find();

    $idfromchat = $all_user['user_id'];

    return $idfromchat;
}

function getLineOAID($chat_id, $db)
{
    $all_user = $db->query("SELECT line_contact.user_id FROM line_chat 
    JOIN line_contact ON line_chat.sender_id = line_contact.id
    WHERE line_chat.chat_id = :chat_id", [
        "chat_id" => $chat_id,
    ])->find();

    $idfromchat = $all_user['user_id'];

    return $idfromchat;
}


function sendLineMessage($userId, $messages, $access_token)
{
    // Data to be sent
    $data = array(
        'to' => $userId,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $messages
            )
        )
    );

    $url = 'https://api.line.me/v2/bot/message/push';
    $headers = array(
        'Authorization: Bearer ' . $access_token,
        'Content-Type: application/json'
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    if ($result === FALSE) {
        return "Error sending message.";
    } else {
        return "Message sent successfully.";
    }
}
/////////////////////////////////////////////////////////FUNCTION///////////////////////////////////////