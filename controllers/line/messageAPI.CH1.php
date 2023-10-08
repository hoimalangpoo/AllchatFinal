<?php
include base_path("controllers/line/messageAPI.Func.php");
$access_token = "6FwZwSMzdaCzs0FrSxphJL8FWCXNcHTg3kkcNH8f1D2oecZ2vXDxQHFHvfXiNEC/uoE+/vn5q6ctsHMp6WTn9c1gug/ct1x7Jnu8fhn0wC80QZPoprXyq/Y+HKb3MOOMawCK7rxqdQD9tfRpBA5QDAdB04t89/1O/w1cDnyilFU=";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['message']) && isset($_POST['lineOAid'])) {
        $messages = $_POST['message'];
        $lineOAid = $_POST['lineOAid']; //LINEOAID
        
        $users = getUsersFromDatabase($lineOAid, $db);

        foreach ($users as $user) {
            $userId = $user['user_id'];
            sendLineMessage($userId, $messages, $access_token);
        }
    } else if (isset($_POST['reply']) && isset($_POST['chat_id'])) {
        $reply = $_POST['reply'];
        $chat_id = $_POST['chat_id']; //chat_id
        $idfromchat = getUserID($chat_id, $db);
        sendLineMessage($idfromchat, $reply, $access_token);
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
                    saveChat($user_id, $message_type, $message_text, $lineOAid, $db);
                }
                
            }
        }
    }
}
