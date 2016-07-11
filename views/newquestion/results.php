<?php
    include("../../public/php/LoadClasses.php"); 
    
    $myQuiz = Quiz::LoadByKey($_GET["key"]);
    
    
    if(isset($_GET["pos"])){
        $pos = $_GET["pos"];
    }else{
        $pos = 1;
    }

    $myQuestion = Question::LoadByQuiz($myQuiz, $pos);
    
    if($myQuestion){
        echo "Quiz: " . $myQuiz->__get("name") . "<br />";
        echo "Quiz-Beschreibung: " . $myQuiz->__get("description") . "<br />";
        
        echo "Frage: " . $myQuestion->__get("question") . "<br />";
        echo "Fragen-Beschreibung: " . $myQuestion->__get("description") . "<br />";
        
        $myQuestion->ShowTable();
        
        echo "<form method='GET'>";
        echo "<input type='text' hidden name='key' value='". $myQuiz->__get("qKey") . "'>";

        if($myQuestion->__get("questionPos") > 1){
            echo "<button type='submit' name='pos' value='" . ($myQuestion->__get("questionPos")-1) . "' text='XD'>Zuvorrige Frage</button>";
        }
        
        if(!$myQuestion->IsLastQuestion()){
            echo "<button type='submit' name='pos' value='" . ($myQuestion->__get("questionPos")+1) . "' text='XD'>Nächste Frage</button>";
        }
        
        echo "</form>";
        
    }
    
    
    

?>
