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
            $statement->bindParam(':questionPos', $questionPos, PDO::PARAM_INT); 
            $statement->bindParam(':singleChoice', $singleChoice, PDO::PARAM_INT); 
            $statement->bindParam(':fkQuiz', $quiz->__get("id"), PDO::PARAM_INT); 
            $statement->execute();
            
            return new Question($pdo->lastInsertId(), $description, $quiz->__get("qKey"), $question, $questionPos, $singleChoice, $quiz->__get("id"));
        }
        
        public static function LoadByQuiz($quiz, $position){
            if(!$quiz){
                return;
            }
            
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            $sql= "SELECT * FROM T_QUESTION WHERE FK_QUIZ=:quiz AND QUESTION_POS=:pos"; 
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':quiz', $quiz->__get("id"), PDO::PARAM_STR); 
            $statement->bindParam(':pos', $position, PDO::PARAM_INT); 
            $statement->execute();
            $result = $statement->fetchAll();
            
            if(!$result){
                echo "Es wurde keine Frage gefunden.";
                return null;
            }
            
            $result = $result[0];
            return new Question($result["ID"], $result["DESCRIPTION"], $result["QKEY"], $result["QUESTION"], $result["QUESTION_POS"], $result["ISSINGLECHOICE"], $result["FK_QUIZ"]);
        }
        
        public function IsLastQuestion(){
            $sql= "SELECT * FROM T_QUESTION WHERE FK_QUIZ=:quiz AND QUESTION_POS=:pos"; 
            $statement = $this->pdo->prepare($sql);
            $nextPos = $this->questionPos+1;
            $statement->bindParam(':quiz', $this->fkQuiz, PDO::PARAM_STR); 
            $statement->bindParam(':pos', $nextPos, PDO::PARAM_INT); 
            $statement->execute();
            $result = $statement->fetchAll();
            
            if(!$result){
                return true;
            }else{
                return false;
            }
        }
        
        public function GetAnswers(){
            $sql= "SELECT * FROM T_ANSWER WHERE FK_QUESTION=:questionId"; 
            $statement = $this->pdo->prepare($sql);
            $statement->bindParam(':questionId', $this->id, PDO::PARAM_STR); 
            $statement->execute();
            
            $answers = array();
            
            foreach($statement->fetchAll() as $fa => $result){
                array_push($answers, new Answer($result["ID"], $result["ANSWER_POS"], $result["ANSWER"], $result["ISCORRECT"], $result["FK_QUESTION"]));
            }

            return $answers;
        }
        
        public function GetMaxVotes(){
            $answers = $this->GetAnswers();
            
            $maxVotes = 0;
            
            foreach($answers as $a => $answer){
                $currentVotes = $answer->GetVotes();
                
                if($maxVotes < $currentVotes){
                    $maxVotes = $currentVotes;
                }
            }
            
            return $maxVotes;
        }
        
        public function ShowTable(){
            $answers = $this->GetAnswers();
            $maxVotes = $this->GetMaxVotes();
            $sumVotes = 0;
            
            foreach($answers as $a => $answer){
                $sumVotes .= $answer->GetVotes();
            }
            
            echo "<table><tr>";

            if($maxVotes==0){
                echo "Bisher hat noch niemand abgestimmt.</tr></table>";
                return;
            }

            /* Buttons in einer Zeile anzeigen */
            foreach($answers as $a => $answer){
                $currentVotes = $answer->GetVotes();
                
                if($currentVotes != 0){
                    $percent =  $currentVotes / $maxVotes * 100;
                }else{
                    $percent = 0;
                }
                echo "<td valign='bottom'>";
                echo "<input type='button' style='height:" . $percent*2 . "px;'>";
                echo "</td>";
            }

            echo "</tr><tr>";

            /* Vote-Anzahl in einer Zeile anzeigen */
            foreach($answers as $a => $answer){
                echo "<td>" . $answer->GetVotes() . " Votes</td>";
            }
            
            echo "</tr><tr>";
            
            /* Prozent in einer Zeile anzeigen */
            foreach($answers as $a => $answer){
                $currentVotes = $answer->GetVotes();
                
                if($currentVotes != 0){
                    $percent =  round($currentVotes / $sumVotes * 100, 1);
                }else{
                    $percent = 0;
                }
                
                echo "<td>" . $percent . " %</td>";
            }
            
            echo "</tr><tr>";

            /* Antwort in einer Zeile anzeigen */
            foreach($answers as $a => $answer){
                echo "<td>" . $answer->__get("answer") . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            }

            echo "</tr></table>";
        }
    }
?>
