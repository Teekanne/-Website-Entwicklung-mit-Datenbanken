<?php
/**
 * Category.php
 * 
 * This file handles several database-operations for an specific category-object.
 * 
 * @author Christoph Pohl <christoph.pohl@stud.fh-flensburg.de>
 * @version 1.0
 */
    class Category {
        /**
         * ID of an category
         * @access private
         * @var integer
         */
        private $id;
        
        /**
         * name of the category
         * @access private
         * @var string
         */
        private $catname;
        
        /**
         * Level of the category
         * @access private
         * @var integer
         */
        private $level;
        
        /**
         * ID of the tutor
         * @access private
         * @var integer
         */
        private $fkTutor;
        
        /**
         * ID of an parent-category
         * @access private
         * @var integer
         */
        private $fkParentId;
        
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
         * Constructor of the category-class
         * 
         * Initializes a new object of the class 'category'
         * 
         * @param integer $id
         * @param string $catname
         * @param integer $level
         * @param integer $fkTutor
         * @param integer $fkParentId
         */
        public function __construct($id, $catname, $level, $fkTutor, $fkParentId){
            $this->id = $id;
            $this->catname = $catname;
            $this->level = $level;
            $this->fkTutor = $fkTutor;
            $this->fkParentId = $fkParentId;
            $this->pdo = new DataBase();
        }
        
        /**
         * Adds a new category to the databse.
         * 
         * @param string $name
         * @param category $mainCategory
         * @param string $fkTutor
         * @return \Category
         */
        public static function Add($name, $mainCategory, $fkTutor){
            $cat = Category::Load($name);
            
            if($cat){
                echo "<p>" . $name . " existiert bereits.</p>";
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
        
        /**
         * Deletes an category from the databse.
         * 
         * @param string $name
         */
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
        
        /**
         * Loads a category from the database.
         * 
         * @param string $name
         * @return \Category
         */
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
        
        /**
         * Counts the available first level categories.
         * 
         * @return int Sum of first level categories
         */
        public static function CountFirstLevelCategories(){
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            
            $sql= "SELECT * FROM T_CATEGORY WHERE LEVEL=1"; 
            $statement = $pdo->prepare($sql);
            $statement->execute();
            
            return $statement->rowCount();
        }
        
        /**
         * Returns an array of first level categories.
         * 
         * @param integer $id
         * @return array of categories
         */
        private static function getFirstLevelCategories($id){
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            $result = $pdo->query("SELECT * FROM T_CATEGORY WHERE LEVEL=1 AND FK_TUTOR=" . $id . " ORDER BY ID");
            $categories = array();
            foreach($result as $category){
                array_push($categories, new Category($category["ID"], $category["CATNAME"], $category["LEVEL"], $category["FK_TUTOR"], $category["FK_PARENT_ID"]));
            }
            return $categories;
        }
        
        /**
         * Returns an array of second level categories.
         * 
         * @param integer $id
         * @return array of categories
         */
        private function getSecondLevelCategories(){
            $result = $this->pdo->query("SELECT * FROM T_CATEGORY WHERE FK_PARENT_ID=" . $this->id);
            $categories = array();
            
            foreach($result as $category){
                array_push($categories, new Category($category["ID"], $category["CATNAME"], $category["LEVEL"], $category["FK_TUTOR"], $category["FK_PARENT_ID"]));
            }
            
            return $categories;            
        }
        
        /**
         * Shows an selectbox with categories
         * 
         * @param type $id
         * @param boolean $secondLevel
         * @param integer $width
         */
        public static function ShowSelectBoxWithCategories($id, $secondLevel, $width){
            $firstOption = true;
            echo "<select style=width:13.3em; name='category' ";
            if($width) { echo "size='5'"; }
            echo ">";
            
            foreach(Category::getFirstLevelCategories($id) as $category){
                echo "<option ";
                if($firstOption){ echo "selected"; $firstOption=false; }
                echo ">" . $category->__get("catname") . "</option>";
                
                if($secondLevel){
                    foreach($category->getSecondLevelCategories() as $secondLevelCategory){
                        echo "<option value='" . $secondLevelCategory->__get("catname") . "'>- " . $secondLevelCategory->__get("catname") . "</option>";
                    }
                }
            }        

            echo "</select>";
        }
    }
?>
