<?php
    require("../../models/quiz_model.php");

    session_start();
    //session_destroy();
?>

<?php

    echo "Hier wird gespeichert...<br><br>";
    
    if (isset($_SESSION['Quiz'])) {
        
        $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');

        if (!$pdo) {
            echo "Verbindungsfehler!<br />";
        } 
        
        $Quiz = $_SESSION['Quiz'];
        $Questions = $Quiz->Questions;
        
        $KeysQuestion = array_keys($Questions);
        $Question = $Questions[$KeysQuestion[0]];

        
        echo "Questiontext: ".$Question->QuestionText."<br><br>";
        
        
        /*
        $VoteResultSelect = "SELECT * FROM T_QUIZ WHERE ID = ".$QuizID;
        $VoteResultResult = $pdo->query($VoteResultSelect);
        
        if ($QuizResult && $QuizResult->rowCount() > 0) {
            while ($QuizRow = $QuizResult->fetch(PDO::FETCH_ASSOC)) {
       
        
            $VoteInsert = "INSERT INTO movies(filmName,
                filmDescription,
                filmImage,
                filmPrice,
                filmReview) VALUES (
                :filmName, 
                :filmDescription, 
                :filmImage, 
                :filmPrice, 
                :filmReview)";

            $stmt = $pdo->prepare($sql);
            }
        }
         */
        
    } else {
        echo "Fehler! Es wurden keine Antworten gefunden<br><br>";
    }

?>

