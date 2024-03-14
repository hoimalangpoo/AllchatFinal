<?php
use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$count_msg = $db->query("SELECT CONCAT(MONTHNAME(created_at),' 
',YEAR(created_at)) AS month_year, 
COUNT(*) AS message_count FROM line_chat GROUP BY month_year ORDER BY created_at ")->findAll();
// check($count_msg);   
header('Content-Type: application/json');
echo json_encode($count_msg) ;





       
