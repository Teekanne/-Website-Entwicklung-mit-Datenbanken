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
		
		for ($i = 0; $i < sizeof($qItems); $i++) {
			
			echo
			'<tr>'.
			'<td>&nbsp</td>'.
			'<td colspan="5" style="font-weight: bold; font-size: 150%; padding-top: 20px; padding-bottom: 10px; padding-right: 25px">'.
			$qItems[$i]->category.
			'</td>'.
			'</tr>';
			
			echo
			'<tr>'.
			'<td>&nbsp</td>'.
			'<td>&nbsp</td>'.
			'<td colspan="4" style="font-weight: bold; font-size: 120%; padding-top: 10px; padding-bottom: 5px;  padding-right: 25px">'.
			
			'HIER MUSS DIE CATEGORY GETEILT WERDEN'.
			
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
			
			echo
			'<tr>'.
			'<td>&nbsp</td>'.
			'<td>&nbsp</td>'.
			'<td>&nbsp</td>'.
			'<td style="padding-right: 25px">'.
			$qItems[$i]->title.
			'</td>'.
			'<td style="text-align: center">';
			
			if($qItems[$i]->active == 0) {
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
			
			if($qItems[$i]->active == 1) {
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
		
		echo
		'</tbody>'.
		'</table>';
	?>

<?php

    echo "test1<br />";

    $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
    
    if (!$pdo) {
        echo "nicht verbunden<br />";
    } else {
        echo "verbunden<br />";
    }
    
    echo "test2<br />";

    $sql = "SELECT QUESTION FROM T_QUESTION WHERE ID = 35";
    
    $question = $pdo->query($sql)->fetch();
    echo $question['QUESTION']."<br />";


    /*
    $db = mysqli_connect("projekt.wi.fh-flensburg.de", "projekt2015a", "P2016s7", "projekt2015a");
    
    if(!$db)
    {
      exit("Verbindungsfehler: ".mysqli_connect_error());
    } else {
        
        $sql = "SELECT question FROM t_question;";
        $result = $db->query($sql);

        while($result) {
            
            echo "question: ".$row["question"]."<br>";
        }
    }
    $db->close();
     */
    

?>
</html>