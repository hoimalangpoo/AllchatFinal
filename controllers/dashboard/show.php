<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$count_msg = $db->query("SELECT CONCAT(MONTHNAME(created_at),' ',YEAR(created_at)) AS month_year, 
COUNT(*) AS message_count FROM chat GROUP BY month_year ORDER BY created_at")->findAll();

check($count_msg);


include base_path("views/dashboard/show.view.php");