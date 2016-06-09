<?php
    class DataBase {
      
        public static $dbInstance = null;
        
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

        public function __construct(){
            self::$dbInstance = new mysqli("projekt.wi.fh-flensburg.de:3306", "projekt2015a", "P2016s7", "projekt2015a");
        }
        
        public static function Select($sql){
            return self::$dbInstance->query($sql)->fetch_array(MYSQLI_ASSOC);
        }
        
        public static function GetColumn($sql)
        {
            $resultSet = self::$dbInstance->query($sql);
            
            $values = array();
            
            while ($row = mysqli_fetch_row($resultSet)){
                foreach ($row as $value){
                    array_push($values, $value);
                }
            }
            
            return $values;
        }
        
        public static function Insert($table, $data){
            $keys = ""; $values = "";
            
            foreach($data as $key => $value){
                $key = self::$dbInstance->real_escape_string($key);
                $value = self::$dbInstance->real_escape_string($value);
                $keys .= $key . ", ";
                $values .= "'" . $value . "', ";
            }
            
            $keys = rtrim($keys, ", ");
            $values = rtrim($values, ", ");
            
            $sql = "INSERT INTO $table (" . $keys . ") VALUES (" . $values . ")";
            
            self::$dbInstance->query($sql);
            $lastId = self::$dbInstance->insert_id;
            
            return $lastId;
        }
    }
?>