<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Crawl_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'upkepr_crawl_pages';
    }

    // Save crawl data
    public function save($data) {
        return $this->db->insert_batch($this->table, $data);
    }

    // update crawl data status 
    public function update($data) {
        return $this->db->update_batch($this->table, $data, 'crawl_page_id');
    }

    // get crawl data
    public function get() {
        return $this->db->select('*')->where('status', 0)->get($this->table)->result();
    }

    // get crawl data
    public function get_speed_request() {
        return $this->db->select('*')->where('speed_request', 0)->get($this->table)->result();
    }

    // get crawl data
    public function get_responsive_status_crawl($id) {
        return $this->db->select('*')->where('project_id', $id)->get($this->table)->result();
    }


    public function get_avg($id) {
        return $this->db->select('AVG(responsive_status) as avg_responsive_status, AVG(mobile_speed) as avg_mobile_speed, AVG(desktop_speed) as avg_desktop_speed,  SUM(mobile_speed) as total_mobile_speed, SUM(desktop_speed) as total_desktop_speed,  COUNT(speed_request) as total_pages')->where('project_id', $id)->get($this->table)->row();
    }

}
