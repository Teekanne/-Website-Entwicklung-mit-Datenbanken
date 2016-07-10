<?php
    class QuizEntity
    {   
        private $QuizID;
        private $QuizTitle;
        private $Questions;
        
        function __get($attribute)
        {
            return $this->$attribute;
        }

        function __set($attribute, $value)
        {
            $this->$attribute = $value;
        }
    }	
    
    class QuestionEntity
    {   
        private $QuestionID;
        private $QuestionText;
        private $QuestionDescription;
        private $SingleChoice;
        private $QuestionKey;
        private $Answers;

        function __get($attribute)
        {
            return $this->$attribute;
        }

        function __set($attribute, $value)
        {
            $this->$attribute = $value;
        }
    }

    class AnswerEntity
    {	
        private $AnswerID;
        private $AnswerText;
        private $QuestionChecked;

        function __get($attribute)
        {
            return $this->$attribute;
        }

        function __set($attribute, $value)
        {
            $this->$attribute = $value;
        }
    }	
?>

