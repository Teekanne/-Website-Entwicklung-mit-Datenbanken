<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <?php
            $questionID="xyxyzza";
            $referer = $_SERVER["HTTP_REFERER"];
            $questionUrl = explode("askquestion.php", $referer)[0]."q.php?id=$questionID";

            include_once("testimeter.php");
            include_once("DataBase.php");

            $currentQuestion = null;
            $currentCategory = null;
            
            if(isset($_POST["question"]) && isset($_POST["answer"]) && isset($_POST["category"])){
                
                $currentCategory = Category::Load($_POST["category"]);
                $currentQuestion = Question::SaveQuestion($_POST["description"], $currentCategory->__get("id"), 2, 1, "Ich", "Key", $_POST["question"]);
                $currentQuestion->SaveAnswers($_POST["answer"]);
            }
        ?>
      
  </head>

  <body>

    <?php
        if($currentQuestion == null){
            echo "<h1>Es wurde keine Frage gestellt</h1>";
        }else{
            echo "<h1>".$currentQuestion->__get("question")."</h1>";
            
            echo "<h2>".$currentQuestion->__get("description")."</h2>";
            foreach($currentQuestion->GetAnswers() as $answer => $key){
                echo "<h3>".$key."</h3>";
            }
            
            echo "<h3>Kategorie: " . $currentCategory->__get("name") . "</h3>";
        }
      
      echo "<br /><p>Sende diese Frage weiter: </p>";
      echo "<form action='q.php?id=$questionID'>";
      echo "<input type='text' onfocus='this.select();' value='$questionUrl'/><br /><br />";
      echo "<input type='button' value='Ergebnisse aktualisieren &raquo;' /><br /><br />";
      echo "<input type='button' value='Umfrage beenden &raquo;' /><br />";
      
      echo "</form>";
    ?>
  </body>
</html>
