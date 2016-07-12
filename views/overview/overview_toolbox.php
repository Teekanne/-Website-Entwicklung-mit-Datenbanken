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
    
    return $retVal;
}

?>

