<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$userid = $_SESSION['user'];
$r_friend = $db->query("SELECT * FROM friend WHERE _to = :userid AND status='P' AND deleted_at IS NULL", [
    "userid" => $userid
])->findAll();



if (isset($_POST['search'])) {
    $search = $_POST['friendSearch'];
    $id = intval($userid);

    $searchFriend = $db->query("SELECT DISTINCT users._id, users.name, users.profile FROM users 
    LEFT JOIN friend ON users._id = friend._from WHERE users.email LIKE :search 
    AND users._id <> :id AND (friend._to <> :id OR friend._to IS NULL);", [
        "search" => '%' . $search . '%',
        "id" => $id
    ])->findAll();

    // check($searchFriend);
} else {
    $searchFriend = NULL;
}


include base_path("views/friends/addfriend.view.php");
