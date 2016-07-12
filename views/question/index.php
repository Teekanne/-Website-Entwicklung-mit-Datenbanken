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
    if (isset($_POST["inputkey"]) && isset($_SESSION['Quiz'])) {

        unset($_SESSION['Quiz']);
        $_SESSION['CurrPage'] = 0;
    }


    if (!isset($_SESSION['Quiz'])) {

        $QuizID = $_POST["inputkey"];
        
        $pdo = new Database();
        
        if (!$pdo) {
            echo "Verbindungsfehler!<br />";
        } 

        $QuizSelect = "SELECT * FROM T_QUIZ WHERE ID = ".$QuizID;
        $QuizResult = $pdo->query($QuizSelect);

        if ($QuizResult && $QuizResult->rowCount() > 0) {
            while ($QuizRow = $QuizResult->fetch(PDO::FETCH_ASSOC)) {

                $IsActive = $QuizRow['ISACTIVE'];

                if ($IsActive) {

                    $QuizTmp = new QuizEntity(); 

                    $QuizTmp->QuizTitle = $QuizRow['QUIZNAME'];

                    $Questions = array();

                    $QuestionSelect = "SELECT * FROM T_QUESTION WHERE FK_QUIZ = ".$QuizID." ORDER BY QUESTION_POS";
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

                            $Answers = array();

                            if ($AnswerResult && $AnswerResult->rowCount() > 0) {
                                while ($AnswerRow = $AnswerResult->fetch(PDO::FETCH_ASSOC)) { 

                                    $AnswerTmp = new AnswerEntity();
                                    $AnswerTmp->AnswerID = $AnswerRow['ID'];
                                    $AnswerTmp->AnswerText = $AnswerRow['ANSWER'];
                                    $AnswerTmp->QuestionChecked = 0;
                                    array_push($Answers, $AnswerTmp);
                                }  
                            }
                            $QuestionTmp->Answers = $Answers;
                            array_push($Questions, $QuestionTmp);
                        }
                        $QuizTmp->Questions = $Questions;
                    }
                    $_SESSION['Quiz'] = serialize($QuizTmp);

                } else {
                    echo "Das gewählte Quiz ist nicht aktiv!<br />";
                }
            }
        } else {
            echo 'Quiz existiert nicht<br>';
        }
    }

    if (!isset($_SESSION['CurrPage'])) {
        $_SESSION['CurrPage'] = 0;
    }

    if (
        isset($_POST['next']) || 
        isset($_POST['back']) || 
        isset($_POST['complete'])
    ) {
        
        $QuizTmp = new QuizEntity();

        $QuizTmp = unserialize($_SESSION['Quiz']);
        
        $QuestionsTmp = $QuizTmp->Questions;
        
        $KeysQuestion = array_keys($QuestionsTmp);
        $QuestionTmp = $QuestionsTmp[$KeysQuestion[$_SESSION['CurrPage']]];

        $AnswersTmp = $QuestionTmp->Answers;
        $KeysAnswers = array_keys($AnswersTmp);

        foreach($AnswersTmp as $AnswerTmp) {
            $AnswerTmp->QuestionChecked = 0;
        }

        if (isset($_POST['Result'])) {
            $ResultTmp = $_POST['Result'];
            foreach($ResultTmp as $ResultSingleTmp)
            {
                $AnswerTmp = $AnswersTmp[$KeysAnswers[$ResultSingleTmp]];
                $AnswerTmp->QuestionChecked = 1;
            }
        }	
        
        $_SESSION['Quiz'] = serialize($QuizTmp);

        if (isset($_POST['next'])) {

            //echo "### Werte ### ".sizeof($_SESSION['Questions'])." / ".($_SESSION['CurrPage']+1)."<br>";

            if (sizeof($QuestionsTmp) > ($_SESSION['CurrPage']+1)) {
                $_SESSION['CurrPage']++;
            }
        }
        if (isset($_POST['back'])) {
            if ($_SESSION['CurrPage'] > 0) {
                $_SESSION['CurrPage']--;		
            }
        }
        if (isset($_POST['complete'])) {
            header("Location: saveresults");
            exit;
        }
    }
?>

<form name="questionform" method="post" action="question">

    <?php
        $QuizTmp = unserialize($_SESSION['Quiz']);
        $QuestionsTmp = $QuizTmp->Questions;
        $keys = array_keys($QuestionsTmp);
        $QuestionTmp = $QuestionsTmp[$keys[$_SESSION['CurrPage']]];

        echo "<h2>".$QuizTmp->QuizTitle."</h2>";  

        echo "<p>";
        echo "Frage (".($_SESSION['CurrPage']+1)."/".sizeof($QuestionsTmp).")<br><br>";
        echo $QuestionTmp->QuestionText."<br>";
        echo "</p>";
    ?>

    <br><br><br>	

    <table style="border:0px solid #647852; border-collapse: collapse;" border="0">

        <tbody>
            <tr style="text-align: center; font-size: 75%; line-height: 0px;">
                <td style="width:50px">&nbsp</td>
                <td style="width:100px">&nbsp</td>
                <td style="width:100px">&nbsp</td>
                <td style="width:200px">&nbsp</td>
                <td style="width:100px">&nbsp</td>
                <td style="width:100px">&nbsp</td>
            </tr>

            <?php
                $QuizTmp = unserialize($_SESSION['Quiz']);
                $QuestionsTmp = $QuizTmp->Questions;
                $keys = array_keys($QuestionsTmp);
                $QuestionTmp = $QuestionsTmp[$keys[$_SESSION['CurrPage']]];

                $AnswersTmp = $QuestionTmp->Answers;

                $QuestionType = "";
                if($QuestionTmp->SingleChoice == 1) {
                    $QuestionType = "radio";
                } else {
                    $QuestionType = "checkbox";
                }

                $index = 0;
                foreach($AnswersTmp as $AnswerTmp)
                {

                    echo "<tr>";
                        echo "<td>&nbsp</td>";
                        echo "<td colspan=\"4\" style=\"font-size: 100%; padding-top: 0px; padding-bottom: 0px; padding-right: 25px\">";
                                echo $AnswerTmp->AnswerText;
                        echo "</td>";
                        echo "<td><input type=\"".$QuestionType."\" name=\"Result[]\" id=\"Result\" value=\"".$index."\" ";
                        if ($AnswerTmp->QuestionChecked == 1) {
                            echo "checked='checked' ";	
                        }
                        echo "/></td>";
                    echo "</tr>";

                    $index++;
                }
            ?>

        </tbody>
    </table>

    <br><br><br>

    <input type='submit' name='back' value='vorherige Frage'>
    &nbsp
    <input type='submit' name='next' value='nächste Frage'>
    <br><br>
    <input type='submit' name='complete' value='Quiz Abschliessen'>
</form>

<br>
