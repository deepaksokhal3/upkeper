<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Email_template extends MY_Controller {

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
        $this->load->model('email_model');
         $this->load->model('alerts/alerts_model');
        
    }

    public function index() {
        $this->page = 'admin/email/index_view';
        $this->data['tab'] = 6;
        $this->data['title'] = 'Email Templates';
        $this->data['templates'] = $this->email_model->get();
        $this->data['alerts'] = $this->alerts_model->get_alerts();
        $this->layout();
    }

    /*     * *************************************** ADD EMAIL TEMPLATE **************************************** */

    function add() {
        if ($this->input->post() && !$this->input->post('temp_id')) {
            $this->form_validation->set_rules('temp_title', 'title', 'required');
            $this->form_validation->set_rules('temp_type', 'template type', 'required');
            $this->form_validation->set_rules('email_template', 'template', 'required');
            if ($this->form_validation->run() == FALSE) {

                $this->data['templates'] = $this->email_model->get();
                $this->data['title'] = 'Email Templates';
                $this->data['tab'] = 6;
                $this->page = 'admin/email/index_view';
                $this->layout();
            } else {
                $this->data['templates'] = array(
                    'temp_title' => $this->input->post('temp_title'),
                    'temp_type' => $this->input->post('temp_type'),
                    'subject' => $this->input->post('subject'),
                    'template_text' => $this->input->post('email_template'),
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                );
                $result = $this->email_model->add($this->data['templates']);
                
                if ($result) {
                    $this->session->set_flashdata("success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), 'Email template has been added..'));
                    redirect('21232f297a57a5a743894a0e4a801fc3/email-templates');
                } else {
                    $this->session->set_flashdata("error", sprintf($this->lang->line('INFO_NOTICE_ALERT'), 'Some technical issue is occurred please try again..'));
                    redirect('21232f297a57a5a743894a0e4a801fc3/email-templates');
                }
            }
        } else {

            $this->data['templates'] = array(
                'temp_title' => $this->input->post('temp_title'),
                'temp_type' => $this->input->post('temp_type'),
                'subject' => $this->input->post('subject'),
                'template_text' => $this->input->post('email_template'),
                'updated_at' => date('Y-m-d h:i:s'),
            );
            $result = $this->email_model->update($this->input->post('temp_id'), $this->data['templates']);
            if ($result) {
                $this->session->set_flashdata("success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), 'Email template has been updated successfully..'));
                redirect('21232f297a57a5a743894a0e4a801fc3/email-templates');
            } else {
                $this->session->set_flashdata("error", sprintf($this->lang->line('INFO_NOTICE_ALERT'), 'Some technical issue is occurred please try again..'));
                redirect('21232f297a57a5a743894a0e4a801fc3/email-templates');
            }
        }
    }

    /*     * ************************************ Edit alert ************************ */

    function edit() {
        if ($this->input->post('temp_id')) {
            echo json_encode($this->email_model->get_temp($this->input->post('temp_id')));
        }
    }

    /*     * ************************************ Delete alert ************************ */

    function delete($id) {
        if ($id) {
            $result = $this->email_model->delete($id);
            if ($result) {
                $this->session->set_flashdata("manage_success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), 'Email template has been deleted successfully..'));
                redirect('21232f297a57a5a743894a0e4a801fc3/email-templates');
            } else {
                $this->session->set_flashdata("manage_error", sprintf($this->lang->line('INFO_NOTICE_ALERT'), 'Some technical issue is occurred please try again..'));
                redirect('21232f297a57a5a743894a0e4a801fc3/email-templates');
            }
        }
    }

}
