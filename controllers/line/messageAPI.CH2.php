<?php
include base_path("controllers/line/messageAPI.Func.php");
$access_token = "RqDyRAeFjbgZCDZH8LHuZ7wjrKJ55MugDxcSWXC7IL45Pm/o05hxsFrSNgZ/xj5GsoQQB89vUEVYeCMopx+/jEURyDxv9IXMc9X8ZASLc5zoMeisCvhxf79FOllFYX60BruJXHRULs3uKhl70WcA7AdB04t89/1O/w1cDnyilFU=";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['message']) && isset($_POST['lineOAid'])) {
        $messages = $_POST['message'];
        $lineOAid = $_POST['lineOAid']; //LINEOAID
        
        $users = getUsersFromDatabase($lineOAid, $db);

        foreach ($users as $user) {
            $userId = $user['user_id'];
            sendLineMessage($userId, $messages, $token_reply,$access_token);
        }
    } else if (isset($_POST['reply']) && isset($_POST['chat_id'])) {
        $reply = $_POST['reply'];
        $chat_id = $_POST['chat_id']; 
        $token_reply = getreplyToken($chat_id, $db);
        
        $idfromchat = getUserID($chat_id, $db);
        
        sendLineMessage($idfromchat, $reply, $token_reply["reply_token"], $access_token);
    }
}

$content = file_get_contents('php://input');
$events = json_decode($content, true);

if (isset($events['events']) && is_array($events['events'])) {
    foreach ($events['events'] as $event) {
        if ($event['type'] == 'follow') {
            $user_id = $event['source']['userId'];

            $display_name = '';

            //NameUser
            $url = 'https://api.line.me/v2/bot/profile/' . $user_id;
            $headers = array(
                'Authorization: Bearer ' . $access_token
            );

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $profile = curl_exec($ch);
            curl_close($ch);
            $profile_data = json_decode($profile, true);
            if (isset($profile_data['displayName'])) {
                $display_name = $profile_data['displayName'];
            }

            $chID = curl_init('https://api.line.me/v2/bot/info');
            curl_setopt($chID, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chID, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $access_token
            ]);

            $response = curl_exec($chID);
            curl_close($chID);
            if ($response){
                $data = json_decode($response, true);

                $lineOAid = $data['userId'];

                saveContact($user_id, $display_name, $lineOAid, $db);
            }
            
        }

        else if ($event['type'] == 'message'){
            $user_id = $event['source']['userId'];
            $message_text = $event['message']['text'];
            $message_type = $event['message']['type'];
            $quoteToken = $event['message']['quoteToken'];

            $chID = curl_init('https://api.line.me/v2/bot/info');
            curl_setopt($chID, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chID, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $access_token
            ]);

            $response = curl_exec($chID);
            curl_close($chID);
            if ($response){
                $data = json_decode($response, true);

                $lineOAid = $data['userId'];

                if (isQuestion($message_text)) {
                    saveChat($user_id, $message_type, $message_text, $lineOAid, $quoteToken, $db);
                }
                
            }
        }
    }
}