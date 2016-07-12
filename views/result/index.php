<?php 
    if(isset($_GET["key"])){
        $key = $_GET["key"];
        $disallowed = "<label>Nur der Fragenersteller kann die Ergebnisse sehen ;-)</label>";
        
        if(isset($_SESSION["ID"])){
            if($_SESSION["ID"] == Quiz::LoadByKey($key)->__get("fkTutor")){
           
                if(isset($_GET["pos"])){
                    $key .= "&pos=" . $_GET["pos"];
                }else{
                    $key .= "&pos=1";
                }
                
                echo "<script>showVoteResults('divResults', '" . $key . "', 600);</script>";
                echo  "<div id='divResults'><img id='imgAjax' src='images/3.gif'></div>"; 
            }else{
                echo $disallowed;
            }
        }else{
            echo $disallowed;
        }
    }
 ?>
