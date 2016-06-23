<?php
    require("../../models/quiz_model.php");

    session_start();
    //session_destroy();
?>


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

                                echo "Vielen Dank für die Beantwortung der Frage...<br><br>";

                                if (isset($_SESSION['Quiz'])) {

                                    $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');

                                    if (!$pdo) {
                                        echo "Verbindungsfehler!<br />";
                                    } 

                                    $Quiz = $_SESSION['Quiz'];
                                    $Questions = $Quiz->Questions;

                                    $KeysQuestion = array_keys($Questions);
                                    $Question = $Questions[$KeysQuestion[0]];


                                    echo "Questiontext: ".$Question->QuestionText."<br><br>";


                                    /*
                                    $VoteResultSelect = "SELECT * FROM T_QUIZ WHERE ID = ".$QuizID;
                                    $VoteResultResult = $pdo->query($VoteResultSelect);

                                    if ($QuizResult && $QuizResult->rowCount() > 0) {
                                        while ($QuizRow = $QuizResult->fetch(PDO::FETCH_ASSOC)) {


                                        $VoteInsert = "INSERT INTO movies(filmName,
                                            filmDescription,
                                            filmImage,
                                            filmPrice,
                                            filmReview) VALUES (
                                            :filmName, 
                                            :filmDescription, 
                                            :filmImage, 
                                            :filmPrice, 
                                            :filmReview)";

                                        $stmt = $pdo->prepare($sql);
                                        }
                                    }
                                     */

                                } else {
                                    echo "Fehler! Es wurden keine Antworten gefunden<br><br>";
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

