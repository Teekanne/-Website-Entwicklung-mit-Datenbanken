<?php
    class Category {
        private $id;
        private $catname;
        private $level;
        private $fkTutor;
        private $fkParentId;
        private $dataBase;
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
        
        public static function Load($name) {
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            /*$selected = $pdo->query("SELECT * FROM T_CATEGORY WHERE CATNAME='". $name . "'");
            $row = $selected->fetch(PDO::FETCH_ASSOC);
            echo "var_dump(selected): " . var_dump($selected);
            echo "var_dump(selected[0][ID]): " . var_dump($row["ID"]);
            */
            $sql= "SELECT * FROM T_CATEGORY WHERE CATNAME=':catName'"; 
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':catName', $name); 
            
            $stmt->execute();
            $result = $stmt->fetchAll();

            echo "Row-Ausgabe";
            foreach($result as $row){
                echo "<li>{$row['ID']}</li>";
            }
            
            $column["ID"] = 1;
            $column["CATNAME"] = 1;
            $column["LEVEL"] = 1;
            $column["FK_TUTOR"] = 1;
            $column["FK_PARENT_ID"] = 1;
            
            return new Category($column["ID"], $column["CATNAME"], $column["LEVEL"], $column["FK_TUTOR"], $column["FK_PARENT_ID"]);
        }
        
        /* Gibt eine Liste des generischen Typs "Category" zurück */
        public static function GetFirstLevelCategories(){
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            $result = $pdo->query("SELECT * FROM T_CATEGORY WHERE LEVEL=1 ORDER BY ID");
            $categories = array();
            foreach($result as $r => $category){
                array_push($categories, new Category($category["ID"], $category["CATNAME"], $category["LEVEL"], $category["FK_TUTOR"], $category["FK_PARENT_ID"]));
            }
            return $categories;
        }
        
        public function GetSecondLevelCategories(){
            $pdo = new PDO('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');
            $result = $pdo->query("SELECT * FROM T_CATEGORY WHERE FK_PARENT_ID=" . $this->id);
            $categories = array();
            foreach($result as $r => $category){
                array_push($categories, new Category($category["ID"], $category["CATNAME"], $category["LEVEL"], $category["FK_TUTOR"], $category["FK_PARENT_ID"]));
            }
            return $categories;            
        }
        
        public static function ShowSelectBoxWithCategories(){
             echo "<select style=width:13.3em; name='category'>";
            foreach(Category::GetFirstLevelCategories() as $c => $category){
                echo "<option>" . $category->__get("catname") . "</option>";

                foreach($category->GetSecondLevelCategories() as $s => $secondLevelCategory){
                    echo "<option value='" . $secondLevelCategory->__get("catname") . "'>- " . $secondLevelCategory->__get("catname") . "</option>";
                }
            }        

            echo "</select>";
        }
    }
?>
