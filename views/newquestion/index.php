<?php

    class Category {
        /* ID CATNAME LEVEL FK_TUTOR FK_PARENT_ID*/
        private $id;
        private $catname;
        private $level;
        private $fkTutor;
        private $fkParentId;
        private $dataBase;
        private $pdo;
        
        public function __get($key){
            if(property_exists($this, $key)){
                return $this->$key;                
            }
        }
        
        public function __set($key, $value){
            if(property_exists($this, $key)){
                $this->$key = $value;
            }
        }

        public function __construct($id, $catname, $level, $fkTutor, $fkParentId){
            $this->id = $id;
            $this->catname = $catname;
            $this->level = $level;
            $this->fkTutor = $fkTutor;
            $this->fkParentId = $fkParentId;
            $this->pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
        }
        
        public static function Load($name) {
            $db = new DataBase();
            $column = $db->SelectRow("SELECT * FROM T_CATEGORY WHERE CATNAME='" . $name . "'");
            return new Category($column["ID"], $column["CATNAME"], $column["LEVEL"], $column["FK_TUTOR"], $column["FK_PARENT_ID"]);
        }
        
        /* Gibt eine Liste des generischen Typs "Category" zurück */
        public static function GetFirstLevelCategories(){
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            $result = $pdo->query("SELECT * FROM T_CATEGORY WHERE LEVEL=1 ORDER BY ID");
            $categories = array();
            foreach($result as $r => $category){
                array_push($categories, new Category($category["ID"], $category["CATNAME"], $category["LEVEL"], $category["FK_TUTOR"], $category["FK_PARENT_ID"]));
            }
            return $categories;
        }
        
        public function GetSecondLevelCategories(){
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            $result = $pdo->query("SELECT * FROM T_CATEGORY WHERE FK_PARENT_ID=" . $this->id);
            $categories = array();
            foreach($result as $r => $category){
                array_push($categories, new Category($category["ID"], $category["CATNAME"], $category["LEVEL"], $category["FK_TUTOR"], $category["FK_PARENT_ID"]));
            }
            return $categories;            
        }
    }
    

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
            <th><textarea name="description" maxlength="1000"></textarea></th>
        </tr>
        <tr>
            <th>Antworten</th>
            <th> 
                <div id="divAnswers1">
                    <input type="text" name="answer[]" id="answer1_1" placeholder="Antwortmöglichkeit 1" /><br />
                    <input type="text" name="answer[]" id="answer1_2" placeholder="Antwortmöglichkeit 2" onkeydown="addTextbox('divAnswers1', this);" />
                </div>
            </th>
        </tr>
        <tr>
            <th>Art</th>
            <th>
                <input type="radio" name="choice1" value="singlechoice" checked="checked"/><label>Single-Choice</label><br />
                <input type="radio" name="choice1" value="multiplechoice"/><label>Multiple-Choice</label>
            </th>                            
        </tr>            <th>Beschreibung</th>
    </table>
    
    <input type="button" value="Neue Frage einfügen" onclick="addNewQuestion('questionTable', 'question1');">  <input type="submit" value="Jetzt erstellen &raquo"/>
</form>
