<?php
/* */
class Functions extends Controller {

	function __construct() {
		parent::__construct();
		Session::init();
		$logged = Session::get('loggedIn');
		if ($logged == false) {
			Session::destroy();
			header('location: ../login');
			exit;
		}
               // print_r($_SESSION);
             
                $this->view->js = array('function/js/default.js');
	}
	
	function index() 
	{	
		$this->view->render('function/index');
	}
	/*  
         * Logout function
         *          */
	function logout()
	{
		Session::destroy();
		header('location: ../login');
		exit;
	}
 

}
