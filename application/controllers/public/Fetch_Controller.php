<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fetch_Controller extends MY_Controller {

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
        $this->load->model('cron_model');
        $this->load->model('project/project_model');
        $this->data['queue_projects'] = $this->project_model->get_queue_projects();
    }

    /*     * ************************************** Fetch  project speed info *************************************** */

    function fetch_site_speed($id) {
        $project = $this->common_model->get_project_detail($id);
        $save_date = array();
        $existing_info = $this->project_model->get_project_speed_info($project->project_id); // check speed info exist
        $project_url = $project->project_url;
        try {
            $googleApi = "https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=$project_url&key=AIzaSyDMYlOv5CUPrT4gSHLx5TJ0ZmtMB4w4Zxs";
            $speed_info = file_get_contents($googleApi); // get website speed info from google api
            $this->data['speed_info'] = array(
                'project_id' => $project->project_id,
                'speed_info' => $speed_info,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            if (!$existing_info) {
                $result = $this->project_model->save_project_speed_info($this->data['speed_info']);
                if ($result) {
                    $this->data['queue_status'] = array(
                        'speed_status' => 1,
                        'updated_at' => date('Y-m-d h:i:s')
                    );
                    $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                }
            } else {
                unset($this->data['speed_info']['created_at']);
                $this->cron_model->update_speed_info($existing_info->speed_id, $this->data['speed_info']);
                echo json_encode(array('last_update' => date('d M Y'), 'ago' => time_elapsed_string(date('Y-m-d H:i:s'))));
            }
        } catch (Exception $e) {
            //   print_r($e);
        }

        echo json_encode(array('last_update' => date('d M Y'), 'ago' => time_elapsed_string(date('Y-m-d H:i:s'))));
    }

    /*     * ************************************** Fetch  project responsive info ************************************** */

    function fetch_responsive_pages($id) {
        $project = $this->common_model->get_project_detail($id);
        $project_url = $project->project_url;
        try {
            // Save and check responsive
            $mobile_friendly = "https://www.googleapis.com/pagespeedonline/v3beta1/mobileReady?url=$project_url";
            $mobile = file_get_contents($mobile_friendly);
            $m = json_decode($mobile);
            $friendly_status = isset($m->ruleGroups->USABILITY->pass) ? $m->ruleGroups->USABILITY->pass : 0;
            $img = preg_replace('#^data:image/\w+;base64,#i', '', str_replace("-", "+", str_replace("_", "/", $m->screenshot->data)));
            $decoded = base64_decode($img);
            $name = "assets/photo/screenshot/m_" . $project->project_id . '_' . strtotime(date('Y-m-d H:i:s')) . 'jpg';
            $success = file_put_contents($name, $decoded);
            if (isset($success)) {
                $this->data['res_info'] = array(
                    'project_id ' => $project->project_id,
                    'screenshot' => $name,
                    'status' => $friendly_status,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
            }
            $check_existing = $this->project_model->check_screenshot($id);
            if ($check_existing) {
                $this->project_model->update_responsibilty($id, $this->data['res_info']);
                echo json_encode(array('last_update' => date('d M Y'), 'ago' => time_elapsed_string(date('Y-m-d H:i:s'))));
            } else {
                $result = $this->project_model->save_responsibilty($this->data['res_info']);
            }
            if ($result) {
                $this->data['queue_status'] = array(
                    'responsive_status' => 1,
                    'updated_at' => date('Y-m-d-h:i:s')
                );
                $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                echo json_encode(array('last_update' => date('d M Y'), 'ago' => time_elapsed_string(date('Y-m-d H:i:s'))));
            }
        } catch (Exception $e) {
            // print_r($e);
        }
    }

    /*     * *********************************************** Fetch blacklist websites *********************************** */

    function fetch_blacklist($id) {
        $project = $this->common_model->get_project_detail($id);
        $save_date = array();
        $bl_report = $this->project_model->get_blacklist_current_info($project->project_id);
        $project_url = $project->project_url;
        try {
            $url_send = "https://safebrowsing.googleapis.com/v4/threatMatches:find?key=AIzaSyDnFc8wXwl9BC2pw2uz00Y6eMFRliT8VSs";
            $data = '{"client": {
                                    "clientId": "TestClient",
                                    "clientVersion": "1.0"
                                  },
                                  "threatInfo": {
                                    "threatTypes":      ["MALWARE", "SOCIAL_ENGINEERING"],
                                    "platformTypes":    ["LINUX"],
                                    "threatEntryTypes": ["URL"],
                                    "threatEntries": [
                                      {"url": "' . $project_url . '"}
                                    ]
                                  }
                                }';
            $googleRes = json_decode($this->sendPostData($url_send, $data));

            $url = domain_name($project_url);
            exec("nslookup $url", $ip);
            $IP = explode(":", $ip[5])[1];
            exec("bl $IP", $output);
            $blacklist_check = blacklist_engine();
            $result = array_combine($blacklist_check, $output);
            if (isset($googleRes->matches[0]->threatType) && $googleRes->matches[0]->threatType == 'MALWARE') {
                $merge_arra['google'] = 'blacklisted';
                $result = array_merge($merge_arra, $result);
            } else {
                $merge_arra['google'] = 'not_listed';
                $result = array_merge($merge_arra, $result);
            }

            $this->data['black_list'] = array(
                'blacklist_data' => json_encode($result),
                'status' => 1,
                'project_id' => $project->project_id,
                'updated_at' => date('Y-m-d H:i:s')
            );
            if (!$bl_report) {
                $this->data['queue_status'] = array(
                    'blacklist_status' => 1,
                    'updated_at' => date('Y-m-d-h:i:s')
                );
                $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                $this->cron_model->save_blacklist_checked($this->data['black_list']);
                echo json_encode(array('last_update' => date('d M Y'), 'ago' => time_elapsed_string(date('Y-m-d H:i:s'))));
            } else {
                $this->cron_model->update_blacklist_checked($bl_report[0]->black_id, $this->data['black_list']);
                echo json_encode(array('last_update' => date('d M Y'), 'ago' => time_elapsed_string(date('Y-m-d H:i:s'))));
            }
        } catch (Exception $e) {
            // print_r($e);
        }
    }

    /*     * ************************* Send email to company when any website is down ************************************ */

    public function fetch_uptime_status($id) {
        $project = $this->common_model->get_project_detail($id);
        $hit_response = array();
        try {
            $http_responce = array();
            $ch = curl_init($project->project_url);
            curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
            curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_exec($ch);
            $info = curl_getinfo($ch);

            $http_responce['status_code'] = $info['http_code'];
            $http_responce['up_time'] = $info['namelookup_time'];
            $http_responce['local_ip'] = $info['local_ip'];
            $http_responce['primary_id'] = $info['primary_ip'];
            $http_responce['primary_port'] = $info['primary_port'];
            curl_close($ch);
            if (isset($http_responce)) {
                $hit_response[] = array(
                    'project_url' => $project->project_url,
                    'project_id' => $project->project_id,
                    'user_id' => $project->user_id,
                    'status_code' => $http_responce['status_code'],
                    'http_data' => serialize($http_responce),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
            }
        } catch (Exception $e) {
            //   print_r($e);
        }
        if ($hit_response) {
            $this->cron_model->save_down_time($hit_response);
            echo json_encode(array('last_update' => date('d M Y'), 'ago' => time_elapsed_string(date('Y-m-d H:i:s'))));
        }
    }

    /*     * *************************************************************************************
     * WORDPRESS
     * SAVE ALL OVER ONLY UPDATED INFO
     * ************************************************************************************* */

    function fetch_wp_status($id) {
        $project = $this->common_model->get_project_detail($id);
        $save_date = array();
        $project_url = $project->project_url;
        $exist_wp = $this->project_model->get_wp_current_info($id);
        try {
            $request = $project_url . '/wp-content/plugins/cWebCo-Maintenance/public/template/wp_over_all_info.php';
            $update_info = file_get_contents($request);

            $this->data['wp_info'] = array(
                'wp_all_status' => $update_info,
                'project_id' => $project->project_id
            );
            $this->data['queue_status'] = array(
                'wp_status' => 1,
                'updated_at' => date('Y-m-d-h:i:s')
            );
            if (isset($exist_wp[0]->wp_id)) {
                $this->cron_model->update_wp_info($id, $this->data['wp_info']);
            } else {
                $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                $this->cron_model->save_wp_info($this->data['wp_info']);
            }
        } catch (Exception $e) {
            
        }
    }

    /*     * ************************************** update  project domain info *************************************** */

    function fetch_domain_status($id) {
        $project = $this->common_model->get_project_detail($id);
        $project_url = $project->project_url;
        try {
            //Save project domain  info section
            $url = domain_name($project_url);
            $domain_info = $this->get_domain_info($url);
            $dns = '';
             $this->project_model->delete_host_info($id);
            foreach (json_decode($domain_info)->DNS as $server_n) {
                if ($dns)
                    $dns.= ',' . $server_n->Name_Server;
                else
                    $dns.= $server_n->Name_Server;
            }
            $param['dns'] = $dns;
            $param['project_url'] = $project_url;
            $param['project_id'] = $id;
            $save_host_url = site_url('admin/Cron_job/update_project_host_info');
            curl_post_async($save_host_url, $param);
            $this->data['domain'] = array(
                'domain_name ' => $url,
                'project_id' => $project->project_id,
                'status' => 1,
                'domain_info' => $domain_info,
                'created_at' => date('Y-m-d-h:i:s'),
                'updated_at' => date('Y-m-d-h:i:s')
            );
            $existing_domain = $this->project_model->get_domain_info($id);
            if ($existing_domain) {
                $this->project_model->update_domain_info($id, $this->data['domain']);
            } else {
                $result = $this->project_model->save_domain_info($this->data['domain']);
                if ($result) {
                    $this->data['queue_status'] = array(
                        'domain_status' => 1,
                        'updated_at' => date('Y-m-d-h:i:s')
                    );
                    $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                }
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }

    /*     * ************************************* update  project Host info *************************************** */

    function update_project_host_info() {
        try {
            $url = domain_name($this->input->post('project_url'));
            exec("nslookup $url", $ip);
            $IP = explode(":", $ip[5])[1];
            $dns = explode(",", $this->input->post('dns'));
            foreach ($dns as $dns_name) {
                $this->data['host'][] = array(
                    'host_name ' => $url,
                    'project_id' => $this->input->post('project_id'),
                    'status' => 1,
                    'Host_IP' => $IP,
                    'DNS' => $dns_name,
                    'created_at' => date('Y-m-d-h:i:s'),
                    'updated_at' => date('Y-m-d-h:i:s')
                );
            }
           
            $result = $this->project_model->save_host_info($this->data['host']);
//            if ($result) {
//                $this->data['queue_status'] = array(
//                    'host_status' => 1,
//                    'updated_at' => date('Y-m-d-h:i:s')
//                );
//                $this->project_model->update_queue_status($this->input->post('queue_id'), $this->data['queue_status']);
//            }
        } catch (Exception $e) {
            print_r($e);
        }
    }

    function get_domain_info($domain) {

        $lines = explode("\n", domain_info($domain));
        $array = array();
        $key_value = '';
        foreach ($lines as $line) {
            $key_value = '';
            foreach (domain_fields() as $field) {
                if (strpos($line, $field) !== false) {
                    $key_value = $field;
                }
            }
            if ($key_value) {
                $val = explode($key_value, $line);
                if (strpos($key_value, 'Registrant') !== false) {
                    $sub_key = 'Registrant';
                } else if (strpos($key_value, 'Admin') !== false) {
                    $sub_key = 'Admin';
                } else if (strpos($key_value, 'Tech') !== false) {
                    $sub_key = 'Technical';
                } else if (strpos($key_value, 'Name Server') !== false) {
                    $sub_key = 'DNS';
                } else {
                    $sub_key = 'General';
                }
                $key_value = str_replace(" ", "_", str_replace(":", "", $key_value));
                if ($sub_key == 'DNS') {
                    $array[$sub_key][][$key_value] = $val[1];
                } else {
                    $array[$sub_key][$key_value] = $val[1];
                }
            }
        }
        return json_encode($array);
    }

    function fetch_website_info($id) {
        $this->fetch_uptime_status($id);
        $this->fetch_blacklist($id);
        $this->fetch_responsive_pages($id);
        $this->fetch_site_speed($id);
        $this->fetch_wp_status($id);
        $this->fetch_domain_status($id);
        echo true;
        exit;
    }
    


    function sendPostData($url, $post) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", 'Content-Length: ' . strlen($post)));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        return $result;
    }

}
