<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Common_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_users';
    }

    public function get_project_detail($project_id) {

        return $this->db->select('p.*,s.project_url as ssl_url, wp.created_at as wp_check_date, gt.account_id, u.user_email as email, up.company_name, gt.access_token, wp.wp_all_status, cp.c_id, cp.c_username, cp.c_password, cp.c_auth_url, cp.status as c_status, s.ssl_id, r.created_at as add_response, r.updated_at as update_response,r.screenshot, r.status as mobile_friendly, s.project_url as ssl_url,c.status as credentials_status, c.user_name,c.password,c.admin_url,c.credential_id, d.domain_id, d.domain_name,d.updated_at as domain_updated, d.domain_info, h.host_id,h.host_id, h.host_name, h.dns')
                        ->join('upkepr_ssl as s', 's.project_id = p.project_id', 'left')
                        ->join('upkepr_credentials as c', 'c.project_id = p.project_id', 'left')
                        ->join('upkepr_domains as d', 'd.project_id = p.project_id', 'left')
                        ->join('upkepr_hosting as h', 'h.project_id = h.project_id', 'left')
                        ->join('upkepr_responsive as r', 'r.project_id = p.project_id', 'left')
                        ->join('upkepr_cpanel_credentials as cp', 'cp.project_id = p.project_id', 'left')
                        ->join('upkepr_wp_info as wp', 'wp.project_id = p.project_id', 'left')
                        ->join('upkepr_google_analytics as gt', 'gt.project_id = p.project_id', 'left')
                        ->join('upkepr_user_profile as up', 'up.user_id = p.user_id', 'INNER')
                        ->join('upkepr_users as u', 'u.user_id = p.user_id', 'INNER')
                        ->where('p.project_id', $project_id)->group_by('p.project_id')->get('upkepr_projects as p')->row();
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

    public function get_user_detail($param) {
        $result = $this->db->select('u.user_id, u.user_email, u.user_type, u.status,u.c_acc_status , up.company_name,up.status as p_status,up.prof_image')->join('upkepr_user_profile as up', 'up.user_id = u.user_id ', 'left')->where('u.user_email', $param['email'])->where('u.user_password', md5($param['password']))->get($this->table . ' as u')->row_array();
        return ($result) ? $result : false;
    }

    /*     * ************************** check existing user ******************************** */

    public function check_existing_users($param) {
        $result = $this->db->select('user_id, user_email')->where('user_email', $param['email'])->get($this->table)->row();
        return ($result) ? true : false;
    }

    /*     * ************************** check existing user ******************************** */

    public function company($email) {
        $result = $this->db->select('up.company_name')->join('upkepr_user_profile as up', 'up.user_id = u.user_id')->where('u.user_email', $email)->get($this->table . ' as u')->row();
        return ($result) ? $result : false;
    }

    /*     * ******************** update user status (active/deactive) *********************** */

    public function update_user_status($user_id) {
        $param['status'] = 1;
        $this->db->where('user_id', $user_id)->update($this->table, $param);
    }

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

    public function get_uesr($user_id) {
        return $this->db->select('u.user_email,u.user_id,up.f_name as company_name')->join('upkepr_user_profile as up', 'up.user_id = u.user_id', 'inner')->where('u.user_id', $user_id)->where('u.status', 1)->get($this->table . ' as u')->row_array();
    }

    /*     * ******************** Get project *********************** */

    public function get_projects($user_id) {
        return $this->db->select('p.*,s.project_url as ssl_url, s.ssl_id, s.project_url as ssl_url,c.user_name,c.password,c.admin_url,c.credential_id, d.domain_id, d.domain_name, d.domain_info, h.host_id, h.host_name,h.host_id, h.dns')
                        ->join('upkepr_ssl as s', 's.project_id = p.project_id', 'left')
                        ->join('upkepr_credentials as c', 'c.project_id = p.project_id', 'left')
                        ->join('upkepr_domains as d', 'd.project_id = p.project_id', 'left')
                        ->join('upkepr_hosting as h', 'h.project_id = h.project_id', 'left')
                        ->where('p.user_id', $user_id)->group_by('p.project_id')->get('upkepr_projects as p')->result();
    }

    /*     * ******************** Get Total Projects *********************** */

    public function get_total_projects($user_id) {
        return $this->db->select('*')->where('user_id', $user_id)->get('upkepr_projects')->num_rows();
    }

    /*     * ******************** Get Critical alerts********************** */

    public function get_critical_alerts($user_id) {
        return $this->db->select('sa.*,p.project_url, p.meta_title')->join('upkepr_projects as p', 'p.project_id = sa.project_id', 'INNER')->where('sa.user_id', $user_id)->where('receiver_type', 'critical')->group_by("alert_type, project_id")->order_by('sa.sent_id', 'DESC')->get('upkepr_sent_alert as sa')->result();
    }

    /*     * ******************** Get reguler alerts *********************** */

    public function get_active_critical_alerts($user_id) {
        return $this->db->select('sa.*,p.project_url')->join('upkepr_projects as p', 'p.project_id = sa.project_id', 'INNER')->where('sa.user_id', $user_id)->where('receiver_type', 'critical')->group_by("alert_type, project_id")->order_by('sa.sent_id', 'DESC')->get('upkepr_sent_alert as sa')->result();
    }

    /*     * ******************** Get reguler alerts *********************** */

    public function get_sent_alert($user_id) {
        return $this->db->select('sa.*,p.project_url,p.meta_title')->join('upkepr_projects as p', 'p.project_id = sa.project_id', 'INNER')->where('sa.user_id', $user_id)->group_by("alert_type, project_id")->order_by('sa.sent_id', 'DESC')->get('upkepr_sent_alert as sa')->result();
    }

    /*     * ******************** Get reguler alerts *********************** */

    public function get_active_reguler_alerts($user_id) {
        return $this->db->select('sa.*,p.project_url')->join('upkepr_projects as p', 'p.project_id = sa.project_id', 'INNER')->where('sa.user_id', $user_id)->group_by("alert_type, project_id")->order_by('sa.sent_id', 'DESC')->get('upkepr_sent_alert as sa')->result();
    }

    public function get_total_notificarion($user_id) {
        return $this->db->select('sa.sent_id')->where('sa.user_id', $user_id)->where('status', 0)->group_by("alert_type, project_id")->order_by('sa.sent_id', 'DESC')->get('upkepr_sent_alert as sa')->result_array();
    }

    /*     * ******************** Get Total Projects *********************** */

    public function save_user_log($data) {
        return $this->db->insert('upkepr_logs', $data);
    }

    /**     * ******************* close client account *********************** */
    public function close_account($user_id, $data) {
        return $this->db->where('user_id', $user_id)->update('upkepr_users', $data);
    }

    /*     * ***************************************** Delete user data **************************************** */

    function delete_user_data($user_id) {
        $result = $this->db->delete('upkepr_projects', array('user_id' => $user_id));
//        $query = "DELETE p,c,d,h,wp,s,q,r,ps FROM upkepr_projects as p  LEFT JOIN `upkepr_wp_info` as wp ON wp.project_id = p.project_id  LEFT JOIN `upkepr_queue_status` as q ON q.project_id = p.project_id LEFT JOIN `upkepr_responsive` as r ON r.project_id = p.project_id LEFT JOIN `upkepr_project_speed` as ps ON ps.project_id = p.project_id LEFT JOIN `upkepr_ssl` as `s` ON s.project_id = p.project_id LEFT JOIN upkepr_credentials as c ON c.project_id = p.project_id  LEFT JOIN upkepr_domains as d ON d.project_id = p.project_id LEFT JOIN upkepr_hosting as h ON h.project_id = h.project_id WHERE p.user_id = $user_id";
//        $result = $this->db->query($query);
    }

    /*     * ***************************************** Delete user data **************************************** */

    function save_google_access_token($data) {
        return $this->db->insert('upkepr_google_analytics', $data);
    }

    /*     * ***************************************** Delete user data **************************************** */

    function update_google_access_token($id, $data) {
        return $this->db->where('project_id', $id)->update('upkepr_google_analytics', $data);
    }

    function delete_google_access_token($id) {
        return $this->db->where('project_id', $id)->delete('upkepr_google_analytics');
    }

    function get_google_access_token($id) {
        return $this->db->select('token_id')->where('project_id', $id)->get('upkepr_google_analytics')->row();
    }

    /*     * ***************************************** Delete user data **************************************** */

    function get_category() {
        return $this->db->select('*')->get('upkepr_categories')->result();
    }

    function update_alert_counter($ids) {
        return $this->db->where_in($ids)->update('upkepr_sent_alert', array('status' => 1));
    }

    function log($id) {
        return $this->db->select('*')->where('user_id', $id)->limit(2)->get('upkepr_logs')->result();
    }
    
    function serach_user($keyword){
        return $this->db->select('*')->like("company_name",$keyword)->get('upkepr_user_profile')->result();
    }

}
