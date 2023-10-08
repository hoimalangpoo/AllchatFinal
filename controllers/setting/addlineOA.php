<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
function savelineOA($lineOAid, $lineOaDisplayName, $lineOAPictureUrl, $access_token, $user_id, $db)
{

    $check_lineoa = $db->query("SELECT lineOAid FROM line_oa WHERE lineOAid = :lineOAid ", [
        "lineOAid" => $lineOAid,

    ])->find();


    if (!$check_lineoa) {

        try {
            $db->query("INSERT INTO line_oa(lineOAid, lineOaDisplayName, access_token, profile, by_user)
        VALUES(:lineOAid, :lineOaDisplayName, :access_token, :lineOAPictureUrl, :user_id)", [
                "lineOAid" => $lineOAid,
                "lineOaDisplayName" => $lineOaDisplayName,
                "access_token" => $access_token,
                "lineOAPictureUrl" => $lineOAPictureUrl,
                "user_id" => $user_id,
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        header('location: /setting');
        exit;
    }
}

$access_token = "";
$lineOAid = "";
$lineOaDisplayName = "";
if (isset($_POST['access_token'])) {
    $access_token = $_POST['access_token'];
    $user_id = intval($_SESSION['user']);

    $chID = curl_init('https://api.line.me/v2/bot/info');
    curl_setopt($chID, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($chID, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $access_token
    ]);

    $response = curl_exec($chID);
    curl_close($chID);
    $data = json_decode($response, true);

    $lineOAid = $data['userId'];
    $lineOaDisplayName = $data['displayName'];
    $lineOAPictureUrl = $data['pictureUrl'];
    // check($user_id);
    savelineOA($lineOAid, $lineOaDisplayName, $lineOAPictureUrl, $access_token, $user_id, $db);
    header('location: /chat');
    exit();
}
