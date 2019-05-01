<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Hostmanager_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_host_manager';
    }

    function save($data){
    	return $this->db->insert($this->table,$data);

    }
    
    function get(){
    	return $this->db->select('*')->get($this->table)->result();

    }
    
    function get_host_details($id){
    	return $this->db->select('*')->where('h_manager_id',$id)->get($this->table)->row();

    }
    
    function update($id,$data){
        return $this->db->where('h_manager_id',$id)->update($this->table,$data);

    }
    
    function delete($id){
        return $this->db->where('h_manager_id',$id)->delete($this->table);

    }
}