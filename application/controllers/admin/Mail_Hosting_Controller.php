<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Mail_Hosting_Controller extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin/mail_server_model');
    }

    /* ===================================================================================================
     * MAIL HOSTING
     *  Use for listing of mail companies
     * ================================================================================================== */

    function index() {
        $this->page = 'admin/mail_server/index_view';
        $this->data['title'] = 'Mail Host Manager';
        $this->data['mail_hosting'] = $this->mail_server_model->get();
        $this->data['tab'] = 4;
        $this->layout();
    }

    /* ===================================================================================================
     * ADD AND UPADTE
     *  Use for add and update mail company
     * ================================================================================================== */

    function add() {
        $this->page = 'admin/mail_server/add_view';
        $this->data['title'] = 'Add Mail Hosting Details';
        $this->data['tab'] = 4;
        if ($this->input->post()) {
            $this->form_validation->set_rules('mail_company', 'company name', 'required');
            $this->form_validation->set_rules('mail_company_url', 'host company url', 'required');
            if ($this->form_validation->run() == FALSE) {
                return $this->layout();
            } else {
                if ($this->input->post('m_server_id')) {
                    $this->data['data'] = array(
                        'mail_company' => $this->input->post('mail_company'),
                        'mail_company_url' => $this->input->post('mail_company_url'),
                        'comment' => $this->input->post('comment'),
                        'mail_server' => strtoupper(implode(",", $this->input->post('mail_server'))),
                        'updated_at' => date('Y-m-d')
                    );
                    $result = $this->mail_server_model->update($this->input->post('m_server_id'), $this->data['data']);
                    if ($result) {
                        redirect('21232f297a57a5a743894a0e4a801fc3/mail-server');
                    }
                } else {
                    $this->data['data'] = array(
                        'mail_company' => $this->input->post('mail_company'),
                        'mail_company_url' => $this->input->post('mail_company_url'),
                        'comment' => $this->input->post('comment'),
                        'mail_server' => strtoupper(implode(",", $this->input->post('mail_server'))),
                    );
                }
                $result = $this->mail_server_model->save($this->data['data']);
                if ($result) {
                    redirect('21232f297a57a5a743894a0e4a801fc3/mail-server');
                }
            }
        }
        $this->layout();
    }

    /* ===================================================================================================
     * EDIT
     *  Use for link to edit form to update
     * ================================================================================================== */

    function edit($id) {
        $this->page = 'admin/mail_server/edit_view';
        $this->data['title'] = 'Update Mail Hosting Company';
        $this->data['mail_host'] = $this->mail_server_model->single(array('m_server_id' => $id));
        $this->data['tab'] = 4;
        $this->layout();
    }

    /* ===================================================================================================
     * DELETE
     *  Use for delete mal company
     * ================================================================================================== */

    function delete($id) {
        $result = $this->mail_server_model->delete($id);
        redirect('21232f297a57a5a743894a0e4a801fc3/mail-server');
    }

}
