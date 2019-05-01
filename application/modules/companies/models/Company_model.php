<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Company_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_user_profile';
    }

    /* ===========================================================================
     * Get company details from table user and user profile
      ============================================================================ */

    public function get_companies() {
        $this->db->select('u.user_id, u.user_email, u.user_type, u.created_at, u.status, up.prof_id,u.c_acc_status, up.company_name,up.thumb_nail, up.prof_image, up.status as prof_status, up.ip_address, up.updated_at as prof_updated');
        $this->db->join('upkepr_users as u', 'up.user_id = u.user_id', 'INNER')->where('u.user_type',2);
        return $this->db->get($this->table . ' as up')->result();
    }

    public function update_user_status($data) {
        $res = $this->db->where('user_id', $data['user_id'])->update($this->table, $data);
        return($res) ? true : false;
    }

    /*     * ***************************************************************************
     * get user profile data 
     * 
     * *************************************************************************** */

    public function get_uesr($user_id) {
        return $this->db->select('u.user_email,u.user_id, up.company_name, up.f_name, up.l_name, up.mobile_number, up.address1, up.address2, up.city, up.state, up.country, up.category')->join('upkepr_user_profile as up', 'up.user_id = u.user_id', 'inner')->where('u.status', 1)->where('u.user_id',$user_id)->get('upkepr_users as u')->row();
    }

    /*     * ***************************************************************************
     * update user profile data 
     * 
     * *************************************************************************** */

    public function update_user_profile($user_id, $data) {
        return $this->db->where('user_id', $user_id)->update($this->table, $data);
    }

}
