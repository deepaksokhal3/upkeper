<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Alerts_model extends CI_Model{
    
    
    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_alerts';
    }
    
    /**************************** get alerts ********************************/
    function get_alerts(){
      return $this->db->select('*')->get($this->table)->result_array();
        
    }
    
    /**************************** Add alerts ***********************************/
    function add($data){
        return $this->db->insert($this->table,$data);
        
    }
    
    /**************************** Update alerts ********************************/
    function update($id,$data){
        return $this->db->where('alert_id',$id)->update($this->table,$data);
        
    }
    
     /**************************** get alert (specific) ********************************/
    function get($id){
        return $this->db->select('*')->where('alert_id',$id)->get($this->table)->row_array();
        
    }
    
    /**************************** get alert (specific) ********************************/
    function delete($id){
        return $this->db->where('alert_id',$id)->delete($this->table);
        
    }
    
    
      /**************************** get alert (specific) ********************************/
    function alert($data){
        return $this->db->select('*')->where($data)->row();
        
    }
    
}