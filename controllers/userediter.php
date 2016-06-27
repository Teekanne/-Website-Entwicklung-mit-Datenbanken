<?php

class UserEditer extends Controller {

    public function __construct() {
        parent::__construct();
        Session::init();

        $logged = Session::get('loggedIn');
        $role = Session::get('ROLE');
        if ($logged == false || $role != 'Administrator') {
            Session::destroy();
            header('location: ../login');
            exit;
        }
    }
      public function editUser($id){
        echo $id;
        exit;
    }
}