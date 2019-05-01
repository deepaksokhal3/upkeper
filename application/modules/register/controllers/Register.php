<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Register extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('sign_up');
        $this->data['countries'] = $this->common_model->get_countries();
        $this->data['catagories'] = $this->common_model->get_category();
        $this->load->model('email_model');
    }

    function index() {
        $this->data['tab'] = 3;
        $type = $this->input->post('type');
        switch ($type) {
            case "UPDATE":
                echo 'test';
                break;
            case "ADD":
                $this->sign_up();
                break;
            default:
                $this->page = 'register_company';

                $this->layout();
        }
    }

    /* =======================================================================================
     * Admin create a company profile and send password to compnay for complete profile
     * Sign up process admin end
      ======================================================================================== */

    function sign_up() {
        $this->page = 'register_company';
        
        if (!$this->sign_up->check_existing_users($this->input->post('email'))) {
            $params = $this->input->post();
            $this->form_validation->set_rules('f_name', 'First name', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('email', 'E-mail', 'required', array('required' => 'You have not provided %s.'));
            $this->form_validation->set_rules('category', 'Category', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->layout();
            } else {
                $token = md5(genrate_token($params['email']));
                $password = md5($params['password']);
                $this->data['user_register_data'] = array(
                    'user_email' => $params['email'],
                    'user_password' => $password,
                    'user_type' => 2,
                    'created_at' => date('Y-m-d h:i:s'),
                    'user_token' => $token,
                    'expire_token' => date("Y/m/d h:i:s", strtotime("+15 minutes")),
                );
                $user_id = $this->sign_up->save($this->data['user_register_data']);
                $this->data['user_profile_data'] = array(
                    'company_name' => ucfirst($params['company_name']),
                    'f_name' => ucfirst($params['f_name']),
                    'l_name' => ucfirst($params['l_name']),
                    'mobile_number' => $params['mobile_number'],
                    'address1' => $params['address1'],
                    'address2' => $params['address2'],
                    'country' => $params['country'],
                    'city' => $params['city'],
                    'state' => $params['state'],
                    'user_id' => $user_id,
                    'created_at' => date('Y-m-d h:i:s')
                );
                $prof_id = $this->sign_up->save_profile($this->data['user_profile_data']);
                if ($user_id && $prof_id) {
                    $templates = $this->email_model->get_email_content(1);
                    $param['company_name'] = $companyname = ucfirst($params['company_name']);
                    $param['link'] = '<a href="' . site_url('login/' . $token) . '"/>Click here</a>';
                    $param['password'] = $params['password'];
                    $param['username'] = $params['email'];
                    site_url('login/' . $token);
                    $from = 'upkepr.com ('.$companyname.')';
                    $templateContent['emailText'] = email_template($templates->template_text, $param);
                    if ($this->input->post('send_email') == 1) {
                        mailgun($params['email'], $from,email_template($templates->subject, $param), $this->load->view('email-templates/register', $templateContent, TRUE));
                    }

                    $this->session->set_flashdata("success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), lang_msg('PROFILE_CREATED')));
                    redirect('21232f297a57a5a743894a0e4a801fc3/companies');
                } else {
                    $this->session->set_flashdata("notice", sprintf($this->lang->line('INFO_NOTICE_ALERT'), 'Sorry ', lang_msg('COMPANY_CREATION_FAILED')));
                    redirect('21232f297a57a5a743894a0e4a801fc3/register');
                }
            }
        } else {
            $this->session->set_flashdata("notice", sprintf($this->lang->line('INFO_NOTICE_ALERT'), 'Sorry ', lang_msg('EMAIL_EXIST')));
            $this->layout();
        }
    }

}
