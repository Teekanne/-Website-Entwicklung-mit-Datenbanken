<?php

class User_Model extends Model {

    public function __construct() {
        parent::__construct();
    }
    function deleteUser($id){
        $deletesth = $this->db->prepare('DELETE FROM T_TUTOR WHERE ID = :id');
        $deletesth->execute(array(':id' => $id));
         header('location: ..');
                exit;
    }

    public function userList() {
        $sth = $this->db->prepare('Select ID, TITLE, FIRSTNAME, LASTNAME, EMAIL, ROLE from T_TUTOR');
        $sth->execute();
        return $sth->fetchAll();
    }
 public function reg($title, $firstname, $lastname, $email, $password, $rolereg) {
        $Checklength = $password;
        
        $checkEMAIL = $email;
        //Romove all illegal characters from E-Mail.
        $cleanEmail = filter_var($checkEMAIL, FILTER_SANITIZE_EMAIL);

        if (strlen($Checklength) >= 8) {
            //!filter_var($clanEail, FILTER_VALIDATE_EMAIL);
            $sth = $this->db->prepare("SELECT * FROM T_TUTOR WHERE EMAIL = :email");
            $sth->execute(array(':email' => $email));

            $count = $sth->rowCount();
            //   $sth->fetchAll();
            //$rows = $sth->fetch(P DO::FETCH_NUM);
            //$this->view->render('login/index');
            // $count = $sth->fetchColumn(); 
            //  $rows = $sth->rowCount();
            //$count = $sth->fetchColumn(); 
            //$count =  mysql_num_rows(sth);
            //  $rows = $sth->fetchAll();
            //$num_rows = count($rows);
            //  if ($sth->fetch(PDO::FETCH_NUM) == 0){
            if ($count == 0) {
                $regStatement = $this->db->prepare("INSERT INTO T_TUTOR(TITLE, FIRSTNAME, LASTNAME, EMAIL, PASSWORD, ROLE)VALUES(:title, :firstname, :lastname, :email, :password, :role)");
                $regStatement->execute(array("title" => "$title", "firstname" => "$firstname", "lastname" => "$lastname", "email" => "$email", "password" => "$password", "role" => $rolereg));
                //  $this->regmail($title, $firstname, $lastname, $email, $password);
                header('location: ../user');
                exit;
            } else {
                header('location: ../user');
                exit;
            }
        } else {
            
        }
    }
    
    
   

}
