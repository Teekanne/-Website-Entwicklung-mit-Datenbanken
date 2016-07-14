
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
        $ich = "";
         testmail();
         sendmessage();
    }

    public function newPassword() {
        $login = $_POST['login'];
        $key = $_POST['key'];
        $password = md5($_POST['password']);
        $passwordConfirmation = md5($_POST['passwordconfirmation']);

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

    public function messagenewPasswordSet() {
        $this->view->render('messages/newPasswordSet');
    }

    public function messageKeySent() {
        $this->view->render('messages/keysent');
    }

    public function messageNotFound() {
        $this->view->render('messages/loginnotfound');
    }
    public function testmail()
    {
            $string = "Folgender Benutzer hat ein neues Passwort beantragt ... \r\n\r\n";
            $string .= "Benutzer:" ;
            $string .= "E-Mail: " ;
            $stringHtml = str_replace("\r\n", "<br>", $string);
            
            require 'library/PHPMailer/class.phpmailer.php';
            require 'library/PHPMailer/class.smtp.php';

            $mail = new PHPMailer();

            $mail->isSMTP();

            $mail->Host = "193.174.250.201";
            $mail->Port = 25;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom('helpdesk@wi.fh-flensburg.de', 'Headcrash & Co');
            $mail->addAddress('creq@live.de', 'Ben');
            $mail->addAddress('benjamin.juergens@stud.fh-flensburg.de', 'Ben');
            

            $mail->Subject = 'Testimeter Passwort vergessen eingegangen (projekt2015b)';
            $mail->Body    = $stringHtml;
            $mail->AltBody = $string;
            //send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
        
           
    }
    public function sendthemail() {
        /**
         * This example shows settings to use when sending via Google's Gmail servers.
         */
//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
        date_default_timezone_set('Etc/UTC');
        require '../PHPMailerAutoload.php';
//Create a new PHPMailer instance
        $mail = new PHPMailer;
//Tell PHPMailer to use SMTP
        $mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
        $mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';
//Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;
//Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'tls';
//Whether to use SMTP authentication
        $mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = "username@gmail.com";
//Password to use for SMTP authentication
        $mail->Password = "yourpassword";
//Set who the message is to be sent from
        $mail->setFrom('from@example.com', 'First Last');
//Set an alternative reply-to address
        $mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
        $mail->addAddress('whoto@example.com', 'John Doe');
//Set the subject line
        $mail->Subject = 'PHPMailer GMail SMTP test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
        $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
        $mail->AltBody = 'This is a plain-text message body';
//Attach an image file
        $mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }

    public function sendmessage(){
      date_default_timezone_set('Etc/UTC');
      require 'library/PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'hsflensburg@gmail.com';                 // SMTP username
$mail->Password = 'Pegasus123';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('hsflensburg@gmail.com', 'Mailer');
$mail->addAddress('creq@live.de', 'Joe User');     // Add a recipient

$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
    }
    
// Ausgabe des Generatos Gibt eine 6 wertige Zeichenkette zurück
    public function echoout() {
//echo "Und das neue Passwort lautet: ".randomstring(6);
        echo "TEST";
    }
    public function keysendmail($key, $toemail){
//$key, $toemail, $name
        date_default_timezone_set('Etc/UTC');
      
            
            require 'library/PHPMailer/class.phpmailer.php';
            require 'library/PHPMailer/class.smtp.php';

            $mail = new PHPMailer();

            $mail->isSMTP();

            $mail->Host = "193.174.250.201";
            $mail->Port = 25;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom('mueller@hs-flensburg.de', 'Prof. Dipl.-Kfm. Thomas Müller');
            $mail->addAddress($toemail, 'Benutzer');
          
            

            $mail->Subject = 'Testimeter Resetkey';
             $string = "Bitte nutzen Sie den folgenden Key um Ihr Passwort neu zu setzen. \r\n\r\n";
            $string .= "Benutzer: $toemail\r\n\r\n" ;
            $string .= "Key: $key \r\n\r\n" ;
            $string .= "http://projekt.wi.fh-flensburg.de/~projekt2015a/passwordlost";
            $stringHtml = str_replace("\r\n", "<br>", $string);
            
            $mail->Body    = $stringHtml;
            $mail->AltBody = $string;
            //send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
   // echo "Message sent!";
}/*
        
        
        
        
     // require 'library/PHPMailer/PHPMailerAutoload.php';
        require 'library/PHPMailer/class.phpmailer.php';
            require 'library/PHPMailer/class.smtp.php';
        $mail = new PHPMailer(); 
$mail->IsSMTP(); // send via SMTP

$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "hsflensburg@gmail.com"; // SMTP username
$mail->Password = "Pegasus123"; // SMTP password
$mail->SMTPDebug = 1;
$webmaster_email = "hsflensburg@gmail.com"; //Reply to this email ID
$email="creq@live.de"; // Recipients email ID
$name="SomeonesName"; // Recipient's name
$mail->From = $webmaster_email;
$mail->FromName = "Me";
$mail->AddAddress($email,$name);
$mail->AddReplyTo($webmaster_email,"Webmaster");
$mail->WordWrap = 50; // set word wrap
$mail->IsHTML(true); // send as HTML
$mail->Subject = "This is the subject";
$mail->Body = "Hi,
This is the HTML BODY "; //HTML Body
$mail->AltBody = "This is the body when user views in plain text format"; //Text Body
if(!$mail->Send())
{
    echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
    echo "Message has been sent";
}
    }
*/
}
}