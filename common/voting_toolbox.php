<?php
    // QUESTION
    include_once("models/quiz_model.php");
    include_once("config/database.php");
    
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    //session_destroy();
?>

<?php

function deactivateQuiz($quizId)
{
    $retVal = false;
    
    $pdo = new Database();
    
    $SqlDeactivate = "UPDATE T_QUIZ SET ISACTIVE=0 WHERE ID=".$quizId;
    $SqlDeactivateStmnt = $pdo->prepare($SqlDeactivate);
    $retVal = $SqlDeactivateStmnt->execute();
    
    return $retVal;
}

function activateQuiz($quizId)
{
    $retVal = false;
    
    $pdo = new Database();
    
    $SqlActivate = "UPDATE T_QUIZ SET ISACTIVE=1 WHERE ID=".$quizId;
    $SqlActivateStmnt = $pdo->prepare($SqlActivate);
    $retVal = $SqlActivateStmnt->execute();
    
    resetQuizResults($quizId);
    
    return $retVal;
}

function resetQuizResults($quizId)
{
    $retVal = false;
    
    $pdo = new Database();
    
    $QuizSelect = "SELECT * FROM T_QUIZ WHERE ID = ".$quizId;
    $QuizResult = $pdo->query($QuizSelect);

    if ($QuizResult && $QuizResult->rowCount() > 0) {
        while ($QuizRow = $QuizResult->fetch(PDO::FETCH_ASSOC)) {
            
            $QuizTmp = new QuizEntity(); 

            $QuizTmp->QuizTitle = $QuizRow['QUIZNAME'];

            $Questions = array();

            $QuestionSelect = "SELECT * FROM T_QUESTION WHERE FK_QUIZ = ".$quizId." ORDER BY QUESTION_POS";
            $QuestionResult = $pdo->query($QuestionSelect);

            if ($QuestionResult && $QuestionResult->rowCount() > 0) {
                while ($QuestionRow = $QuestionResult->fetch(PDO::FETCH_ASSOC)) {
                    
                    $QuestionTmp = new QuestionEntity();

                    $QuestionTmp->QuestionID = $QuestionRow['ID'];
                    
                    $QuestionTmp->QuestionText = $QuestionRow['QUESTION'];
                    $QuestionTmp->SingleChoice = $QuestionRow['ISSINGLECHOICE'];
                    $QuestionTmp->QuestionDescription = $QuestionRow['DESCRIPTION'];
                    $QuestionTmp->QuestionKey = $QuestionRow['QKEY'];


                    $AnswerSelect = "SELECT * FROM T_ANSWER WHERE FK_QUESTION = ".$QuestionRow['ID']." ORDER BY ANSWER_POS";
                    $AnswerResult = $pdo->query($AnswerSelect);

                    if ($AnswerResult && $AnswerResult->rowCount() > 0) {
                        while ($AnswerRow = $AnswerResult->fetch(PDO::FETCH_ASSOC)) { 

                            $AnswerTmp = new AnswerEntity();
                            $AnswerTmp->AnswerID = $AnswerRow['ID'];
                            $AnswerTmp->AnswerText = $AnswerRow['ANSWER'];
                            $AnswerTmp->QuestionChecked = 0;

                            setQuestionResults($QuestionTmp->QuestionID, $AnswerTmp->AnswerID, false, true);
                        }  
                    }     
                }
            }
        }
    }
    
    return $retVal;
}

function setQuestionResults($questionId, $answerId, $increment, $reset)
{
    $retVal = false;
    
    $pdo = new Database();
    
    $VoteResultSelect = 
        "SELECT * FROM T_VOTE_RESULT WHERE ".
        "FK_QUESTION = ".$questionId." AND ".
        "FK_ANSWER = ".$answerId;

    $VoteResultResult = $pdo->query($VoteResultSelect);

    if ($VoteResultResult && $VoteResultResult->rowCount() > 0) {

        $VoteResultRow = $VoteResultResult->fetch(PDO::FETCH_ASSOC);

        if ($increment) {
            $VoteQuantity = $VoteResultRow['QUANTITY'];
            $VoteQuantity++;
        }
        if ($reset) {
            $VoteQuantity = 0;
        }

        $VoteResultUpdate = 
            "UPDATE T_VOTE_RESULT SET QUANTITY=".$VoteQuantity.
            " WHERE FK_QUESTION = ".$questionId.
            " AND FK_ANSWER = ".$answerId;

        $VoteResultUpdateStmnt = $pdo->prepare($VoteResultUpdate);
        $VoteResultUpdateStmnt->execute();

    } else {     
        
        if ($increment) {
            $VoteQuantity = 1;
        }
        if ($reset) {
            $VoteQuantity = 0;
        }

        $VoteResultInsert = 
            "INSERT INTO T_VOTE_RESULT (FK_QUESTION, FK_ANSWER, QUEST_DATE, QUANTITY) values (".
            $questionId.", ". 
            $answerId.", ". 
            "'".date("Y-m-d H:i:s")."', ". 
            $VoteQuantity.
            ");";                     

        $VoteResultInsertStmnt = $pdo->prepare($VoteResultInsert);
        $VoteResultInsertStmnt->execute();     
    }
}
    
?>

