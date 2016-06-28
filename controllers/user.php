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

    public function editUser($id) {
        
        $change = new User_Model();
        $change->editUser($id);
    
        $this->view->render('userediter/index'); 
        
        exit;
        /*  
        <form method="post" action="<?php echo URL; ?>user/create">
    <h1>Einen bestehenden Benutzer beabreiten</h1></br>
    <input name="titel" type="text" value="<?php echo $title ?>" placeholder="Titel"></br>
    <input name="vorname" type="text" value="<?php echo $firstname ?>" pattern=".{0}|.{2,20}" required title="Ihr Name muss mindestens zwei maximal 20 Zeichen lang sein"  placeholder="Vorname"></br>
    <input name="nachname" type="text" value="<?php echo $lastname ?>" pattern=".{0}|.{2,20}" required title="Ihr Nachname muss mindestestens zwei maximal 20 Zeichen lang sein" placeholder="Nachname"></br>
    <input name="e-mail" type="email" value="<?php echo $email ?>" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail"></br>
    <input name="e-mailConfirmation" value="<?php echo $email ?>" type="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail bestätigen"></br>
       <label>Role</label>
    <select name="ROLE" value="<?php echo $role ?>">
        <option value="Default">Default</option>
        <option value="User">User</option>
        <option value="Administrator">Administrator</option>
    </select><br />
    <input type="submit" name="Benutzer anlegen" value="Registrieren">

</form>*/
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
