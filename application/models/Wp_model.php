<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Wp_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_wp_info';
    }



    /*     * ************************** Add alerts ********************************** */

    function add($data) {
        return $this->db->insert($this->table, $data);
    }

    /*     * ************************** Update alerts ******************************* */

    function update($id, $data) {
        return $this->db->where('template_id', $id)->update($this->table, $data);
    }

    /*     * ************************** get alert (specific) ******************************* */

     function single($id) {
        return $this->db->select('*')->where('project_id', $id)->get($this->table)->row();

    }
    
    /*     * ************************** get alert (specific) ******************************* */

    function email_template($data){
        return $this->db->select('*')->where($data)->get($this->table)->row();
    }

    /*     * ************************** get alert (specific) ******************************* */
    function delete($id) {
        return $this->db->where('template_id', $id)->delete($this->table);
    }
    
    
  

}
