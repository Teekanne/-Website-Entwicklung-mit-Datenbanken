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
       $titel = $_POST['titel'];
        $vorname = $_POST['vorname'];
        $nachname = $_POST['nachname'];
        $email = $_POST['e-mail'];
        $emailConfirmation = $_POST['e-mailConfirmation'];
        $password = md5($_POST['password']);
        $passwordConfirmation = md5($_POST['passwordConfirmation']);
        $rolereg = $_POST['ROLE'];
        try{
            if($email == $emailConfirmation){
                if($password == $passwordConfirmation){
               // echo "$password";
              $regModel = new User_Model();
              $regModel->reg($titel, $vorname, $nachname, $email, $password, $rolereg);
            }else
            {
                
            }
            }
           else
            {
                
            }
         $this->view->render('login/index');   
        } catch (Exception $ex) {

        }
    }

    public function edit($id) {
        $editUser = new User_Model();
        $editUser->editUser($id);
        exit;
    }

    public function delete($id) {
            $deleteUser = new User_Model();
            $deleteUser->deleteUser($id);
    }

}
