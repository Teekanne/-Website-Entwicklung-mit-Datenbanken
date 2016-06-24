<?php 
    include("Category.php"); 
    
    if(isset($_POST["quizName"])){
        echo "Sessions: " . var_dump($_SESSION);
        echo '<br /><br />POST-Variablen:';
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        /*
        $currentCategory = Category::Load($_POST["category"]);
        /*
        $currentQuiz = new Quiz(
                $_POST["quizName"], 
                $_POST["quizDescription"],
                $_SESSION["id"], 
                $currentCategory->id);
        
        echo "CurrentQuiz->ID: " . $currentQuiz->id;*/
    }
?>

<h2>Neue Umfrage erstellen</h2>
<form action="" method="post">
    <table border= '0' id="questionTable">
        <tr>
            <th><label>Kategorie</label></th>
            <th><?php Category::ShowSelectBoxWithCategories(); ?></th>
        </tr>
        <tr>
            <th><label>Quiz-Name</label></th>
            <th><input type="text" name="quizName" placeholder="Quiz-Name" /></th>
        </tr>
        <tr>
            <th><label>Quiz-Beschreibung</label></th>
            <th><input type="text" name="quizDescription" placeholder="Quiz-Beschreibung" /></th>
        </tr>
        
        <?php for($i=0;$i<20;$i++){ echo "<tr></tr>"; } ?>
        <tr>
            <th><label>Frage</label></th>
            <th><input type="text" name="question1"/></th>
        </tr>
        <tr>
            <th><label>Beschreibung</label></th>
            <th><textarea name="description1" maxlength="1000"></textarea></th>
        </tr>
        <tr>
            <th><label>Antworten</label></th>
            <th> 
                <div class="divAnswers1">
                    <input type="text" name="answer1_1" placeholder="Antwortmöglichkeit 1" /><br />
                    <input type="text" name="answer1_2" placeholder="Antwortmöglichkeit 2" onkeydown="addTextbox('divAnswers1', 'answer1_2');" />
                </div>
            </th>
        </tr>
	
        <tr>
            <th><label>Art</label></th>
            <th>
                <input type="radio" name="choice1" value="singlechoice" checked="checked"/>Single-Choice<br />
                <input type="radio" name="choice1" value="multiplechoice"/>Multiple-Choice
            </th>                            
        </tr>
    </table>
    <br />
	<table>
		<tr>
			<th>
				<input type="button" value="Neue Frage einfügen" onclick="addNewQuestion('questionTable', 'question1');">  <input type="submit" value="Jetzt erstellen &raquo"/>
			</th>
		<tr>
	</table>
</form>

