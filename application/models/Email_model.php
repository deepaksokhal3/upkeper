<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Email_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_email_template';
    }

    /*     * ************************** get alerts ******************************* */

    function get() {
        return $this->db->select('*')->get($this->table)->result();
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

    function get_temp($id){
        return $this->db->select('*')->where('template_id',$id)->get($this->table)->row();
    }
    
    /*     * ************************** get alert (specific) ******************************* */

    function email_template($data){
        return $this->db->select('*')->where($data)->get($this->table)->row();
    }

    /*     * ************************** get alert (specific) ******************************* */
    function delete($id) {
        return $this->db->where('template_id', $id)->delete($this->table);
    }
    
    
     /*     * ************************** get alert (specific) ******************************* */

    function get_email_content($type){
        return $this->db->select('*')->where('temp_type',$type)->get($this->table)->row();
    }

}
