<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Alert_Controller extends MY_Controller {

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
        if (!$this->session->userdata('user_data')) {
            redirect('login');
        }
        $this->load->model('common_model');
        $this->load->model('project/project_model');
    }

    private $perPage = 1;

    public function index() {

        $this->data['title'] = "Alerts";
        $this->data['task'] = "1";
        $this->data['metatitle'] = 'UpKepr | Alerts';
        $this->data['criticals'] = $this->common_model->get_critical_alerts($this->session_data['user_id']);
        $this->data['critical_total'] = count($this->data['criticals']);
        $this->data['regulers'] = $this->common_model->get_sent_alert($this->session_data['user_id']);
        $this->data['reguler_total'] = count($this->data['regulers']);
        $this->page = 'public/alerts/alert.php';
        $this->display_Schedule();
    }

}
