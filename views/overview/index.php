<?php
    // OVERVIEW
    // Table-Based View of prepared Quizes

    include_once("models/quiz_model.php");
    include_once("config/database.php");
    include_once("common/voting_toolbox.php");
    include_once("common/overview_toolbox.php");
    
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    //session_destroy();
?>

<h2>
    Übersicht über Ihre aktuellen Umfragen
</h2>
<br>

<br>

<?php
    // If User is not logged in,
    // He will be relocated to Login Page
    $logged = $_SESSION['loggedIn'];
    if ($logged == false){
        echo "NICHT EINGELOGGT!<br>";
        session_destroy();
        header('location: ../login');
        exit;
    }

    // Tutor from Session
    $Tutor_ID = $_SESSION['ID'];

    // Reset Navigation for all Quizes
    // (Just in Case...)
    if (!isset($_SESSION['CurrPage'])) {
        $_SESSION['CurrPage'] = 0;
    }

    // Get DB Connection
    $pdo = new Database();

    if (!$pdo) {
        echo "Verbindungsfehler!<br />";
    } 
    
    // Handling of Quiz operation Actions
    if (isset($_GET['DEACTIVATE_QUIZ_ID'])) {
        deactivateQuiz($_GET['DEACTIVATE_QUIZ_ID']);
    } 
    
    if (isset($_GET['ACTIVATE_QUIZ_ID'])) {
        activateQuiz($_GET['ACTIVATE_QUIZ_ID']);
    }
    
    if (isset($_GET['DELETE_QUIZ_ID'])) {
        deleteQuiz($_GET['DELETE_QUIZ_ID']);
    }
    
    // Print table body
    echo
        '<table style="border:0px solid #647852; border-collapse: collapse;" border="0">'.
        '<tbody>'.
        '<tr style="text-align: left; font-size: 75%; line-height: 0px;">'.
            '<td style="width:10px">&nbsp</td>'.
            '<td style="width:25px">&nbsp</td>'.
            '<td style="width:25px">&nbsp</td>'.
            '<td style="width:500px">&nbsp</td>'.
            '<td style="width:1px">&nbsp</td>'.
            '<td style="width:75px">&nbsp</td>'.
            '<td style="width:75px">&nbsp</td>'.
        '</tr>';

    $CategoryParentSelect = 
        "SELECT * FROM T_CATEGORY ".
        "WHERE FK_PARENT_ID IS NULL AND FK_TUTOR = ".$Tutor_ID." ".
        "ORDER BY ID";

    $CategoryParentResult = $pdo->query($CategoryParentSelect);

    // Iterating through Quiz Data for Display purposes
    if ($CategoryParentResult && $CategoryParentResult->rowCount() > 0) {
        while ($CategoryParent = $CategoryParentResult->fetch(PDO::FETCH_ASSOC)) {

            echo
                '<tr>'.
                '<td>&nbsp</td>'.
                '<td colspan="5" text-align = "left"; style="font-weight: bold; font-size: 140%; padding-top: 20px; padding-bottom: 10px; padding-right: 25px">'.
                '<label id=overviewLabel>&bull;&nbsp;&nbsp;'.$CategoryParent['CATNAME'].'</label>'.
                '</td>'.
                '</tr>';

            $CategoryParentID = $CategoryParent['ID'];
            
            // Printing Quiz Content for Parent Categories
            generateQuizOverview($Tutor_ID, $CategoryParentID);

            $CategoryChildSelect = 
                "SELECT * FROM T_CATEGORY ".
                "WHERE ".
                "FK_PARENT_ID IS NOT NULL AND ".
                "FK_TUTOR = ".$Tutor_ID." AND ".
                "FK_PARENT_ID = ".$CategoryParentID." ".
                "ORDER BY ID";

            $CategoryChildResult = $pdo->query($CategoryChildSelect);

            if ($CategoryChildResult && $CategoryChildResult->rowCount() > 0) {
                while ($CategoryChild = $CategoryChildResult->fetch(PDO::FETCH_ASSOC)) {

                    echo
                        '<tr>'.
                        '<td>&nbsp</td>'.
                        '<td>&nbsp</td>'.
                        '<td colspan="4" style="font-weight: bold; text-align = solid; font-size: 120%; padding-top: 10px; padding-bottom: 5px;  padding-right: 20px">'.
                        '&bull;&nbsp;&nbsp;'.
                        $CategoryChild['CATNAME'].
                        '</td>'.
                        '</tr>';

                    $CategoryChildID = $CategoryChild['ID'];
                    
                    // Printing Quiz Content for Child Categories
                    generateQuizOverview($Tutor_ID, $CategoryChildID);
                }
            }
        }
        
        echo
            '</tbody>'.
            '</table>'.
            '</p></p>';
        
    } else {
        // Show message for no existing Quizes...
        echo "<p>Keine Umfragen angelegt!</p><br />";
    }
 ?>








