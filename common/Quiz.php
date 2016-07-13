<?php
    class Quiz {
        private $id;
        private $name;
        private $description;
        private $isactive;
        private $fkTutor;
        private $fkCategory;
        private $qKey;
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
        
        public function __construct($id, $name, $description, $isactive, $fkTutor, $fkCategory, $qKey){
            $this->id = $id;
            $this->name = $name;
            $this->description = $description;
            $this->isactive = $isactive;
            $this->fkTutor = $fkTutor;
            $this->fkCategory = $fkCategory;
            $this->qKey = $qKey;
            $this->pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
        }
        
        public static function LoadByKey($qkey){
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            $sql= "SELECT * FROM T_QUIZ WHERE QKEY=:key"; 
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':key', $qkey, PDO::PARAM_STR); 
            $statement->execute();
            $result = $statement->fetchAll();
            
            if(!$result){
                echo "<p>Quiz mit Key '" . $qkey . "' existiert nicht.</p>";
                return null;
            }
            
            $result = $result[0];
            
            return new Quiz($result["ID"], $result["QUIZNAME"], $result["DESCRIPTION"], $result["ISACTIVE"], $result["FK_TUTOR"], $result["FK_CATEGORY"], $result["QKEY"]);
        }
        
        public static function Add($name, $description, $tutor, $category){
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            $sql= "INSERT INTO T_QUIZ (QUIZNAME, DESCRIPTION, ISACTIVE, FK_TUTOR, FK_CATEGORY) " .
                    "VALUES (:name, :description, :isactive, :fktutor, :fkcategory)"; 

            $isactive = 1;
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':name', $name, PDO::PARAM_STR); 
            $statement->bindParam(':description', $description, PDO::PARAM_STR); 
            $statement->bindParam(':isactive', $isactive, PDO::PARAM_STR); 
            $statement->bindParam(':fktutor', $tutor->__get("id"), PDO::PARAM_STR); 
            $statement->bindParam(':fkcategory', $category->__get("id"), PDO::PARAM_STR); 
            $statement->execute();
            $qkey = self::addKey($tutor, $pdo->lastInsertId());
            return new Quiz($pdo->lastInsertId(), $name, $description, $isactive, $tutor->__get("id"), $category->__get("id"), $qkey);
        }
        
        private static function addKey($tutor, $quizId){
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');

            $sql= "UPDATE T_QUIZ SET QKEY=:qkey WHERE ID=:id"; 
            
            $replacePairs = array(
                'ä' => 'ae',
                'ö' => 'oe',
                'ü' => 'ue',
                'ß' => 'ss'
            );
            
            $key = substr(strtr($tutor->__get("firstname"), $replacePairs),0,2)
                    . substr(strtr($tutor->__get("lastname"), $replacePairs),0,2)
                    . $quizId;
            $key = strtolower($key);

            $statement = $pdo->prepare($sql);
            $statement->bindParam(':qkey', $key, PDO::PARAM_STR); 
            $statement->bindParam(':id', $quizId, PDO::PARAM_STR); 
            $statement->execute();
            
            return strtolower($key);
        }
    }
?>
