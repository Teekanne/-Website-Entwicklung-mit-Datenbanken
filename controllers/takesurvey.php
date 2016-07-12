<?php

class Takesurvey extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->render('takesurvey/index');
    }
}

?>

