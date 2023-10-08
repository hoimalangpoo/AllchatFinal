<?php
use Core\App;
use Core\Database;
$db = App::resolve(Database::class);
    if(isset($_POST['question']) && isset($_POST['answer'])){
        $question = $_POST['question'];
        $answer = $_POST['answer'];
        $userid = $_SESSION['user'];

        try {
            $agency_user = $db->query("SELECT agency FROM users WHERE _id = :userid", [
                "userid" => $userid
            ])->find();
    
            $agency = intval($agency_user['agency']);
            
            $addQA = $db->query("INSERT INTO announceqa(question, answer, by_agency)VALUES(:question, :answer, :agency)",[
                "question" => $question,
                "answer" => $answer,
                "agency" => $agency
            ]);

                header("location: /chat");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

   