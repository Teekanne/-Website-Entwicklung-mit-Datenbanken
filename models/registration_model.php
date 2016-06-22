<?php

class Registration_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function reg($title, $firstname, $lastname, $email, $password, $rolereg) {

        $sth = $this->db->prepare("SELECT * FROM T_TUTOR WHERE EMAIL = :email");
        $sth->execute(array(':email' =>$email));

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
  exit;
                  
        } else {header('location: ../login');
                  exit;
            
        }
    
    }
        function regmail($title, $firstname, $lastname, $email, $password) {
            $empfaenger = "$email";
            $betreff = "Testimeter Registration";
            $from = "From: Team Testimeter <testimetr@hs-flensburg.de>";
            $text = "Hallo $title $firstname $lastname, Sie haben Sich erfolgreich mit dem Passwort:$password registriert.";

            mail($empfaenger, $betreff, $text, $from);
        }

    }

