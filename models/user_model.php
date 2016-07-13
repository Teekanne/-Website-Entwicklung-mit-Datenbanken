<?php

class User_Model extends Model {

    public function __construct() {
        parent::__construct();
    }
    function deleteUser($id){
        $deletesth = $this->db->prepare('DELETE FROM T_TUTOR WHERE ID = :id');
        $deletesth->execute(array(':id' => $id));
         $message = new User();
         $message->deleted();
     
    }

    public function userList() {
        $sth = $this->db->prepare('Select ID, TITLE, FIRSTNAME, LASTNAME, EMAIL, ROLE from T_TUTOR');
        $sth->execute();
        return $sth->fetchAll();
    }
    public function editUser($id){
      
        $editsth = $this->db->prepare('SELECT ID, TITLE, FIRSTNAME, LASTNAME, EMAIL, ROLE FROM T_TUTOR WHERE ID = :id');
        $editsth->execute(array(':id' => $id));
        while ($row = $editsth->fetch(PDO::FETCH_ASSOC))
        {
             $idEdit = $row['ID'];
            SESSION::set('EDITID', $idEdit);
            $titleEdit = $row['TITLE'];
            SESSION::set('TITLEEDIT', $titleEdit);
            $firstnameEdit = $row['FIRSTNAME'];
            SESSION::set('FIRSTNAMEEDIT', $firstnameEdit);
            $lastnameEdit = $row['LASTNAME'];
            SESSION::set('LASTNAMEEDIT', $lastnameEdit);
            $emailEdit = $row['EMAIL'];
            SESSION::set('EMAILEDIT', $emailEdit);
            $roleEdit = $row['ROLE'];
            SESSION::set('ROLEEDIT', $roleEdit);
            

            $view = new User();
            $view->view();
            exit;
        }
        exit;
    }
    public function getUsertoDelte($id){
        $editsth = $this->db->prepare('SELECT ID, TITLE, FIRSTNAME, LASTNAME, EMAIL, ROLE FROM T_TUTOR WHERE ID = :id');
        $editsth->execute(array(':id' => $id));
        while ($row = $editsth->fetch(PDO::FETCH_ASSOC))
        {
             $idEdit = $row['ID'];
            SESSION::set('DELETEID', $idEdit);
            $titleEdit = $row['TITLE'];
            SESSION::set('DELETETITTLE', $titleEdit);
            $firstnameEdit = $row['FIRSTNAME'];
            SESSION::set('DELETEFIRSTNAME', $firstnameEdit);
            $lastnameEdit = $row['LASTNAME'];
            SESSION::set('DELETELASTNAME', $lastnameEdit);
            $emailEdit = $row['EMAIL'];
            SESSION::set('DELETEEMAIL', $emailEdit);
            $roleEdit = $row['ROLE'];
            SESSION::set('DELETEROLE', $roleEdit);

            $view = new User();
            $view->viewdelete();
            exit;
        }
        exit;
    }
    public function updateUser($titel, $firstname, $lastname, $email, $role) {
    
            $ID = SESSION::get('EDITID');
            $sqlInsert = "UPDATE T_TUTOR SET TITLE='".$titel."', FIRSTNAME='".$firstname."', LASTNAME='".$lastname."', EMAIL='".$email."', ROLE='".$role."' where ID='".$ID."'";
            $preparedStatement = $this->db->prepare($sqlInsert);
            $preparedStatement->execute();
            $message = new User();
            $message->success();
  
    }
    public function reg($title, $firstname, $lastname, $email, $password, $rolereg) {
        $Checklength = $password;
        $checkEMAIL = $email;
        //Romove all illegal characters from E-Mail.
        $cleanEmail = filter_var($checkEMAIL, FILTER_SANITIZE_EMAIL);
        if (strlen($Checklength) >= 8) {

            $sth = $this->db->prepare("SELECT * FROM T_TUTOR WHERE EMAIL = :email");
            $sth->execute(array(':email' => $email));
            $count = $sth->rowCount();

            if ($count == 0) {
                $regStatement = $this->db->prepare("INSERT INTO T_TUTOR(TITLE, FIRSTNAME, LASTNAME, EMAIL, PASSWORD, ROLE)VALUES(:title, :firstname, :lastname, :email, :password, :role)");
                $regStatement->execute(array("title" => "$title", "firstname" => "$firstname", "lastname" => "$lastname", "email" => "$email", "password" => "$password", "role" => $rolereg));

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
