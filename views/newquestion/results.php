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
        echo "Frage: " . $myQuestion->__get("question") . "<br />";
        $myQuestion->ShowTable();
        
        if($myQuestion->__get("questionPos") > 1){
            echo "<form method='GET' action=''>";
            echo "<input type='text' hidden name='key' value='". $myQuiz->__get("qKey") . "'>";
            
            echo "<input type='text' hidden name='pos' value='". ($myQuestion->__get("questionPos")-1) . "'>";
            echo "<input type='submit' value='Zuvorrige Frage'>";
            echo "</form>";
        }
        
        if(!$myQuestion->IsLastQuestion()){
            echo "<form method='GET'>";
            echo "<input type='text' hidden name='key' value='". $myQuiz->__get("qKey") . "'>";
            echo "<input type='text' hidden name='pos' value='". ($myQuestion->__get("questionPos")+1) . "'>";
            
            echo "<input type='submit' value='Nächste Frage'>";
            echo "</form>";
        }
        
    }
    
    
    

?>