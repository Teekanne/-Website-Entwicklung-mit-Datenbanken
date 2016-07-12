<?php
    // OVERVIEW
    include_once("models/quiz_model.php");
    include_once("config/database.php");
    include_once("common/voting_toolbox.php");
    
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    //session_destroy();
?>

<h2>
    Übersicht über ihre aktuellen Umfragen
</h2>
<br>

<br>

<?php
    $logged = $_SESSION['loggedIn'];
    if ($logged == false){
        echo "NICHT EINGELOGGT!<br>";
        session_destroy();
        header('location: ../login');
        exit;
    }

    
    $Tutor_ID = $_SESSION['ID'];

    if (!isset($_SESSION['CurrPage'])) {
        $_SESSION['CurrPage'] = 0;
    }

    
    $pdo = new Database();

    if (!$pdo) {
        echo "Verbindungsfehler!<br />";
    } 
    
    
    if (isset($_GET['DEACTIVATE_QUIZ_ID'])) {
        deactivateQuiz($_GET['DEACTIVATE_QUIZ_ID']);
    } 
    
    if (isset($_GET['ACTIVATE_QUIZ_ID'])) {
        activateQuiz($_GET['ACTIVATE_QUIZ_ID']);
    }
    
    echo
        '<table style="border:0px solid #647852; border-collapse: collapse;" border="0">'.
        '<tbody>'.
        '<tr style="text-align: left; font-size: 75%; line-height: 0px;">'.
            '<td style="width:10px">&nbsp</td>'.
            '<td style="width:25px">&nbsp</td>'.
            '<td style="width:25px">&nbsp</td>'.
            '<td style="width:500px">&nbsp</td>'.
            '<td style="width:50px">&nbsp</td>'.
            '<td style="width:10px">&nbsp</td>'.
            '<td style="width:50px">&nbsp</td>'.
        '</tr>';

    $CategoryParentSelect = 
        "SELECT * FROM T_CATEGORY ".
        "WHERE FK_PARENT_ID IS NULL AND FK_TUTOR = ".$Tutor_ID." ".
        "ORDER BY ID";

    $CategoryParentResult = $pdo->query($CategoryParentSelect);

    if ($CategoryParentResult && $CategoryParentResult->rowCount() > 0) {
        while ($CategoryParent = $CategoryParentResult->fetch(PDO::FETCH_ASSOC)) {

            echo
                '<tr>'.
                '<td>&nbsp</td>'.
                '<td colspan="5" text-align = "left"; style="font-weight: bold; font-size: 140%; padding-top: 20px; padding-bottom: 10px; padding-right: 25px">'.
                '<label id=overviewLabel>&bull;&nbsp;&nbsp;'.$CategoryParent['CATNAME'].'</label>'.
                '</td>'.
                '</tr>';

            /*
            echo
                '<tr style="text-align: center; font-size: 100%">'.
                '<td>&nbsp</td>'.
                '<td>&nbsp</td>'.
                '<td>&nbsp</td>'.
                '<td>&nbsp</td>'.
                '<td>inaktiv</td>'.
                '<td>&nbsp</td>'.
                '<td>aktiv</td>'.
                '</tr>';
             */


            $CategoryParentID = $CategoryParent['ID'];

            $CategoryChildSelect = 
                "SELECT * FROM T_CATEGORY ".
                "WHERE ".
                "FK_PARENT_ID IS NOT NULL AND ".
                "FK_TUTOR = ".$Tutor_ID." AND ".
                "FK_PARENT_ID = ".$CategoryParentID." ".
                "ORDER BY ID";

            $CategoryChildResult = $pdo->query($CategoryChildSelect);

            if ($CategoryChildResult && $CategoryChildResult->rowCount() > 0) {
                while ($CategoryChild = $CategoryChildResult->fetch(PDO::FETCH_ASSOC)) {

                    echo
                        '<tr>'.
                        '<td>&nbsp</td>'.
                        '<td>&nbsp</td>'.
                        '<td colspan="4" style="font-weight: bold; text-align = solid; font-size: 120%; padding-top: 10px; padding-bottom: 5px;  padding-right: 20px">'.
                        '&bull;&nbsp;&nbsp;'.
                        $CategoryChild['CATNAME'].
                        '</td>'.
                        '</tr>';

                    $CategoryChildID = $CategoryChild['ID'];

                    $QuizSelect = 
                        "SELECT * FROM T_QUIZ ".
                        "WHERE ".
                        "FK_TUTOR = ".$Tutor_ID." AND ".
                        "FK_CATEGORY = ".$CategoryChildID." ".
                        "ORDER BY ID";

                    $QuizResult = $pdo->query($QuizSelect);

                    if ($QuizResult && $QuizResult->rowCount() > 0) {
                        while ($Quiz = $QuizResult->fetch(PDO::FETCH_ASSOC)) {

                            echo
                                '<tr>'.
                                '<td>&nbsp</td>'.
                                '<td>&nbsp</td>'.
                                '<td>&nbsp</td>'.
                                '<td style="padding-right: 25px">';

                            if($Quiz['ISACTIVE'] == 1) {
                                echo '<a id="current" href="'.URL.'result?key='.$Quiz['QKEY'].'"> <b>-</b> &nbsp;&nbsp;'.$Quiz['QUIZNAME'].' (Q-Key: '.$Quiz['QKEY'].')</a><br>';
                                //echo '<a href="'.URL.'takesurvey">'.$Quiz['QUIZNAME'].' mentee</a>';
                            } else {
                                echo '<b>-</b> &nbsp;&nbsp;'.$Quiz['QUIZNAME'];
                            }

                            echo
                                '</td>'.
                                '<td style="text-align: center">';

                            if($Quiz['ISACTIVE'] == 0) {
                                
                                echo '<a id="start" href="'.URL.'overview?ACTIVATE_QUIZ_ID='.$Quiz['ID'].'"><b>starten</b></a><br>'; 
                                
                            } else {
                                    echo '&nbsp';
                            }

                            echo
                            '</td>'.
                            '<td>&nbsp</td>'.
                            '<td style="text-align: center">';

                            if($Quiz['ISACTIVE'] == 1) {
                                                                    
                                echo '<a id="close" href="'.URL.'overview?DEACTIVATE_QUIZ_ID='.$Quiz['ID'].'"><b>beenden</b></a><br>';                               
                                    
                            } else {
                                    echo '&nbsp';
                            }

                            echo
                            '</td>'.
                            '</tr>';
                        }
                    }
                }
            }
        }
        
        echo
            '</tbody>'.
            '</table>'.
            '</p></p>';
        
        
    } else {
        echo "<p>Leere Ergebnismenge!</p><br />";
    }
 ?>








