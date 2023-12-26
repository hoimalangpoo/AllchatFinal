<?php
use Core\App;
use Core\Database;
$db = App::resolve(Database::class);

if (isset($_POST['filterKeyword'])){
    $selectedKeyword = $_POST['filterKeyword'];
    if($_POST['filterKeyword'] == "เลือก"){
        $filter = $db->query("SELECT * FROM announceqa")->findAll();
          
        $_SESSION['filter'] = $filter;
        header('Location: /chat');
        exit();
    }else{
        $filter = $db->query("SELECT * FROM announceqa WHERE question LIKE :selectedKeyword",[
            "selectedKeyword" => '%' . $selectedKeyword . '%'
        ])->findAll();
          
        $_SESSION['filter'] = $filter;
        $_SESSION['selectedKeyword'] = $selectedKeyword;
        
        header('Location: /chat');
        exit();
    }
    

    
}