<?php
    // SAVE_RESULTS

    // Upon completing a Survey,
    // the checked Answers will be added to
    // its corresponding Result Rows in (t_vote_result)

    include_once("models/quiz_model.php");
    include_once("config/database.php");
    include_once("common/voting_toolbox.php");
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    //session_destroy();
?>


<label style="font-size: 250%; text-align: center; font-family:Helvetica;">
    
    <br><br>
    
    Vielen Dank für Ihre Teilnahme!
    
    <br>&nbsp;<br>
    
    <div id="containerImg">
        <img src="images/check.png">
    </div>
</label>


<br>

<?php
    if (isset($_SESSION['Quiz'])) {
        
        $pdo = new Database();

        // Loading Quiz Data from Session
        $QuizTmp = unserialize($_SESSION['Quiz']);
        $QuestionsTmp = $QuizTmp->Questions;
        
        foreach($QuestionsTmp as $QuestionTmp) {

            $QuestionIdTmp = $QuestionTmp->QuestionID;
            $AnswersTmp = $QuestionTmp->Answers;
            
            foreach($AnswersTmp as $AnswerTmp) {
                
                $AnswerIdTmp = $AnswerTmp->AnswerID;
                
                if ($AnswerTmp->QuestionChecked) {
                    
                    // Incrementing the vote Count quantity of the checked Answer
                    setQuestionResults($QuestionTmp->QuestionID, $AnswerTmp->AnswerID, true, false);
                    // If at least one Answer is given, the Quiz is marked as completed in Session
                    $_SESSION['completed'.$QuestionTmp->QuestionKey] = true;
                }
            }
        }
    }
?>