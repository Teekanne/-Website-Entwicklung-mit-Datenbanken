<?php
    // QUIZ UNAVAILABLE

    // If the Mentee is not allowed Access to a Quiz, 
    // he will be redirected to this Page 

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
        
        // Distinguish the different voilation reasons
        if(isset($_GET['FIRSTTIME']) && $_GET['FIRSTTIME'] == 1) {
            // The Quiz was previously completed
            echo 
                "Sie haben für das bezügliche Quiz bereits abgestimmt!<br>";
        }
        else if(isset($_GET['FIRSTTIME']) && $_GET['FIRSTTIME'] == 0) {
            // The Quiz is nonexistent or inactive
            echo 
                "Das bezügliche Quiz ist (noch) nicht freigegeben.<br>".
                "Beziehungsweise - Ihr eingegebener Quiz-Key ist falsch.";
        } 
        else {
            // Unknown technical cause
            echo 
                "Bei der Vorbereitung des bezüglichen Quiz ist ein unbekannter Fehler aufgetreten...";
        }
    
    ?>
     
    
    
    
    <form name="homeform" method="post" action="index">
        <input type='submit' name='login' value='Zurück!'>
    </form>
</p>