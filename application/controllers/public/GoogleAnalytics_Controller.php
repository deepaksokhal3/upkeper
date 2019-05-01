<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GoogleAnalytics_Controller extends MY_Controller {

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
        $this->load->model('common_model');
        $this->load->model('project/project_model');
        $this->data['token'] = $this->session->userdata('google_access');
    }

    public function index() {

        require_once __DIR__ . '/../../../anaylitics/vendor/autoload.php';
        $client_id = '64708822544-ummrcg5t37eu868pr74evvd6vq87c068.apps.googleusercontent.com';
        $client_secret = 'qZbBOwvBviDpa6WqwjZYbq2_';
        $redirect_uri = site_url('oauth');
        $simple_api_key = 'AIzaSyD7TpnAJIGszf2LR7kx6f0QFUAYju47T5k';
        $client = new Google_Client();
        $client->setApplicationName("PHP Google OAuth Login Example");
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->setDeveloperKey($simple_api_key);
        $client->addScope(Google_Service_Webmasters::WEBMASTERS_READONLY);
        $client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');

        if (isset($_REQUEST['logout'])) {
            $client->revokeToken();
        }
        if (isset($_GET['code'])) {

            $client->authenticate($_GET['code']);
            $TOKEN = $client->getAccessToken();
            $project = $this->session->userdata('google_analytic');
            $_SESSION['access_token'] = $client->getAccessToken();
            $token  = $this->common_model->get_google_access_token($project['project_id']);
            if (empty($token)) {
                $this->data['access_token']['project_id'] = $project['project_id'];
                $this->data['access_token']['access_token'] = json_encode($TOKEN);
                $this->common_model->save_google_access_token($this->data['access_token']);
                $this->managementAccounts();
            }else{
                $this->data['access_token']['access_token'] = json_encode($TOKEN);
                $this->common_model->update_google_access_token($project['project_id'], $this->data['access_token']);
            }
            $this->session->unset_userdata('google_analytic');
            header('Location:' . site_url('project/detail/' . $project['project_id']));
        }
        if ($client->getAccessToken()) {
            
        } else {

            $authUrl = $client->createAuthUrl();
            return $authUrl;
        }
    }

    function google_aouth() {
        echo json_encode(array('link' => $this->index()));
        exit;
    }

    function sendGetData($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        return $result;
    }

    function device_performance() {
        require_once __DIR__ . '/../../../anaylitics/vendor/autoload.php';

        if (isset($this->data['token']['access_token']) && $this->data['token']['VIEWID']) {
            $startDate = date('Y-m-d', strtotime($this->input->get('start_date')));
            $endDate = date('Y-m-d', strtotime($this->input->get('end_date')));
            $Url = "https://analyticsreporting.googleapis.com/v4/reports:batchGet?access_token=" . $this->data['token']['access_token'];
            $params = '{
            reportRequests:[{
            viewId:"ga:' . $this->data['token']['VIEWID'] . '",
             dateRanges:[{
              startDate:"' . $startDate . '",
             endDate:"' . $endDate . '"
            }],
             metrics:[{expression:"ga:sessions"}],
             dimensions: [{ "name":"ga:deviceCategory"},{ "name":"ga:date"}]
            }]
            }';
            $res = $this->sendPostData($Url, $params);
            $Rresult = json_decode($res);
            if (isset($Rresult->reports[0]->data->rows) && !empty($Rresult->reports[0]->data->rows)) {
                $date = array();
                $dasktop = array('name' => 'Desktop', 'data' => array());
                $mobile = array('name' => 'Mobile', 'data' => array());
                foreach ($Rresult->reports[0]->data->rows as $graph_data) {
                    if ($graph_data->dimensions[0] == "desktop") {
                        $dasktop['data'][] = (int) $graph_data->metrics[0]->values[0];
                        $date[] = date('M d', strtotime($graph_data->dimensions[1]));
                    }
                }
                foreach ($Rresult->reports[0]->data->rows as $graph_data) {
                    if ($graph_data->dimensions[0] == "mobile") {
                        $dateTemp[] = date('M d', strtotime($graph_data->dimensions[1]));
                    }
                }

                $datediff = array_diff($date, $dateTemp);
                foreach ($Rresult->reports[0]->data->rows as $graph_data) {
                    if ($graph_data->dimensions[0] == "mobile" && in_array(date('M d', strtotime($graph_data->dimensions[1])), $date)) {
                        $mobile['data'][] = (int) $graph_data->metrics[0]->values[0];
                    } else {
                        if ($graph_data->dimensions[0] == "desktop" && in_array(date('M d', strtotime($graph_data->dimensions[1])), $datediff)) {
                            $mobile['data'][] = 0;
                        }
                    }
                }
                echo json_encode(array('desktop' => $dasktop, 'date' => $date, 'mobile' => $mobile));
                exit;
            }
        }
    }

    function bounce_vs_exit_rate() {
        require_once __DIR__ . '/../../../anaylitics/vendor/autoload.php';
        if (isset($this->data['token']['access_token']) && $this->data['token']['VIEWID']) {
            $startDate = date('Y-m-d', strtotime($this->input->get('start_date')));
            $endDate = date('Y-m-d', strtotime($this->input->get('end_date')));
            $Url = "https://analyticsreporting.googleapis.com/v4/reports:batchGet?access_token=" . $this->data['token']['access_token'];
            $params = '{
            reportRequests:[{
            viewId:"ga:' . $this->data['token']['VIEWID'] . '",
             dateRanges:[{
             startDate:"' . $startDate . '",
             endDate:"' . $endDate . '"
            }],
             metrics:[{expression:"ga:bounceRate"},{expression:"ga:exitRate"}],
             dimensions: [{ "name":"ga:date"}]
            }]
            }';
            $res = $this->sendPostData($Url, $params);
            $Rresult = json_decode($res);

            if (isset($Rresult->reports[0]->data->rows) && !empty($Rresult->reports[0]->data->rows)) {
                $date = array();
                $bounceRate = array('name' => 'Bounce Rate', 'data' => array());
                $exitRate = array('name' => 'Exit Rate', 'data' => array());
                foreach ($Rresult->reports[0]->data->rows as $graph_data) {
                    $bounceRate['data'][] = (float) round_figure($graph_data->metrics[0]->values[0]);
                    $exitRate['data'][] = (float) round_figure($graph_data->metrics[0]->values[1]);
                    $date[] = date('M d', strtotime($graph_data->dimensions[0]));
                }
                echo json_encode(array('bounceRate' => $bounceRate, 'date' => $date, 'exitRate' => $exitRate));
                exit;
            }
        }
    }

    function get_acquisation() {
        require_once __DIR__ . '/../../../anaylitics/vendor/autoload.php';
        if (isset($this->data['token']['access_token'])) {
            $startDate = date('Y-m-d', strtotime($this->input->get('start_date')));
            $endDate = date('Y-m-d', strtotime($this->input->get('end_date')));
            $url = $this->data['projects']['project_url'];
            $this->session->set_userdata('report_period', array('start' => $startDate, 'end' => $endDate, 'url' => $url));
            $Url = "https://analyticsreporting.googleapis.com/v4/reports:batchGet?access_token=" . $this->data['token']['access_token'];
            $params = '{
            reportRequests:[{
            viewId:"ga:' . $this->data['token']['VIEWID'] . '",
             dateRanges:[{
              startDate:"' . $startDate . '",
             endDate:"' . $endDate . '"
            }],
             metrics:[{expression:"ga:sessions"},
             {expression: "ga:percentNewSessions"},
             {expression: "ga:newUsers"}],
             dimensions: [{ "name":"ga:medium"}]
            }]
            }';
            $res = $this->sendPostData($Url, $params);
            $Rresult = json_decode($res);
            if (isset($Rresult->error)) {
                echo json_encode(array('error' => '400', 'relink' => $this->index()));
                exit;
            }
            $this->data['acquisition'] = $Rresult;
            echo json_encode(array('html' => $this->load->view('public/googleanalytics/acquisition', $this->data, TRUE)));
            exit;
        } else {
            // die('');
            echo json_encode(array('link' => $this->index()));
            exit;
        }
    }

    function get_keywords() {
        require_once __DIR__ . '/../../../anaylitics/vendor/autoload.php';
        if (isset($this->data['token']['access_token'])) {
            $startDate = date('Y-m-d', strtotime($this->input->get('start_date')));
            $endDate = date('Y-m-d', strtotime($this->input->get('end_date')));

            $Url = "https://analyticsreporting.googleapis.com/v4/reports:batchGet?access_token=" . $this->data['token']['access_token'];
            $params = '{
            reportRequests:[{
            viewId:"ga:' . $this->data['token']['VIEWID'] . '",
             dateRanges:[{
              startDate:"' . $startDate . '",
             endDate:"' . $endDate . '"
            }],
             metrics:[{expression:"ga:sessions"},
             {expression:"ga:users"},
             {expression:"ga:goalCompletionsAll"},
             {expression:"ga:goalConversionRateAll"},
             {expression:"ga:avgPageLoadTime"},
             {expression:"ga:percentNewSessions"},
             ],
             dimensions: [{ "name":"ga:pageTitle"},{ "name":"ga:keyword"}]
            }]
            }';
            $res = $this->sendPostData($Url, $params);
            $Rresult = json_decode($res);
            $this->data['keywords'] = $Rresult;
            echo $this->load->view('public/googleanalytics/keywords', $this->data, TRUE);
            exit;
        }
    }

    function managementAccounts() {
        $compaire_data = $this->session->userdata('google_analytic');
        if (isset($_SESSION['access_token']['access_token']) && $compaire_data) {
            $Url = "https://www.googleapis.com/analytics/v3/management/accounts?access_token=" . $_SESSION['access_token']['access_token'];
            $res = $this->sendGetData($Url);
            $Rresults = json_decode($res);
            foreach ($Rresults->items as $Rresult) {
                $webProperty = "https://www.googleapis.com/analytics/v3/management/accounts/" . $Rresult->id . "/webproperties?access_token=" . $_SESSION['access_token']['access_token'];
                $res = $this->sendGetData($webProperty);
                $Rresu = json_decode($res);
                foreach ($Rresu->items as $item) {
                    if (trim(domain_name($item->websiteUrl)) == trim($compaire_data['domain'])) {
                        $this->data['access_token']['account_id'] = $item->defaultProfileId;
                        $this->data['access_token']['last_updated'] = date('Y-m-d', strtotime($item->updated));
                        $this->common_model->update_google_access_token($compaire_data['project_id'], $this->data['access_token']);
                    }
                }
            }
        }
    }

    function return_visitor() {
        require_once __DIR__ . '/../../../anaylitics/vendor/autoload.php';
        if (isset($this->data['token']['access_token'])) {
            $startDate = date('Y-m-d', strtotime($this->input->get('start_date')));
            $endDate = date('Y-m-d', strtotime($this->input->get('end_date')));
            $Url = "https://analyticsreporting.googleapis.com/v4/reports:batchGet?access_token=" . $this->data['token']['access_token'];
            $params = '{
            reportRequests:[{
            viewId:"ga:' . $this->data['token']['VIEWID'] . '",
             dateRanges:[{
              startDate:"' . $startDate . '",
             endDate:"' . $endDate . '"
            }],
             metrics:[{expression:"ga:sessions"},
             {expression:"ga:percentNewSessions"},
             {expression:"ga:newUsers"},
             {expression:"ga:bounceRate"},
             {expression:"ga:pageviewsPerSession"},
             {expression:"ga:avgSessionDuration"},
             {expression:"ga:goal1ConversionRate"},
             {expression:"ga:goal1Completions"},
             {expression:"ga:goal1Value"}
             ],
             dimensions: [{ "name":"ga:userType"}]
            }]
            }';
            $res = $this->sendPostData($Url, $params);
            $Rresult = json_decode($res);
            $this->data['visitors'] = $Rresult;
            echo $this->load->view('public/googleanalytics/visitor', $this->data, true);
            exit;
        }
    }

    function return_visitor_graph() {
        require_once __DIR__ . '/../../../anaylitics/vendor/autoload.php';
        if (isset($this->data['token']['access_token'])) {
            $startDate = date('Y-m-d', strtotime($this->input->get('start_date')));
            $endDate = date('Y-m-d', strtotime($this->input->get('end_date')));
            $Url = "https://analyticsreporting.googleapis.com/v4/reports:batchGet?access_token=" . $this->data['token']['access_token'];
            $params = '{
            reportRequests:[{
            viewId:"ga:' . $this->data['token']['VIEWID'] . '",
             dateRanges:[{
              startDate:"' . $startDate . '",
             endDate:"' . $endDate . '"
            }],
             metrics:[{expression:"ga:sessions"}],
             dimensions: [{ "name":"ga:userType"}, {"name":"ga:date"}]
            }]
            }';
            $res = $this->sendPostData($Url, $params);
            $Rresult = json_decode($res);
            if (isset($Rresult->reports[0]->data->rows) && !empty($Rresult->reports[0]->data->rows)) {

                $date = array();
                $newVistor = array('name' => 'New Visitor', 'data' => array());
                $returnVistor = array('name' => 'Returning Visitor', 'data' => array());
                foreach ($Rresult->reports[0]->data->rows as $graph_data) {
                    if ($graph_data->dimensions[0] == "New Visitor") {
                        $newVistor['data'][] = (int) $graph_data->metrics[0]->values[0];
                        $date[] = date('M d', strtotime($graph_data->dimensions[1]));
                    }
                }
                foreach ($Rresult->reports[0]->data->rows as $graph_data) {
                    if ($graph_data->dimensions[0] == "Returning Visitor") {
                        $dateTemp[] = date('M d', strtotime($graph_data->dimensions[1]));
                    }
                }
                $datediff = array_diff($date, $dateTemp);
                foreach ($Rresult->reports[0]->data->rows as $graph_data) {
                    if ($graph_data->dimensions[0] == "Returning Visitor" && in_array(date('M d', strtotime($graph_data->dimensions[1])), $date)) {
                        $returnVistor['data'][] = (int) $graph_data->metrics[0]->values[0];
                    } else {
                        if ($graph_data->dimensions[0] == "New Visitor" && in_array(date('M d', strtotime($graph_data->dimensions[1])), $datediff)) {
                            $returnVistor['data'][] = 0;
                        }
                    }
                }
                echo json_encode(array('NEW' => $newVistor, 'date' => $date, 'RETURN' => $returnVistor));
                exit;
            }
        }
    }

    function landing_report() {
        require_once __DIR__ . '/../../../anaylitics/vendor/autoload.php';
        if (isset($this->data['token']['access_token'])) {
            $startDate = date('Y-m-d', strtotime($this->input->get('start_date')));
            $endDate = date('Y-m-d', strtotime($this->input->get('end_date')));
            $Url = "https://analyticsreporting.googleapis.com/v4/reports:batchGet?access_token=" . $this->data['token']['access_token'];
            $params = '{
            reportRequests:[{
            viewId:"ga:' . $this->data['token']['VIEWID'] . '",
             dateRanges:[{
              startDate:"' . $startDate . '",
             endDate:"' . $endDate . '"
            }],
             metrics:[{expression:"ga:sessions"},
             {expression:"ga:percentNewSessions"},
             {expression:"ga:newUsers"},
             {expression:"ga:bounceRate"},
             {expression:"ga:pageviewsPerSession"},
             {expression:"ga:avgSessionDuration"},
             {expression:"ga:goal1ConversionRate"},
             {expression:"ga:goal1Completions"},
             {expression:"ga:goal1Value"}
             ],
             dimensions: [{ "name":"ga:landingPagePath"}]
            }]
            }';
            $res = $this->sendPostData($Url, $params);
            $Rresult = json_decode($res);
            $this->data['landing_pages'] = $Rresult;
            echo $this->load->view('public/googleanalytics/landing', $this->data, true);
            exit;
        }
    }

    function sitemap() {
        $url = "https://www.googleapis.com/webmasters/v3/sites/" . urlencode('http://rockandhoney.co.nz/') . "/sitemaps/" . urlencode('http://rockandhoney.co.nz/sitemap.xml');
        $res = $this->sendGetData($url);
        print_r($res);
        die;
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

    function unlink_google_analytic($id) {
        require_once __DIR__ . '/../../../anaylitics/vendor/autoload.php';
        $client_id = '64708822544-ummrcg5t37eu868pr74evvd6vq87c068.apps.googleusercontent.com';
        $client_secret = 'qZbBOwvBviDpa6WqwjZYbq2_';
        $redirect_uri = site_url('oauth');
        $simple_api_key = 'AIzaSyD7TpnAJIGszf2LR7kx6f0QFUAYju47T5k';
        $client = new Google_Client();
        $client->setApplicationName("PHP Google OAuth Login Example");
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->setDeveloperKey($simple_api_key);
        $client->addScope(Google_Service_Webmasters::WEBMASTERS_READONLY);
        $client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');
        $client->revokeToken();
        $this->session->unset_userdata('google_access');
        $this->common_model->delete_google_access_token($id);
        redirect(site_url('project/detail/' . $id));
    }

}
