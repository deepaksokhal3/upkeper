<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Alert_setting_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_alerts';
    }

    function update($data) {
        return $this->db->where('alert_id', $data['alert_id'])->update($this->table, $data);
    }
    /******************************** GET ALL ALERTS **************************************/
    public function get() {
        return $this->db->select('*')->get('upkepr_alerts')->result_array();
    }

}
