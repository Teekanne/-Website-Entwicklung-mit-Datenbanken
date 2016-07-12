<?php 
    include("public/php/LoadClasses.php"); 
    
    if(isset($_GET["key"])){
        $key = $_GET["key"];
        
        if(isset($_GET["pos"])){
            $key .= "&pos=" . $_GET["pos"];
        }else{
            $key .= "&pos=1";
        }
        
	echo "<script>showVoteResults('divResults', '" . $key . "', 600);</script>";
        echo  "<div id='divResults'><img id='imgAjax' src='images/3.gif'></div>"; 
    }
 ?>
