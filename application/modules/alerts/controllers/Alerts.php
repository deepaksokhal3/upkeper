<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Alerts extends MY_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_admin')) {
            redirect('21232f297a57a5a743894a0e4a801fc3/login');
        }
        $this->load->model('alerts_model');
    }

    function index() {
        $this->data['title'] = 'Manage Alert`s';
        $this->data['tab'] = 3;
        $this->page = 'index_view';
        $this->data['alert_data'] = $this->alerts_model->get_alerts();
        $this->layout();
    }

    /*     * **************************** Add alerts ******************************** */

    function manage_alert() {
        if ($this->input->post() && !$this->input->post('alert_id')) {
            $this->form_validation->set_rules('alert_name', 'Alert Name', 'required');
            $this->form_validation->set_rules('alert_type', 'Alert Type', 'required');
            if ($this->form_validation->run() == FALSE) {

                $this->data['alert_data'] = $this->alerts_model->get_alerts();
                $this->data['title'] = 'Manage Alert`s';
                $this->data['tab'] = 3;
                $this->page = 'index_view';
                $this->layout();
            } else {
                $this->data['alert_data'] = array(
                    'alert_name' => $this->input->post('alert_name'),
                    'alert_type' => $this->input->post('alert_type'),
                    'status' => 1,
                    'created_at' => date('Y-m-d h:i:s'),
                );
                $result = $this->alerts_model->add($this->data['alert_data']);
                if ($result) {
                    $this->session->set_flashdata("success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), lang_msg('ALERT_ADD')));
                    redirect('21232f297a57a5a743894a0e4a801fc3/alerts');
                } else {
                    $this->session->set_flashdata("error", sprintf($this->lang->line('INFO_NOTICE_ALERT'), lang_msg('TECH_ISSUES')));
                    redirect('21232f297a57a5a743894a0e4a801fc3/alerts');
                }
            }
        } else {

            $this->data['alert_data'] = array(
                'alert_name' => $this->input->post('alert_name'),
                'alert_type' => $this->input->post('alert_type'),
                'updated_at' => date('Y-m-d h:i:s'),
            );
            $result = $this->alerts_model->update($this->input->post('alert_id'), $this->data['alert_data']);
            if ($result) {
                $this->session->set_flashdata("success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), lang_msg('ALERT_UPDATE')));
                redirect('21232f297a57a5a743894a0e4a801fc3/alerts');
            } else {
                $this->session->set_flashdata("error", sprintf($this->lang->line('INFO_NOTICE_ALERT'), lang_msg('TECH_ISSUES')));
                redirect('21232f297a57a5a743894a0e4a801fc3/alerts');
            }
        }
    }

    /*     * ************************************ Edit alert ************************ */

    function edit_alert() {
        if ($this->input->post('alert_id')) {
            echo json_encode($this->alerts_model->get($this->input->post('alert_id')));
        }
    }

    /*     * ************************************ Delete alert ************************ */

    function delete($id) {
        if ($id) {
            $result = $this->alerts_model->delete($id);
            if ($result) {
                $this->session->set_flashdata("manage_success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'),lang_msg('ALERT_DELETE')));
                redirect('21232f297a57a5a743894a0e4a801fc3/alerts');
            } else {
                $this->session->set_flashdata("manage_error", sprintf($this->lang->line('INFO_NOTICE_ALERT'), lang_msg('TECH_ISSUES')));
                redirect('21232f297a57a5a743894a0e4a801fc3/alerts');
            }
        }
    }

}
