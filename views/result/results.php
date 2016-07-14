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
        /**
         * Displaying general informations about the quiz 
         */
        echo "</br><table>";
        echo "<tr>";
        echo "<td>Quiz:</td>";
        echo "<td>&nbsp;&nbsp&nbsp;&nbsp;" . $myQuiz->__get("name") . "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td>Quiz-Key:</td>";
        echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;" . $myQuiz->__get("qKey") . "</td>";
        echo "</tr>";
        
        if(strlen($myQuiz->__get("description"))>1){
            echo "<tr>";
            echo "<td>Quiz-Beschreibung: </td>";
            echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;" . $myQuiz->__get("description") . "</td>";
            echo "</tr>";
        }
        
        echo "<tr>";
        echo "<td>Frage: </td>";
        echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;" . $myQuestion->__get("question") . "</td>";
        echo "</tr>";
        
        if(strlen($myQuestion->__get("description"))>1){
            echo "<tr>";
            echo "<td>Fragen-Beschreibung:</td>";
            echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;" . $myQuestion->__get("description") . "</td>";
            echo "</tr>";
        }
        
        echo "</table><label id='overviewLabel'>&nbsp;</label><br>";
	
        $votes = $myQuestion->CountVotes();
        
        if($votes>0){
            echo "<h3><center>Anzahl der abgegebenen Stimmen: " . $votes . "</center></h3>";
        }
        
        /**
         * Displaying the vote-results
         */
        $myQuestion->ShowTable();
        
        /**
         * Displaying buttons for next- and previous-questions
         */
        echo "<form method='GET'>";
        echo "<input type='text' hidden name='key' value='". $myQuiz->__get("qKey") . "'>";
        echo "<table><tr>";
        if($myQuestion->__get("questionPos") > 1){
            echo "<td><button id='buttonNext' type='submit' name='pos' value='" . ($myQuestion->__get("questionPos")-1) . "'    >←</button></td>";
        }
        
        if(!$myQuestion->IsLastQuestion()){
            echo "<td><button id='buttonNext' type='submit' name='pos' value='" . ($myQuestion->__get("questionPos")-1) . "'    >→</button></td>";
        }
        echo "</tr></table>";
        echo "</form>";
        
    }
?>
