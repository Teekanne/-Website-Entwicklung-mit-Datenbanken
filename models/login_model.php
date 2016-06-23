<?php


class Login_Model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}
        
      
        
	public function run()
	{
		 $sth= $this->db->prepare("SELECT ID, ROLE FROM T_TUTOR WHERE EMAIL = :login AND PASSWORD = MD5(:password)");
		$sth->execute(array(
			':login' => $_POST['login'],
			':password' => $_POST['password']
		));
		//only needed for debugging so its hidden
                //  $data = $sth->fetchAll();
                // print_r($data);
		$data = $sth->fetch();
               // print_r($data);
                //echo $data['ROLE1'];
                //die;
		
		$count =  $sth->rowCount();
		if ($count > 0) {
			// login
			Session::init();
                        //set key for session
			Session::set('ROLE', $data['ROLE']);
                        Session::set('ID', $data['ID']);
			Session::set('loggedIn', true);
			header('location: ../user');
		} else {
			header('location: ../login');
		}
		
	}
	
}