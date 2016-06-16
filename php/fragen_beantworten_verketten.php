<html>
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
		session_start();
		//session_destroy();
	?>

	<?php
	class Question
	{
		private $QuestionTitle;		
		private $QuestionText;
		private $Questions;
		private $SingleChoice;
		
		function __get($attribute)
		{
			return $this->$attribute;
		}

		function __set($attribute, $value)
		{
			$this->$attribute = $value;
		}
	}
	
	class Answer
	{	
		private $AnswerText;
		private $QuestionChecked;
		
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
	
	// HIER WERDEN TESTWERTE ERZEUGT.
	// WENN DIE INTEGRATION (OBERFLÄCHE/DB) FERTIG IST,
	// MUSS DIE SCHNITTSTELLE DAHINGEHEND UMGESTELLT WERDEN
	
	if (!isset($_SESSION['Questions'])) {
	
		$Questions = array();
	
		//////
		//////
	
		$Question = new Question();

		$Question->QuestionTitle = "Testfrage erstes Thema";
		$Question->QuestionText = "Fragetext erste Frage";
		$Question->SingleChoice = 0;
		$Question->Questions = $Questions;
		
		$Answers = array();
		
		$Answer = new Answer();
		$Answer->AnswerText = "erste Frage Antwort, erste Antwort;";
		$Answer->QuestionChecked = 0;
		array_push($Answers, $Answer);
		
		$Answer = new Answer();
		$Answer->AnswerText = "erste Frage Antwort, zweite Antwort;";
		$Answer->QuestionChecked = 0;
		array_push($Answers, $Answer);
		
		$Answer = new Answer();
		$Answer->AnswerText = "erste Frage Antwort, dritte Antwort;";
		$Answer->QuestionChecked = 0;
		array_push($Answers, $Answer);
		
		$Answer = new Answer();
		$Answer->AnswerText = "erste Frage Antwort, vierte Antwort;";
		$Answer->QuestionChecked = 0;
		array_push($Answers, $Answer);
		
		
		$Question->Answers = $Answers;
		
		array_push($Questions, $Question);
		
		
		//////
		//////
	
		$Question = new Question();

		$Question->QuestionTitle = "Testfrage erstes Thema";
		$Question->QuestionText = "Fragetext zweite Frage";
		$Question->SingleChoice = 1;
		$Question->Questions = $Questions;
		
		$Answers = array();
		
		$Answer = new Answer();
		$Answer->AnswerText = "zweite Frage Antwort, erste Antwort;";
		$Answer->QuestionChecked = 0;
		array_push($Answers, $Answer);
		
		$Answer = new Answer();
		$Answer->AnswerText = "zweite Frage Antwort, zweite Antwort;";
		$Answer->QuestionChecked = 0;
		array_push($Answers, $Answer);
		
		$Answer = new Answer();
		$Answer->AnswerText = "zweite Frage Antwort, dritte Antwort;";
		$Answer->QuestionChecked = 0;
		array_push($Answers, $Answer);
		
		$Answer = new Answer();
		$Answer->AnswerText = "zweite Frage Antwort, vierte Antwort;";
		$Answer->QuestionChecked = 0;
		array_push($Answers, $Answer);
		
		$Answer = new Answer();
		$Answer->AnswerText = "zweite Frage Antwort, fuenfte Antwort;";
		$Answer->QuestionChecked = 0;
		array_push($Answers, $Answer);
		
		
		$Question->Answers = $Answers;
		
		array_push($Questions, $Question);
		
		
		//////
		//////
		
	
		$Question = new Question();

		$Question->QuestionTitle = "Testfrage erstes Thema";
		$Question->QuestionText = "Fragetext zweite Frage";
		$Question->SingleChoice = 0;
		$Question->Questions = $Questions;
		
		$Answers = array();
		
		$Answer = new Answer();
		$Answer->AnswerText = "dritte Frage Antwort, erste Antwort;";
		$Answer->QuestionChecked = 0;
		array_push($Answers, $Answer);
		
		$Answer = new Answer();
		$Answer->AnswerText = "dritte Frage Antwort, zweite Antwort;";
		$Answer->QuestionChecked = 0;
		array_push($Answers, $Answer);
		
		$Answer = new Answer();
		$Answer->AnswerText = "dritte Frage Antwort, dritte Antwort;";
		$Answer->QuestionChecked = 0;
		array_push($Answers, $Answer);
		
		$Answer = new Answer();
		$Answer->AnswerText = "dritte Frage Antwort, vierte Antwort;";
		$Answer->QuestionChecked = 0;
		array_push($Answers, $Answer);
		
		$Answer = new Answer();
		$Answer->AnswerText = "dritte Frage Antwort, fuenfte Antwort;";
		$Answer->QuestionChecked = 0;
		array_push($Answers, $Answer);
		
		$Answer = new Answer();
		$Answer->AnswerText = "dritte Frage Antwort, sechste Antwort;";
		$Answer->QuestionChecked = 0;
		array_push($Answers, $Answer);
		
		
		$Question->Answers = $Answers;
		
		array_push($Questions, $Question);		
		
		
		//////
		//////
		
		
		$_SESSION['Questions'] = $Questions;
	}
	
	if (!isset($_SESSION['CurrPage'])) {
  		$_SESSION['CurrPage'] = 0;
	}
	
	if (isset($_POST['next']) || isset($_POST['back'])) {
		
		$QuestionsTmp = $_SESSION['Questions'];
		$KeysQuestion = array_keys($QuestionsTmp);
		$QuestionTmp = $QuestionsTmp[$KeysQuestion[$_SESSION['CurrPage']]];
		
		$AnswersTmp = $QuestionTmp->Answers;
		$KeysAnswers = array_keys($AnswersTmp);
		
		foreach($AnswersTmp as $AnswerTmp) {
			$AnswerTmp->QuestionChecked = 0;
		}

		if (isset($_POST['Result'])) {
			$ResultTmp = $_POST['Result'];
			foreach($ResultTmp as $ResultSingleTmp)
			{
				$AnswerTmp = $AnswersTmp[$KeysAnswers[$ResultSingleTmp]];
				$AnswerTmp->QuestionChecked = 1;
			}
		}		
		
		if (isset($_POST['next'])) {
			
			//echo "### Werte ### ".sizeof($_SESSION['Questions'])." / ".($_SESSION['CurrPage']+1)."<br>";
			
			if (sizeof($_SESSION['Questions']) > ($_SESSION['CurrPage']+1)) {
				$_SESSION['CurrPage']++;
			}
		}
		if (isset($_POST['back'])) {
			if ($_SESSION['CurrPage'] > 0) {
				$_SESSION['CurrPage']--;		
			}
		}
	}
	
	//echo "Seite: " + $_SESSION['CurrPage'];
	
	echo "<form name=\"questionform\" method=\"post\" action=".getenv('SCRIPT_NAME').">";
	?>
	
	<h1>
		Fragenkatalog Nummer eins
	</h1>
	
	<br>
	
	<?php
		$QuestionsTmp = $_SESSION['Questions'];
		$keys = array_keys($QuestionsTmp);
		$QuestionTmp = $QuestionsTmp[$keys[$_SESSION['CurrPage']]];
		echo $QuestionTmp->QuestionText." (".($_SESSION['CurrPage']+1)."/".sizeof($_SESSION['Questions']).")";
	?>
	
	<br><br><br>	

	<table style="border:0px solid #647852; border-collapse: collapse;" border="0">
		
		<tbody>
			<tr style="text-align: center; font-size: 75%; line-height: 0px;">
				<td style="width:50px">&nbsp</td>
				<td style="width:100px">&nbsp</td>
				<td style="width:100px">&nbsp</td>
				<td style="width:250px">&nbsp</td>
				<td style="width:100px">&nbsp</td>
				<td style="width:100px">&nbsp</td>
			</tr>
			
			<?php
			$QuestionsTmp = $_SESSION['Questions'];
			$keys = array_keys($QuestionsTmp);
			$QuestionTmp = $QuestionsTmp[$keys[$_SESSION['CurrPage']]];
			
			$AnswersTmp = $QuestionTmp->Answers;
			
			$QuestionType = "";
			if($QuestionTmp->SingleChoice == 1) {
				$QuestionType = "radio";
			} else {
				$QuestionType = "checkbox";
			}
			
			$index = 0;
			foreach($AnswersTmp as $AnswerTmp)
			{
				
				echo "<tr>";
					echo "<td>&nbsp</td>";
					echo "<td colspan=\"4\" style=\"font-size: 100%; padding-top: 0px; padding-bottom: 0px; padding-right: 25px\">";
						echo $AnswerTmp->AnswerText;
					echo "</td>";
					echo "<td><input type=\"".$QuestionType."\" name=\"Result[]\" id=\"Result\" value=\"".$index."\" ";
					if ($AnswerTmp->QuestionChecked == 1) {
						echo "checked='checked' ";	
					}
					echo "/></td>";
				echo "</tr>";
				
			    $index++;
			}
				
			?>
			
			
		</tbody>
	</table>

	<br><br><br>

    <input type='submit' name='back' value='vorherige Frage'>
    &nbsp
    <input type='submit' name='next' value='nächste Frage'>
    <br>
    <br>
    <input type='submit' name='complete' value='Quiz Abschliessen'>
	
	</form>
	
	</body>

</html>