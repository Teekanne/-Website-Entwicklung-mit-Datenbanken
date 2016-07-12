<?php

class Quizunavailable extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->render('quizunavailable/index');
    }
}

?>
