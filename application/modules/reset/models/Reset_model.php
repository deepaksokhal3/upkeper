<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Reset_model extends CI_Model
{
    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_users';
    }

 	function valid_email($email){
 		$result = $this->db->select('*')->where('user_email',$email)->where('status',1)->get($this->table)->row_array();
 		return ($result)? $result: false;
 	}
    
}