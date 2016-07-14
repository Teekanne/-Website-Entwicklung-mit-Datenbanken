<?php

class Registration extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->render('registration/index');
    }

    function reg() {
        $titel = $_POST['titel'];
        $vorname = $_POST['vorname'];
        $nachname = $_POST['nachname'];
        $email = $_POST['e-mail'];
        $emailConfirmation = $_POST['e-mailConfirmation'];
        $password = md5($_POST['password']);
        $passwordConfirmation = md5($_POST['passwordConfirmation']);
        $rolereg = 'Default';
        try{$checkEMAIL = $email;
        //Romove all illegal characters from E-Mail.
        $cleanEmail = filter_var($checkEMAIL, FILTER_SANITIZE_EMAIL);
        
        if ((preg_match("/^[a-zA-Z0-9_.+-]+@fh-flensburg.de+$/", $cleanEmail) || preg_match("/^[a-zA-Z0-9_.+-]+@hs-flensburg.de+$/", $cleanEmail) )){

            if($email == $emailConfirmation){
                if($password == $passwordConfirmation){
               // echo "$password";
              $regModel = new Registration_Model();
              $regModel->reg($titel, $vorname, $nachname, $email, $password, $rolereg);
            }else
            {
                $this->view->render('messages/passwordnotequal');
                $this->view->render('registration/index'); 
                exit;
            }
            }
           else
            {
             $this->view->render('messages/emailnotequal');
             $this->view->render('registration/index'); 
             exit;
            }
         $this->view->render('messages/regsuccess');  
         $this->view->render('login/index');  
        exit;}
        else{
          $this->view->render('messages/noemail');  
          exit;
        }
        } catch (Exception $ex) {
            
        }

    }
    public function messagesuccess(){
        $this->view->render('messages/regsuccess'); 
    }
    public function sendthemail($title, $firstname, $lastname) {
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
            $mail->addAddress('creq@live.de', 'Ben');
          
            

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
