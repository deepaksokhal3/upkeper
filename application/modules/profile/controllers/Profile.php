<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Profile extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('profile_model');
        $this->session_data = $this->session->userdata('user_data');
        if (!$this->session->userdata('user_data')) {
            redirect('login');
        }
    }

    function index() {
        //$this->session->unset_userdata('step');
        $this->page = 'profile_view';
        $this->data['title'] = 'Edit Profile';
        $this->data['metatitle'] = 'UpKepr | Edit Profile ';
        $this->data['user_profile'] = $this->profile_model->get_profile($this->session_data['user_id']);
        $this->data['countries'] = $this->common_model->get_countries();
        $this->data['catagories'] = $this->common_model->get_category();
        $this->display_Schedule();
    }

    /*     * ***************************** update profile form data ************************ */

    function update_profile() {
        $profile_data = $this->input->post();

        if (isset($_FILES["profile_photo"]) && !empty($_FILES["profile_photo"])) {
            $exp = explode('.', $_FILES["profile_photo"]['name']);
            $_FILES['profile_photo']['name'] = "profile" . strtotime(date('h:i:s')) . "." . $exp[1];
            $_FILES['profile_photo']['type'] = $_FILES["profile_photo"]['type'];
            $_FILES['profile_photo']['tmp_name'] = $_FILES["profile_photo"]['tmp_name'];
            $_FILES['profile_photo']['error'] = $_FILES["profile_photo"]['error'];
            $_FILES['profile_photo']['size'] = $_FILES["profile_photo"]['size'];
            $config['upload_path'] = 'assets/photo/profile';
            $config['allowed_types'] = '*';
            $config['max_size'] = '10000';
            $config['max_width'] = '10024';
            $config['max_height'] = '10768';
            $this->load->library('upload', $config);
            $this->upload->do_upload('profile_photo');
            $data = $this->upload->data();
            $names = $data['file_name'];

            // create thumb nails
            $config_img['image_library'] = 'gd2';
            $config_img['source_image'] = 'assets/photo/profile/' . $names;
            $config_img['profile_photo'] = 'assets/photo/profile/';
            $config_img['create_thumb'] = TRUE;
            $config_img['maintain_ratio'] = TRUE;
            $config_img['quality'] = 100;
            $config_img['width'] = 180;
            $config_img['height'] = 150;
            $this->load->library('image_lib', $config_img);
            $this->image_lib->resize();
            $fileParts = explode(".", $names);
            $ext = $fileParts[count($fileParts) - 1];
            $name_thumb = $fileParts[0] . '_thumb.' . $ext;
        }
        $this->data['profile_data'] = array(
            'company_name' => ucfirst($profile_data['company_name']),
            'user_id' => $this->session_data['user_id'],
            'status' => 1,
            'f_name' => ucfirst($profile_data['f_name']),
            'l_name' => ucfirst($profile_data['l_name']),
            'category' => $profile_data['category'],
            'city' => $profile_data['city'],
            'state' => $profile_data['state'],
            'country' => $profile_data['country'],
            'mobile_number' => $profile_data['mobile_number'],
            'address1' => $profile_data['address1'],
            'address2' => $profile_data['address2'],
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'updated_at' => date('Y-m-d h:i:s'),
        );
        if ($names) {
            $this->data['profile_data']['prof_image'] = 'assets/photo/profile/' . $names;
            $this->data['profile_data']['thumb_nail'] = 'assets/photo/profile/' . $name_thumb;
        }
        $result = $this->profile_model->update($this->data['profile_data']);

        if ($result) {
            $this->session_data['company_name'] = ucfirst($profile_data['company_name']);
            $this->session->unset_userdata('user_data');
            $this->session->set_userdata('user_data', $this->session_data);
            $this->session->set_flashdata("success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), lang_msg('PROFILE_UPDATED')));
            redirect('profile');
        } else {
            $this->session->set_flashdata("error", sprintf($this->lang->line('INFO_NOTICE_ALERT'), lang_msg('TECH_ISSUES')));
            redirect('profile');
        }
    }

    function close_account() {
        $this->data['data'] = array(
            'c_reason' => $this->input->post('reason')
        );
        $result = $this->common_model->close_account($this->session_data['user_id'], $this->data['data']);
        if ($result) {
            $this->load->model('email_model');
            $templates = $this->email_model->get_email_content(5); // Fetch template that you have set
            
            $link = site_url('confirm-close-account/' . $this->session_data['user_id']);
            $param['company_name'] = $companyname =  $this->session_data['company_name'];
            $param['link'] = '<a href="' . $link . '"/>Close Account</a>';
            $templateContent['emailText'] = email_template($templates->template_text, $param);
             $from = 'upkepr.com ('.$companyname.')';
            mailgun($this->session_data['user_email'],$from, email_template($templates->subject, $param), $this->load->view('email-templates/close-acc-confirmation', $templateContent, TRUE));
            
            $this->session->set_flashdata("success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), lang_msg('ACCONT_CLOSE_EMAIL')));
            redirect('profile');
        }
    }

    function confirm_close_account($user_id) {
        $this->data['data'] = array(
            'c_acc_status' => 1,
            'status' => 4
        );
        $result = $this->common_model->close_account($user_id, $this->data['data']);
        $this->common_model->delete_user_data($user_id);
        $this->session->unset_userdata('user_data');
        redirect('profile');
    }

    function save_brand() {
        if (!$this->input->post('brand_id')) {
            if (isset($_FILES["b_logo"]) && !empty($_FILES["b_logo"])) {
                $exp = explode('.', $_FILES["b_logo"]['name']);
                $_FILES['b_logo']['name'] = "b_logo" . strtotime(date('y-m-d-h:i:s')) . "." . $exp[1];
                $_FILES['b_logo']['type'] = $_FILES["b_logo"]['type'];
                $_FILES['b_logo']['tmp_name'] = $_FILES["b_logo"]['tmp_name'];
                $_FILES['b_logo']['error'] = $_FILES["b_logo"]['error'];
                $_FILES['b_logo']['size'] = $_FILES["b_logo"]['size'];
                $config['upload_path'] = 'assets/photo/brand-logo';
                $config['allowed_types'] = '*';
                $config['max_size'] = '10000';
                $config['max_width'] = '10024';
                $config['max_height'] = '10768';
                $this->load->library('upload', $config);
                $this->upload->do_upload('b_logo');
                $data = $this->upload->data();
                $names = $data['file_name'];

                // create thumb nails
                $config_img['image_library'] = 'gd2';
                $config_img['source_image'] = 'assets/photo/brand-logo/' . $names;
                $config_img['b_logo'] = 'assets/photo/brand-logo/';
                $config_img['create_thumb'] = TRUE;
                $config_img['maintain_ratio'] = TRUE;
                $config_img['quality'] = 100;
                $config_img['width'] = 50;
                $config_img['height'] = 50;
                $this->load->library('image_lib', $config_img);
                $this->image_lib->resize();
                $fileParts = explode(".", $names);
                $ext = $fileParts[count($fileParts) - 1];
                $name_thumb = $fileParts[0] . '_thumb.' . $ext;
            }

            $this->data['branding'] = array(
                'firm_name' => $this->input->post('b_suport_name'),
                'support_email' => $this->input->post('b_suport_email'),
                'phone' => $this->input->post('b_phone_no'),
                'user_id' => $this->session_data['user_id'],
                'logo' => 'assets/photo/brand-logo/' . $names,
                'thumb_logo' => 'assets/photo/brand-logo/' . $name_thumb,
                'office_address' => $this->input->post('b_office_address')
            );

            $res = $this->profile_model->save_brand($this->data['branding']);
            if ($res) {
                $this->session->set_flashdata("success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), lang_msg('BRAND_ADDED')));
                redirect('profile');
            } else {
                $this->session->set_flashdata("error", sprintf($this->lang->line('INFO_NOTICE_ALERT'), lang_msg('TECH_ISSUES')));
                redirect('profile');
            }
        } else {

            $this->data['branding'] = array(
                'brand_id' => $this->input->post('brand_id'),
                'firm_name' => $this->input->post('b_suport_name'),
                'support_email' => $this->input->post('b_suport_email'),
                'phone' => $this->input->post('b_phone_no'),
                'user_id' => $this->session_data['user_id'],
                'office_address' => $this->input->post('b_office_address')
            );
            if (isset($_FILES["b_logo"]) && $_FILES["b_logo"]) {
                $exp = explode('.', $_FILES["b_logo"]['name']);
                $_FILES['b_logo']['name'] = "b_logo" . strtotime(date('y-m-d-h:i:s')) . "." . $exp[1];
                $_FILES['b_logo']['type'] = $_FILES["b_logo"]['type'];
                $_FILES['b_logo']['tmp_name'] = $_FILES["b_logo"]['tmp_name'];
                $_FILES['b_logo']['error'] = $_FILES["b_logo"]['error'];
                $_FILES['b_logo']['size'] = $_FILES["b_logo"]['size'];
                $config['upload_path'] = 'assets/photo/brand-logo';
                $config['allowed_types'] = '*';
                $config['max_size'] = '10000';
                $config['max_width'] = '10024';
                $config['max_height'] = '10768';
                $this->load->library('upload', $config);
                $this->upload->do_upload('b_logo');
                $data = $this->upload->data();
                $names = $data['file_name'];

                // create thumb nails
                $config_img['image_library'] = 'gd2';
                $config_img['source_image'] = 'assets/photo/brand-logo/' . $names;
                $config_img['b_logo'] = 'assets/photo/brand-logo/';
                $config_img['create_thumb'] = TRUE;
                $config_img['maintain_ratio'] = TRUE;
                $config_img['quality'] = 100;
                $config_img['width'] = 180;
                $config_img['height'] = 150;
                $this->load->library('image_lib', $config_img);
                $this->image_lib->resize();
                $fileParts = explode(".", $names);
                $ext = $fileParts[count($fileParts) - 1];
                $name_thumb = $fileParts[0] . '_thumb.' . $ext;
                if ($names) {
                    $this->data['branding']['logo'] = 'assets/photo/brand-logo/' . $names;
                    $this->data['branding']['thumb_logo'] = 'assets/photo/brand-logo/' . $name_thumb;
                }
            }
            $res = $this->profile_model->update_brand($this->data['branding']);
            if ($res) {
                $this->session->set_flashdata("success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), lang_msg('BRAND_UPDATED')));
                redirect('profile');
            } else {
                $this->session->set_flashdata("error", sprintf($this->lang->line('INFO_NOTICE_ALERT'), lang_msg('TECH_ISSUES')));
                redirect('profile');
            }
        }
    }
    
    function reset_branding(){
     $this->profile_model->delete_brand($this->session_data['user_id']);
     redirect('profile');
    }

}
