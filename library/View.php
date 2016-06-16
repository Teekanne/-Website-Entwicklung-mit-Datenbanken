<?php
class View {

    function __construct() {
      //  echo ' This is the View<br />';
    }
    public function render ($name, $noInclude =false)
    {
        if ($noInclude== true){
            require 'views/' . $name . '.php';
        } else {
            require 'views/header.php';
            require 'views/' . $name . '.php';
            require 'views/footer.php';
        }
        
    }
}