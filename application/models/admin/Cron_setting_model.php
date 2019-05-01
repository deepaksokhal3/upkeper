<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Cron_setting_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_cron_setting';
    }

    /*     * ******************************  ************************************* */

    public function get() {
        return $this->db->select('*')->get($this->table)->result();
    }

    /*     * ****************************** Upadet ************************************* */

    public function update($id, $data) {
        return $this->db->where('cron_st_id', $id)->update($this->table, $data);
    }

    /*     * ****************************** Upadet ************************************* */

    public function save($data) {
        return $this->db->insert($this->table, $data);
    }

    /*     * ****************************** Upadet ************************************* */

    public function find($find) {
        return $this->db->select('*')->where($find)->get($this->table)->row();
    }

}
