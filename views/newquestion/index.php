<?php 
    include("Classes/LoadClasses.php"); 
    
    if(isset($_POST["quizName"])){

        $currentCategory = Category::Load($_POST["category"]);
        $currentUser = Tutor::Load($_SESSION["ID"]);
        $currentQuiz = Quiz::Add($_POST["quizName"], $_POST["quizDescription"], $currentUser, $currentCategory);
        
        /* Einfach mal 100 Fragen durchlaufen */
        for ($questionNumber = 1; $questionNumber <= 1000; $questionNumber++) {
            /* Wenn Frage Nummer x nicht mehr vorhanden, dann Abbruch */
            if(!isset($_POST["question" . $questionNumber])){
                break;
            }
            
            if($_POST["choice" . $questionNumber] == "singlechoice"){
                $singleChoice = true;
            }else{
                $singleChoice = false;
            }
            
            $currentQuestion = Question::Add($_POST["description" . $questionNumber], $_POST["question" . $questionNumber], $questionNumber, $singleChoice, $currentQuiz);
            
            for($answerNumber = 1; $answerNumber < 11; $answerNumber++){
                if(!isset($_POST["answer" . $questionNumber . "_" . $answerNumber])){ break; }
                
                if(empty($_POST["answer" . $questionNumber . "_" . $answerNumber])) { break; }
                
                $currentAnswer = Answer::Add($answerNumber, $_POST["answer" . $questionNumber . "_" . $answerNumber], true, $currentQuestion);
            }
            
            echo "<h2>Glückwunsch! Du hast ein neues Quiz erstellt!</h2>";
            echo "<form><table table border='0'>";
            echo "<tr>";
            echo "<td class='cells'><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Abfrageurl</label></td>";
            $key = $currentQuiz->__get("qKey");
            echo "<td class='cells'><input type='text' value='SUB-URL??/$key'/></td>";
            echo "</tr>";
            echo "</table></form>";
        }
    }
?>

<h2>Neue Umfrage erstellen</h2>
<form action="" method="post">
    <table table border= '0'>
        <tr>
            <td class='cells'><label>Kategorie</label></td>
            <td class='cells'><?php Category::ShowSelectBoxWithCategories($_SESSION["ID"]); ?></td>
        </tr>
        <tr>
            <td class='cells'><label>Quiz-Name</label></td>
            <td class='cells'><input type="text" name="quizName" required/></td>
        </tr>
        <tr>
            <td class='cells'><label>Quiz-Beschreibung</label></td>
            <td class='cells'><input type="text" name="quizDescription"/></td>
        </tr>
    </table>
    
    <br /><hr><br />
    
    <table table border='0'>
        <tr>
            <td class='cells'><label>Frage</label></td>
            <td class='cells'><input type="text" name="question1" required/></td>
        </tr>
        <tr>
            <td class='cells'><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Beschreibung</label></td>
            <td class='cells'><textarea name="description1" maxlength="1000"></textarea></td>
        </tr>
        <tr>
            <td class='cells'><label>Antworten</label></td>
            <td class='cells'> 
                <div class="divAnswers1">
                    <input type="text" name="answer1_1" placeholder="Antwortmöglichkeit 1" required/><br />
                    <input type="text" name="answer1_2" placeholder="Antwortmöglichkeit 2" onkeydown="addTextbox('divAnswers1', 'answer1_2');" required/>
                </div>
            </td>
        </tr>
        <tr>
            <td><label>Art</label></td>
            <td class='cells'>
                <input type="radio" name="choice1" value="singlechoice" checked="checked" /><label class="radioLabel">Single-Choice</label><br />
                <input type="radio" name="choice1" value="multiplechoice" /><label class="radioLabel">Multiple-Choice</label>
            </td>                            
        </tr>
    </table>
    
    <input type="button" value="Neue Frage einfügen" onclick="addNewQuestion('questionTable', 'question1');">  <input type="submit" value="Jetzt erstellen &raquo"/>
</form>
