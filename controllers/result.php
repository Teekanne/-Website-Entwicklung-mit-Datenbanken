<?php

class Result extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->render('result/index');
    }
}