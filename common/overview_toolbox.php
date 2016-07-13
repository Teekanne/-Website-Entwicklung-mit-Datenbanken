<?php
include_once("config/database.php");

function generateQuizOverview($TutorId, $CategoryId)
{
    $pdo = new Database();
    
    $QuizSelect = 
        "SELECT * FROM T_QUIZ ".
        "WHERE ".
        "FK_TUTOR = ".$TutorId." AND ".
        "FK_CATEGORY = ".$CategoryId." ".
        "ORDER BY ID";

    $QuizResult = $pdo->query($QuizSelect);

    if ($QuizResult && $QuizResult->rowCount() > 0) {
        while ($Quiz = $QuizResult->fetch(PDO::FETCH_ASSOC)) {

            $IsQuizActive = $Quiz['ISACTIVE'];

            /*
            echo
                'ID: '.$Quiz['ID'].', '.
                'QUIZNAME: '.$Quiz['QUIZNAME'].', '.
                'DESCRIPTION: '.$Quiz['DESCRIPTION'].', '.
                'ACTIVE: '.$IsQuizActive.', '.
                'FK_TUTOR: '.$Quiz['FK_TUTOR'].', '.
                'QKEY: '.$Quiz['QKEY'].', '.
                'FK_CATEGORY: '.$Quiz['FK_CATEGORY'].'<br>';
             */

            echo
                '<tr>'.
                '<td>&nbsp</td>'.
                '<td>&nbsp</td>'.
                '<td>&nbsp</td>'.
                '<td style="padding-right: 25px">';

            if($IsQuizActive == 1) {                             
                echo '<a id="current" href="'.URL.'result?key='.$Quiz['QKEY'].'"> <b>-</b> &nbsp;&nbsp;'.$Quiz['QUIZNAME'].' (Q-Key: '.$Quiz['QKEY'].')</a><br>';
            } else {
                echo '<b>-</b> &nbsp;&nbsp;'.$Quiz['QUIZNAME'];
            }

            echo
                '</td>'.
                '<td style="text-align: center">';

            if($IsQuizActive == 0) {

                echo 
                    '<a id="start" href="'.URL.
                    'overview?ACTIVATE_QUIZ_ID='.$Quiz['ID'].
                    '"><b>starten</b></a><br>'; 

            } else {
                
                echo 
                    '<a id="close" href="'.URL.
                    'overview?DEACTIVATE_QUIZ_ID='.
                    $Quiz['ID'].'"><b>beenden</b></a><br>';   
                
            }

            echo
                '</td>'.
                '<td>&nbsp</td>'.
                '<td style="text-align: center">'.
                'löschen'.
                '</td>'.
                '</tr>';
        }
    } 
}

