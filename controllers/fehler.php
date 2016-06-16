<?php

class Fehler extends Controller {

    function __construct() {
        parent::__construct();  
    }
 function index(){
        $this->view->msg = 'This page does not exists!';
        $this->view->render('error/index');
    }
}
