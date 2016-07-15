<?php
/**
 * Data.php
 * 
 * Holds the database-connection.
 * 
 * @author Christoph Pohl <christoph.pohl@stud.fh-flensburg.de>
 * @version 1.0
 */
    class DataBench extends PDO {
        public function __construct(){
            parent::__construct('mysql:host=projekt.wi.fh-flensburg.de;dbname=projekt2015a', 'projekt2015a', 'P2016s7');            
        }
    }
?>