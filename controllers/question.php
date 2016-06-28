<?php

class Question extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->render('question/index');
    }
}

?>

