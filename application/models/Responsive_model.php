<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Responsive_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_responsive';
    }

    
    
    function get($id) {
        return $this->db->select('*')->where('project_id',$id)->get($this->table)->row();
    }



}
