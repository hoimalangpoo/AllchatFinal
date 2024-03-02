<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);



include base_path("views/dashboard/show.view.php");

?>


