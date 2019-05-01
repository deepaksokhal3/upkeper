<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Speed_Controller extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('project/project_model');
         $this->load->model('crawl_model');
        $this->project = $this->session->userdata('project');
        if (!$this->session->userdata('user_data')) {
            redirect('login');
        }
    }

    function index($project_id) {
        $this->page = 'public/speed/index_view';
        $this->data['project'] = $this->project_model->get(array('project_id'=>$project_id));
        $this->data['title'] = "Speed Status";
        $this->data['speed'] =  $this->crawl_model->get_responsive_status_crawl($project_id);
        $this->data['avg_status'] =  $this->crawl_model->get_avg($project_id);
        $this->display_Schedule();
    }

   

}
