<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Project_model extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->table = 'upkepr_projects';
    }

    /*     * ******************************  ************************************* */

    public function get($start, $limit) {
        return $this->db->select('p.*,up.company_name, up.f_name')
                        ->join('upkepr_user_profile as up', 'up.user_id = p.user_id', 'INNER')
                        ->limit($limit, $start)->order_by('p.project_id','DESC')->get($this->table . ' as p')->result();
    }

    public function total_project() {
        return $this->db->count_all_results($this->table);
    }

    public function get_serach_project($start, $limit, $keyword) {
        return $this->db->select('p.*,up.company_name, up.f_name')
                        ->join('upkepr_user_profile as up', 'up.user_id = p.user_id', 'INNER')
                        ->like('p.project_url', $keyword)
                        ->limit($limit, $start)->order_by('p.project_id','DESC')->get($this->table . ' as p')->result();
    }

    public function filter_project($start, $limit, $keywords) {
        $company_txt = $keywords['company'];
        $project_txt = $keywords['project'];
        $order_by = isset($keywords['orderby'])?$keywords['orderby']:'DESC';
        $this->db->select('p.*,up.company_name, up.f_name');
        $this->db->join('upkepr_user_profile as up', 'up.user_id = p.user_id', 'INNER');
        if ($company_txt)
            $this->db->like('up.company_name', $company_txt);
        if ($project_txt)
            $this->db->like('p.project_url', $project_txt);
        return $this->db->limit($limit, $start)->order_by('p.created_at',$order_by)->get($this->table . ' as p')->result();
    }

    public function total_filter_project($keywords) {
        $company_txt = $keywords['company'];
        $project_txt = $keywords['project'];
        $this->db->join('upkepr_user_profile as up', 'up.user_id = p.user_id', 'INNER');
        if ($company_txt)
            $this->db->like('up.company_name', $company_txt);
        if ($project_txt)
            $this->db->like('p.project_url', $project_txt);
        return $this->db->count_all_results($this->table . ' as p');
    }

    public function get_serach_company_project($start, $limit, $keyword) {
        return $this->db->select('p.*,up.company_name, up.f_name')
                        ->join('upkepr_user_profile as up', 'up.user_id = p.user_id', 'INNER')
                        ->like('up.company_name', $keyword)
                        ->limit($limit, $start)->get($this->table . ' as p')->result();
    }

    public function serach_total_project($keyword) {
        return $this->db->like('project_url', $keyword)->count_all_results($this->table);
    }

    public function serach_total_company_project($keyword) {
        return $this->db->join('upkepr_user_profile as up', 'up.user_id = p.user_id', 'INNER')
                        ->like('up.company_name', $keyword)->count_all_results($this->table . ' as p');
    }

    function move_project($id, $data) {
        return $this->db->where('project_id', $id)->update($this->table, $data);
    }

    public function serch_project($keyword) {
        return $this->db->select('*')->like('project_url', $keyword)->get($this->table)->result();
    }
    
    public function valid($url,$user_id) {
        return $this->db->select('*')->where('project_url', $url)->where('user_id', $user_id)->get($this->table)->row();
    }

}
