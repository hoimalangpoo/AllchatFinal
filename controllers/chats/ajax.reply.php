<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);


$userid = $_SESSION['user'];

?>

<script src="js/reply.js"></script>

<?php
include base_path("views/chats/reply.ajax.php");