<?php
    class Category {
        private $id;
        private $catname;
        private $level;
        private $fkTutor;
        private $fkParentId;
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

        public function __construct($id, $catname, $level, $fkTutor, $fkParentId){
            $this->id = $id;
            $this->catname = $catname;
            $this->level = $level;
            $this->fkTutor = $fkTutor;
            $this->fkParentId = $fkParentId;
            $this->pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
        }
        
        public static function Add($name, $mainCategory, $fkTutor){
            $cat = Category::Load($name);
            
            if($cat){
                echo $name . " existiert bereits.";
                return;
            }
            
            if($mainCategory){
                $level = 2;
                $fkParentId = $mainCategory->__get("id");
            }else{
                $level = 1;
                $fkParentId = null;
            }
            
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            
            $sql= "INSERT INTO T_CATEGORY(CATNAME, LEVEL, FK_TUTOR, FK_PARENT_ID) " .
                    "VALUES (:name, :level, :fkTutor, :fkParentId)";
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->bindParam(':level', $level, PDO::PARAM_STR);
            $statement->bindParam(':fkTutor', $fkTutor, PDO::PARAM_STR);
            $statement->bindParam(':fkParentId', $fkParentId, PDO::PARAM_STR);
            
            $statement->execute();

            return new Category($pdo->lastInsertId(), $name, $level, $fkTutor, $fkParentId);
        }
        
        public static function Delete($name) {
            $category = Category::Load($name);
            
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            
            if(!$category->__get("fkParentId")){
                $sql= "DELETE FROM T_CATEGORY WHERE FK_PARENT_ID=:parentId"; 
                $statement = $pdo->prepare($sql);
                $statement->bindParam(':parentId', $category->__get("id"), PDO::PARAM_STR); 
                $statement->execute();
            }
            
            $sql= "DELETE FROM T_CATEGORY WHERE CATNAME=:catName"; 
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':catName', $name, PDO::PARAM_STR); 
            $statement->execute();
        }
        
        public static function Load($name) {
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            $sql= "SELECT * FROM T_CATEGORY WHERE CATNAME=:catName"; 
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':catName', $name, PDO::PARAM_STR); 
            $statement->execute();
            $result = $statement->fetchAll();
            
            if(!$result){
                return null;
            }else{
                $result = $result[0];
            }

            return new Category($result["ID"], $result["CATNAME"], $result["LEVEL"], $result["FK_TUTOR"], $result["FK_PARENT_ID"]);
        }
        
        public static function CountFirstLevelCategories(){
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            
            $sql= "SELECT * FROM T_CATEGORY WHERE LEVEL=1"; 
            $statement = $pdo->prepare($sql);
            $statement->execute();
            
            return $statement->rowCount();
        }
        
        /* Gibt eine Liste des generischen Typs "Category" zurück */
        private static function getFirstLevelCategories($id){
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            $result = $pdo->query("SELECT * FROM T_CATEGORY WHERE LEVEL=1 AND FK_TUTOR=" . $id . " ORDER BY ID");
            $categories = array();
            foreach($result as $r => $category){
                array_push($categories, new Category($category["ID"], $category["CATNAME"], $category["LEVEL"], $category["FK_TUTOR"], $category["FK_PARENT_ID"]));
            }
            return $categories;
        }
        
        private function getSecondLevelCategories(){
            //$pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            $result = $this->pdo->query("SELECT * FROM T_CATEGORY WHERE FK_PARENT_ID=" . $this->id);
            $categories = array();
            
            foreach($result as $r => $category){
                array_push($categories, new Category($category["ID"], $category["CATNAME"], $category["LEVEL"], $category["FK_TUTOR"], $category["FK_PARENT_ID"]));
            }
            
            return $categories;            
        }
        
        public static function ShowSelectBoxWithCategories($id, $secondLevel){
            
            echo "<select style=width:13.3em; name='category'>";
            foreach(Category::getFirstLevelCategories($id) as $c => $category){
                echo "<option>" . $category->__get("catname") . "</option>";
                
                if($secondLevel){
                    foreach($category->getSecondLevelCategories() as $s => $secondLevelCategory){
                        echo "<option value='" . $secondLevelCategory->__get("catname") . "'>- " . $secondLevelCategory->__get("catname") . "</option>";
                    }
                }
            }        

            echo "</select>";
        }
    }
?>
