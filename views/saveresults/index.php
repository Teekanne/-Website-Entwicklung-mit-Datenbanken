<?php
    // SAVE_RESULTS
    include_once("models/quiz_model.php");
    include_once("config/database.php");
    include_once("common/voting_toolbox.php");
    
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

        $QuizTmp = unserialize($_SESSION['Quiz']);
        $QuestionsTmp = $QuizTmp->Questions;
        
        foreach($QuestionsTmp as $QuestionTmp) {

            $QuestionIdTmp = $QuestionTmp->QuestionID;
            $AnswersTmp = $QuestionTmp->Answers;
            
            foreach($AnswersTmp as $AnswerTmp) {
                
                $AnswerIdTmp = $AnswerTmp->AnswerID;
                
                if ($AnswerTmp->QuestionChecked) {
                    
                    setQuestionResults($QuestionTmp->QuestionID, $AnswerTmp->AnswerID, true, false);
                }
            }
        }
    }
?>