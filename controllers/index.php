<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);



$fromline = $db->query("SELECT * FROM line_contact")->findAll();



include base_path("views/index.view.php");
