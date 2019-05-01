<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Report_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_report_setting';
    }

    function save($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function update($id, $data) {
        return $this->db->where('report_id', $id)->update($this->table, $data);
    }
    
    function get($id) {
        return $this->db->select('*')->where('project_id',$id)->get($this->table)->row();
    }

    /*     * *************************** get spacific project details ********************* */

    public function project_detail($ref_code) {
        return $this->db->select('p.*,s.project_url as ssl_url, wp.created_at as wp_check_date, gt.account_id, u.user_email as u_email, gt.access_token, wp.wp_all_status, cp.c_id, cp.c_username, cp.c_password, cp.c_auth_url, cp.status as c_status, s.ssl_id, r.created_at as add_response, r.updated_at as update_response,r.screenshot, r.status as mobile_friendly, rs.report_id, rs.email as r_email,rs.report_time, s.project_url as ssl_url,c.status as credentials_status, c.user_name,c.password,c.admin_url,c.credential_id, d.domain_id, d.domain_name,d.updated_at as domain_updated, d.domain_info, h.host_id,h.host_ip, h.host_name, h.dns')
                        ->join('upkepr_ssl as s', 's.project_id = p.project_id', 'left')
                        ->join('upkepr_credentials as c', 'c.project_id = p.project_id', 'left')
                        ->join('upkepr_domains as d', 'd.project_id = p.project_id', 'left')
                        ->join('upkepr_hosting as h', 'h.project_id = h.project_id', 'left')
                        ->join('upkepr_responsive as r', 'r.project_id = p.project_id', 'left')
                        ->join('upkepr_users as u', 'u.user_id = p.user_id', 'left')
                        ->join('upkepr_cpanel_credentials as cp', 'cp.project_id = p.project_id', 'left')
                        ->join('upkepr_wp_info as wp', 'wp.project_id = p.project_id', 'left')
                        ->join('upkepr_report_setting as rs', 'rs.project_id = p.project_id', 'left')
                        ->join('upkepr_google_analytics as gt', 'gt.project_id = p.project_id', 'left')
                        ->where('p.rep_code', $ref_code)->group_by('p.project_id')->get('upkepr_projects as p')->row_array();
    }

}
