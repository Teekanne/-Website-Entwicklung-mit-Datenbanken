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
echo $email;
echo"</br>";
echo $emailConfirmation;
//exit;
        if ((preg_match("/^[a-zA-Z0-9_.+-]+@fh-flensburg.de+$/", $cleanEmail) || preg_match("/^[a-zA-Z0-9_.+-]+@hs-flensburg.de+$/", $cleanEmail) )&& strlen($Checklength) >= 8){

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
    public function sendthemail(){
        
    }
   
}
