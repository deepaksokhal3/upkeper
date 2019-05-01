<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Error_Message_Controller extends MY_Controller {

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
        $this->load->model('error_message_model');
    }

    public function index() {

        $this->page = 'admin/error_manager/error_message';
        $this->data['messages'] = $this->error_message_model->get();
        $this->data['title'] = 'Error Manager';
        $this->data['tab'] = 5;
        if ($this->input->post()) {
            $this->form_validation->set_rules('e_msg', 'Error message', 'required');
            if ($this->form_validation->run() == FALSE) {
                
            } else {
                if (!$this->input->post('error_id')) {
                    $this->data['data'] = array(
                        'msg' => $this->input->post("e_msg"),
                        'msg_key' => $this->input->post("msg_key")
                    );
                    $validKey = $this->error_message_model->check_super_key($this->input->post("msg_key"));
                    if (!$validKey) {
                        $this->error_message_model->save($this->data['data']);
                        $this->session->set_flashdata("success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), lang_msg('ERROR_MSG_ADDED')));
                    } else {
                        $this->session->set_flashdata("error", sprintf($this->lang->line('INFO_NOTICE_ALERT'), 'Sorry ', lang_msg('SUPER_KEY_EXIST')));
                    }
                    redirect('21232f297a57a5a743894a0e4a801fc3/errro-massage');
                } else {
                    $this->data['data'] = array(
                        'msg' => $this->input->post("e_msg"),
                        'msg_key' => $this->input->post("msg_key"),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    $this->error_message_model->update($this->input->post('error_id'), $this->data['data']);
                    $this->session->set_flashdata("success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), lang_msg('ERROR_MSG_UPDATED')));
                    redirect('21232f297a57a5a743894a0e4a801fc3/errro-massage');
                }
            }
        }
        $this->layout();
    }

    function get_message() {
        if ($this->input->post('error_id')) {
            echo json_encode($this->error_message_model->get_message($this->input->post('error_id')));
        }
    }

    function delete($id) {
        if ($id) {
            $result = $this->error_message_model->delete($id);
            if ($result) {
                $this->session->set_flashdata("manage_success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), lang_msg('ERROR_MSG_DELETE')));
                redirect('21232f297a57a5a743894a0e4a801fc3/errro-massage');
            } else {
                $this->session->set_flashdata("manage_error", sprintf($this->lang->line('INFO_NOTICE_ALERT'), lang_msg('TECH_ISSUES')));
                redirect('21232f297a57a5a743894a0e4a801fc3/errro-massage');
            }
        }
    }

}
