<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Local_Controller extends MY_Controller {

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
    }

    function check_cms() {
        $ch = curl_init($this->input->post('url'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        $error = curl_error($ch);
        $info = curl_getinfo($ch);
        if ($info['http_code'] != 200 && $info['redirect_url']) {
            $ch = curl_init($info['redirect_url']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
            $error = curl_error($ch);
            $info = curl_getinfo($ch);
            if ($info['http_code'] != 200  && $info['redirect_url']) {
                $ch = curl_init($info['redirect_url']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_exec($ch);
                $error = curl_error($ch);
                $info = curl_getinfo($ch);
                if ($info['http_code'] != 200 && $info['redirect_url']) {
                    $ch = curl_init($info['redirect_url']);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_exec($ch);
                    $error = curl_error($ch);
                    $info = curl_getinfo($ch);
                }
            }
        }
        $url = rtrim($info['url'], '/');
        if (isset($info['http_code']) && $info['http_code'] != 200) {
            echo json_encode(array('url' => 'error', 'error' => $error));
            exit;
        } else {
            $result = $this->project_model->check_valid_project($url,$this->session_data['user_id']);
            if ($result) {
                echo json_encode(array('url' => 'exist', 'error' => $error));
                exit;
            }
            echo json_encode(array('url' => $url));
        }
    }

    function wp_verify_auth() {

        if (!function_exists('curl_init') || !function_exists('curl_exec')) {
            $m = "cUrl is not vailable in you PHP server.";
            echo $m;
        }
        $wp_auth_data = $this->project_model->get_wp_credentials($project_id);
        $cookie_file = "/cookie.txt";
        $http_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6";
        $data = "log=" . $this->input->post('wpu') . "&pwd=" . $this->input->post('wpp') . "&wp-submit=Log%20In";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->input->post('wpurl'));
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, $http_agent);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, $login_url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POST, 1);
        $content = curl_exec($ch);
        curl_close($ch);
        echo $content;
    }

    function step_second() {
        if ($this->input->is_ajax_request()) {
            $this->data['process_session'] = $this->session->userdata('add_project');
            $this->data['process_session']['step'] = 1;
            $this->session->set_userdata('add_project', $this->data['process_session']);
            $this->data['process_session'] = $this->session->userdata('add_project');
            echo (isset($this->data['process_session']['step']) && $this->data['process_session']['step'] == 1 ) ? $this->data['process_session']['step'] : '';
            exit;
        }
    }

    public function index() {
        $this->page = 'public/dashboard';
        $this->display_Schedule();
    }

    function update_alert_counter() {
        if ($this->input->post('ids')) {
            echo $this->common_model->update_alert_counter($this->input->post('ids'));
        }
    }

}
