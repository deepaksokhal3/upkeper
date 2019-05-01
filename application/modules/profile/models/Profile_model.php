

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Profile_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_user_profile';
    }

    /*     * ****************************** Get profile data************************** */

    public function get_profile($user_id) {
        $result = $this->db->select('u.*, uf.*,b.firm_name, b.support_email, b.phone, b.office_address, b.thumb_logo as b_thumb_logo, b.brand_id')->join('upkepr_branding as b','b.user_id = uf.user_id','left')->join('upkepr_users as u', 'u.user_id = uf.user_id', 'INNER')->where('uf.user_id', $user_id)->get($this->table . ' as uf')->row_array();

        return ($result) ? $result : false;
    }

    /*     * ****************************** check token validation************************** */

    public function update($param) {
        $this->db->where('user_id', $param['user_id']);
        $rs = $this->db->update($this->table, $param);
        return ($rs) ? true : false;
    }

    /*     * ****************************** check token validation************************** */

    public function save_brand($param) {
        return $this->db->insert('upkepr_branding', $param);
    }

    /*     * ****************************** check token validation************************** */

    public function update_brand($param) {
        $this->db->where('brand_id', $param['brand_id']);
        $rs = $this->db->update('upkepr_branding', $param);
        return ($rs) ? true : false;
    }

     /*     * ****************************** check token validation************************** */

    public function delete_brand($user_id) {
       return $this->db->delete('upkepr_branding', array('user_id' => $user_id));
       
    }
    /*     * ****************************** Get profile data************************** */

    public function brand($user_id) {
        $result = $this->db->select('uf.*,b.firm_name, b.support_email, b.phone, b.office_address, b.thumb_logo as b_thumb_logo, b.brand_id')->join('upkepr_branding as b','b.user_id = uf.user_id','left')->join('upkepr_users as u', 'u.user_id = uf.user_id', 'INNER')->where('uf.user_id', $user_id)->get($this->table . ' as uf')->row();

        return ($result) ? $result : false;
    }
}
