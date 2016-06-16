<?php

class User extends Controller {

    public function __construct() {
        parent::__construct();
        Session::init();

        $logged = Session::get('loggedIn');
        $role = Session::get('ROLE1');
        if ($logged == false || $role != 'owner') {
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
        $data['ROLE1'] = $_POST['ROLE1'];
        $data['FK_STATE'] = $_POST['FK_STATE'];
        $data['FK_DEPARTMENT'] = $_POST['FK_DEPARTMENT'];
        $data['FK_ROLE'] = $_POST['FK_ROLE'];
        //@TODO: Error Handling
        $this->model->create($data);
        header('location: ' . URL . 'user');
    }

    public function edit($id) {
        
    }

    public function delete($id) {
        
    }

}
