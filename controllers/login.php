<?php

class Login extends Controller {

	function __construct() {
		parent::__construct();
                
             
	}
	 function index(){

       $this->view->render('login/index');
    }
    function  run()
    {
        $this->model->run();
    }
    function lostPW(){
        if (isset($_POST['lostpass'])){
 
	if (lostPassword($_POST['username'], $_POST['email'])){
 
		echo "Your password has been reset, an email containing your new password has been sent to your inbox.<br />
		<a href='./index.php'>Click here to return to the homepage.</a>
		";
 
	}else {
 
		echo "Username or email was incorrect !";
		show_lostpassword_form();
 
	}
 
} else {
	//user has not pressed the button
	show_lostpassword_form();	
}
    }
	
}