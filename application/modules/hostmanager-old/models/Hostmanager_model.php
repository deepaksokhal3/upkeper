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
     /**************************** get alerts ********************************/
    function get(){
      return $this->db->select('*')->get($this->table)->result();
        
    }
    
    /**************************** Add alerts ***********************************/
    function add($data){
        return $this->db->insert($this->table,$data);
        
    }
    
    /**************************** Update alerts ********************************/
    function update($id,$data){
        return $this->db->where('h_manager_id',$id)->update($this->table,$data);
        
    }
    
    /**************************** get alert (specific) ********************************/
    function get_host_company($id){
        return $this->db->select('*')->where('h_manager_id',$id)->get($this->table)->row_array();
        
    }
    
    /**************************** get alert (specific) ********************************/
    function delete($id){
        return $this->db->where('h_manager_id',$id)->delete($this->table);
        
    }

}