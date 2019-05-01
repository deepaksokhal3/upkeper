<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Cron_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_projects() {

        return $this->db->select('p.project_id, p.status, p.user_id, p.project_url, p.expire_hosting, u.user_email as email, up.company_name')->join('upkepr_user_profile as up', 'up.user_id = p.user_id')->join('upkepr_users as u', 'u.user_id = p.user_id', 'INNER')->where('p.status', 1)->get('upkepr_projects as p')->result();
    }

    public function get_project($id) {

        return $this->db->select('p.project_id, p.status, p.user_id, p.project_url, p.expire_hosting, u.user_email as email, up.company_name')->join('upkepr_user_profile as up', 'up.user_id = p.user_id')->join('upkepr_users as u', 'u.user_id = p.user_id', 'INNER')->where('p.status', 1)->where('p.project_id', $id)->get('upkepr_projects as p')->result();
    }

    // Save down time information of the projects 
    public function save_down_time($data) {
        return $this->db->insert_batch('upkepr_down_time', $data);
    }

    // Save down time information of the projects 
    public function get_alert($alert_type) {
        return $this->db->select('*')->where('alert_name', $alert_type)->where('status', 1)->get('upkepr_alerts')->result();
    }

    // Save down time information of the projects 
    public function save_malware($data) {
        return $this->db->insert_batch('upkepr_down_time', $data);
    }

    // get domain info information of the projects 
    public function get_domain_info($project_id) {
        return $this->db->select('d.*,p.user_id, p.project_url, u.user_email as email, up.company_name')->join('upkepr_projects as p', 'p.project_id = d.project_id', 'INNER')->join('upkepr_users as u', 'u.user_id = p.user_id', 'INNER')->join('upkepr_user_profile as up', 'up.user_id = p.user_id')->where('d.project_id', $project_id)->order_by('d.domain_id', 'DESC')->limit(1)->get('upkepr_domains as d')->result();
    }

    // Save down time information of the projects 
    public function save_sent_alerts($data) {
        return $this->db->insert_batch('upkepr_sent_alert', $data);
    }

    // Save down time information of the projects 
    public function update_sent_alerts($data) {
        $this->db->insert_batch('upkepr_sent_alert', $data, 'sent_id');
    }

    // Save down time information of the projects 
    public function check_sent_alerts($id, $alert_type) {
        return $this->db->select('*')->where('sa.project_id', $id)->where('alert_type', $alert_type)->get('upkepr_sent_alert as sa')->row();
    }

    // Save images of all pages of the projects 
    public function save_responsive_page_images($data) {
        return $this->db->insert('upkepr_responsive_page_images', $data);
    }

    // Save images of all pages of the projects 
    public function save_blacklist_checked($data) {
        return $this->db->insert('upkepr_blacklist_project', $data);
    }

    // Update blacklist projects
    public function update_blacklist_checked($id, $data) {
        return $this->db->where('black_id', $id)->update('upkepr_blacklist_project', $data);
    }

    // Save images of all pages of the projects 
    public function save_wp_info($data) {
        return $this->db->insert('upkepr_wp_info', $data);
    }

    // Save images of all pages of the projects 
    public function update_wp_info($id, $data) {
        return $this->db->where('project_id', $id)->update('upkepr_wp_info', $data);
    }

    public function update_speed_info($id, $data) {
        return $this->db->where('speed_id', $id)->update('upkepr_project_speed', $data);
    }

    function get_report_setting() {
        return $this->db->select('rs.*, u.user_email,p.project_url, up.company_name')
                        ->join('upkepr_users as u', 'u.user_id = rs.user_id', 'inner')
                        ->join('upkepr_user_profile as up', 'rs.user_id = up.user_id')
                        ->join('upkepr_projects as p', 'p.project_id = rs.project_id')->get('upkepr_report_setting as rs')->result();
    }

    function update_project($id, $data) {
        return $this->db->where('project_id', $id)->update('upkepr_projects', $data);
    }

    // Save down time information of the projects 
    public function check_expire($id, $alert_type) {
        return $this->db->select("TIMESTAMPDIFF(DAY,NOW(), expire_date) as daydiff")->where('sa.project_id', $id)->where('alert_type', $alert_type)->order_by('sent_id', 'DESC')->get('upkepr_sent_alert as sa')->row();
    }

    // Save down time information of the projects 
    public function get_host() {
        return $this->db->select("*")->where('host_company', '')->get('upkepr_hosting')->result();
    }

    // Save down time information of the projects 
    public function host_company() {
        return $this->db->select("*")->get('upkepr_host_manager')->result();
    }

    function upadte_hosting($data) {
        $this->db->update_batch('upkepr_hosting', $data, 'project_id');
    }

    function save_mx_records($data) {
        return $this->db->insert_batch('upkepr_mx_records', $data);
    }

    function send_project_project_status_mail($id) {
        return $this->db->select('queue_status')->where('project_id', $id)->get('upkepr_projects')->row();
    }

    function email_status($project_id) {
        return $this->db->select('*')->where('project_id', $project_id)
                        ->where('ssl_status', 1)
                        ->where('domain_status', 1)
                        ->where('host_status', 1)
                        ->where('mx_status', 1)
                        ->where('speed_status', 1)
                        ->where('responsive_status', 1)
                        ->where('blacklist_status', 1)
                        ->where('screenshot', 1)
                        ->get('upkepr_queue_status')->row();
    }

    function get_report_data() {
//        return $this->db->select('fted, d.domain_info, h.host_id,h.host_ip, h.host_name, h.dns')
//                        ->join('upkepr_ssl as s', 's.project_id = p.project_id', 'left')
//                        ->join('upkepr_credentials as c', 'c.project_id = p.project_id', 'left')
//                        ->join('upkepr_domains as d', 'd.project_id = p.project_id', 'left')
//                        ->join('upkepr_hosting as h', 'h.project_id = h.project_id', 'left')
//                        ->join('upkepr_responsive as r', 'r.project_id = p.project_id', 'left')
//                        ->join('upkepr_users as u', 'u.user_id = p.user_id', 'left')
//                        ->join('upkepr_cpanel_credentials as cp', 'cp.project_id = p.project_id', 'left')
//                        ->join('upkepr_wp_info as wp', 'wp.project_id = p.project_id', 'left')
//                        ->join('upkepr_report_setting as rs', 'rs.project_id = p.project_id', 'left')
//                        ->join('upkepr_google_analytics as gt', 'gt.project_id = p.project_id', 'left')
//                        ->join('upkepr_malware as mr', 'mr.project_id = p.project_id', 'left')
//                        ->where('p.project_id', $project_id)->group_by('p.project_id')->get($this->table . ' as p')->row_array();
    }

}
