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
        $this->page = 'index_view';
        $this->data['title'] = 'Host manager';
        $this->data['hosts'] = $this->hostmanager_model->get();
        $this->data['tab'] = 4;
        $this->layout();
    }

    /*     * *********************** Add  *********************** */

    function add() {
     
        $this->page = 'add_view';
        $this->data['title'] = 'Add Host Details';
        $this->data['tab'] = 4;
        if ($this->input->post()) {
            $this->form_validation->set_rules('host_company', 'company name', 'required');
            $this->form_validation->set_rules('host_company_url', 'host company url', 'required');
            if ($this->form_validation->run() == FALSE) {
                return $this->layout();
            } else {

                if ($this->input->post('host_id')) {
                    $this->data['data'] = array(
                        'host_company' => $this->input->post('host_company'),
                        'host_company_url' => $this->input->post('host_company_url'),
                        'name_server' => strtoupper(implode(",", $this->input->post('server_names'))),
                        'updated_at' => date('Y-m-d')
                    );
                    $result = $this->hostmanager_model->update($this->input->post('host_id'), $this->data['data']);
                    if ($result) {
                        redirect('21232f297a57a5a743894a0e4a801fc3/hostmanager');
                    }
                } else {

                    $this->data['data'] = array(
                        'host_company' => $this->input->post('host_company'),
                        'host_company_url' => $this->input->post('host_company_url'),
                        'name_server' => strtoupper(implode(",", $this->input->post('server_names'))),
                    );
                }
         
                $result = $this->hostmanager_model->save($this->data['data']);
                if ($result) {
                    redirect('21232f297a57a5a743894a0e4a801fc3/hostmanager');
                }
            }
        }
        $this->layout();
    }

    function edit($id) {
        $this->page = 'edit_view';
        $this->data['title'] = 'Update Hosting Company';
        $this->data['host'] = $this->hostmanager_model->get_host_details($id);
        $this->data['tab'] = 4;
        $this->layout();
    }

    function delete($id) {
        $result = $this->hostmanager_model->delete($id);
        redirect('21232f297a57a5a743894a0e4a801fc3/hostmanager');
    }

}
