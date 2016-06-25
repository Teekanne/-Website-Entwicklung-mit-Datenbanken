<?php
/* Quiz-Key wird mit Umlauten (öäü) gespeichert. PHP-seitig nicht möglich, diese umzuwandeln (oe ae ue),
 * da die Konfiguration falsch ist */
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
            $this->isactive = true;
            $this->fkTutor = $fkTutor;
            $this->fkCategory = $fkCategory;
            $this->qKey = $qKey;
            $this->pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
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
            $qkey = 
                    substr($tutor->__get("firstname"), 0, 2) .
                    substr($tutor->__get("lastname"), 0, 2) .
                    $quizId;
            
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':qkey', $qkey, PDO::PARAM_STR); 
            $statement->bindParam(':id', $quizId, PDO::PARAM_STR); 
            $statement->execute();
            return strtolower($qkey);
        }
    }
?>