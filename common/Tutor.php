<?php
/**
 * Tutor.php
 * 
 * This file handles several database-operations for an specific tutor-object.
 * 
 * @author Christoph Pohl <christoph.pohl@stud.fh-flensburg.de>
 * @version 1.0
 */
    class Tutor {
        /**
         * ID of an tutor
         * @access private
         * @var int
         */
        private $id;
        
        /**
         * title of a tutor
         * @access private
         * @var string
         */
        private $title;
        
        /**
         * first name of a tutor
         * @access private
         * @var string
         */
        private $firstname;
        
        /**
         * last name of a tutor
         * @access private
         * @var string
         */
        private $lastname;
        
        /**
         * email of a tutor
         * @access private
         * @var string
         */
        private $email;
        
        /**
         * md5-hashed-password of a tutor
         * @access private
         * @var string
         */
        private $password;
        
        /**
         * role of a user
         * @access private
         * @var string
         */
        private $role;
        
        /**
         * key for resetting the tutor-password
         * @access private
         * @var string
         */
        private $resetkey;
        
        /**
         * contains the database-connection
         * @access private
         * @var PDO
         */
        private $pdo;
        
        /**
         * Magic getter-method
         * 
         * This method returns the internal value of a variable if it exists.
         * 
         * @param string $key
         * @return misc $key
         */
        public function __get($key){
            if(property_exists($this, $key)){
                return $this->$key;                
            }
        }
        
        /**
         * Magic setter-method
         * 
         * This method sets the internal value of a variable if it exists.
         * 
         * @param string $key
         * @param misc $value
         */
        public function __set($key, $value){
            if(property_exists($this, $key)){
                $this->$key = $value;
            }
        }

        /**
         * Constructor of the tutor-class
         * 
         * Initializes a new object of the class 'tutor'
         * 
         * @param int $id
         * @param string $title
         * @param string $firstname
         * @param string $lastname
         * @param string $email
         * @param string $password
         * @param string $role
         * @param string $resetkey
         */
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
        
        /**
         * Loads an question by a quiz out of the databench.
         * 
         * @param int $id
         * @return \Tutor
         */
        public static function Load($id){
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            $sql= "SELECT * FROM T_TUTOR WHERE ID=:userid"; 
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':userid', $id, PDO::PARAM_INT); 
            $statement->execute();
            $result = $statement->fetchAll()[0];
            
            if(!$result){
                echo "<p>User mit ID " . $id . " existiert nicht.</p>";
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
