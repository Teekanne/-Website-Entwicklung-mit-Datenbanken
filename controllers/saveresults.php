<?php

class Saveresults extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->render('saveresults/index');
    }
}

?>