<?php

class Overview extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->render('overview/index');
    }
}

?>