<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Project extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('project_model');
        $this->load->model('notification_model');
        $this->load->model('blacklist_model');
        $this->load->model('crawl_model');
        $this->project = $this->session->userdata('project');
        if (!$this->session->userdata('user_data')) {
            redirect('login');
        }
    }

    /* ===================================================================================================
     * STEP:1
     *  Use for simple add project
     * ================================================================================================== */

    function step_first() {
        $post_data = $this->input->post();
        $this->page = 'add_view';
        $this->data['active_nav'] = '2';
        $this->data['title'] = 'Add Project';
        $this->data['metatitle'] = 'UpKepr | Add New Project';
        $this->data['process_session'] = $this->session->userdata('add_project');
        if ($this->input->post()) {
            $this->form_validation->set_rules('project_url', 'website url', 'required');
            if ($this->form_validation->run() == FALSE) {
                return $this->display_Schedule();
            } else {
                if (!valid_url($post_data['project_url'])) {
                    return $this->display_Schedule();
                }
                $meta_data = '';
                try {
                    $meta_data = get_meta_tags($post_data['project_url']);
                } catch (Exception $e) {
                    
                }
                $description = isset($meta_data['description']) ? $meta_data['description'] : '';
                $title = isset($meta_data['title']) ? $meta_data['title'] : '';
                $project_url = rtrim($post_data['project_url'], "/");
                $this->data['basic_info'] = array(
                    'user_id' => $this->session_data['user_id'],
                    'project_url' => strtolower($project_url),
                    'description' => $description,
                    'meta_title' => $this->page_title($project_url),
                    'status' => 0,
                    'created_at' => date('Y-m-d-h:i:s')
                );
                $project_id = $this->project_model->save_basic_info($this->data['basic_info']); // add domain to database

                include(__DIR__ . "/../../../../cms/vendor/autoload.php"); // 
                $cms = new \DetectCMS\DetectCMS($project_url);
                if ($cms->getResult() == 'Wordpress') {
                    $this->step_second($project_id, $project_url, 'WP', 0);
                    $res = $this->response($project_url . '/wp-content/plugins/upkepr-Maintenance/public/template/wp_add_info.php'); // check wp plugin installed or not
                    $result = $this->project_model->check_valid_project($post_data['project_url']);

                    if (isset($result->project_id)) {
                        $project_id = $result->project_id;
                    }
                    $pluging_status = ($res) ? 'yes' : 'no';
                    $sessionArry = array(
                        'project_id' => $project_id,
                        'project_url' => strtolower($project_url),
                        'plugin_status' => $pluging_status,
                        'step' => 1
                    );
                    $this->session->set_userdata('add_project', $sessionArry);
                    $this->data['process_session'] = $this->session->userdata('add_project');
                    $check_plugin_url = isset($this->data['process_session']['project_url']) ? $this->data['process_session']['project_url'] : ($this->input->post('project_url') ? $this->input->post('project_url') : '');

                    if ($check_plugin_url) {
                        $check_plugin = $this->response(rtrim($check_plugin_url, "/") . '/wp-content/plugins/upkepr-Maintenance/public/template/wp_check_plugin.php'); // check plugin Active or not
                        if ($check_plugin) {
                            $check_plugin = json_decode($check_plugin);
                            $this->data['process_session']['plugin'] = $check_plugin[0];
                        }
                    }
                } else {
                    $this->step_second($project_id, $project_url, 'NOT_WP', 1);
                    $this->session->set_flashdata("success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), lang_msg('NOTE_FOR_AFTER_ADD_PROJECT')));
                    redirect();
                }
                return $this->display_Schedule();
            }
        } else {
            $check_plugin_url = isset($this->data['process_session']['project_url']) ? $this->data['process_session']['project_url'] : ($this->input->post('project_url') ? $this->input->post('s') . $this->input->post('project_url') : '');
            if ($check_plugin_url) {
                $check_plugin = $this->response(rtrim($check_plugin_url, "/") . '/wp-content/plugins/upkepr-Maintenance/public/template/wp_check_plugin.php'); // check plugin Active or not
                if ($check_plugin) {
                    $check_plugin = json_decode($check_plugin);
                    $this->data['process_session']['plugin'] = $check_plugin[0];
                }
            }
            $this->display_Schedule();
        }
    }

    /* ===================================================================================================
     * CHECK ABLE TO ADD
     *  Use for availbility to add project
     * ================================================================================================== */

    function verify_plugin() {
        if ($this->input->is_ajax_request()) {
            if ($project_id = $this->input->post('project_id')) {
                $url = rtrim($this->input->post('url'), "/") . '/wp-content/plugins/upkepr-Maintenance/public/template/wp_add_info.php';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_URL, $url);
                $result = curl_exec($ch);
                $res = curl_getinfo($ch);
                $ob = json_decode($result);
                if ($ob === null) {
                    echo 'unverified';
                    exit;
                } else {
                    echo 'verified';
                    $this->project_model->update_basic_info($project_id, array('check_avaiablility_to_add' => 1));
                    $this->step_second($project_id, $this->input->post('url'), $result);
                }
            }
        }
    }

    /* ===================================================================================================
     *  CONFIGURE ADMIN DETAIL
     *  Use for check entired detail right or not
     * ================================================================================================== */

    function verifyWpAdmin() {
        $post['user_login'] = $this->input->post('user_login');
        $post['user_password'] = $this->input->post('user_password');
        $ch = curl_init($this->input->post('url') . '/wp-content/plugins/upkepr-Maintenance/public/template/wp_admin_login.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);
        curl_close($ch);
        print_r($response);
        exit;
    }

    /* ===================================================================================================
     *  STEP 2
     *  
     * ================================================================================================== */

    function step_second($project_id, $URL, $verifiy_data, $status = 1) {

        //   save project url
        $this->data['basic_info'] = array(
            'installed' => $verifiy_data,
            'status' => $status,
            'updated_at' => date('Y-m-d-h:i:s')
        );
        $update_status = $this->project_model->update_basic_info($project_id, $this->data['basic_info']);
        if ($update_status) {
            try {
                $this->data['process_session'] = $this->session->userdata('add_project');
                $this->session->unset_userdata('add_project');
                $this->data['process_session']['step'] = 2;
                $this->session->set_userdata('add_project', $this->data['process_session']);
                $this->data['queue'] = array(
                    'project_id' => $project_id,
                    'created_at' => date('Y-m-d-h:i:s')
                );
                $this->data['process_session'] = $this->session->userdata('add_project');
                $queue = $this->project_model->queue($project_id);
                if ($queue):
                    $this->project_model->update_queue_status($queue->queue_id, $this->data['queue']);
                else:
                    $this->project_model->save_queue_status($this->data['queue']);
                endif;
            } catch (Exception $ex) {
                
            }
        }
    }

    /* ===================================================================================================
     *  STEP 3
     *  use for save wp admin detail
     * ================================================================================================== */

    function step_three() {
        $project_id = $this->input->post('project_id');
        if (empty($this->input->post('credential_id'))) {
            $this->data['credentials'] = array(
                'user_name ' => $this->input->post('username'),
                'password' => base64_encode($this->input->post('password')),
                'project_id' => $project_id,
                'status' => 1,
                'admin_url' => $this->input->post('login_url'),
                'created_at' => date('Y-m-d-h:i:s'),
                'updated_at' => date('Y-m-d-h:i:s')
            );
            $result = $this->project_model->save_credentials($this->data['credentials']);
            echo json_encode($result);
            exit;
        } else {
            $this->data['credentials'] = array(
                'user_name ' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'project_id' => $project_id,
                'status' => 1,
                'admin_url' => $this->input->post('login_url'),
                'updated_at' => date('Y-m-d-h:i:s')
            );
            $result = $this->project_model->update_credentials($project_id, $this->data['credentials']);
            echo json_encode($result);
            exit;
        }
    }

    /* ===================================================================================================
     *  DELETE COFIRORMATION MAIL SEND
     *  Use for send confirmation mail to the company 
     * ================================================================================================== */

    function confirm_delete_project() {
        $this->load->model('email_model');
        $templates = $this->email_model->get_email_content(4);
        if ($this->input->post('project_id')) {
            $param['company_name'] = $companyname = $this->session_data['company_name'];
            $link = site_url('project/delete/' . $this->input->post('project_id'));
            $param['link'] = '<a href="' . $link . '"/>Delete Project</a>';
            $param['site_url'] = $this->input->post('web_url');
            $param['website_name'] = domain_name($this->input->post('web_url'));
            $from = 'upkepr.com (' . $companyname . ')';
            $templateContent['emailText'] = email_template($templates->template_text, $param);
            $templateContent['title'] = domain_name($this->input->post('web_url'));
            mailgun($this->session_data['user_email'], $from, email_template($templates->subject, $param), $this->load->view('email-templates/confirm-delete-project', $templateContent, TRUE));
            echo json_encode(array('true'));
            exit;
        }
    }

    /* ===================================================================================================
     *  EDIT PROJECT PAGE
     *  Use for link to edit project page get all detail that we need to update
     * ================================================================================================== */

    function update_project($project_id) {
        $this->load->model('alerts/alerts_model');
        $this->load->model('email_model');
        $this->load->model('cron_model');
        $this->data['projects'] = $this->project_model->get_project_detail($project_id);
        $this->data['metatitle'] = 'UpKepr | Edit Project ' . ucfirst(domain_name($this->data['projects']['project_url']));
        $this->data['title'] = 'Edit project';
        $this->data['default_temp'] = $this->email_model->email_template(array('temp_type' => 8));
        $this->data['alerts'] = $this->alerts_model->get_alerts();
        $this->data['alert_setting'] = $this->notification_model->get($project_id);
        $this->data['project_list'] = $this->project_model->get_project_list($this->session_data['user_id']);
        $check_plugin_url = isset($this->data['projects']['project_url']) ? $this->data['projects']['project_url'] : '';
        if ($check_plugin_url) {
            $check_plugin = $this->response(rtrim($check_plugin_url, "/") . '/wp-content/plugins/upkepr-Maintenance/public/template/wp_check_plugin.php');
            $this->data['plugin_status'] = ($check_plugin) ? 'yes' : 'no';
            if ($check_plugin) {
                $check_plugin = json_decode($check_plugin);
                $this->data['plugin'] = $check_plugin[0];
            }
        }
        $this->page = 'edit_view';
        $this->data['admindetail'] = 'adminupdate';
        $this->data['sample_report'] = $this->cron_model->get_alert('Wordpress Plugin Upgrade');
        $sessionArry = array(
            'project_id' => $project_id,
            'domain' => domain_name($this->data['projects']['project_url'])
        );
        $this->session->set_userdata('google_analytic', $sessionArry);
        $this->display_Schedule();
    }

    /* ===================================================================================================
     *  DETAIL PAGE
     *  Use for get project detail related to project
     * ================================================================================================== */

    function project_detail($project_id) {
         $this->load->model('mx_model');
        $this->page = 'project_view';
        $this->data['tab'] = 2;
        $this->data['projects'] = $this->project_model->get_project_detail($project_id);
        $this->data['metatitle'] = 'UpKepr | ' . domain_name($this->data['projects']['project_url']);
        $this->data['title'] = domain_name($this->data['projects']['project_url']);
        $this->session->unset_userdata('google_access');
        if ($this->data['projects']['access_token']) {
            $this->auth2(json_decode($this->data['projects']['access_token']), $this->data['projects']['project_id'], $this->data['projects']['project_url']);
            $this->data['projects'] = $this->project_model->get_project_detail($project_id);
            $this->session->set_userdata('google_access', array(
                'access_token' => json_decode($this->data['projects']['access_token'])->access_token,
                'VIEWID' => $this->data['projects']['account_id']));
        }
        $sessionArry = array(
            'project_id' => $project_id,
            'domain' => domain_name($this->data['projects']['project_url'])
        );
        $this->session->set_userdata('google_analytic', $sessionArry);
        if (!empty($this->data['projects']['wp_all_status'])) {
            $this->data['wordpress_update_status'] = json_decode($this->data['projects']['wp_all_status']);
        }
        $sessionArry = array(
            'project_id' => $project_id,
            'domain' => domain_name($this->data['projects']['project_url'])
        );
        $this->session->set_userdata('google_analytic', $sessionArry);

        $this->data['alerts'] = $this->common_model->get_alerts(); // Golbal alert set as supper admin 
        $this->data['alert_setting'] = $this->notification_model->get($project_id); // Get alert that have set user 

        $this->data['down_times'] = $this->project_model->get_down_time($project_id, 1);

        $this->data['project_speed'] = $this->project_model->get_project_speed_info($project_id);
        $this->data['host_info'] = $this->project_model->get_host($project_id);

        $this->data['ssl'] = $this->project_model->get_ssl_info($project_id);
        $this->data['blacklist'] = $this->blacklist_model->single($project_id);
        $this->data['avg_status'] = $this->crawl_model->get_avg($project_id);

        $check_plugin = $this->response(rtrim($this->data['projects']['project_url'], "/") . '/wp-content/plugins/upkepr-Maintenance/public/template/wp_check_plugin.php');

        $this->data['plugin_status'] = ($check_plugin) ? 'yes' : 'no';
        $this->data['mx_records'] = $this->mx_model->single(array('project_id' => $project_id));

        $this->display_Schedule();
    }

    /* ===================================================================================================
     *  REPORT SAMPLE 
     *  Company can check report sample how its will receive
     * ================================================================================================== */

    function display_sample_report() {
        if ($this->input->post()) {
            $param['company_name'] = 'upkepr';
            $param['site_url'] = 'http://Upkepr.com';
            $param['download_report'] = '<a href="">Download</a>';
            $param['link'] = '<a href="">Click here</a>';
            $data['reportText'] = email_template($this->input->post('template'), $param);
            echo json_encode(array('template' => $this->load->view('email-templates/report-sample', $data, TRUE)));
        }
    }

    /* ===================================================================================================
     *  RESTORE REPORT SETTING TEMPLATE
     *  Use for comapny can restore set report tamplete
     * ================================================================================================== */

    function restore_report() {
        $this->load->model('email_model');
        $temp = $this->email_model->email_template(array('temp_type' => 8));
        echo json_encode(array('template' => $temp->template_text));
    }

    /* ===================================================================================================
     *  WORDPRESS 
     *  Use for wordpress login as admin 
     * ================================================================================================== */

    function admin_login_details() { // get save wp credentials
        if ($project_id = $this->input->post('project_id')) {
            $wp_auth_data = $this->project_model->get_wp_credentials($project_id);
            echo ($wp_auth_data) ? json_encode($wp_auth_data) : false;
        }
    }

    function wp_login($project_id) {
        $wp_auth_data = $this->project_model->get_wp_credentials($project_id);
        if ($wp_auth_data) {
            $post['login'] = $wp_auth_data->user_name;
            $post['pwd'] = base64_decode($wp_auth_data->password);
            $ch = curl_init($wp_auth_data->admin_url . '/wp-content/plugins/upkepr-Maintenance/public/template/wp_custom_login.php');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $response = curl_exec($ch);
            curl_close($ch);
            print_r($response);
            exit;
        } else {
            $this->data['tab'] = "admin";
            $this->session->set_flashdata("error", sprintf($this->lang->line('INFO_NOTICE_ALERT'), 'Sorry', 'Please verify wordpress admin login detail.'));
            redirect(site_url('project/edit/' . $project_id));
        }
    }

    /* ===================================================================================================
     *  CPANEL 
     *  Use for cpanel login  
     * ================================================================================================== */

    function auto_login_cpanel($project_id) {

        $auth_details = $this->project_model->get_cpanel_credentials($project_id);
        $hostname = str_replace("www.", "", preg_replace("/\b\//", "", preg_replace('#^https?://#', '', $auth_details->c_auth_url)));
        $goto = '/';
        $ch = curl_init();
        $fields = array('user' => trim($auth_details->c_username), 'pass' => trim($auth_details->c_password), 'goto_uri' => $goto);
        curl_setopt($ch, CURLOPT_URL, 'https://' . $hostname . '/login/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        // RFC 2616 14.10 compliance
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection' => 'close'));
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $page = curl_exec($ch);
        curl_close($ch);
        $session = $token = array();
        if (!preg_match('/session=([^\;]+)/', $page, $session)) {
            return false;
        }
        // Find the cPanel session token in the page content
        if (!preg_match('|<META HTTP-EQUIV="refresh"[^>]+URL=/(cpsess\d+)/|i', $page, $token)) {
            return false;
        }
        $extra = $goto == '/' ? '' : '&goto_uri=' . urlencode($goto);
        $url = 'https://' . $hostname . '/' . $token[1] . '/login/?session=' . $session[1] . $extra;
        redirect($url);
    }

    /* ===================================================================================================
     *  DELETE (HARD DELETE)
     *  Use for delete a single project  
     * ================================================================================================== */

    function delete_project($project_id) {
        if ($project_id) {
            $result = $this->project_model->delete_project($project_id);
            $this->session->set_flashdata("success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), 'Project has been deleted successfully..!'));
        } else {
            $this->session->set_flashdata("info", sprintf($this->lang->line('INFO_NOTICE_ALERT'), 'Sorry !', 'Some technical issue is occurred please try again.'));
        }
        redirect();
    }

    /* ===================================================================================================
     *  DELETE (HARD DELETE)
     *  Use for delete a single project  
     * ================================================================================================== */

    function update_alerts() {
        if ($this->input->post()) {
            $exist_alert_status = $this->input->post('exist_alert_status');
            $alert_status = explode(",", $this->input->post('alert_id'));
            if (isset($exist_alert_status[0]) && !empty($exist_alert_status[0])) {
                $rm_id = explode(",", $this->input->post('rm_id'));
                if (!empty($rm_id)) {
                    $st = array_diff(array_unique(array_merge($exist_alert_status, $alert_status)), $rm_id);
                    $res = implode(",", $st);
                } else {
                    $res = implode(",", array_unique(array_merge($exist_alert_status, $alert_status)));
                }
            } else {
                $res = implode(",", $alert_status);
            }
            $this->data['data'] = array('alert_status' => $res);
            $result = $this->project_model->update_basic_info($this->input->post('project_id'), $this->data['data']); // Enable/Disable
            if ($result) {
                echo json_encode(array('status' => true, 'exsit_status' => $res));
            } else {
                echo json_encode(array('status' => false));
            }
        }
    }

    /* ===================================================================================================
     *  META TITLE
     *  Use for get meta title from url 
     * ================================================================================================== */

    function page_title($url) {
        $title = '';
        try {
            $fp = file_get_contents($url);
            if (!$fp)
                return null;
            $res = preg_match("/<title>(.*)<\/title>/siU", $fp, $title_matches);
            if (!$res)
                return null;
            $title = preg_replace('/\s+/', ' ', $title_matches[1]);
            $title = trim($title);
        } catch (Exception $e) {
            
        }
        return $title;
    }

    /* ===================================================================================================
     *  CONFIGURE ALERT LINK
     *  Use for link to configure report to edit page
     * ================================================================================================== */

    function configure_alert($id) {
        $this->session->unset_userdata('add_project');
        $this->data['tab'] = 3;
        $this->update_project($id);
    }

    /* ===================================================================================================
     *  CURL GET METHOD
     *  Use for check url working or not
     * ================================================================================================== */

    function response($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        return is_string($result) && is_array(json_decode($result, true)) && (json_last_error() == JSON_ERROR_NONE) ? $result : false;
    }

    /* ===================================================================================================
     *  SKIP
     *  Use for Skip some step at add project process
     * ================================================================================================== */

    function skip() {
        $this->session->set_flashdata("success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), lang_msg('NOTE_FOR_AFTER_ADD_PROJECT')));
        redirect();
    }

    /* ===================================================================================================
     *  THANKU
     *  Use for After add project Success message
     * ================================================================================================== */

    function thanku() {
        $this->data['title'] = 'Thank you';
        $this->page = 'thanku';
        $this->data['process_session'] = (object) $this->session->userdata('add_project');
        $this->display_login();
    }

    /* ===================================================================================================
     *  AUTH 2 
     *  Use for google analytic token refresh to connect again and get some webmaster details
     * ================================================================================================== */

    function auth2($token, $project_id, $project_url) {
        require_once __DIR__ . '/../../../../anaylitics/vendor/autoload.php';

        $client_id = '64708822544-ummrcg5t37eu868pr74evvd6vq87c068.apps.googleusercontent.com';
        $client_secret = 'qZbBOwvBviDpa6WqwjZYbq2_';
        $redirect_uri = site_url('oauth');
        $simple_api_key = 'AIzaSyD7TpnAJIGszf2LR7kx6f0QFUAYju47T5k';
        $client = new Google_Client();
        $client->setApplicationName("auth");
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->setDeveloperKey($simple_api_key);
        $client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
        $client->addScope(Google_Service_Webmasters::WEBMASTERS_READONLY);
        $client->setAccessType('offline');
        //$client->setApprovalPrompt('force');
        try {
            $client->setAccessToken((array) $token);
            if ($client->isAccessTokenExpired()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                $this->data['access_token']['access_token'] = json_encode($client->getAccessToken());
                $this->common_model->update_google_access_token($project_id, $this->data['access_token']);
            }
        } catch (Exception $e) {
            
        }
        try {
            $service = new Google_Service_Webmasters($client);
            $siteMap = $service->sitemaps->listSitemaps($project_url, $option = array('sitemap')); // sitemap
            $type = array();
            $submitted = array('name' => 'Submitted', 'data' => array());
            $indexed = array('name' => 'Indexed', 'data' => array());
            foreach ($siteMap->sitemap[0]->contents as $val) {
                $submitted['data'][] = (int) $val->submitted;
                $indexed['data'][] = (int) $val->indexed;
                $type[] = $val->type;
            }
            $type[] = '';
            $submitted['data'][] = array(0);
            $indexed['data'][] = array(0);
            $this->data['submitted'] = json_encode(array('submitted' => $submitted, 'type' => $type, 'Indexed' => $indexed));
        } catch (Exception $e) {
            
        }
        try {
            $search = new Google_Service_Webmasters_SearchAnalyticsQueryRequest;
            $search->setStartDate(date('Y-m-d', strtotime('29daysAgo')));
            $search->setEndDate(date('Y-m-d', strtotime('now')));
            $search->setDimensions(array('query'));
            $search->setStartRow(0);
            $search->setRowLimit(50);
            $this->data['search_query'] = $service->searchanalytics->query($project_url, $search, $fields = array('responseAggregationType, rows'));
        } catch (Exception $e) {
            
        }
        try {
            $ctr = new Google_Service_Webmasters_SearchAnalyticsQueryRequest;
            $ctr->setStartDate(date('Y-m-d', strtotime('29daysAgo')));
            $ctr->setEndDate(date('Y-m-d', strtotime(date('Y-m-d'))));
            $ctr->setDimensions(array('date'));
            $ctr->setRowLimit(50);

            $crt_data = $service->searchanalytics->query($project_url, $ctr, $fields = array('rows'));

            $date = array();
            $CTR = array('name' => 'CTR', 'data' => array());
            foreach ($crt_data->rows as $crt_val) {
                $ctr_position = round_figure($crt_val->ctr * 100);
                $date[] = date('d/m/y', strtotime($crt_val->keys[0]));
                $CTR['data'][] = floatval($ctr_position);
            }
            $this->data['CTR'] = json_encode(array('date' => $date, 'CLICK' => $CTR));
        } catch (Exception $e) {
            
        }
    }

}
