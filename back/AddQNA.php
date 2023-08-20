<?php
    session_start();
    require_once '../model/db.php';
    if(isset($_SESSION['user'])){
        $question = $_POST['question'];
        $answer = $_POST['answer'];

        try {
            $addQA = $conn->prepare("INSERT INTO announceqa(question, answer)VALUES(:question, :answer)");
                $addQA->bindParam(":question", $question);
                $addQA->bindParam(":answer", $answer);
                $addQA->execute();

                header("location: ../chat.php");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }else{
        header("location: login.php");
    }

   