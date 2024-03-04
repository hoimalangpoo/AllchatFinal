<?php

use Core\App;
use Core\Database;

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/notyes/thsplitlib/THSplitLib/segment.php';
$db = App::resolve(Database::class);
/////////////////////////////////////////////////////////FUNCTION///////////////////////////////////////
function saveContact($user_id, $display_name, $lineOAid, $db)
{
    $check_id = $db->query("SELECT line_contact.id AS sender_id, line_oa.by_user AS recieve_id 
    FROM line_contact JOIN line_oa 
    ON line_contact.lineOAid = line_oa.id
    WHERE line_contact.user_id = :user_id AND line_oa.lineOAid = :lineOAid", [
        "user_id" => $user_id,
        "lineOAid" => $lineOAid,
    ])->find();
    if ($check_id) {
        exit;
    } else {
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
function checkmsg($message_text, $db)
{
    $segment = new Segment();
    $words = $segment->get_segment_array($message_text);
    //  check($wordsString);
    $query = "SELECT question, COUNT(*) AS match_qa FROM announceqa WHERE ";

    foreach ($words as $word) {
        $query .= "question LIKE '%$word%' OR ";
    }
    $query = rtrim($query, " OR ");
    $query .= " GROUP BY question ";

    $message = $db->query($query)->findAll();

    if (!empty($message)) {
        foreach ($message as $sentence) {
            $count = 0;
            $columnName = $sentence['question'];
            foreach ($words as $word) {
                if (strpos($columnName, $word) !== false) {
                    $count++;
                }
            }
            if ($count > 3) {
                return $count;
                exit;
            }
        }
    } else {
        echo "ไม่พบข้อมูล";
    }
}

function saveChat($user_id, $message_type, $message_text, $lineOAid, $quoteToken, $db)
{
    //////////////////////////////////////////Line_USER/////////////////////////
    $check_id = $db->query("SELECT line_contact.id AS sender_id, line_oa.id AS recieve_id
    FROM line_contact JOIN line_oa 
    ON line_contact.lineOAid = line_oa.id
    WHERE line_contact.user_id = :user_id AND line_oa.lineOAid = :lineOAid ", [
        "user_id" => $user_id,
        "lineOAid" => $lineOAid,
    ])->find();
    if ($check_id) {
        $sender_id = $check_id['sender_id'];
        $recieve_id = $check_id['recieve_id'];
        $match_qa = checkmsg($message_text, $db);
        
        if ($match_qa > 3) {
            $db->query("INSERT INTO line_chat(messages, message_type, sender_id, recieve_id, reply_token, match_qa)
            VALUES(:message_text, :message_type, :sender_id, :recieve_id, :quoteToken, :match_qa)", [
                "message_text" => $message_text,
                "message_type" => $message_type,
                "sender_id" => $sender_id,
                "recieve_id" => $recieve_id,
                "quoteToken" => $quoteToken,
                "match_qa" => $match_qa

            ]);
        } else {
            $db->query("INSERT INTO line_chat(messages, message_type, sender_id, recieve_id, reply_token)
            VALUES(:message_text, :message_type, :sender_id, :recieve_id, :quoteToken)", [
                "message_text" => $message_text,
                "message_type" => $message_type,
                "sender_id" => $sender_id,
                "recieve_id" => $recieve_id,
                "quoteToken" => $quoteToken,

            ]);
        }
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

function getreplyToken($chat_id, $db)
{
    $token_reply = $db->query("SELECT reply_token FROM line_chat WHERE chat_id = :chat_id", [
        "chat_id" => $chat_id,
    ])->find();

    return $token_reply;
}


function sendLineMessage($userId, $messages, $quoteToken, $access_token)
{
    $data = array(
        'to' => $userId,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $messages,
                'quoteToken' => $quoteToken,
            ),
        ),
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

    echo "Request JSON: " . json_encode($data) . "\n";

    $result = curl_exec($ch);

    if ($result === FALSE) {
        echo "Error sending message. cURL Error: " . curl_error($ch);
    } else {
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo "HTTP Code: " . $http_code . "\n";
        echo "Response: " . $result . "\n";
    }

    curl_close($ch);
}

function isQuestion($text)
{
    $text = trim($text);
    $endsWithQuestionMark = mb_substr($text, -1) === "?";
    $containsWhat = mb_strpos($text, "อะไร") !== false;
    $containsWhere = mb_strpos($text, "ที่ไหน") !== false;
    $containsWhen = mb_strpos($text, "เมื่อไหร่") !== false;
    $containsWhy = mb_strpos($text, "ทำไม") !== false;
    $containsHow = mb_strpos($text, "อย่างไร") !== false;
    $containsMai = mb_strpos($text, "ไหม") !== false;

    return $endsWithQuestionMark || $containsWhat || $containsWhere || $containsWhen || $containsWhy || $containsHow || $containsMai;
}
/////////////////////////////////////////////////////////FUNCTION///////////////////////////////////////