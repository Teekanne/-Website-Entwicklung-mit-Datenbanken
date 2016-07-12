<?php

class Passwordlost_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function insertkey($key, $login) {
        $checkEMAIL = $login;
        //Romove all illegal characters from E-Mail.
        $cleanEmail = filter_var($checkEMAIL, FILTER_SANITIZE_EMAIL);
        $sth = $this->db->prepare("SELECT * FROM T_TUTOR WHERE EMAIL = :email");
        $sth->execute(array(':email' => $cleanEmail));
        $count = $sth->rowCount();
        if ($count == 1) {
            $sqlInsert = "UPDATE T_TUTOR SET RESETKEY='".$key."' where EMAIL='".$login."'";

            $preparedStatement = $this->db->prepare($sqlInsert);
            $preparedStatement->execute();
            $message = new Passwordlost();
            $message->messageKeySent();
              
                //echo "finish";
                exit;
            } else {
                $message = new Passwordlost();
                $message->messageNotFound();
                exit;
            }
        } 
    }


