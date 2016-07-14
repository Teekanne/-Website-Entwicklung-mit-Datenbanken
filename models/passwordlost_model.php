<?php

class Passwordlost_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function newPassword($login, $key, $password) {
        $checkEMAIL = $login;
        //Romove all illegal characters from E-Mail.
        $cleanEmail = filter_var($checkEMAIL, FILTER_SANITIZE_EMAIL);
        $sth = $this->db->prepare("SELECT * FROM T_TUTOR WHERE EMAIL = :email AND RESETKEY = :key");
        $sth->execute(array(':email' => $cleanEmail, "key" => "$key"));
        $count = $sth->rowCount();
        $pass = "";
        $chars = "!#abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $length = 10;
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
        if ($count == 1) {
            $sqlInsert = "UPDATE T_TUTOR SET PASSWORD='".$password."', RESETKEY='" . $pass . "' where EMAIL='" . $login . "' AND RESETKEY='".$key."'";
            
            $preparedStatement = $this->db->prepare($sqlInsert);
            $preparedStatement->execute();
            $message = new Passwordlost();
            $message->messagenewPasswordSet();

            
            exit;
        } else {
            $message = new Passwordlost();
            $message->messageNotFound();
            exit;
        }
    }

    public function insertkey($key, $login) {
        $checkEMAIL = $login;
        //Romove all illegal characters from E-Mail.
        $cleanEmail = filter_var($checkEMAIL, FILTER_SANITIZE_EMAIL);
        $sth = $this->db->prepare("SELECT * FROM T_TUTOR WHERE EMAIL = :email");
        $sth->execute(array(':email' => $cleanEmail));
        $count = $sth->rowCount();
        if ($count == 1) {
            $sqlInsert = "UPDATE T_TUTOR SET RESETKEY='" . $key . "' where EMAIL='" . $login . "'";

            $preparedStatement = $this->db->prepare($sqlInsert);
            $preparedStatement->execute();
            $message = new Passwordlost();
            $message->messageKeySent();
            $emailSender = new Passwordlost();
            $emailSender->keysendmail($key, $login);

            //echo "finish";
            exit;
        } else {
            $message = new Passwordlost();
            $message->messageNotFound();
            exit;
        }
    }

}
