<?php
/* Bisher wird nicht abgespeichert, ob eine Antwort korrekt ist */
    class Answer {
        private $id;
        private $answerPos;
        private $answer;
        private $iscorrect;
        private $fkQuestion;
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

        public function __construct($id, $answerPos, $answer, $iscorrect, $fkQuestion){
            $this->id = $id;
            $this->answerPos = $answerPos;
            $this->answer = $answer;
            $this->iscorrect = $iscorrect;
            $this->fkQuestion = $fkQuestion;
            $this->pdo = new PDO('mysql:host=localhost;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            //$this->pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
        }
        
        public static function Add($answerPos, $answer, $iscorrect, $question){
            $pdo = new PDO('mysql:host=localhost;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            //$pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');

            $sql= "INSERT INTO T_ANSWER (ANSWER_POS, ANSWER, ISCORRECT, FK_QUESTION) " .
                    "VALUES (:pos, :answer, :iscorrect, :fkQuestion)"; 
            
            if($iscorrect){
                $iscorrect = 1;
            }else{
                $iscorrect = 0;
            }
            
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':pos', $answerPos, PDO::PARAM_STR); 
            $statement->bindParam(':answer', $answer, PDO::PARAM_STR); 
            $statement->bindParam(':iscorrect', $iscorrect, PDO::PARAM_STR); 
            $statement->bindParam(':fkQuestion', $question->__get("id"), PDO::PARAM_STR);
            $statement->execute();
            
            return new Answer($pdo->lastInsertId(), $answerPos, $answer, $iscorrect, $question->__get("id"));
        }
        
        public function GetVotes(){
            //$pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            $sql= "SELECT QUANTITY FROM T_VOTE_RESULT WHERE FK_ANSWER=:questionId"; 
            $statement = $this->pdo->prepare($sql);
            $statement->bindParam(':questionId', $this->id, PDO::PARAM_STR); 
            $statement->execute();
            $result = $statement->fetchAll();

            if(!$result){
                return 0;
            }
            
            return $result[0]["QUANTITY"];
        }
        

    }
?>
