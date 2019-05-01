<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Hostmanager extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('hostmanager_model');
    }

    function index() {
        $this->data['title'] = 'Manage Host Company';
        $this->data['tab'] = 4;
        $this->page = 'index_view';
        $this->data['host_companies'] = $this->hostmanager_model->get();
        $this->layout();
    }

    /*     * **************************** Add alerts ******************************** */

    function add() {

        $this->data['host_companies'] = $this->hostmanager_model->get();
        $this->data['title'] = 'Manage Host Company';
        $this->data['tab'] = 4;
        $this->page = 'index_view';
        if ($this->input->post() && !$this->input->post('h_manager_id')) {
            $this->form_validation->set_rules('host_company', 'Host company', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->layout();
            } else {
                $this->data['manage'] = array(
                    'host_company' => $this->input->post('host_company'),
                    'created_at' => date('Y-m-d h:i:s'),
                );
                $result = $this->hostmanager_model->add($this->data['manage']);
                if ($result) {
                    $this->session->set_flashdata("success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), lang_msg('HOST_COMP_ADD')));
                    redirect('21232f297a57a5a743894a0e4a801fc3/hostmanager');
                } else {
                    $this->session->set_flashdata("error", sprintf($this->lang->line('INFO_NOTICE_ALERT'), lang_msg('TECH_ISSUES')));
                    redirect('21232f297a57a5a743894a0e4a801fc3/hostmanager');
                }
            }
        } else {

            $this->data['manage'] = array(
                'host_company' => $this->input->post('host_company'),
                'updated_at' => date('Y-m-d h:i:s'),
            );
            $result = $this->hostmanager_model->update($this->input->post('h_manager_id'), $this->data['manage']);
            if ($result) {
                $this->session->set_flashdata("success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), lang_msg('HOST_COMP_UPDATE')));
                $this->data['companyData'] = $this->hostmanager_model->get_host_company($this->input->post('h_manager_id'));
                $this->layout();
            } else {
                $this->session->set_flashdata("error", sprintf($this->lang->line('INFO_NOTICE_ALERT'), lang_msg('TECH_ISSUES')));
                redirect('21232f297a57a5a743894a0e4a801fc3/hostmanager');
            }
        }
    }

    /*     * ************************************ Edit alert ************************ */

    function edit() {
        if ($this->input->post('h_manager_id')) {
            echo json_encode($this->hostmanager_model->get_host_company($this->input->post('h_manager_id')));
        }
    }

    /*     * ************************************ Delete alert ************************ */

    function delete($id) {
        if ($id) {
            $result = $this->hostmanager_model->delete($id);
            if ($result) {
                $this->session->set_flashdata("manage_success", sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'),lang_msg('HOST_COMP_DELETE')));
                redirect('21232f297a57a5a743894a0e4a801fc3/hostmanager');
            } else {
                $this->session->set_flashdata("manage_error", sprintf($this->lang->line('INFO_NOTICE_ALERT'),  lang_msg('TECH_ISSUES')));
                redirect('21232f297a57a5a743894a0e4a801fc3/hostmanager');
            }
        }
    }

}
