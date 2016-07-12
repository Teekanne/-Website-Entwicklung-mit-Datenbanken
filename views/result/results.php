<?php
    include("../../common/LoadClasses.php"); 
    
    $myQuiz = Quiz::LoadByKey($_GET["key"]);
    
    
    if(isset($_GET["pos"])){
        $pos = $_GET["pos"];
    }else{
        $pos = 1;
    }
    $myQuestion = Question::LoadByQuiz($myQuiz, $pos);
    
    if($myQuestion){
        echo "<table>";
        echo "<tr>";
        echo "<td>Quiz:</td>";
        echo "<td>" . $myQuiz->__get("name") . "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td>Quiz-Key:</td>";
        echo "<td>" . $myQuiz->__get("qKey") . "</td>";
        echo "</tr>";
        
        if(strlen($myQuiz->__get("description"))>1){
            echo "<tr>";
            echo "<td>Quiz-Beschreibung: </td>";
            echo "<td>" . $myQuiz->__get("description") . "</td>";
            echo "</tr>";
        }
        
        echo "<tr>";
        echo "<td>Frage: </td>";
        echo "<td>" . $myQuestion->__get("question") . "</td>";
        echo "</tr>";
        
        if(strlen($myQuestion->__get("description"))>1){
            echo "<tr>";
            echo "<td>Fragen-Beschreibung</td>";
            echo "<td>" . $myQuestion->__get("description") . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        
        $myQuestion->ShowTable();
        
        echo "<form method='GET'>";
        echo "<input type='text' hidden name='key' value='". $myQuiz->__get("qKey") . "'>";
        echo "<table><tr>";
        if($myQuestion->__get("questionPos") > 1){
            echo "<td><button type='submit' name='pos' value='" . ($myQuestion->__get("questionPos")-1) . "'    >← Zuvorrige Frage</button></td>";
        }
        
        if(!$myQuestion->IsLastQuestion()){
            echo "<td><button type='submit' name='pos' value='" . ($myQuestion->__get("questionPos")+1) . "'>Nächste Frage →</button></td>";
        }
        echo "</tr></table>";
        echo "</form>";
        
    }
?>
