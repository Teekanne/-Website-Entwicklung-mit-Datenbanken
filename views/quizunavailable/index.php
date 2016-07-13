<?php
    include_once("models/quiz_model.php");
    include_once("config/database.php");
    
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>

<h2>
    Das gewählte Quiz ist nicht verfügbar... ¯\_(ツ)_/¯
</h2>

<p>
    <?php
    
        if(isset($_GET['FIRSTTIME']) && $_GET['FIRSTTIME'] == 1) {
            echo 
                "Sie haben für das bezügliche Quiz bereits abgestimmt!<br>";
        }
        else if(isset($_GET['FIRSTTIME']) && $_GET['FIRSTTIME'] == 0) {
            echo 
                "Das bezügliche Quiz ist (noch) nicht freigegeben.<br>".
                "Beziehungsweise - Ihr eingegebener Quiz-Key ist falsch.";
        } 
        else {
            echo 
                "Bei der Vorbereitung des bezüglichen Quiz ist ein unbekannter Fehler aufgetreten...";
        }
    
    ?>
     
    
    
    
    <form name="homeform" method="post" action="index">
        <input type='submit' name='login' value='Zurück!'>
    </form>
</p>

<br>

