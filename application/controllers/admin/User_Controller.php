<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_Controller extends MY_Controller {
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
    }
    
    
    public function index() {
        $this->page = '21232f297a57a5a743894a0e4a801fc3/dashboard';
        $this->layout();
    }
    
    
    function login() {
        $this->page = 'admin/admin_login';
        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'User name', 'required');
            $this->form_validation->set_rules('password', 'password', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata("danger", sprintf($this->lang->line('DANDER_ALERT'), 'Please enter valid username and password .'));
                $this->display_login();
            } else {
                $param = $this->input->post();
                $valid_user = $this->common_model->check_existing_users($param); // check exist user
                if ($valid_user) {
                    $user_data = $this->common_model->get_user_detail($param);    // get user detail
                    if (isset($user_data['user_type']) && !empty($user_data['user_type']) && $user_data['user_type'] == 1) {
                        $sessionArry = array(
                            'user_email' => $user_data['user_email'],
                            'user_id' => $user_data['user_id'],
                            'user_type' => $user_data['user_type'],
                            'f_name' => $user_data['f_name'],
                            'l_name' => $user_data['l_name'],
                            'prof_pic' => $user_data['prof_image']
                        );
                        $this->session->set_userdata('user_admin', $sessionArry);
                        redirect('21232f297a57a5a743894a0e4a801fc3');
                    } else {
                        $this->session->set_flashdata("danger", sprintf($this->lang->line('DANDER_ALERT'), 'Please enter valid username and password .'));
                        $this->display_login();
                    }
                } else {
                    $this->session->set_flashdata("info", sprintf($this->lang->line('INFO_NOTICE_ALERT'), 'Sorry', 'Please sign-up first'));
                    $this->display_login();
                }
            }
        } else {
            $this->display_login();
        }
    }
    
    public function logout(){
        $this->session->unset_userdata('user_admin');
        redirect('21232f297a57a5a743894a0e4a801fc3');
    }
}
