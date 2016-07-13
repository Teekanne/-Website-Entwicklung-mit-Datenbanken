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
    public function viewdelete(){
        $this->view->render('userediter/delete'); 
    }
    public function deleted(){
        $this->view->render('messages/deleted');
    }

    public function editUser($id) {
        $change = new User_Model();
        $change->editUser($id);
        exit;

    }
    public function updateUser() {
        $titel = $_POST['titelUser'];
        $firstname = $_POST['firstnameUser'];
        $lastname = $_POST['lastnameUser'];
        $email = $_POST['e-mail'];
        $emailConfirmation = $_POST['e-mailConfirmation'];

        $role = $_POST['ROLEUSER'];
        try{
            if($email == $emailConfirmation){
                
               // echo "$password";
              $userModel = new User_Model();
              $userModel->updateUser($titel, $firstname, $lastname, $email,$role);
             
            }

           else
            {
             $this->view->render('messages/emailnotequal');
             $this->view->render('user/index'); 
             exit;
            }

         exit;
        } catch (Exception $ex) {
            
        }
    }
    public function success() {
        $this->view->render('messages/editsuccess');  
        
    }
    public function renderDelete($id){
        Session::set('UserDeleteID', $id);
        $user = new User_Model();
        $user->getUsertoDelte($id);
    }
    public function delete() {
             $id=Session::get('DELETEID');
            $deleteUser = new User_Model();
            $deleteUser->deleteUser($id);
         
            
    }

}
