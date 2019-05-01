    <?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Companies extends MY_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_admin')) {
            redirect('21232f297a57a5a743894a0e4a801fc3/login');
        }
        $this->load->model('company_model');
    }

    function index() {
        $this->page = 'companies-list';
        $this->data['tab'] = 3;
        $this->data['title'] = 'Companies';
        $this->data['compay_data'] = $this->company_model->get_companies();
        $this->layout();
    }

    function update_user_sataus() {
        if ($this->input->post()) {
            $this->data['data'] = $this->input->post();
            $result = $this->company_model->update_user_status($this->data['data']);
            if ($result) {
                echo json_encode(array('status' => true));
            } else {
                echo json_encode(array('status' => false));
            }
        }
    }

    function get_register_data($id) {
        $this->data['title'] = 'Edit company Profile';
        $this->page = 'edit_comp_view';
        $this->data['user'] = $this->company_model->get_uesr($id);
        $this->data['countries'] = $this->common_model->get_countries();
        $this->data['catagories'] = $this->common_model->get_category();
        $this->layout();
    }

    function update_user_profile() {
        if ($user_id = $this->input->post('user_id')) {
            $this->data['user_profile_data'] = array(
                'company_name' => ucfirst($this->input->post('company_name')),
                'f_name' => ucfirst($this->input->post('f_name')),
                'l_name' => ucfirst($this->input->post('l_name')),
                'mobile_number' => $this->input->post('mobile_number'),
                'address1' => $this->input->post('address1'),
                'address2' => $this->input->post('address2'),
                'category' => $this->input->post('category'),
                'country' => $this->input->post('country'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'updated_at' => date('Y-m-d h:i:s')
            );
            
//           if($this->input->post('password')){
//               $user_data['user_data']= array(
//                   'user_password' => md5($this->input->post('password'))
//               );
//           }
            
            
            $result = $this->company_model->update_user_profile($user_id, $this->data['user_profile_data']);
            if ($result) {
                $this->session->set_flashdata("success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), lang_msg('PROFILE_UPDATED')));
                redirect('21232f297a57a5a743894a0e4a801fc3/companies');
            } else {
                $this->session->set_flashdata("notice", sprintf($this->lang->line('INFO_NOTICE_ALERT'), 'Sorry ', lang_msg('COMPANY_UPADTE_FAILED')));
            }
        } else {
            $this->session->set_flashdata("notice", sprintf($this->lang->line('INFO_NOTICE_ALERT'), 'Oop`s ',  lang_msg('TECH_ISSUES')));
        }
    }

}
