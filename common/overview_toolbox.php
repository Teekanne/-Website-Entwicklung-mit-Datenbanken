<?php
include_once("config/database.php");

// Generates the Main Part of the table for Quiz overview.
// It is a separate function, because it has to be used from two aspects...
// 1 - Parent Categories
// 2 - Child Categories
// The Shell of the table is already existing
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

            echo
                '<tr>'.
                '<td>&nbsp</td>'.
                '<td>&nbsp</td>'.
                '<td>&nbsp</td>'.
                '<td style="padding-right: 25px">';

            // Quiz-Name / Quiz-Key

            // When a Quiz is active...
            // ... display link to results (Quiz-Name) and Quiz-Key
            echo '<a id="current" href="'.URL.'result?key='.$Quiz['QKEY'].'"> <b>-</b> &nbsp;&nbsp;'.$Quiz['QUIZNAME'].' (Q-Key: '.$Quiz['QKEY'].')</a><br>';

            echo
                '</td>'.
                '<td style="text-align: center">';

            // ACTIVATE / DEACTIVATE Quiz
            if($IsQuizActive == 1) {
                // When a Quiz is active...
                // ... display link to deactivate
                echo 
                    '<td style="text-align: center">'.
                    '<a id="close" href="'.URL.
                    'overview?DEACTIVATE_QUIZ_ID='.
                    $Quiz['ID'].'"><b>beenden</b></a>'.
                    '</td>';   
            } else {
                // When a Quiz is inactive...
                // ... display link to activate
                 echo 
                    '<td style="text-align: center">'.
                    '<a id="start" href="'.URL.
                    'overview?ACTIVATE_QUIZ_ID='.$Quiz['ID'].
                    '"><b>starten</b></a>'.
                    '</td>';      
            }

            // DELETE Quiz
            echo
                '<td style="text-align: center">'.
                '<a href="'.URL.
                'overview?DELETE_QUIZ_ID='.
                $Quiz['ID'].'"><b>löschen</b></a>'.
                '</td>'.
                '</tr>'; 
        }
    } 
}

