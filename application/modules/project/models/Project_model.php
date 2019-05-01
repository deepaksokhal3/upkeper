<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Project_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_projects';
    }

    /*     * **************************** save nbasic info of aproject*********************** */

    public function save_basic_info($data) {
        $this->db->insert($this->table, $data);
        $project_id = $this->db->insert_id();
        return ($project_id) ? $project_id : false;
    }

    public function get($param) {
        return $this->db->select('*')->where($param)->get($this->table)->row();
    }

    /*     * *************************** get spacific project details ********************* */

    public function get_project_detail($project_id) {

        return $this->db->select('p.*,s.project_url as ssl_url, wp.created_at as wp_check_date, gt.account_id, u.user_email as u_email, gt.access_token, wp.wp_all_status, cp.c_id, cp.c_username, cp.c_password, cp.c_auth_url, cp.status as c_status, s.ssl_id, r.created_at as add_response, mr.check_status as malware_status, r.updated_at as update_response,r.screenshot, r.status as mobile_friendly, rs.report_id, rs.email as r_email,rs.report_time,rs.custom_temp, s.project_url as ssl_url,c.status as credentials_status, c.user_name,c.admin_url,c.credential_id, d.domain_id, d.domain_name,d.updated_at as domain_updated, d.domain_info, h.host_id,h.host_ip, h.host_name, h.dns')
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
                        ->join('upkepr_malware as mr', 'mr.project_id = p.project_id', 'left')
                        ->where('p.project_id', $project_id)->group_by('p.project_id')->get($this->table . ' as p')->row_array();
    }

    /*     * ******************************** search  project by keywords url and description  ********************** */

    public function search_project($keywords, $user_id) {
        $results = $this->db->select('p.*,q.speed_status, q.responsive_status, gt.access_token, r.status as responsive_status,r.updated_at as responsive_date,wp.wp_all_status, s.project_url as ssl_url, mr.check_status as malware_status, ps.mobile_speed,ps.desktop_speed,ps.created_at as checked_speed, s.ssl_id, s.project_url as ssl_url,c.user_name,c.password,c.admin_url,c.credential_id, d.domain_id, d.domain_name, d.domain_info, h.host_id, h.host_name,h.host_ip, h.dns')
                        ->join('upkepr_ssl as s', 's.project_id = p.project_id', 'left')
                        ->join('upkepr_credentials as c', 'c.project_id = p.project_id', 'left')
                        ->join('upkepr_domains as d', 'd.project_id = p.project_id', 'left')
                        ->join('upkepr_hosting as h', 'h.project_id = h.project_id', 'left')
                        ->join('upkepr_project_speed as ps', 'ps.project_id = p.project_id', 'left')
                        ->join('upkepr_responsive as r', 'r.project_id = p.project_id', 'left')
                        ->join('upkepr_queue_status as q', 'q.project_id = p.project_id', 'left')
                        ->join('upkepr_wp_info as wp', 'wp.project_id = p.project_id', 'left')
                        ->join('upkepr_google_analytics as gt', 'gt.project_id = p.project_id', 'left')
                        ->join('upkepr_malware as mr', 'mr.project_id = p.project_id', 'left')
                        ->where('p.user_id', $user_id)
                        ->group_start()->like('p.project_url', $keywords)->or_like('p.description', $keywords)->group_end()->group_by('p.project_id')->get('upkepr_projects as p')->result();

        if (!empty($results)):
            foreach ($results as $key => $result):
                $res = $this->db->select('*')->where("yearweek(DATE(`updated_at`), 1) = yearweek(curdate(), 1)")->where('project_id', $result->project_id)->get('upkepr_down_time')->result_array();
                $queueStatus = $this->db->select('*')->where('project_id', $result->project_id)
                                ->where('ssl_status', 1)
                                ->where('domain_status', 1)
                                ->where('speed_status', 1)
                                ->where('responsive_status', 1)
                                ->where('blacklist_status', 1)
                                ->get('upkepr_queue_status')->row();
                $results[$key]->queue_status = (!empty($queueStatus)) ? 1 : 0;
                if (!empty($res)) {
                    $upcounter = array_count_values(array_column($res, 'status_code'));
                    $results[$key]->uptime = round($upcounter[200] / count($res) * 100);
                } else {
                    $results[$key]->uptime = '';
                }
            endforeach;
        endif;
        return $results;
    }

    /*     * ******************************** search  project by keywords url and description  ********************** */

    public function autocoplete_search($user_id, $keywords) {
        return $this->db->select('p.*')->where('user_id', $user_id)->like('p.project_url', $keywords)->group_by('p.project_id')->get('upkepr_projects as p')->result();
    }

    /*     * ******************************** Total result found  ********************** */

    public function get_total_result($keywords, $user_id) {
        return $this->db->select('*')->where('user_id', $user_id)->group_start()->like('project_url', $keywords)->or_like('description', $keywords)->group_end()->group_by('project_id')->get('upkepr_projects')->num_rows();
    }

    /*     * ************************** get all project that in queue ********************* */

    public function get_queue_projects() {
        return $this->db->select('p.user_id,u.user_email as email,up.company_name, p.project_url, p.status, p.installed, p.queue_status, q.*, ns.renewal_alert, ns.happen_alert')->join('upkepr_users as u', 'u.user_id = p.user_id', 'inner')->join('upkepr_user_profile as up', 'up.user_id= p.user_id', 'inner')->join('upkepr_queue_status as q', 'q.project_id = p.project_id', 'INNER')->join('upkepr_notification_setting as ns', 'ns.project_id = p.project_id', 'left')->get($this->table . ' as  p')->result();
    }

    /*     * ************************** UPDATE SSL info of a project ************************* */

    public function queue($id) {
        return $this->db->select('queue_id')->where('project_id', $id)->get('upkepr_queue_status')->row();
    }

    /*     * ************************** update all project queue status ********************* */

    public function update_queue_status($id, $data) {
        return $this->db->where('queue_id', $id)->update('upkepr_queue_status', $data);
    }

    /*     * ************************** SAVE SSL info of a project ************************* */

    public function save_ssl_info($data) {
        $this->db->insert('upkepr_ssl', $data);
        $ssl_id = $this->db->insert_id();
        return ($ssl_id) ? $ssl_id : false;
    }

    /*     * ************************** UPDATE SSL info of a project ************************* */

    function get_down_time($id, $limit = 1) {
        $date = date('Y-m-d h:i:s');
        $result = $this->db->select('*,(SELECT COUNT(down_id) FROM upkepr_down_time WHERE status_code != 200 AND MONTH(`updated_at`) = MONTH(NOW()) AND project_id = ' . $id . ') as MONTHLY_DOWN , COUNT(MONTH(updated_at)) as MONTHLY_UP, (SELECT COUNT(down_id) FROM upkepr_down_time WHERE status_code != 200 AND WEEK(`updated_at`) = WEEK(NOW()) AND project_id = ' . $id . ') as WEEKLY_DOWN, COUNT(WEEK(updated_at)) as WEEKLY_UP,  (SELECT COUNT(down_id) FROM upkepr_down_time WHERE status_code != 200 AND DAY(`updated_at`) = DAY(NOW()) AND project_id = ' . $id . ') as DAILY_DOWN, COUNT(DAY(updated_at)) as DAILY_UP')->where('project_id', $id)->get('upkepr_down_time')->result_array();

        $result1 = $this->db->select('updated_at')->where('project_id', $id)->order_by('down_id', 'DESC')->get('upkepr_down_time')->row();
        if ($result)
            $result[0]['updated_at'] = isset($result1->updated_at) ? $result1->updated_at : '';
        return ($result) ? $result : false;
    }

    /*     * ************************** UPDATE SSL info of a project ************************* */

    public function update_ssl_info($id, $data) {
        $res = $this->db->where('ssl_id', $id)->update('upkepr_ssl', $data);
        return ($res) ? $res : false;
    }

    /*     * ************************** GET SSL info of a project ************************* */

    public function get_ssl_info($project_id) {
        $res = $this->db->select('*')->where('project_id', $project_id)->get('upkepr_ssl')->row_array();
        return ($res) ? $res : false;
    }

    /*     * ***************** save Credentials (Admin/ftp) of a project ******************** */

    public function save_credentials($data) {
        $this->db->insert('upkepr_credentials', $data);
        $cred_id = $this->db->insert_id();
        return ($cred_id) ? $cred_id : false;
    }

    /*     * ***************** update Credentials (Admin/ftp) of a project ******************** */

    public function update_credentials($id, $data) {
        $res = $this->db->where('project_id', $id)->update('upkepr_credentials', $data);
        return ($res) ? $res : false;
    }

    /*     * *********************** update project basic info ***************************** */

    public function update_basic_info($id, $data) {
        $this->db->where('project_id', $id);
        $result = $this->db->update($this->table, $data);
        return ($result) ? $result : false;
    }

    /*     * ************************ save project domain info ****************************** */

    public function save_domain_info($data) {
        $this->db->insert('upkepr_domains', $data);
        $domain_id = $this->db->insert_id();
        return ($domain_id) ? $domain_id : false;
    }

    /*     * ************************ update project domain info ****************************** */

    public function update_domain_info($id, $data) {
        $res = $this->db->where('project_id', $id)->update('upkepr_domains', $data);
        return ($res) ? $res : false;
    }

    /*     * *********************** save hosting info a project **************************** */

    public function save_host_info($data) {
        $host_id = $this->db->insert_batch('upkepr_hosting', $data);
        return ($host_id) ? $host_id : false;
    }

    public function get_host($id) {
        $res = $this->db->select('*')->where('project_id', $id)->get('upkepr_hosting')->row();
        return ($res) ? $res : false;
    }

    /*     * *********************** update hosting info a project **************************** */

    public function update_host_info($id, $data) {
        $res = $this->db->where('host_id', $id)->update('upkepr_hosting', $data);
        return ($res) ? $res : false;
    }

    /*     * *********************** update hosting info a project **************************** */

    public function get_host_manager_info($id) {
        $res = $this->db->select('hm.*')->join('upkepr_hosting as h', 'h.host_name = hm.ref_weburl', 'left')->get('upkepr_host_manager as hm')->row_array();
        return ($res) ? $res : false;
    }

    /*     * *********************************** Get project of a user*********************** */

    public function get_projects($limit = '', $start = 0, $user_id) {

        $results = $this->db->select('p.*,q.speed_status, q.responsive_status, r.status as responsive_status,r.updated_at as responsive_date, s.project_url as ssl_url,ps.mobile_speed,ps.desktop_speed,ps.created_at as checked_speed, wp.wp_all_status, s.ssl_id, s.project_url as ssl_url,c.user_name,c.admin_url,c.credential_id, d.domain_id, d.domain_name, d.domain_info, h.host_id, h.host_name,h.host_ip, h.dns')
                        ->join('upkepr_ssl as s', 's.project_id = p.project_id', 'left')
                        ->join('upkepr_credentials as c', 'c.project_id = p.project_id', 'left')
                        ->join('upkepr_domains as d', 'd.project_id = p.project_id', 'left')
                        ->join('upkepr_hosting as h', 'h.project_id = h.project_id', 'left')
                        ->join('upkepr_wp_info as wp', 'wp.project_id = p.project_id', 'left')
                        ->join('upkepr_project_speed as ps', 'ps.project_id = p.project_id', 'left')
                        ->join('upkepr_responsive as r', 'r.project_id = p.project_id', 'left')
                        ->join('upkepr_queue_status as q', 'q.project_id = p.project_id', 'left')
                        ->where('p.user_id', $user_id)->group_by('p.project_id')->limit($limit, $start)->get($this->table . ' as p')->result();
        if (!empty($results)):
            foreach ($results as $key => $result):
                $res = $this->db->select('*')->where("yearweek(DATE(`updated_at`), 1) = yearweek(curdate(), 1)")->where('project_id', $result->project_id)->get('upkepr_down_time')->result_array();
                $queueStatus = $this->db->select('*')->where('project_id', $result->project_id)
                                ->where('ssl_status', 1)
                                ->where('domain_status', 1)
                                ->where('speed_status', 1)
                                ->where('responsive_status', 1)
                                ->where('blacklist_status', 1)
                                ->get('upkepr_queue_status')->row();
                $results[$key]->queue_status = (!empty($queueStatus)) ? 1 : 0;
                if (!empty($res)) {
                    $upcounter = array_count_values(array_column($res, 'status_code'));
                    $up = isset($upcounter[200]) ? round($upcounter[200] / count($res) * 100) : 100;
                    $results[$key]->uptime = $up;
                } else {
                    $results[$key]->uptime = '';
                }
            endforeach;
        endif;
        return $results;
    }

    function project_counter($id) {
        return $this->db->select('*')->where('user_id', $id)->get($this->table)->num_rows();
    }

    /*     * *********************************** Get project of a user*********************** */

    function refresh_queue($id) {

        $results = $this->db->select('p.*,q.speed_status, q.responsive_status, r.status as responsive_status,r.updated_at as responsive_date, s.project_url as ssl_url,ps.mobile_speed,ps.desktop_speed,ps.created_at as checked_speed, wp.wp_all_status, s.ssl_id, s.project_url as ssl_url,c.user_name,c.password,c.admin_url,c.credential_id, d.domain_id, d.domain_name, d.domain_info, h.host_id, h.host_name,h.host_ip, h.dns')
                        ->join('upkepr_ssl as s', 's.project_id = p.project_id', 'left')
                        ->join('upkepr_credentials as c', 'c.project_id = p.project_id', 'left')
                        ->join('upkepr_domains as d', 'd.project_id = p.project_id', 'left')
                        ->join('upkepr_hosting as h', 'h.project_id = h.project_id', 'left')
                        ->join('upkepr_wp_info as wp', 'wp.project_id = p.project_id', 'left')
                        ->join('upkepr_project_speed as ps', 'ps.project_id = p.project_id', 'left')
                        ->join('upkepr_responsive as r', 'r.project_id = p.project_id', 'left')
                        ->join('upkepr_queue_status as q', 'q.project_id = p.project_id', 'left')
                        ->where('p.project_id', $id)->group_by('p.project_id')->get($this->table . ' as p')->result();
        if (!empty($results)):
            foreach ($results as $key => $result):
                $res = $this->db->select('*')->where("yearweek(DATE(`updated_at`), 1) = yearweek(curdate(), 1)")->where('project_id', $result->project_id)->get('upkepr_down_time')->result_array();
                $queueStatus = $this->db->select('*')->where('project_id', $result->project_id)
                                ->where('ssl_status', 1)
                                ->where('domain_status', 1)
                                ->where('speed_status', 1)
                                ->where('responsive_status', 1)
                                ->where('blacklist_status', 1)
                                ->get('upkepr_queue_status')->row();
                $results[$key]->queue_status = (!empty($queueStatus)) ? 1 : 0;
                if (!empty($res)) {
                    $up = isset($upcounter[200]) ? round($upcounter[200] / count($res) * 100) : 100;
                    $results[$key]->uptime = $up;
                } else {
                    $results[$key]->uptime = '';
                }
            endforeach;
        endif;
        return $results;
    }

    // Save down time information of the projects 
//    public function get_alert($alert_type) {
//        return $this->db->select('email_template_text')->where('alert_name', $alert_type)->where('status', 1)->get('upkepr_alerts')->row();
//    }

    /*     * *********************************** Get project of a user*********************** */

    public function get_active_alerts($id) {
        $res = '';

        $result = $this->db->select('alert_type')->where('project_id', $id)->get('upkepr_projects')->row();

        if (isset($result) && !empty($result->alert_type)) {
            $res = $this->db->select('*')->from('alerts')->where("alert_id IN (" . $result->alert_type . ")")->get()->result();
        }
        return ($res) ? $res : false;
    }

    /*     * *********************************** Delete project *********************** */

    function delete_project($project_id) {
        $result = $this->db->delete($this->table, array('project_id' => $project_id));
        return ($result) ? $result : false;
    }

    /*     * *********************************** Delete project *********************** */

    function get_wp_credentials($id) {
        $result = $this->db->select('*')->where('project_id', $id)->get('upkepr_credentials')->row();
        return ($result) ? $result : false;
    }

    /*     * *********************************** save screenshot project *********************** */

    function save_responsibilty($data) {
        $result = $this->db->insert('upkepr_responsive', $data);
        return ($result) ? $result : false;
    }

    /*     * *********************************** upadete screenshot project *********************** */

    function update_responsibilty($projectId, $data) {
        $this->db->where('project_id', $projectId);
        $result = $this->db->update('upkepr_responsive', $data);
        return ($result) ? $result : false;
    }

    /*     * ************************* Get malware and blacklist of project************************** */

    function get_malware_blacklist($id) {
        $result = $this->db->select('*')->where('project_id', $id)->order_by('malware_id', 'DESC')->limit('1')->get('upkepr_malware')->row();
        return ($result) ? $result : false;
    }

    /*     * ************************* Get malware and blacklist of project************************** */

    function save_malware_blacklist($data) {
        $result = $this->db->insert('upkepr_malware', $data);
        return ($result) ? $result : false;
    }

    /*     * ************************** save speed info of a project ************************* */

    public function save_project_speed_info($data) {
        $result = $this->db->insert('upkepr_project_speed', $data);
        return ($result) ? $result : false;
    }

    /*     * ************************** update speed info of a project ************************* */

    public function update_project_speed_info($id, $data) {
        $this->db->where('project_id', $id);
        $result = $this->db->update('upkepr_project_speed', $data);
        return ($result) ? $result : false;
    }

    /*     * ************************** Get speed info of a project ************************* */

    public function get_project_speed_info($id) {
        return $this->db->select('*')->where('project_id', $id)->get('upkepr_project_speed')->row();
    }

    /*     * ************************** Get speed info of a project ************************* */

    public function get_project_speed_current_info($id) {
        return $this->db->select('*')->where('project_id', $id)->order_by('speed_id', 'DESC')->limit(1)->get('upkepr_project_speed')->result();
    }

    /*     * ************************** Get speed info of a project ************************* */

    public function get_project_speed_historical_info($id) {
        return $this->db->select('*')->where('project_id', $id)->order_by('speed_id', 'DESC')->limit(100, 1)->get('upkepr_project_speed')->result();
    }

    /**     * ********************************** *********************** */
    function check_screenshot($projectId) {
        $result = $this->db->select('*')->where('project_id', $projectId)->get('upkepr_responsive')->row_array();
        return ($result) ? $result : false;
    }

    /**     * ********************************** *********************** */
    function check_page_screenshot($projectId) {
        $result = $this->db->select('image')->where('image_id', $projectId)->get('upkepr_responsive_page_images')->row_array();
        return ($result) ? $result : false;
    }

    // Save images of a pages of the projects 
    public function upadte_responsive_page_images($id, $data) {
        return $this->db->where('image_id', $id)->update('upkepr_responsive_page_images', $data);
    }

    // Save images of all pages of the projects 
    public function save_responsive_page_images($data) {
        return $this->db->insert('upkepr_responsive_page_images', $data);
    }

    /*     * ********************** get down time monthly************************************ */

    function get_sent_alert($id) {
        $result = $this->db->select('*')->where('project_id', $id)->get('upkepr_sent_alert')->result();
        return ($result) ? $result : false;
    }

    /*     * ************************* Save crawl data ********************************* */

    function save_crawl_data($data) {
        $result = $this->db->insert('upkepr_crawl_data', $data);
        return ($result) ? $result : false;
    }

    /*     * ************************* Update crawl data ********************************* */

    function update_crawl_data($id, $data) {
        $this->db->where('project_id', $id);
        $result = $this->db->update('upkepr_crawl_data', $data);
        return ($result) ? $result : false;
    }

    /*     * ************************* Save crawl data ********************************* */

    function get_crawl_data($id) {
        $result = $this->db->select('*')->where('project_id', $id)->get('upkepr_crawl_data')->row();
        return ($result) ? $result : false;
    }

    /*     * ************************* Save crawl data ********************************* */

    public function save_blacklist($data) {
        return $this->db->insert('upkepr_blacklist_project', $data);
    }

    /*     * ************************* Save cpenal credentials ********************************* */

    public function save_cpanel_credentials($data) {
        return $this->db->insert('upkepr_cpanel_credentials', $data);
    }

    /*     * ************************* update cpenal credentials ********************************* */

    public function update_cpanel_credentials($id, $data) {
        return $this->db->where('project_id', $id)->update('upkepr_cpanel_credentials', $data);
    }

    /*     * ************************* get cpenal credentials ********************************* */

    public function get_cpanel_credentials($id) {
        return $this->db->select('*')->where('project_id', $id)->get('upkepr_cpanel_credentials')->row();
    }

    /*     * ************************* Save crawl data ********************************* */

    public function save_queue_status($data) {
        return $this->db->insert('upkepr_queue_status', $data);
    }

    // Save down time information of the projects 
    public function save_down_time($data) {
        return $this->db->insert('upkepr_down_time', $data);
    }

    /**     * ********************************** Get Mobile friendly data *********************** */
    function get_domain_info($projectId) {
        $result = $this->db->select('*')->where('project_id', $projectId)->get('upkepr_domains')->row();
        return ($result) ? $result : false;
    }

    /*     * *********************************** Get Mobile friendly data *********************** */

    function get_mobile_firendly_pages($projectId) {
        $result = $this->db->select('*')->where('project_id', $projectId)->get('upkepr_responsive_page_images')->result_array();
        return ($result) ? $result : false;
    }

    /*     * *********************************** Get Mobile friendly history *********************** */

    function get_mobile_firendly_current_info($projectId) {
        $result = $this->db->select('wb.web_id,wb.created_at')->where('wb.project_id', $projectId)->order_by('web_id', 'DESC')->limit(1)->get('upkepr_web_pages as wb')->result_array();
        if (!empty($result)) {
            foreach ($result as $key => $res) {
                $result[$key]['images'] = $this->db->select('*')->where('page_ref_id', $res['web_id'])->get('upkepr_responsive_page_images')->result_array();
            }
        }

        return ($result) ? $result : false;
    }

    /*     * *********************************** Get Mobile friendly history *********************** */

    function get_mobile_firendly_historical_info($projectId) {
        $result = $this->db->select('wb.web_id,wb.created_at')->where('wb.project_id', $projectId)->order_by('web_id', 'DESC')->limit(100, 1)->get('upkepr_web_pages as wb')->result_array();
        if (!empty($result)) {
            foreach ($result as $key => $res) {
                $result[$key]['images'] = $this->db->select('*')->where('page_ref_id', $res['web_id'])->get('upkepr_responsive_page_images')->result_array();
            }
        }

        return ($result) ? $result : false;
    }

    /*     * *********************************** Get Mobile friendly data *********************** */

    function get_mobile_firendly_page($image_id) {
        $result = $this->db->select('*')->where('image_id', $image_id)->get('upkepr_responsive_page_images')->row_array();
        return ($result) ? $result : false;
    }

    /*     * *********************************** Get blacklisted data *********************** */

    public function get_blacklist_data($id) {
        return $this->db->select('*')->where('project_id', $id)->get('upkepr_blacklist_project')->row();
    }

    /*     * ******************************************** project list ****************************************** */

    function get_project_list($user_id) {
        return $this->db->select('project_id, project_url, user_id')->where('user_id', $user_id)->where('status', 1)->get($this->table)->result();
    }

    /*     * *********************** save hosting info a project **************************** */

    public function delete_host_info($id) {
        return $this->db->where('project_id', $id)->delete('upkepr_hosting');
    }

    /*     * ******************************************** set email for notification  ****************************************** */

//    function save_naitification_emails($data) {
//        return $this->db->insert('upkepr_notification_setting', $data);
//    }

    /*     * ******************************************** set email for notification  ****************************************** */

//    function update_naitification_emails($id, $data) {
//        return $this->db->where('email_id', $id)->update('upkepr_notification_setting', $data);
//    }

    /*     * ******************************************** get notification receiver email ****************************************** */
//
//    function notification_setting($project_id) {
//        return $this->db->select('*')->where('project_id', $project_id)->get('upkepr_notification_setting')->row();
//    }

    /*     * ******************************************** get notification receiver email ****************************************** */

    function check_valid_project($url, $user_id) {
        $url = rtrim($url, "/");
        return $this->db->select('*')->where('project_url', $url)->group_start()->where("check_avaiablility_to_add =1 OR user_id = $user_id")->group_end()->get($this->table)->row();
    }

    function get_health_time($id) {

        return $this->db->select('d.updated_at as LAST_DOWN, s.updated_at as LAST_SPEED, r.updated_at as LAST_RESPONSIVE, b.updated_at as LAST_BLACKLIST')->join("down_time as d", "d.project_id = p.project_id", 'LEFT')
                        ->join("responsive as r", "r.project_id = p.project_id", 'LEFT')
                        ->join("project_speed as s", "s.project_id = p.project_id", 'LEFT')
                        ->join("blacklist_project as b", "b.project_id = p.project_id", 'LEFT')
                        ->where('p.project_id', $id)->order_by('p.project_id,d.down_id', 'DESC')->get('upkepr_projects as p')->row();
    }

    /*     * ************************************ GET MX RECORDS **************************************** */
//
//    function get_mx_records($id) {
//
//        return $this->db->select('*')->where('project_id', $id)->get('upkepr_mx_records')->result();
//    }
}
