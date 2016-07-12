<?php
    // SAVE_RESULTS
    include_once("models/quiz_model.php");
    include_once("config/database.php");
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    //session_destroy();
?>


<h2>
    Vielen Dank für Ihre Teilnahme!
</h2>

<br>

<?php
    if (isset($_SESSION['Quiz'])) {
        
        $pdo = new Database();
        
        if (!$pdo) {
            echo "Verbindungsfehler!<br />";
        } 

        $QuizTmp = unserialize($_SESSION['Quiz']);
        
        $QuestionsTmp = $QuizTmp->Questions;
        
        foreach($QuestionsTmp as $QuestionTmp) {

            $QuestionIdTmp = $QuestionTmp->QuestionID;
            $AnswersTmp = $QuestionTmp->Answers;
            
            foreach($AnswersTmp as $AnswerTmp) {
                
                $AnswerIdTmp = $AnswerTmp->AnswerID;
                
                if ($AnswerTmp->QuestionChecked) {
                    
                    $VoteResultSelect = 
                        "SELECT * FROM T_VOTE_RESULT WHERE ".
                        "FK_QUESTION = ".$QuestionIdTmp." AND ".
                        "FK_ANSWER = ".$AnswerIdTmp;

                    $VoteResultResult = $pdo->query($VoteResultSelect);

                    if ($VoteResultResult && $VoteResultResult->rowCount() > 0) {
                        
                        $VoteResultRow = $VoteResultResult->fetch(PDO::FETCH_ASSOC);
                        
                        $VoteQuantity = $VoteResultRow['QUANTITY'];
                        $VoteQuantity++;
                        
                        $VoteResultUpdate = 
                            "UPDATE T_VOTE_RESULT SET QUANTITY=".$VoteQuantity.
                            " WHERE FK_QUESTION = ".$QuestionTmp->QuestionID.
                            " AND FK_ANSWER = ".$AnswerTmp->AnswerID;
                        
                        $VoteResultUpdateStmnt = $pdo->prepare($VoteResultUpdate);
                        $VoteResultUpdateStmnt->execute();
                        
                    } else {                     
                        
                        $VoteResultInsert = 
                            "INSERT INTO T_VOTE_RESULT (FK_QUESTION, FK_ANSWER, QUEST_DATE, QUANTITY) values (".
                            $QuestionTmp->QuestionID.", ". 
                            $AnswerTmp->AnswerID.", ". 
                            "'".date("Y-m-d H:i:s")."', ". 
                            "1".
                            ");";                     
                        
                        $VoteResultInsertStmnt = $pdo->prepare($VoteResultInsert);
                        $VoteResultInsertStmnt->execute();     
                    }
                }
            }
        }
    }
?>