<!-- TODO:
     Methode über User-Klasse schreiben, um Kategorien zu holen
-->
<!doctype html>
<html>
    <head>
        <title>Mentimeter</title>
        <link href="style.css" type="text/css" rel="stylesheet" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="description" content="Create a new question">
        <meta name="author" content="Christoph Pohl">
        <meta charset="utf-8">
        <title>Ask question</title>

        <?php
            include_once("DataBase.php");
            $dataBase = new DataBase("localhost", "root", "root", "Testimeter");
        ?>

        <script language="javascript" type="text/javascript" src="javascript.js"></script>
    </head>

    <body>
        <section id="menubar"><ul></ul></section>
        <header>
                <h1>Testimeter</h1>
        </header>
        <nav class="nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="askquestion.php" class="active">Frage erstellen</a></li>
                <li><a href="#">Verwaltung</a></li>
                <li><a href="account.php">Account</a></li>
                <li><a href="#">Abmelden</a></li>
            </ul>
        </nav>
        <section id="main">
            <article>
                <h1>Neue Umfrage erstellen</h1>
                <form action="newquestion.php" method="post">
                    <link href="style.css" rel="stylesheet" type="text/css"/>
                    <input type="text" name="question" placeholder="Frage" /><br /><br />
                    <textarea name="description" maxlength="1000" placeholder="Beschreibung" ></textarea><br /><br />

                    <label>Kategorie:</label>
                    <select name="category">
                        <?php
                            foreach($dataBase->getColumn("SELECT CATNAME FROM T_CATEGORY") as $catName){
                                    echo "<option>".$catName."</option>";
                            }
                        ?>
                    </select>

                    <br /><br />

                    <div id="answers">
                      <input type="text" name="answer[]" id="answer1" placeholder="Antwortmöglichkeit 1" /><br />
                      <input type="text" name="answer[]" id="answer2" placeholder="Antwortmöglichkeit 2" onkeydown="addTextbox('answers', this);" /><br />
                    </div><br />

                    <input type="radio" name="choice" value="singlechoice" checked="checked"/><label>Single-Choice</label>
                    <input type="radio" name="choice" value="multiplechoice"/><label>Multiple-Choice</label><br /><br />

                    <input type="submit" value="Jetzt erstellen &raquo" />
                </form>
                <br /><br />
            </article>
        </section>
    <body>
</html>