<?php
    include_once("database.php");

    
    class Question {
        private $id;
        private $fk_category;
        private $fk_tutor; 
        private $isactive; 
        private $owner; 
        private $qkey; 
        private $question;
        private $description;
        
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
        
        public function __construct($id, $description, $fk_category, $fk_tutor, $isactive, $owner, $qkey, $question){
            $this->id = $id;
            $this->description = $description;
            $this->fk_category = $fk_category;
            $this->fk_tutor = $fk_tutor;
            $this->isactive = $isactive;
            $this->owner = $owner;
            $this->qkey = $qkey;
            $this->question = $question;
        }
        
        public static function SaveQuestion($description, $fk_category, $fk_tutor, $isactive, $owner, $qkey, $question) {
            $dataBase = new DataBase();
            
            $insertedId = $dataBase->insert(
                    "T_QUESTION", 
                    array("DESCRIPTION" => $description, "FK_CAT" => $fk_category, "FK_TUTOR" => $fk_tutor, "ISACTIVE" => $isactive, "OWNER" => $owner, "QKEY" => $qkey, "QUESTION" => $question));;
            return new Question($insertedId, $description, $fk_category, $fk_tutor, $isactive, $owner, $qkey, $question);
        }
        
        public function SaveAnswers($answers){
            $dataBase = new DataBase();
            $position = 1;
            
            foreach($answers as $answer){
                if(!empty($answer)){
                    $dataBase->insert(
                        "T_ANSWER", 
                        array("ANSWER_POS" => $position, "ANSWER" => $answer, "ISCORRECT" => 0, "FK_QUESTION" => $this->id));;

                    $position++;
                }
            }
        }
        
        public function GetAnswers(){
            $dataBase = new DataBase();
            return $dataBase->GetColumn("SELECT ANSWER FROM T_ANSWER WHERE FK_QUESTION=". $this->id);
        }
    }
    
    class Category {
        private $id;
        private $name;
        private $level;
        private $owner;
        
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

        public function __construct($id, $name, $level, $owner){
            $this->id = $id;
            $this->name = $name;
            $this->level = $level;
            $this->owner = $owner;
        }
        
        public static function Load($name){
            $dataBase = new DataBase();
            $column = $dataBase->Select("SELECT * FROM T_CATEGORY WHERE CATNAME='" . $name . "'");
            return new Category($column["ID"], $column["CATNAME"], $column["LEVEL"], $column["OWNER"]);
        }
        
    }
    
    class User {
        private $id;
        private $title;
        private $firstname;
        private $lastname;
        private $email;
        private $password;
        private $fk_state;
        private $fk_department;
        private $department;
        private $fk_role;
        private $role;
        
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

        public function __construct($id, $title, $firstname, $lastname, $email, $password, $fk_state, $fk_department, $fk_role){
            $this->id = $id;
            $this->title = $title;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            $this->email = $email;
            $this->password = $password;
            $this->fk_state = $fk_state;
            $this->fk_department = $fk_department;
            $this->fk_role = $fk_role;
            
            $dataBase = new DataBase();
            $column = $dataBase->Select("SELECT * FROM T_DEPARTMENT WHERE ID=".$this->fk_department);
            $this->department = $column["NAME"];
            
            $column = $dataBase->Select("SELECT * FROM T_ROLE WHERE ID=".$this->fk_role);
            $this->role = $column["NAME"];
        }
        
        public static function Load($id){
            $dataBase = new DataBase();
            $column = $dataBase->Select("SELECT * FROM T_TUTOR WHERE ID=".$id);
            return new User($column["ID"], $column["TITLE"], $column["FIRSTNAME"], $column["LASTNAME"], $column["EMAIL"], $column["PASSWORD"], $column["FK_STATE"] , $column["FK_DEPARTMENT"], $column["FK_ROLE"]);
        }
    }
?>