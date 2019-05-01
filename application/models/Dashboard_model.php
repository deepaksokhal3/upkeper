<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Dashboard_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_users';
    }

    /*     * ****************************** check token validation************************** */

    public function valid_token($token) {
        $expire_token = date('Y-m-d h:i:s');
        $result = $this->db->select('user_email')->where('expire_token <=', 'NOW()')->or_where('status', 1)->where('user_token', $token)->get($this->table)->row();
        return ($result) ? true : false;
    }

    /*     * ****************************** check token validation************************** */

    public function valid_reset_token($token) {
        $result = $this->db->select('user_id,user_email')->where('status', 1)->where('reset_token', $token)->get($this->table)->row();
        return ($result) ? $result : false;
    }

    /*     * *************************** get user details********************************** */

    public function get_user_detail($id) {
        $result = $this->db->select('u.user_id, u.user_email, u.user_type, u.status, up.company_name,up.status as p_status,up.prof_image')->join('upkepr_user_profile as up', 'up.user_id = u.user_id ')->where('u.user_id', $id)->get($this->table . ' as u')->row_array();
        return ($result) ? $result : false;
    }

    /*     * ************************** login admin as a user ******************************** */

    public function login_user($user_id) {
        $result = $this->db->select('user_id, user_email')->where('user_email', $param['email'])->get($this->table)->row();
        return ($result) ? true : false;
    }

    public function check_existing_users($id) {
        $result = $this->db->select('user_id')->where('user_id', $id)->get($this->table)->row();
        return ($result) ? true : false;
    }

    /*     * ******************** update user status (active/deactive) *********************** */


    /*     * ******************** update user status (active/deactive) *********************** */

    public function update_user($data) {
        $result = $this->db->where('user_id', $data['user_id'])->update($this->table, $data);
        return ($result) ? true : false;
    }

    /*     * ******************** update user status (active/deactive) *********************** */

    public function get_countries() {
        return $this->db->select('*')->get('upkepr_country')->result_array();
    }

    /*     * ******************** update user status (active/deactive) *********************** */

    public function get_cities() {
        return $this->db->select('*')->get('upkepr_city')->result_array();
    }

    /*     * ******************** update user status (active/deactive) *********************** */

    public function get_state() {
        return $this->db->select('*')->get('upkepr_state')->result_array();
    }

    /*     * ******************** Get alert list *********************** */

    public function get_alerts() {
        return $this->db->select('*')->where('status', 1)->get('upkepr_alerts')->result_array();
    }

    /*     * ******************** Get alert list *********************** */

    public function get_alert_ids() {
        return $this->db->select('alert_id')->where('status', 1)->get('upkepr_alerts')->result_array();
    }

    /*     * ******************** Get alert list *********************** */

    public function get_uesrs() {
        return $this->db->select('u.user_type,u.user_email, u.status, u.user_id,up.company_name,up.thumb_nail, (SELECT COUNT(project_id) FROM upkepr_projects WHERE user_id = u.user_id) as total_projects')->join('upkepr_user_profile as up', 'up.user_id = u.user_id', 'inner')->where('u.user_type', 2)->get($this->table . ' as u')->result();
    }

    /*     * ******************** Get project *********************** */

    public function get_projects() {
        return $this->db->select('p.*,s.project_url as ssl_url, s.ssl_id, s.project_url as ssl_url,c.user_name,c.password,c.admin_url,c.credential_id, d.domain_id, d.domain_name, d.domain_info, h.host_id,h.host_ip, h.host_name, h.dns')
                        ->join('upkepr_ssl as s', 's.project_id = p.project_id', 'left')
                        ->join('upkepr_credentials as c', 'c.project_id = p.project_id', 'left')
                        ->join('upkepr_domains as d', 'd.project_id = p.project_id', 'left')
                        ->join('upkepr_hosting as h', 'h.project_id = h.project_id', 'left')
                        ->group_by('p.project_id')->get('upkepr_projects as p')->result();
    }
    
     public function serch_project($keyword) {
        return $this->db->select('*')->like('project_url',$keyword)->get('upkepr_projects')->result();
    }

    /*     * ******************** Get Total Projects *********************** */

    public function get_total_projects($user_id) {
        return $this->db->select('*')->where('user_id', $user_id)->get('upkepr_projects')->num_rows();
    }

    /*     * ******************** Get Total Projects *********************** */

    public function get_sent_alert($user_id) {
        return $this->db->select('sa.*,p.project_url')->join('upkepr_projects as p', 'p.project_id = sa.project_id', 'INNER')->where('sa.user_id', $user_id)->get('upkepr_sent_alert as sa')->result();
    }

    public function get_active_uesrs() {
        return $this->db->select('u.*')->join('upkepr_user_profile as up', 'up.user_id = u.user_id', 'inner')->where('u.user_type', 2)->where('u.status', 1)->get($this->table . ' as u')->num_rows();
    }
    
    function move_project($id,$data){
        return $this->db->where('project_id',$id)->update('upkepr_projects',$data);
        
    }
    

}
