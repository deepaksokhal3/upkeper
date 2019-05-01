<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blacklist_Controller extends MY_Controller {

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
        if (!$this->session->userdata('user_data')) {
            redirect('login');
        }
        $this->load->model('blacklist_model');
    }


    public function get($id) {
        $this->load->model('project/project_model');
        $this->data['metatitle'] = 'UpKepr | Blacklisting Report';
        $this->data['blacklist']  = $this->blacklist_model->single($id);
        $this->data['projects'] = $this->project_model->get_project_detail($id);
        $this->data['title'] = domain_name($this->data['projects']['project_url']);
        $this->page = 'public/blacklist/blacklist_view';
        $this->display_Schedule();
    }

}
