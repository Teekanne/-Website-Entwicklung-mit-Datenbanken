<!doctype html>
<html>
	<head>
		<title>Mentimeter</title>
		<link rel="stylesheet" type="text/css" href="../../public/css/style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	</head>
	<body>
		<section id="menubar">
		</section>
		<header>
			<ul>
				<li><a href="https://www.hs-flensburg.de/"> <img src="../../images/HS.png"/> </a></li> 
			</ul>
			<h1>Testimeter</h1>
		</header>
		<nav class="nav">
			<ul>
				<li><a href="index.html" class="active">Home</a></li>
				<li><a href="index.html">Frage erstellen</a></li>
				<li><a href="index.html">Verwaltung</a></li>
				<li><a href="index.html">Account</a></li>
				<li><a href="index.html">Abmelden</a></li>
			</ul>
		</nav>
		<section id="main">
			<article>
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


                            <h2>
                                Übersicht über ihre aktuellen Umfragen
                            </h2>

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
                                    '<tr style="text-align: left; font-size: 75%; line-height: 0px;">'.
                                        '<td style="width:10px">&nbsp</td>'.
                                        '<td style="width:25px">&nbsp</td>'.
                                        '<td style="width:25px">&nbsp</td>'.
                                        '<td style="width:500px">&nbsp</td>'.
                                        '<td style="width:50px">&nbsp</td>'.
					'<td style="width:10px">&nbsp</td>'.
                                        '<td style="width:50px">&nbsp</td>'.
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
                                            '<td colspan="5" text-align = "left"; style="font-weight: bold; font-size: 140%; padding-top: 20px; padding-bottom: 10px; padding-right: 25px">'.
                                            '<label>'.$CategoryParent['CATNAME'].'</label>'.
                                            '</td>'.
                                            '</tr>';

                                        echo
                                            '<tr style="text-align: center; font-size: 100%">'.
                                            '<td>&nbsp</td>'.
                                            '<td>&nbsp</td>'.
                                            '<td>&nbsp</td>'.
                                            '<td>&nbsp</td>'.
                                            '<td>inaktiv</td>'.
					    '<td>&nbsp</td>'.
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
                                                    '<td colspan="4" style="font-weight: bold; text-align = solid; font-size: 120%; padding-top: 10px; padding-bottom: 5px;  padding-right: 20px">'.
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
                                                            '<td style="padding-right: 25px">';

                                                        if($Quiz['ISACTIVE'] == 1) {
                                                            echo '<a href="../question/question.php?QUIZ_ID='.$Quiz['ID'].'">'.$Quiz['QUIZNAME'].'</a>';
                                                        } else {
                                                            echo $Quiz['QUIZNAME'];
                                                        }

                                                        echo
                                                            '</td>'.
                                                            '<td style="text-align: center">';

                                                        if($Quiz['ISACTIVE'] == 0) {
                                                                echo
                                                                '<form style="margin: 0; padding:0">'.
                                                                        '<button type="button" id="'.$Quiz['ID'].'">starten</button>'.
                                                                '</form>';
                                                        } else {
                                                                echo '&nbsp';
                                                        }

                                                        echo
                                                        '</td>'.
														'<td>&nbsp</td>'.
                                                        '<td style="text-align: center">';

                                                        if($Quiz['ISACTIVE'] == 1) {
                                                                echo
                                                                '<form style="margin: 0; padding:0">'.
                                                                        '<button type="button" id="'.$Quiz['ID'].'">beenden</button>'.
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
                        </article>
		</section>
		<footer>
			<ul>
				<li>@Testimeter</li>
			</ul>
		</footer>
	</body>
</html>






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



</body>
</html>
