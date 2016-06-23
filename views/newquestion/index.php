<?php 

    include("Categories.php"); 

    function ShowSelectBoxWithCategories(){
        echo "<select name='category'>";
        foreach(Category::GetFirstLevelCategories() as $c => $category){
            echo "<option>" . $category->__get("catname") . "</option>";

            foreach($category->GetSecondLevelCategories() as $s => $secondLevelCategory){
                echo "<option>- " . $secondLevelCategory->__get("catname") . "</option>";
            }
        }        
        
        echo "</select>";
    }
?>

<h2>Neue Umfrage erstellen</h2>
<form action="frmSaveQuestion.php" method="post">
    <table id="questionTable">
        <tr>
            <th>Kategorie</th>
            <th><?php ShowSelectBoxWithCategories(); ?></th>
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
                <input type="radio" name="choice1" value="singlechoice" checked="checked"/><label>Single-Choice</label><br />
                <input type="radio" name="choice1" value="multiplechoice"/><label>Multiple-Choice</label>
            </th>                            
        </tr>
    </table>
    
    <input type="button" value="Neue Frage einfügen" onclick="addNewQuestion('questionTable', 'question1');">  <input type="submit" value="Jetzt erstellen &raquo"/>
</form>
