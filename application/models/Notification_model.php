<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Notification_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_notification_setting';
    }

     function save($data) {
         $this->db->insert($this->table, $data);
         return $this->db->insert_id();
    }

    /*     * ******************************************** set email for notification  ****************************************** */

    function update($id, $data) {
        return $this->db->where('notification_id', $id)->update($this->table, $data);
    }
    
    /*     * *************************** get spacific project details ********************* */
     public function get($project_id) {
        return $this->db->select('*')->where('project_id', $project_id)->get($this->table)->row();
    }

}
