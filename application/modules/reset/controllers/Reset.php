<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Reset extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('reset_model');
        $this->load->model('email_model');
    }

    function index() {
        $this->page = 'forgot_pass';
        $this->form_validation->set_rules('email', 'User name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->display_login();
        } else {
            $email = $this->input->post('email');
            $valid_user = $this->reset_model->valid_email($email); // check exist user
            if ($valid_user) {
                $company = $this->common_model->company($email);
                $token = md5(genrate_token($email));

                $templates = $this->email_model->get_email_content(2);
                $param['company_name'] = $companyname = $company->company_name;
                $param['link'] = '<a href="' . site_url('new-password/' . $token) . '">Reset Password </a>';
                $templateContent['emailText'] = email_template($templates->template_text, $param);
                $from = 'upkepr.com ('.$companyname.')';
                mailgun($valid_user['user_email'], $from, email_template($templates->subject, $param), $this->load->view('email-templates/reset-password', $templateContent, TRUE));
                $this->data['user_data'] = array(
                    'user_id' => $valid_user['user_id'],
                    'reset_token' => $token
                );
                $user_data = $this->common_model->update_user($this->data['user_data']);    // get user detail
                if ($user_data) {
                    $this->data['title'] = "Check you email";
                    $this->data['text'] = "We have sent you an email with a password reset link. Please click that link to reset your account password.";
                    $this->data['type'] = 'sent';
                    $this->page = 'success';
                    $this->display_login();
                } else {
                    $this->session->set_flashdata("info", sprintf($this->lang->line('INFO_NOTICE_ALERT'), 'Oops! ', lang_msg('TECH_ISSUES')));
                    redirect('reset-password');
                }
            } else {

                $this->display_login();
            }
        }
    }

    function set_password() {
        $token = $this->uri->segment(2);
        $check_valid = $this->common_model->valid_reset_token($token);
        // print_r($check_valid);die;
        if ($check_valid) {
            $this->page = 'set_password';
            $this->data['token'] = $token;
            $this->display_login();
        } else {
            $this->data['title'] = "Token Expired !!";
            $this->data['text'] = "Your token is expired please create again";
            $this->data['type'] = ' ';
            $this->page = 'success';
            $this->display_login();
        }
    }

    function save_new_password() {
        if ($password = $this->input->post('password')) {
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('password_confirmation', 'Confirm Password', 'required|matches[password]');
            if ($this->form_validation->run() == FALSE) {
                 $this->session->set_flashdata("error", sprintf($this->lang->line('DANDER_ALERT'), lang_msg('NOT_CONFIRM_PASS')));
                 redirect('new-password/'.$this->input->post('token'));
            } else {
                $valid_user = $this->common_model->valid_reset_token($this->input->post('token'));
                if ($valid_user) {
                    $this->data['user_data'] = array(
                        'user_id' => $valid_user->user_id,
                        'user_password' => md5($password)
                    );
                    $user_data = $this->common_model->update_user($this->data['user_data']);
                    if ($user_data) {
                        redirect('login');
                    } else {
                        $this->session->set_flashdata("info", sprintf($this->lang->line('INFO_NOTICE_ALERT'), 'Oops !', lang_msg('TECH_ISSUES')));
                        redirect('new-password/' . $this->input->post('token'));
                    }
                }
            }
        } else {
            $this->data['title'] = "Token Expired !!";
            $this->data['text'] = "Your token is expired please create again";
            $this->data['type'] = ' ';
            $this->page = 'success';
            $this->display_login();
        }
    }

    function captcha() {

        if ($this->input->post('email') && $this->input->post('g-recaptcha-response')) {
            $secret = '6Le3lT4UAAAAAAe7scFExPXPTD1arBi-EYCle6uJ';
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $this->input->post('g-recaptcha-response'));
            $responseData = json_decode($verifyResponse);
            if ($responseData->success) {
                echo json_encode(array('sucess' => 'sucess'));
            } else {
                echo json_encode(array('error' => sprintf($this->lang->line('DANDER_ALERT'), lang_msg('FAILED_CAPTCHA'))));
            }
        } else {
            echo json_encode(array('error' => sprintf($this->lang->line('DANDER_ALERT'), lang_msg('CAPTACH_CHECK'))));
        }
    }

}
