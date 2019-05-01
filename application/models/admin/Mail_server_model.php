<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Mail_server_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_mail_servers';
    }

    function save($data){
    	return $this->db->insert($this->table,$data);

    }
    
    function get(){
    	return $this->db->select('*')->get($this->table)->result();

    }
    
    function single($param){
    	return $this->db->select('*')->where($param)->get($this->table)->row();

    }
    
    function update($id,$data){
        return $this->db->where('m_server_id',$id)->update($this->table,$data);

    }
    
    function delete($id){
        return $this->db->where('m_server_id',$id)->delete($this->table);

    }
}