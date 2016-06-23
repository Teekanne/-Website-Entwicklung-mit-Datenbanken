<?php

class NewQuestion extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->render('newquestion/index');
    }
}