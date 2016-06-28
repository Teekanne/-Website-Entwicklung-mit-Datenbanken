<?php

class User extends Controller {

    public function __construct() {
        parent::__construct();
        Session::init();

        $logged = Session::get('loggedIn');
        $role = Session::get('ROLE');
        $test="test";
        Session::set('TITLEEDIT', $test);
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
    public function view(){
        $this->view->render('userediter/index'); 
    }

    public function editUser($id) {
        $change = new User_Model();
        $change->editUser($id);
        exit;
        $editUser = new User_Model();  
        $editUser->editUser($id);
    }

    public function delete($id) {
            $deleteUser = new User_Model();
            echo $id;
            exit;
            $deleteUser->deleteUser($id);
    }

}
