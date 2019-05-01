<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class WP_Controller extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('project/project_model');
        $this->load->model('wp_model');
        $this->project = $this->session->userdata('project');
        if (!$this->session->userdata('user_data')) {
            redirect('login');
        }
    }

    function index($id) {

         $this->page = 'public/wp/index_view';
        $this->data['projects'] = $this->project_model->get(array('project_id'=>$id));
        $this->data['wordpress_current_status'] = $this->wp_model->single($id);
        $this->data['title'] = domain_name($this->data['projects']->project_url);
        $this->display_Schedule();
    }

}
