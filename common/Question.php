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
                echo "<p>Es wurde keine Frage gefunden.</p>";
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
            
            foreach($statement->fetchAll() as $result){
                array_push($answers, new Answer($result["ID"], $result["ANSWER_POS"], $result["ANSWER"], $result["ISCORRECT"], $result["FK_QUESTION"]));
            }

            return $answers;
        }
        
        public function GetMaxVotes(){
            $answers = $this->GetAnswers();
            
            $maxVotes = 0;
            
            foreach($answers as $answer){
                $currentVotes = $answer->GetVotes();
                
                if($maxVotes < $currentVotes){
                    $maxVotes = $currentVotes;
                }
            }
            
            return $maxVotes;
        }
        
        public function CountVotes(){
            $sql = "SELECT SUM(QUANTITY) AS 'QUANTITY' FROM T_VOTE_RESULT WHERE FK_QUESTION = :questionId";
            $statement = $this->pdo->prepare($sql);
            $statement->bindParam(':questionId', $this->id, PDO::PARAM_STR); 
            $statement->execute();
            $result = $statement->fetchAll();
            
            if(!$result){
                return 0;
            }
            
            return $result[0]["QUANTITY"];
        }
        
        public function ShowTable(){
            $answers = $this->GetAnswers();
            $maxVotes = $this->GetMaxVotes();

            $sumVotes = $this->CountVotes();
            
            echo "<table border='0'><tr>";

            if($maxVotes==0 || $sumVotes==0){
                echo "<p>Bisher hat noch niemand abgestimmt.</p></tr></table>";
                return;
            }

            /* Buttons in einer Zeile anzeigen */
            foreach($answers as $answer){
                $currentVotes = $answer->GetVotes();
                
                echo "<td valign='bottom'>&nbsp;&nbsp;";
                if($currentVotes != 0){
                    echo "<input id='resultBtn' type='button' style='height:" . $currentVotes / $maxVotes * 100*2 . "px;'>";
                }

                echo "</td>";
            }

            echo "</tr><tr>";

            /* Vote-Anzahl in einer Zeile anzeigen */
            foreach($answers as $answer){
                echo "<td>&nbsp;&nbsp;" . $answer->GetVotes() . " Vote(s)</td>";
            }
            
            echo "</tr><tr>";
            
            /* Prozent in einer Zeile anzeigen */
            foreach($answers as $answer){
                $currentVotes = $answer->GetVotes();
                
                if($currentVotes != 0){
                    $percent =  round($currentVotes / $sumVotes * 100,1);
                    //$percent =  round($currentVotes / $sumVotes * 100, 1);
                }else{
                    $percent = 0;
                }
                
                echo "<td>&nbsp;&nbsp;" . $percent . " %</td>";
            }
            
            echo "</tr><tr>";

            /* Antwort in einer Zeile anzeigen */
            foreach($answers as $answer){
                echo "<td>&nbsp;&nbsp;" . $answer->__get("answer") . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            }

            echo "</tr></table>";
        }
    }
?>
