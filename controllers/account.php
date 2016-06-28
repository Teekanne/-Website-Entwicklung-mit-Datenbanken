<?php

class Account extends Controller {

    public function __construct() {
        parent::__construct();
        Session::init();

        $logged = Session::get('loggedIn');
        $role = Session::get('ROLE');
        if ($logged == false || $role = 'Administrator') {
            Session::destroy();
            header('location: ../login');
            exit;
        }
    }

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function changePW(){
if (isset($_POST['change']))
    {
 
        if (changePassword($_POST['username'], $_POST['oldpassword'], $_POST['password'],
            $_POST['password2']))
        {
            echo "Your password has been changed ! <br /> <a href='./index.php'>Return to homepage</a>";
 
        } else
        {
            echo "Password change failed! Please try again.";
            show_changepassword_form();
        }
 
    } else
    {
        show_changepassword_form();
    }
 
 }
}