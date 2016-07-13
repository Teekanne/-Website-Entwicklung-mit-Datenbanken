<?php
class Senderemail extends Controller {

    function __construct() {
        parent::__construct();
    }
   
    
    public function sendkeymail($emailTo)
    {
            $string = "Folgender Benutzer hat ein neues Passwort beantragt ... \r\n\r\n";
            $stringHtml = str_replace("\r\n", "<br>", $string);
        
        include 'library/class.phpmailer.php';
        include 'library/class.smtp.php';
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = "193.174.250.201";
        $mail->Port = 25;
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('helpdesk@wi.fh-flensburg.de', 'Headcrash & Co');
            $mail->addAddress('creq@live.de', 'TESt ds');
            $mail->Subject = 'Testimeter Passwort vergessen eingegangen (projekt2015b)';
            $mail->Body    = $stringHtml;
            $mail->AltBody = $string;
        
            if(!$mail->send()) {


            } else {

            }
        }
    }
   
