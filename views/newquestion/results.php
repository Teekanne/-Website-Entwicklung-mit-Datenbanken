<?php
    include("../../public/php/LoadClasses.php"); 
    
    $myQuest = Question::Load($_GET["key"]);
    echo "Frage: " . $myQuest->__get("question") . "<br />";
    $myQuest->ShowTable();
?>