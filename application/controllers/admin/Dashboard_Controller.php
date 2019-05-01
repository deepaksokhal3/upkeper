<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_Controller extends MY_Controller {

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
        if (!$this->session->userdata('user_admin')) {
            redirect('21232f297a57a5a743894a0e4a801fc3/login');
        }
        $this->load->model('dashboard_model');
    }

    public function index() {
        $this->page = 'admin/dashboard';
        $this->data['projects'] = $this->dashboard_model->get_projects();

        $this->data['users'] = $this->dashboard_model->get_uesrs();
        $this->data['active_users'] = $this->dashboard_model->get_active_uesrs();

        $this->layout();
    }

    //************************************* Admin login as company **************************************/

    public function user_login($id) {
        $check_exist = $this->dashboard_model->check_existing_users($id);
        $this->page = 'admin/dashboard';
        if ($check_exist) {
            $user_data = $this->dashboard_model->get_user_detail($id);    // get user detail
            if (!$user_data['status'])
                $this->common_model->update_user_status($user_data['user_id']);
            $sessionArry = array(
                'user_email' => $user_data['user_email'],
                'user_id' => $user_data['user_id'],
                'user_type' => $user_data['user_type'],
                'company_name' => $user_data['company_name'],
                'prof_pic' => $user_data['prof_image']
            );
            $this->session->set_userdata('user_data', $sessionArry);
            if ($user_data['status'] && $user_data['p_status'])
                redirect();
            else
                redirect('profile');
        } else {
            $this->session->set_flashdata("danger", sprintf($this->lang->line('DANDER_ALERT'), 'user not exist'));
            $this->layout();
        }
    }

    function block_user() {
        $resp = $this->dashboard_model->update_user($this->input->post());
        echo json_encode($resp);
    }

    function search_project() {
        if ($this->input->is_ajax_request()) {
            $data = $this->dashboard_model->serch_project($this->input->get('keyword'));
            echo ($data) ? json_encode(array('status' => true, 'data' => $data)) : json_encode(array('status' => false, "data" => 'No record found'));
        }
    }

    function search_user() {
        if ($this->input->is_ajax_request()) {
            $data = $this->common_model->serach_user($this->input->get('company'));
            echo ($data) ? json_encode(array('status' => true, 'data' => $data)) : json_encode(array('status' => false, "data" => 'No record found'));
        }
    }

    function move_project() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->get('project_id') && $this->input->get('user_id')) {
                $data['user_id'] = $this->input->get('user_id');
                $res = $this->dashboard_model->move_project($this->input->get('project_id'), $data);
                echo ($res) ? json_encode(array('status' => "success", 'message'=>  sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), 'Project successfully moved'))) : json_encode(array('status' => "error",'message'=>  sprintf($this->lang->line('INFO_NOTICE_ALERT'), 'Oops ! Please try again some technical issues is occurred.')));
            }else{
                echo json_encode(array('status' => "error"));
            }
        }
    }

}
