<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Handshake_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->model('error_message_model');
       
    }

    public function index() {
        if (isset($_REQUEST['handshake']) && isset($_REQUEST['url'])) {
            $url = rtrim($_REQUEST['url'], "/") . '/wp-content/plugins/cWebCo-Maintenance/public/template/wp_add_info.php';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5); //timeout in seconds
            $result = curl_exec($ch);
            $res = curl_getinfo($ch);
            curl_close($ch);
            $obj = is_string($result) && is_array(json_decode($result, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
            if ($obj) {
                 $success = $this->error_message_model->plugin_success_msg();
                echo json_encode(array('Status' => 200, 'message' => lang_msg('PLUGIN_INSTALLED')));
            } else {
                $error = $this->error_message_model->plugin_success_msg();
                echo json_encode(array('Status' => 403, 'message' => lang_msg('PLUGIN_NOT_COMP')));
            }
        } else {
            echo json_encode(array('Status' => 400, 'message' => 'Bad Request'));
        }
    }

}
