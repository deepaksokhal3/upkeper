<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MY_Controller extends CI_Controller{
    
    protected $data = array();
    public function __construct() {
        
        parent::__construct();
        $this->session_data = $this->session->userdata('user_data');
        $this->_redirect =  current_url();
        $this->admin_session = $this->session->userdata('user_admin');
        define("MALWARE_API_KEY","e022850a3a1b675da9591864875adefdbefc038ad80b0a5952686ad6b36c5c7d");
    }
    
    /**=========================================================================
     * Set layout for admin panel
     ===========================================================================*/
    public function layout()
    {
        $this->template['header'] = $this->load->view('templates/_part/master_admin_header',$this->data,TRUE);
        $this->template['top_nav'] = $this->load->view('templates/nav-bar/top-nav-admin',$this->data,TRUE);
        $this->template['footer'] = $this->load->view('templates/_part/master_admin_footer',$this->data,TRUE);
        $this->template['page'] =   $this->load->view($this->page, $this->data, TRUE);
        $this->load->view('admin/main', $this->template);
    }
    
    /**=========================================================================
     * Set layout for Public
     ===========================================================================*/
    public function display_Schedule()
    {   $this->data['critical'] = $this->common_model->get_active_critical_alerts($this->session_data['user_id']);
        $this->data['reguler'] = $this->common_model->get_active_reguler_alerts($this->session_data['user_id']);
        $this->data['new_notifications'] = $this->common_model->get_total_notificarion($this->session_data['user_id']);  
        $this->data['alert_total'] = count($this->data['new_notifications']);
        $this->template['header'] = $this->load->view('templates/_part/master_public_header',$this->data,TRUE);
        $this->template['top_nav'] = $this->load->view('templates/nav-bar/top-nav-public',$this->data,TRUE);
        $this->template['footer'] = $this->load->view('templates/_part/master_public_footer',$this->data,TRUE);
        $this->template['page'] =   $this->load->view($this->page, $this->data, TRUE);
        $this->load->view('public/main', $this->template);
        
    }

        /**=========================================================================
     * Set layout for login and sign up
     ===========================================================================*/
    public function display_login()
    {
        $this->template['header'] = $this->load->view('templates/_part/master_public_header',$this->data,TRUE);
        $this->template['top_nav'] = '';
        $this->template['footer'] = '';//$this->load->view('templates/_part/master_public_footer',$this->data,TRUE);
        $this->template['page'] =   $this->load->view($this->page, $this->data, TRUE);
        $this->load->view('public/main', $this->template);
        
    }
    
    
}