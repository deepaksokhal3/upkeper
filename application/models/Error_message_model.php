<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Error_message_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_error_message';
    }

    function save($data) {
        return $this->db->insert($this->table, $data);
    }

    function update($id, $data) {
        return $this->db->where('error_id', $id)->update($this->table, $data);
    }

    function get() {
        return $this->db->select("*")->get($this->table)->result();
    }
    
      function delete($id) {
        return $this->db->where('error_id',$id)->delete($this->table);
    }
    
    function get_message($id) {
        return $this->db->select("*")->where('error_id',$id)->get($this->table)->row();
    }
    
    function plugin_success_msg() {
        return $this->db->select("msg")->where('msg_type',1)->get($this->table)->row();
    }
    
    function plugin_error_msg() {
        return $this->db->select("msg")->where('msg_type',2)->get($this->table)->row();
    }
    
    function check_super_key($key) {
        return $this->db->select("*")->where('msg_key',$key)->get($this->table)->row();
    }

}
