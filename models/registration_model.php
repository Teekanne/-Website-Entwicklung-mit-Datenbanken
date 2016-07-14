<?php

class Registration_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

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
                regmail($title, $firstname, $lastname);
                header('location: ../login');
                exit;
            } else {
                header('location: ../login');
                exit;
            }
        } else {
            
        }
    }

    function regmail($title, $firstname, $lastname) {
             date_default_timezone_set('Etc/UTC');
      
            
            require 'library/PHPMailer/class.phpmailer.php';
            require 'library/PHPMailer/class.smtp.php';

            $mail = new PHPMailer();

            $mail->isSMTP();

            $mail->Host = "193.174.250.201";
            $mail->Port = 25;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom('mueller@hs-flensburg.de', 'Prof. Dipl.-Kfm. Thomas Müller');
           // $mail->addAddress('mueller@hs-flensburg.de', 'Prof. Dipl.-Kfm. Thomas Müller');
            $mail->addAddress('creq@live.de', 'Test');
          
            

            $mail->Subject = 'Testimeter Registration';
             $string = "Ein neuer Benutzer hat sich angemeldet. \r\n\r\n";
             $string .= "Benutzer: $title $firstname $lastname\r\n\r\n" ;
             $string .= "http://localhost/Mentimeter/login";
             $stringHtml = str_replace("\r\n", "<br>", $string);
            
             $mail->Body    = $stringHtml;
             $mail->AltBody = $string;
            //send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
   // echo "Message sent!";
}
    }

}
