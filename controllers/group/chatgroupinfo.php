<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$userid = $_SESSION['user'];


// check($member);

include base_path("views/group/chatgroupinfo.view.php");
