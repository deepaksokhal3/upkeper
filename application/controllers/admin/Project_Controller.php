<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Project_Controller extends MY_Controller {

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
        $this->load->library('pagination');
        $this->load->model('admin/project_model');
        $this->limit = 50;
    }

//    function index() {
//        $this->page = 'admin/project/index_view';
//        $this->data['title'] = 'Projects';
//        $this->data['total'] = $total = $this->project_model->total_project();
//        $start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
//        $num_link = $total / $this->limit;
//        $this->data['projects'] = $this->project_model->get($start, $this->limit);
//        $config1 = $this->config_pagination($total, $this->limit, $num_link, 4);
//        $this->pagination->initialize($config1);
//        $this->data["links"] = $this->pagination->create_links();
//        $this->data['tab'] = 8;
//        $this->layout();
//    }

    function pagination_project() {
        $this->page = 'admin/project/index_view';
        $this->data['title'] = 'Projects';
        $this->data['total'] = $total = $this->project_model->total_project();
        $start = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) * $this->limit : 0;
        $num_link = $total / $this->limit;
        $this->data['projects'] = $this->project_model->get($start, $this->limit);
        $config1 = $this->config_pagination($total, $this->limit, $num_link, 4);
        $this->pagination->initialize($config1);
        $this->data["links"] = $this->pagination->create_links();
        $this->data['tab'] = 8;
        $this->layout();
    }

    function search_project() {
        if ($this->input->is_ajax_request()) {
            $data = $this->project_model->serch_project($this->input->get('keyword'));
            echo ($data) ? json_encode(array('status' => true, 'data' => $data)) : json_encode(array('status' => false, "data" => 'No record found'));
        }
    }

    function search_user() {
        if ($this->input->is_ajax_request()) {
            $data = $this->common_model->serach_user($this->input->get('company'));
            echo ($data) ? json_encode(array('status' => true, 'data' => $data)) : json_encode(array('status' => false, "data" => 'No record found'));
        }
    }

    function move_project() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->get('project_id') && $this->input->get('user_id')) {
                $data['user_id'] = $this->input->get('user_id');
                $check_valid = $this->project_model->valid($this->input->get('url'),$this->input->get('user_id'));

                if (empty($check_valid)) {
                    $res = $this->project_model->move_project($this->input->get('project_id'), $data);
                    echo ($res) ? json_encode(array('status' => "success", 'message' => sprintf($this->lang->line('SUCCESS_NOTICE_ALERT'), 'Project successfully moved'))) : json_encode(array('status' => "error", 'message' => sprintf($this->lang->line('DANDER_ALERT'), 'Please try again some technical issues is occurred.')));
                }else{
                   echo json_encode(array('status' => "error", 'message' => sprintf($this->lang->line('DANDER_ALERT'),'Domain already exist.'))); 
                }
            } else {
                echo json_encode(array('status' => "error"));
            }
        }
    }

    function config_pagination($total, $limit, $num_link, $segment) {
        $config['base_url'] = site_url('21232f297a57a5a743894a0e4a801fc3/projects');
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $config["uri_segment"] = 3;

        // custom paging configuration
        $config['num_links'] = $num_link;
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        //$config['anchor_class'] = 'class="page-link"';
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = 'First Page';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last Page';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '<span aria-hidden="true" class="la la-caret-right"></span><span class="sr-only">Next</span>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '<span aria-hidden="true" class="la la-caret-left"></span><span class="sr-only">Previous</span>';
        $config['prev_tag_open'] = ' <li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = ' <li class="page-item page-link active">';
        $config['cur_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        return $config;
    }

    function get_search_project() {
        if ($this->input->is_ajax_request()) {
            $this->page = 'admin/project/serach-project-tbl';
            $this->data['total'] = $total = $this->project_model->serach_total_project($this->input->get('keyword'));
            $start = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) * $this->limit : 0;
            $num_link = $total / $this->limit;
            $this->data['projects'] = $this->project_model->get_serach_project($start, $this->limit, $this->input->get('keyword'));
            $config1 = $this->config_pagination($total, $this->limit, $num_link, 4);
            $this->pagination->initialize($config1);
            $this->data["links"] = $this->pagination->create_links();
            echo ($total > 0) ? json_encode(array('status' => 'success', 'message' => $this->load->view('admin/project/serach-project-tbl', $this->data, true))) : json_encode(array('error' => 'success', 'message' => $this->load->view('admin/project/serach-project-tbl', $this->data, true)));
        }
    }

    function get_project() {
        if ($this->input->is_ajax_request()) {
            $this->page = 'admin/project/serach-project-tbl';
            $this->data['total'] = $total = $this->project_model->total_filter_project($this->input->get());

            $start = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) * $this->limit : 0;
            $num_link = $total / $this->limit;
            $this->data['projects'] = $this->project_model->filter_project($start, $this->limit, $this->input->get());
            //print_r($this->data['projects']);die;
            $config1 = $this->config_pagination($total, $this->limit, $num_link, 4);
            $this->pagination->initialize($config1);
            $this->data["links"] = $this->pagination->create_links();
            echo ($total > 0) ? json_encode(array('status' => 'success', 'links' => $this->data["links"], 'message' => $this->load->view('admin/project/serach-project-tbl', $this->data, true))) : json_encode(array('error' => 'success', 'message' => $this->load->view('admin/project/serach-project-tbl', $this->data, true)));
        }
    }

    function get_search_company_project() {
        if ($this->input->is_ajax_request()) {
            $this->page = 'admin/project/serach-project-tbl';
            $this->data['total'] = $total = $this->project_model->serach_total_company_project($this->input->get('keyword'));
            $start = ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) * $this->limit : 0;
            $num_link = $total / $this->limit;
            $this->data['projects'] = $this->project_model->get_serach_company_project($start, $this->limit, $this->input->get('keyword'));
            $config1 = $this->config_pagination($total, $this->limit, $num_link, 4);
            $this->pagination->initialize($config1);
            $this->data["links"] = $this->pagination->create_links();
            echo ($total > 0) ? json_encode(array('status' => 'success', 'message' => $this->load->view('admin/project/serach-project-tbl', $this->data, true))) : json_encode(array('error' => 'success', 'message' => $this->load->view('admin/project/serach-project-tbl', $this->data, true)));
        }
    }

}
