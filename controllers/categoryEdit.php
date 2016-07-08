<?php

class categoryEdit extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->render('category/index');
    }
}