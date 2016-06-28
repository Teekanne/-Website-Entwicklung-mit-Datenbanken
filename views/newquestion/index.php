<?php 
    include("Classes/LoadClasses.php"); 
    
    if(isset($_POST["quizName"])){
        echo "Sessions: " . nl2br(print_r($_SESSION,true));

        echo '<br /><br />POST-Variablen:';
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        
        $currentCategory = Category::Load($_POST["category"]);

        $currentUser = Tutor::Load($_SESSION["ID"]);
        
        $currentQuiz = Quiz::Add("test", "test", $currentUser, $currentCategory);
        /* Add($description, $question, $questionPos, $singleChoice, $quiz){ */
        $currentQuestion = Question::Add("test", "test", 1, true, $currentQuiz);
        $currentAnswer = Answer::Add(1, "XD", true, $currentQuestion);
        echo "antwortid:" . $currentAnswer->__get("id");
    }
?>

<h2>Neue Umfrage erstellen</h2>
<form action="" method="post">
    <table id="questionTable">
        <tr>
            <th>Kategorie</th>
            <th><?php Category::ShowSelectBoxWithCategories(); ?></th>
        </tr>
        <tr>
            <th>Quiz-Name</th>
            <th><input type="text" name="quizName" placeholder="Quiz-Name" /></th>
        </tr>
        <tr>
            <th>Quiz-Beschreibung</th>
            <th><input type="text" name="quizDescription" placeholder="Quiz-Beschreibung" /></th>
        </tr>
        
        <?php for($i=0;$i<20;$i++){ echo "<tr></tr>"; } ?>
        <tr>
            <th>Frage</th>
            <th><input type="text" name="question1"/></th>
        </tr>
        <tr>
            <th>Beschreibung</th>
            <th><textarea name="description1" maxlength="1000"></textarea></th>
        </tr>
        <tr>
            <th>Antworten</th>
            <th> 
                <div class="divAnswers1">
                    <input type="text" name="answer1_1" placeholder="Antwortmöglichkeit 1" /><br />
                    <input type="text" name="answer1_2" placeholder="Antwortmöglichkeit 2" onkeydown="addTextbox('divAnswers1', 'answer1_2');" />
                </div>
            </th>
        </tr>
        <tr>
            <th>Art</th>
            <th>
                <input type="radio" name="choice1" value="singlechoice" checked="checked">Single-Choice</input><br />
                <input type="radio" name="choice1" value="multiplechoice">Multiple-Choice</input>
            </th>                            
        </tr>
    </table>
    
    <input type="button" value="Neue Frage einfügen" onclick="addNewQuestion('questionTable', 'question1');">  <input type="submit" value="Jetzt erstellen &raquo"/>
</form>
