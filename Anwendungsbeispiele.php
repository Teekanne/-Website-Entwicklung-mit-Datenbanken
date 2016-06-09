<html>
    <head></head>
    <body>
	<h1>Anwendungsbeispiele</h1>
	
        <?php
            echo "<h3>Beispiel: Objekte erzeugen - Getter und Setter anwenden</h3>";
		
            include_once("testimeter.php");
            include_once("testimeter.php");
            
            echo "<h3>Beispiel: Datenbank-Klasse verwenden</h3>";
			
            include_once("DataBase.php");
			
            $dataBase = new DataBase();
      
            
            echo "<br /><br />getColumn(): Attributwerte von 'Catname' aus Relation 't_category' ausgeben:<ul>";
            
            foreach($dataBase->getColumn("T_CATEGORY", "CATNAME") as $catName){
                echo "<li>".$catName."</li>";
            }
            echo "</ul>";
			
            echo "Select(): 'SELECT * FROM T_CATEGORY' anwenden und ausgeben:<br />";
            echo var_dump($dataBase->Select("SELECT * FROM T_CATEGORY"));
            
            $insertedId = $dataBase->insert(
                    "T_QUESTION", 
                    array("FK_CAT" => 1, "FK_TUTOR" => 2, "ISACTIVE" => 1, "OWNER" => "ich", "QKEY" => "key", "QUESTION" => "Wie alt?"));;
            
            echo "insert: " . $insertedId;
        ?>
    </body>
</html>