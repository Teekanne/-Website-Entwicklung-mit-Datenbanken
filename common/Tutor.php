<?php
    class Tutor {
        private $id;
        private $title;
        private $firstname;
        private $lastname;
        private $email;
        private $password;
        private $role;
        private $resetkey;
        private $pdo;
        
        public function __get($key){
            if(property_exists($this, $key)){
                return $this->$key;                
            }
        }
        
        public function __set($key, $value){
            if(property_exists($this, $key)){
                $this->$key = $value;
            }
        }

        public function __construct($id, $title, $firstname, $lastname, $email, $password, $role, $resetkey){
            $this->id = $id;
            $this->title = $title;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            $this->email = $email;
            $this->password = $password;
            $this->role = $role;
            $this->resetkey = $resetkey;
            $this->pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
        }
        
        public static function Load($id){
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            $sql= "SELECT * FROM T_TUTOR WHERE ID=:userid"; 
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':userid', $id, PDO::PARAM_INT); 
            $statement->execute();
            $result = $statement->fetchAll()[0];
            
            if(!$result){
                echo "<label id='commentLabel'><h3>User mit ID " . $id . " existiert nicht.</h3></label></p>";
                return null;
            }

            return new Tutor(
                    $result["ID"], 
                    $result["TITLE"], 
                    $result["FIRSTNAME"], 
                    $result["LASTNAME"], 
                    $result["EMAIL"],
                    $result["PASSWORD"],
                    $result["ROLE"],
                    $result["RESETKEY"]);
        }
    }
?>
