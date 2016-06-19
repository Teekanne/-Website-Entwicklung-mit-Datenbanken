<!doctype html public "-//W3C//DTD HTML 4.0 //EN">
<head>
	<title>
		<?php print basename($_SERVER['PHP_SELF'])?>
	</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<!--<link rel="stylesheet" href="<?php echo $_SERVER['CONTEXT_PREFIX'].'/Hochschule/templates/hebr2888.css" type="text/css">'?>-->
</head>

<body style="font-family: Verdana, 'Lucida Sans Unicode', sans-serif">

	<?php
	class QuestionItem
	{
		private $category;
		private $title;
		private $active;
		
		function __get($attribute)
		{
			return $this->$attribute;
		}

		function __set($attribute, $value)
		{
			$this->$attribute = $value;
		}
	}
	?>


	<?php
	
	$qItems = array();
	
	$qItem = new QuestionItem();

	$qItem->category = "Grundlagen der Softwareentwicklung";
	$qItem->title = "erweitern von Arrays";
	$qItem->active = 1;
	
	array_push($qItems, $qItem);
	?>


<h1>
	Übersicht über ihre aktuellen Umfragen
</h1>

<br>

<?php

    $Tutor_ID = 2;

    $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
    
    if (!$pdo) {
        echo "Verbindungsfehler!<br />";
    } 
    
    echo
        '<table style="border:0px solid #647852; border-collapse: collapse;" border="0">'.
        '<tbody>'.
        '<tr style="text-align: center; font-size: 75%; line-height: 0px;">'.
                '<td style="width:50px">&nbsp</td>'.
                '<td style="width:100px">&nbsp</td>'.
                '<td style="width:100px">&nbsp</td>'.
                '<td style="width:400px">&nbsp</td>'.
                '<td style="width:100px">&nbsp</td>'.
                '<td style="width:100px">&nbsp</td>'.
        '</tr>';
    
    
    
    $CategoryParentSelect = 
        "SELECT * FROM T_CATEGORY ".
        "WHERE FK_PARENT_ID IS NULL AND FK_TUTOR = ".$Tutor_ID." ".
        "ORDER BY ID";
    
    $CategoryParentResult = $pdo->query($CategoryParentSelect);
    
    if ($CategoryParentResult && $CategoryParentResult->rowCount() > 0) {
        
        while ($CategoryParent = $CategoryParentResult->fetch(PDO::FETCH_ASSOC)) {
            
            echo
                '<tr>'.
                '<td>&nbsp</td>'.
                '<td colspan="5" style="font-weight: bold; font-size: 150%; padding-top: 20px; padding-bottom: 10px; padding-right: 25px">'.
                $CategoryParent['CATNAME'].
                '</td>'.
                '</tr>';
            
            echo
                '<tr style="text-align: center; font-size: 75%">'.
                '<td>&nbsp</td>'.
                '<td>&nbsp</td>'.
                '<td>&nbsp</td>'.
                '<td>&nbsp</td>'.
                '<td>inaktiv</td>'.
                '<td>aktiv</td>'.
                '</tr>';
            
            
            $CategoryParentID = $CategoryParent['ID'];
            
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
			'<td colspan="4" style="font-weight: bold; font-size: 120%; padding-top: 10px; padding-bottom: 5px;  padding-right: 25px">'.
			$CategoryChild['CATNAME'].
			'</td>'.
			'</tr>';
                    
                    $CategoryChildID = $CategoryChild['ID'];
            
                    $QuizSelect = 
                        "SELECT * FROM T_QUIZ ".
                        "WHERE ".
                        "FK_TUTOR = ".$Tutor_ID." AND ".
                        "FK_CATEGORY = ".$CategoryChildID." ".
                        "ORDER BY ID";
                    
                    $QuizResult = $pdo->query($QuizSelect);
            
                    if ($QuizResult && $QuizResult->rowCount() > 0) {
                        while ($Quiz = $QuizResult->fetch(PDO::FETCH_ASSOC)) {

                            echo
                                '<tr>'.
                                '<td>&nbsp</td>'.
                                '<td>&nbsp</td>'.
                                '<td>&nbsp</td>'.
                                '<td style="padding-right: 25px">'.
                                $Quiz['QUIZNAME'].
                                '</td>'.
                                '<td style="text-align: center">';

                            if($Quiz['ISACTIVE'] == 0) {
                                    echo
                                    '<form style="margin: 0; padding:0">'.
                                            '<button type="button" id="berechnen">starten</button>'.
                                    '</form>';
                            } else {
                                    echo '&nbsp';
                            }

                            echo
                            '</td>'.
                            '<td style="text-align: center">';

                            if($Quiz['ISACTIVE'] == 1) {
                                    echo
                                    '<form style="margin: 0; padding:0">'.
                                            '<button type="button" id="berechnen">beenden</button>'.
                                    '</form>';
                            } else {
                                    echo '&nbsp';
                            }

                            echo
                            '</td>'.
                            '</tr>';
                        }
                    }
                }
            }
        }
        echo
            '</tbody>'.
            '</table>';
    } else {
        echo "Leere Ergebnismenge!<br />";
    }
?>
</html>