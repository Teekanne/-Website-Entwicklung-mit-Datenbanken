<?php

class Bootstrap {

    function __construct() {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
//trim the url
        $url = rtrim($url, '/');
//explode the url
        $url = explode('/', $url);

        //Hidden, beacue it is just for debugging...
        //  print_r($url);
        //echo $url;


        if (empty($url[0])) {
            require 'controllers/index.php';
            $controller = new Index();
            $controller->index();
            return false;
        }

        $file = 'controllers/' . $url[0] . '.php';
        if (file_exists($file)) {
            require $file;
        } else {
            $this->error();
        }

        $controller = new $url[0];
        $controller->loadModel($url[0]);

        // calling methods
        if (isset($url[2])) {
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}($url[2]);
            } else {
                $this->error();
            }
        } else {
            if (isset($url[1])) {
                if (method_exists($controller, $url[1])) {
                    $controller->{$url[1]}();
                } else {
                    $this->error();
                }
            } else {
                $controller->index();
            }
        }
    }

    function error() {
        require 'controllers/fehler.php';
        $controller = new Fehler();
        $controller->index();
        return false;
    }
/*
    protected function _initMail() {
        try {
            $config = array(
                'auth' => 'login',
                'username' => 'username@gmail.com',
                'password' => 'password',
                'ssl' => 'tls',
                'port' => 587
            );

            $mailTransport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
            Zend_Mail::setDefaultTransport($mailTransport);
        } catch (Zend_Exception $e) {
            //Do something with exception
        }
    }
 */

}
