<?php
    class Question {
        private $id;
        private $description;
        private $qkey;
        private $question;
        private $questionPos;
        private $singleChoice;
        private $fkQuiz;
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

        public function __construct($id, $description, $qkey, $question, $questionPos, $singleChoice, $fkQuiz){
            $this->id = $id;
            $this->description = $description;
            $this->qkey = $qkey;
            $this->question = $question;
            $this->questionPos = $questionPos;
            $this->singleChoice = $singleChoice;
            $this->fkQuiz = $fkQuiz;
            $this->pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
        }
        
        public static function Add($description, $question, $questionPos, $singleChoice, $quiz){
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');

            $sql= "INSERT INTO T_QUESTION (DESCRIPTION, QKEY, QUESTION, QUESTION_POS, ISSINGLECHOICE, FK_QUIZ) " .
                    "VALUES (:description, :qkey, :question, :questionPos, :singleChoice, :fkQuiz)"; 

            if($singleChoice){
                $singleChoice = 1;
            }else{
                $singleChoice = 0;
            }
            
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':description', $description, PDO::PARAM_STR); 
            $statement->bindParam(':qkey', $quiz->__get("qKey"), PDO::PARAM_STR); 
            $statement->bindParam(':question', $question, PDO::PARAM_STR); 
            $statement->bindParam(':questionPos', $questionPos, PDO::PARAM_STR); 
            $statement->bindParam(':singleChoice', $singleChoice, PDO::PARAM_STR); 
            $statement->bindParam(':fkQuiz', $quiz->__get("id"), PDO::PARAM_STR); 
            $statement->execute();
            
            return new Question($pdo->lastInsertId(), $description, $quiz->__get("qKey"), $question, $questionPos, $singleChoice, $quiz->__get("id"));
        }
    }
?>