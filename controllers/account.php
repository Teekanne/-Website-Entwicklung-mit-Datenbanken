<?php
class Account extends Controller {

	function __construct() {
		parent::__construct();
		Session::init();
		$logged = Session::get('loggedIn');
		if ($logged == false) {
			Session::destroy();
			header('location: ../login');
			exit;
		}
	}
	
	function index() 
	{	$id = Session::get('ID');
                $change = new Account_Model();
                $change->editUser($id);
		$this->view->render('account/index');
	}
         public function view(){
        $this->view->render('account/index'); 
    }
        public function editAccount() {
        $titel = $_POST['titel'];
        $vorname = $_POST['vorname'];
        $nachname = $_POST['nachname'];
        $email = $_POST['e-mail'];
        $emailConfirmation = $_POST['e-mailConfirmation'];
        $password = md5($_POST['password']);
        $passwordConfirmation = md5($_POST['passwordConfirmation']);
        $rolereg = Session::get('ROLE');
        try{
            if($email == $emailConfirmation){
                if($password == $passwordConfirmation){
              $regModel = new Account_Model();
              $regModel->changeEdit($titel, $vorname, $nachname, $email, $password, $rolereg);
            }else
            {
                $this->view->render('messages/acceditpwfail');
                $this->view->render('account/index'); 
                exit;
            }
            }
           else
            {
                $this->view->render('messages/acceditemailfail');
                $this->view->render('account/index'); 
                exit;
            }
        // $this->view->render('account/index');   
        } catch (Exception $ex) {

        }
    }
    public function success(){
          $this->view->render('messages/acceditsuccess');
         
    }
}