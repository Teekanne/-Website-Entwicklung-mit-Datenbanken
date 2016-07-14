<?php
/**
 * Quiz.php
 * 
 * This file handles several database-operations for an specific quiz-object.
 * 
 * @author Christoph Pohl <christoph.pohl@stud.fh-flensburg.de>
 * @version 1.0
 */
    class Quiz {
        /**
         * ID of a quiz
         * @access private
         * @var int
         */
        private $id;
        
        /**
         * name of the quiz
         * @access private
         * @var string
         */
        private $name;
        
        /**
         * quiz-description
         * @access private
         * @var string
         */
        private $description;
        
        /**
         * sets the activity of a quiz
         * @access private
         * @var boolean
         */
        private $isactive;
        
        /**
         * foreign-key-id of the tutor
         * @access private
         * @var int
         */
        private $fkTutor;
        
        /**
         * foreign-key-id of the category
         * @access private
         * @var int
         */
        private $fkCategory;
        
        /**
         * uniquied key of a quiz
         * @access private
         * @var int
         */
        private $qKey;
        
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
         * Constructor of the quiz-class
         * 
         * Initializes a new object of the class 'quiz'
         * 
         * @param int $id
         * @param string $name
         * @param string $description
         * @param boolean $isactive
         * @param int $fkTutor
         * @param int $fkCategory
         * @param string $qKey
         */
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
        
        /**
         * Loads a quiz by a key out of the databench.
         * 
         * @param string $qkey
         * @return \Quiz
         */
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
        
        /**
         * Adds a new quiz to the databench
         * @param string $name
         * @param string $description
         * @param Tutor $tutor
         * @param Category $category
         * @return \Quiz
         */
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
        
        /**
         * Sets a key for a quiz
         * @param type $tutor
         * @param type $quizId
         * @return type
         */
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
