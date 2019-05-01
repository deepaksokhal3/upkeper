<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Auth extends MY_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_data')) {
            redirect(site_url());
        }
    }

    function index() {
        $token = $this->uri->segment(2);
        $check_valid = $this->common_model->valid_token($token); //  check token expire date
        $this->page = 'login';
        if ($check_valid) {

            $this->form_validation->set_rules('email', 'User name', 'required');
            $this->form_validation->set_rules('password', 'User password', 'required');
            $this->form_validation->set_rules('g-recaptcha-response', 'captcha', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->display_login();
            } else {
                $secret = '6Le3lT4UAAAAAAe7scFExPXPTD1arBi-EYCle6uJ';
                $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $this->input->post('g-recaptcha-response'));
                $responseData = json_decode($verifyResponse);
                if ($responseData->success) {
                    $param = $this->input->post();
                    $valid_user = $this->common_model->check_existing_users($param); // check exist user
                    if ($valid_user) {
                        $user_data = $this->common_model->get_user_detail($param);    // get user detail
                        if (isset($user_data['status']) && ($user_data['status'] == 1 || $user_data['status'] == 2 || $user_data['status'] == 0)) {

                            if (($user_data['c_acc_status'] == 0 && $user_data) && ($user_data['user_type'] == 2)) {
                                if (!$user_data['status']) {
                                    $this->common_model->update_user_status($user_data['user_id']);
                                }
                                //$logs = $this->common_model->log($user_data['user_id']);
                                $sessionArry = array(
                                    'user_email' => $user_data['user_email'],
                                    'user_id' => $user_data['user_id'],
                                    'user_type' => $user_data['user_type'],
                                    'company_name' => $user_data['company_name'],
                                    'prof_pic' => $user_data['prof_image']
                                );
                                $this->session->set_userdata('user_data', $sessionArry);
                                $this->data['logs'] = array(
                                    'client_ip' => getRealIpAddr(),
                                    'user_id' => $user_data['user_id'],
                                    'request' => @$_SERVER['REQUEST_URI'],
                                    'status_code' => 200
                                );

                                $this->common_model->save_user_log($this->data['logs']);
                                if ($user_data['status'] && $user_data['p_status'])
                                    redirect();
                                else
                                    redirect();
                            }else {
                                $this->session->set_flashdata("danger", sprintf($this->lang->line('DANDER_ALERT'), lang_msg('VAILED_USER')));
                                $this->display_login();
                            }
                        } else {
                            $this->session->set_flashdata("danger", sprintf($this->lang->line('DANDER_ALERT'), lang_msg('VAILED_USER')));
                            $this->display_login();
                        }
                    } else {
                        $this->session->set_flashdata("info", sprintf($this->lang->line('INFO_NOTICE_ALERT'), 'Sorry', lang_msg('CREATE_ACCOUNT')));
                        $this->display_login();
                    }
                } else {
                    $this->session->set_flashdata("danger", sprintf($this->lang->line('DANDER_ALERT'), lang_msg('FAILED_CAPTCHA')));
                }
            }
        } else {
            $this->session->set_flashdata("danger", sprintf($this->lang->line('DANDER_ALERT'), lang_msg('TOKEN_EXPIRE')));
            $this->display_login();
        }
    }


}
