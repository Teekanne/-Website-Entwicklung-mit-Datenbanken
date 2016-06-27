<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of userediter_model
 *
 * @author Ben
 */
class UserEditer_model extends Model {
   public function __construct() {
        parent::__construct();
    }
    function editUser($id){
        echo $id;
    }
}
