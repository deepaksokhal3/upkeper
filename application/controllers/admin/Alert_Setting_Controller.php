<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Alert_Setting_Controller extends MY_Controller {

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
        $this->load->model('admin/alert_setting_model');
        $this->load->model('admin/cron_setting_model');
    }

    public function index() {
        $this->page = 'admin/setting/alert/index_view';
        $this->data['tab'] = 7;
        $this->data['title'] = 'Alert Setting';
        $this->data['alerts'] = $this->alert_setting_model->get();
        $this->layout();
    }

    function update() {
        if ($this->input->post()) {
            $data['alert_id'] = $this->input->post('alert_id');
            if ($this->input->post('reminder')):
                $data['reminder_time'] = implode(",", $this->input->post('reminder'));
            endif;
            $data['status'] = ($this->input->post('status')) ? $this->input->post('status') : (!$this->input->post('reminder') ? 0 : 1);
            $res = $this->alert_setting_model->update($data);
            echo ($res) ? json_encode(array('message' => lang_msg('ALERT_SETTING_UPDATE'))) : json_encode(array('error' => lang_msg('ALER_FAILD_UPDATE_SETTING')));
        }
    }

    function cron_frequency() {
        $this->page = 'admin/setting/cron/index_view';
        $this->data['tab'] = 7;
        $this->data['title'] = "Cron Setting";
        $this->data['frequency_speed'] = $this->cron_setting_model->find(array('cron_type' => 1));
        $this->data['frequency_down'] = $this->cron_setting_model->find(array('cron_type' => 2));
        $this->layout();
    }

    function save_frequency() {
        if (!$this->input->post('cron_st_id')) {
            $this->form_validation->set_rules('frequency', 'frequency', 'required');
            if ($this->form_validation->run() == FALSE) {
                
            } else {
                $this->data['data'] = array(
                    'frequency' => $this->input->post('frequency'),
                    'cron_type' => $this->input->post('cron_type')
                );
                $this->cron_setting_model->save($this->data['data']);
            }
        } else {

            $this->data['data'] = array(
                'frequency' => $this->input->post('frequency'),
            );
            $this->cron_setting_model->update($this->input->post('cron_st_id'),$this->data['data']);
        }
        redirect('21232f297a57a5a743894a0e4a801fc3/cron-frequency');
    }

}
