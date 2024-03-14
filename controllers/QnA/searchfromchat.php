<?php

use Core\App;
use Core\Database;

require __DIR__ . '/../../vendor/notyes/thsplitlib/THSplitLib/segment.php';
$db = App::resolve(Database::class);

if (isset($_POST['searchKeyword'])) {
    $Keyword = $_POST['searchKeyword'];
    $segment = new Segment();

    $array_search = $segment->get_segment_array($Keyword);
    // check($array_search);

    $query = "SELECT * FROM announceqa WHERE ";

    foreach ($array_search as $word) {
        $query .= "question LIKE '%$word%' OR ";
    }
    $query = rtrim($query, " OR ");
    $query .= " GROUP BY question";

    $search = $db->query($query, [
        "message_text" => '%' . $Keyword . '%'
    ])->findAll();
// check($array_search);

    // check($search);
    $_SESSION['search'] = $search;
    $_SESSION['Keyword'] = $Keyword;
    
    echo json_encode($search);
    exit();
}

