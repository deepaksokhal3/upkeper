<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home_Controller extends MY_Controller {

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

    private $perPage = 100;

    public function index() {
        $this->session->unset_userdata('add_project');
        $this->data['title'] = "Dashboard";
        $this->data['task'] = "1";
        $this->data['active_nav'] = '1';
        $this->data['total_projects'] = $this->common_model->get_total_projects($this->session_data['user_id']);
        $this->data['metatitle'] = 'UpKepr | Monitor Your Web Assests ';
        $this->data['project_counter'] = $this->project_model->project_counter($this->session_data['user_id']);
        $this->page = 'public/dashboard';
        $this->display_Schedule();
    }

    function project_list($page) {
        $page = ($page) ? $page : 0;
        $this->data['total_projects'] = $this->common_model->get_total_projects($this->session_data['user_id']);
        $start = ceil($page * $this->perPage);
        $this->data['projects'] = $this->project_model->get_projects($this->perPage, $start, $this->session_data['user_id']);
        echo $this->load->view('public/project/project_list', $this->data);
    }

    function search($keywords) {
        $this->data['projects'] = $this->project_model->search_project($keywords, $this->session_data['user_id']);
        $this->data['total'] = $this->project_model->get_total_result($keywords, $this->session_data['user_id']);
        echo $this->load->view('public/search/search_project_list', $this->data);
    }

    function autocomplete($keywords) {
        $this->data['result'] = $this->project_model->autocoplete_search($this->session_data['user_id'], $keywords);
        echo json_encode($this->data['result']);
        die;
    }

    function check_queue_status($id) {
        if ($id) {
            $this->data['projects'] = $this->project_model->refresh_queue($id);
            echo $this->load->view('public/project/project_list_queue', $this->data);
        }
    }
    
    function email(){
        echo $this->load->view('email-templates/health/speed');
    }

}
