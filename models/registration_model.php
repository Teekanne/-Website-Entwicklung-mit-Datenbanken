<?php
//contains the functions to insert a new user on the db
class Registration_Model extends Model {

    public function __construct() {
        parent::__construct();
    }
//reg the new user
    public function reg($title, $firstname, $lastname, $email, $password, $rolereg) {
        
        $Checklength = $password;
        
        $checkEMAIL = $email;
        //Romove all illegal characters from E-Mail.
        $cleanEmail = filter_var($checkEMAIL, FILTER_SANITIZE_EMAIL);

        if ((preg_match("/^[a-zA-Z0-9_.+-]+@fh-flensburg.de+$/", $cleanEmail) || preg_match("/^[a-zA-Z0-9_.+-]+@hs-flensburg.de+$/", $cleanEmail) )&& strlen($Checklength) >= 8) {
 
            $sth = $this->db->prepare("SELECT * FROM T_TUTOR WHERE EMAIL = :email");
            $sth->execute(array(':email' => $email));

            $count = $sth->rowCount();
  
            if ($count == 0) {
                $regStatement = $this->db->prepare("INSERT INTO T_TUTOR(TITLE, FIRSTNAME, LASTNAME, EMAIL, PASSWORD, ROLE)VALUES(:title, :firstname, :lastname, :email, :password, :role)");
                $regStatement->execute(array("title" => "$title", "firstname" => "$firstname", "lastname" => "$lastname", "email" => "$email", "password" => "$password", "role" => $rolereg));
               // regmail($title, $firstname, $lastname);
                $mailsender = new Registration();
                $mailsender->sendthemail($title, $firstname, $lastname);
                $message = new Registration();
                $message->messagesuccess();
                exit;
            } else {
                header('location: ../login');
                exit;
            }
        } else {
            
        }
    }

   

}
