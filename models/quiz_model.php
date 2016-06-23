<?php
    class Quiz
    {   
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
    
    class Question
    {   		
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

    class Answer
    {	
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

