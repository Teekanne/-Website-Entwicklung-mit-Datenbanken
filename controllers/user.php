<?php

class User extends Controller {

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

    public function index() {
        $this->view->userList = $this->model->userList();
        $this->view->render('user/index');
    }

    public function create() {
        $data = array();
        $data['TITLE'] = $_POST['TITLE'];
        $data['FIRSTNAME'] = $_POST['FIRSTNAME'];
        $data['LASTNAME'] = $_POST['LASTNAME'];
        $data['EMAIL'] = $_POST['EMAIL'];
        $data['PASSWORD'] = md5($_POST['PASSWORD']);
        $data['ROLE'] = $_POST['ROLE'];
        //@TODO: Error Handling
        $this->model->create($data);
        header('location: ' . URL . 'user');
    }

    public function edit($id) {
        
    }

    public function delete($id) {
        
    }

}
