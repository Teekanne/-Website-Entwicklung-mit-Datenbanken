
<?php

class Passwordlost extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {

        $this->view->render('passwordlost/index');
    }

    function generateKey() {
       // $sendit = new Senderemail();
       // $emailTo ="";
        //$sendit->sendkeymail($emailTo);
        $pass = "";
        $login = $_POST['login'];
        // $chars - String aller erlaubten Zahlen
        $chars = "!#abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $length = 6;
// Funktionsstart
        srand((double) microtime() * 1000000);
        $i = 0; // Counter auf null
        while ($i < $length) { // Schleife solange $i kleiner $length
// Holen eines zufälligen Zeichens
            $num = rand() % strlen($chars);
// Ausf&uuml;hren von substr zum wählen eines Zeichens
            $tmp = substr($chars, $num, 1);
// Anhängen des Zeichens
            $pass = $pass . $tmp;
// $i++ um den Counter um eins zu erhöhen
            $i++;
        }
//echo $login;
//echo $pass;
        $loststream = new Passwordlost_Model();

        $loststream->insertkey($pass, $login);
    }

    public function newPassword() {
        $login = $_POST['login'];
        $key = $_POST['key'];
        $password = md5($_POST['password']);
        $passwordConfirmation =md5($_POST['passwordconfirmation']);

        try {

            if ($password == $passwordConfirmation) {
                // echo "$password";
                $setnewPW = new Passwordlost_Model();
                $setnewPW->newPassword($login, $key, $password);
            } else {
                $this->view->render('messages/passwordnotequal');
                $this->view->render('passwordlost/index');
                exit;
            }
            $this->view->render('messages/regsuccess');
            $this->view->render('login/index');
            exit;
        } catch (Exception $ex) {
            
        }
    }
    public function messagenewPasswordSet(){
        $this->view->render('messages/newPasswordSet');
    }
    public function messageKeySent() {
        $this->view->render('messages/keysent');
    }

    public function messageNotFound() {
        $this->view->render('messages/loginnotfound');
    }

// Ausgabe des Generatos Gibt eine 6 wertige Zeichenkette zurück
    public function echoout() {
//echo "Und das neue Passwort lautet: ".randomstring(6);
        echo "TEST";
    }

}
