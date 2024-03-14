<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

if (isset($_POST['friendSearch'])) {
    $userid = $_SESSION['user'];
    $search = $_POST['friendSearch'];
    $id = intval($userid);

    $searchFriend = $db->query("SELECT DISTINCT users._id, users.name, users.profile 
    FROM users 
    LEFT JOIN friend ON users._id = friend._from 
    WHERE (users.email LIKE :search OR users.name LIKE :search) 
    AND users._id <> :id 
    AND (friend._to <> :id OR friend._to IS NULL)
    AND COALESCE(friend.status, '') != 'F';", [
        "search" => '%' . $search . '%',
        "id" => $id
    ])->findAll();

    // check($searchFriend);
    foreach ($searchFriend as $result_friend) { ?>
        <li class="list-group-item d-flex justify-content-between align-items-center"><i class="fs-4 bi-person-circle"></i>
            <?= $result_friend['name'] ?>
            <a href="/friend_req?id=<?= $result_friend['_id'] ?>" class="btn btn-success btn-lg text-dark ml-auto" role="button" aria-disabled="true">ส่งคำขอ</a>
        </li>

<?php }





    // check($searchFriend);
}
