<?php 
    include("Classes/LoadClasses.php"); 
    
    if(isset($_GET["key"])){
        if($_GET["key"] == "123") {
            echo "Du hast Frage " . $_GET["key"] . " aufgerufen";
        }else{
            echo "Die frage ist nicht vorhanden";
        }
    }
    
    if(isset($_POST["quizName"])){

        $currentCategory = Category::Load($_POST["category"]);
        $currentUser = Tutor::Load($_SESSION["ID"]);
        $currentQuiz = Quiz::Add($_POST["quizName"], $_POST["quizDescription"], $currentUser, $currentCategory);
        
        echo "Quiz gespeichert: " . var_dump($currentQuiz) . "<br />";
        
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
                echo "Antwort gespeichert: " . var_dump($currentAnswer) . "<br />";
            }
            
            echo "Frage gespeichert: " . var_dump($currentQuestion) . "<br />";
            
        }
    }
?>

<h2>Neue Umfrage erstellen</h2>
<form action="" method="post">
    <table table border= '0'>
        <tr>
            <th><label>Kategorie</label></th>
            <th><?php Category::ShowSelectBoxWithCategories($_SESSION["ID"]); ?></th>
        </tr>
        <tr>
            <th><label>Quiz-Name</label></th>
            <th><input type="text" name="quizName" required/></th>
        </tr>
        <tr>
            <th><label>Quiz-Beschreibung</label></th>
            <th><input type="text" name="quizDescription"/></th>
        </tr>
    </table>
    
    <br /><hr><br />
    
    <table table border= '0' id="questionTable">
        <tr>
            <th><label>Frage</label></th>
            <th><input type="text" name="question1" required/></th>
        </tr>
        <tr>
            <th><label>Beschreibung</label></th>
            <th><textarea name="description1" maxlength="1000"></textarea></th>
        </tr>
        <tr>
            <th><label>Antworten</label></th>
            <th> 
                <div class="divAnswers1">
                    <input type="text" name="answer1_1" placeholder="Antwortmöglichkeit 1" required/><br />
                    <input type="text" name="answer1_2" placeholder="Antwortmöglichkeit 2" onkeydown="addTextbox('divAnswers1', 'answer1_2');" required/>
                </div>
            </th>
        </tr>
        <tr>
            <th><label>Art</label></th>
            <th>
                <input type="radio" name="choice1" value="singlechoice" checked="checked">Single-Choice</input><br />
                <input type="radio" name="choice1" value="multiplechoice">Multiple-Choice</input>
            </th>                            
        </tr>
    </table>
    
    <input type="button" value="Neue Frage einfügen" onclick="addNewQuestion('questionTable', 'question1');">  <input type="submit" value="Jetzt erstellen &raquo"/>
</form>
