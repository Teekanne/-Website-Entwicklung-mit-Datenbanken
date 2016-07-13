<!doctype html>
<html>
    <head>
        <title>Testimeter</title>
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/style.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/custom.js"></script>

        <?php
            include("common/LoadClasses.php");

            function getCurrentUrl(){
                $currentUrl = $_SERVER['REQUEST_URI'];
                if(strpos($currentUrl, "/")!== false){
                    $splittedUrl = explode("/", $currentUrl);
                    $currentUrl = $splittedUrl[count($splittedUrl)-1];
                }
                return $currentUrl;
            }

            function setUrl($subUrl, $text){
                $currentUrl = getCurrentUrl();
                $active = "";

                if($currentUrl == $subUrl){
                    $active = " class='active' ";
                }

                echo "<li><a href='" . URL . $subUrl . "'" . $active . ">" . $text . "</a></li>";
            }

            if (isset($this->js)) 
            {
                foreach ($this->js as $js)
                {
                        echo '<script type="text/javascript" src="'.URL.'views/'.$js.'"></script>';
                }
            }

            header("Content-Type: text/html; charset=utf-8");
        ?>
    </head>
    <body>
        <?php Session::init(); ?>
        <section id="menubar">
        </section>
        <header>
            <ul>
                <li><a href="https://www.hs-flensburg.de/"> <img src="images/HS.png"/> </a></li> 
            </ul>
            <h1>Testimeter</h1>
        </header>
        <nav class="nav">
            <ul>
                <?php 
                    if (Session::get('loggedIn') == false){
                        setUrl("", "Index");
                        setUrl("registration", "Registrierung");
                        setUrl("help", "Help");
                        setUrl("login", "Login"); 
                    }elseif(Session::get('loggedIn') == true){
                         setUrl("newquestion", "Frage stellen");
                         setUrl("overview", "Fragen Übersicht");
                         setUrl("categoryEdit", "Kategorieverwaltung");
                         setUrl("account", "Account");

                        if(Session::get('ROLE') == 'Administrator'){
                            setUrl("user", "Users");
                        }

                         setUrl("dashboard/logout", "Logout");
                    }
                ?>
            </ul>
        </nav>
        <section id="main">
            <article>
