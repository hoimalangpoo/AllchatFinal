<?php
use Core\App;
use Core\Database;
$db = App::resolve(Database::class);
    if(isset($_POST['question']) && isset($_POST['answer'])){
        $question = $_POST['question'];
        $answer = $_POST['answer'];

        try {
            $addQA = $db->query("INSERT INTO announceqa(question, answer)VALUES(:question, :answer)",[
                "question" => $question,
                "answer" => $answer
            ]);

            header("location: /chat");
            exit;  
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

   