<?php   
/**
 * Answer.php
 * 
 * This file handles several database-operations for an specific answer-object.
 * @author Christoph Pohl <christoph.pohl@stud.fh-flensburg.de>
 * @version 1.0
 * @package sample
 */

    class Answer {
        /**
         * ID of an answer
         * @access private
         * @var integer
         */
        private $id;
        
        /**
         * position of an answer
         * @access private
         * @var integer
         */
        private $answerPos;
        
        /**
         * text of an answer
         * @access private
         * @var string
         */
        private $answer;
        
        /**
         * certains if an answer is correct
         * @access private
         * @var boolean
         */
        private $iscorrect;
        
        /**
         * certains if an answer is correct
         * @access private
         * @var boolean
         */
        private $fkQuestion;
        
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
         * Constructor of the answer-class
         * 
         * Initializes a new object of the class 'answer'
         * 
         * @param int $id
         * @param int $answerPos
         * @param string $answer
         * @param boolean $iscorrect
         * @param int $fkQuestion
         */
        public function __construct($id, $answerPos, $answer, $iscorrect, $fkQuestion){
            $this->id = $id;
            $this->answerPos = $answerPos;
            $this->answer = $answer;
            $this->iscorrect = $iscorrect;
            $this->fkQuestion = $fkQuestion;
            $this->pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
        }
        
        /**
         * Adds a new question to the databse.
         * 
         * @param int $answerPos
         * @param Answer $answer
         * @param boolean $iscorrect
         * @param Question $question
         * @return \Answer
         */
        public static function Add($answerPos, $answer, $iscorrect, $question){
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');

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
        
        /**
         * Gets the sum of votes for an answer.
         * 
         * @return int sum of votes
         */
        public function GetVotes(){
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
