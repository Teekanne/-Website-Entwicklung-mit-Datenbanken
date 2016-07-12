<?php

class Account_Model extends Model {

    public function __construct() {
        parent::__construct();
    }
     public function editUser($id){
      
        $editsth = $this->db->prepare('SELECT ID, TITLE, FIRSTNAME, LASTNAME, EMAIL, ROLE FROM T_TUTOR WHERE ID = :id');
        $editsth->execute(array(':id' => $id));
        while ($row = $editsth->fetch(PDO::FETCH_ASSOC))
        {
            $idEdit = $row['ID'];
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

            $view = new Account();
            $view->view();
             exit;
        }
        exit;
    }
    public function changeEdit($titel, $vorname, $nachname, $email, $password, $rolereg) {
       //
    }
}
