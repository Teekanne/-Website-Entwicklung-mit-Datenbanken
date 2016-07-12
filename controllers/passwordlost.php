
<?php

class Passwordlost extends Controller {

function __construct() {
parent::__construct();
}

function index()
{

$this->view->render('passwordlost/index');
}
function generateKey(){
    $pass = "";
    $login = $_POST['login'];
    // $chars - String aller erlaubten Zahlen
$chars = "!#abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
$length = 6;
// Funktionsstart
srand((double) microtime()*1000000);
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
public function newPassword(){

}
public function messageKeySent()
{
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