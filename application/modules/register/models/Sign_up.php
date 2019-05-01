<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sign_up extends CI_Model {
    
    /*********************** Constructor ***************************** */

    public function Sign_up() {
        
        parent::__construct();
        $this->table = 'upkepr_users';
    }
    
    /*****************************************************************************
     * Save user credentials 
     * 
     *****************************************************************************/
    public function save($data){
        
        $this->db->insert($this->table, $data);
       return $this->db->insert_id();
    }
    
    /*****************************************************************************
     * Save user profile date 
     * 
     *****************************************************************************/
    public function save_profile($data){ 
        $this->db->insert('upkepr_user_profile', $data);
       return $this->db->insert_id(); 
    }
    
     public function check_existing_users($email) {
        $result = $this->db->select('user_id, user_email')->where('user_email', $email)->get($this->table)->row();
        return ($result) ? true : false;
    }
    
  
}