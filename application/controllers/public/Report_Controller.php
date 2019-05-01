<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report_Controller extends MY_Controller {
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        parent::__construct();
        $this->load->model('project/project_model');
        $this->load->model('profile/profile_model');
        $this->load->model('report_model');
        $this->load->model('notification_model');
        $this->data['token'] = $this->session->userdata('google_access');
    }

    function report($ref_code) {
        $this->data['projects'] = $this->report_model->project_detail($ref_code);
        $project_id = $this->data['projects']['project_id'];
        $this->page = 'reports/report';
        $this->data['brand'] = $this->profile_model->brand($this->data['projects']['user_id']);
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

        $this->data['alerts'] = $this->common_model->get_alerts();
        $this->data['alert_setting'] = $this->notification_model->get($project_id);
        $this->data['down_times'] = $this->project_model->get_down_time($project_id, 1);
        $this->data['project_speed'] = $this->project_model->get_project_speed_info($project_id);
        $this->data['host_info'] = $this->project_model->get_host_info($project_id);
        $this->data['ssl'] = $this->project_model->get_ssl_info($project_id);
        $this->data['blacklist'] = $this->project_model->get_blacklist_data($project_id);
        $this->data['mx_records'] = $this->project_model->get_mx_records($project_id);

        echo $this->load->view('reports/report', $this->data);
    }

    function auth2($token, $project_id, $project_url) {
        require_once __DIR__ . '/../../../anaylitics/vendor/autoload.php';

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

    /*     * ************************* REPORT AND NOTIFICATION SETTING ***************************** */

    function report_setting() {
        if ($this->input->is_ajax_request()) {
            
            /* ------------------------ REPORTS TEMPLATE SETTING------------------------- */
            if (!$this->input->post('report_id')) {
                $this->data['report'] = array(
                    'user_id' => $this->session_data['user_id'],
                    'project_id' => $this->input->post('project_id'),
                    'email' => $this->input->post('email'),
                    'custom_temp' => $this->input->post('custom_temp'),
                    'report_time' => $this->input->post('report_time'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'status' => 1
                );
                $report_id = $this->report_model->save($this->data['report']); // save report template and frequency
            } else {
                $this->data['report'] = array(
                    'email' => $this->input->post('email'),
                    'custom_temp' => $this->input->post('custom_temp'),
                    'report_time' => $this->input->post('report_time'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $report_id = $this->input->post('report_id');
                $this->report_model->update($this->input->post('report_id'), $this->data['report']); // update report template and frequency
            }
            /* --------------------------- NOTIFICATION SETING------------------------- */

            if (empty($this->input->post('notification_id'))) {

                $renewal_alert = ($this->input->post('renewal_alert')) ? implode(",", $this->input->post('renewal_alert')) : '';
                $happen_alert = ($this->input->post('happen_alert')) ? implode(",", $this->input->post('happen_alert')) : '';

                $this->data['notification'] = array(
                    'project_id' => $this->input->post('project_id'),
                    'renewal_alert' => $renewal_alert,
                    'happen_alert' => $happen_alert,
                    'user_id' => $this->session_data['user_id'],
                    'status' => 1
                );
                $notification_id = $this->notification_model->save($this->data['notification']); // save notification setting that is required
            } else {
                 $renewal_alert = ($this->input->post('renewal_alert')) ? implode(",", $this->input->post('renewal_alert')) : '';
                $happen_alert = ($this->input->post('happen_alert')) ? implode(",", $this->input->post('happen_alert')) : '';
                $this->data['notification'] = array(
                    'renewal_alert' => $renewal_alert,
                    'happen_alert' => $happen_alert,
                );
                $notification_id = $this->input->post('notification_id');
                $this->notification_model->update($this->input->post('notification_id'), $this->data['notification']); // update notification setting that is required
            }
            echo (json_encode(array('notificationId' => $notification_id, 'report_id' => $report_id,)));
            exit;
            /* ---------------------------------------------------- */
        }
    }

    /*     * ****************************************** END ******************************************* */

    function top_query_pdf_report() {
        $this->load->library('html2pdf');
        $this->html2pdf->folder('./assets/pdfs/');
        $this->html2pdf->filename('test.pdf');
        $this->html2pdf->paper('a4', 'portrait');
        require_once __DIR__ . '/../../../anaylitics/vendor/autoload.php';

        $client = new Google_Client();
        $service = new Google_Service_Webmasters($client);
        $search = new Google_Service_Webmasters_SearchAnalyticsQueryRequest;
        $search->setStartDate(date('Y-m-d', strtotime('29daysAgo')));
        $search->setEndDate(date('Y-m-d', strtotime('now')));
        $search->setDimensions(array('query'));
        $search->setStartRow(0);
        $search->setRowLimit(50);
        $this->data['search_query'] = $service->searchanalytics->query($this->input->get('url'), $search, $fields = array('responseAggregationType, rows'));
        $this->html2pdf->html($this->load->view('reports/search_query', $this->data, true));

        if ($this->html2pdf->create('download')) {
            //PDF was successfully saved or downloaded
            echo 'PDF saved';
        }
    }

    function sendPostData($url, $post) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", 'Content-Length: ' . strlen($post)));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        return $result;
    }

}
