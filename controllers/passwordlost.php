
<?php
class Passwordlost extends Controller {

	function __construct() {
		parent::__construct();
		}
	
function index() 
	{	

		$this->view->render('passwordlost/index');
	}
        
        public function newPassword(){
            
        }
}