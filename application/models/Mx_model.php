<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Mx_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_mx_records';
    }

    function save($data) {
        return $this->db->insert_batch($this->table, $data);
    }

    function get() {
        return $this->db->select('*')->get($this->table)->result();
    }

    function single($param) {
        $result = '';
        $where = $this->db->select_min('priority')->where($param)->where('company_name !=', '')->get($this->table)->row();
        if ($where) {
            return $this->db->select('*')->where($param)->where('priority', $where->priority)->where('company_name !=', '')->get($this->table)->row();
        } else {
            return $this->db->select('*')->where($param)->get($this->table)->row();
        }
    }

    function update($id, $data) {
        return $this->db->where('h_manager_id', $id)->update($this->table, $data);
    }

    function delete($id) {
        return $this->db->where('h_manager_id', $id)->delete($this->table);
    }

}
