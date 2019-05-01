<?php

use Screen\Capture;

require_once (__DIR__ . '/../../../capture/vendor/autoload.php');
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_job extends CI_Controller {

    /**
     * Index Page for this controller.
     * Since this controller is set as the default controller in
     * So any other public methods not prefixed with an underscore will

     */
//$text = '[This] is a [test] string, [eat] my [shorts].';
//preg_match_all("/\[[^\]]*\]/", $text, $matches);
//var_dump($matches[0]);

    function __construct() {
        parent::__construct();
        $this->load->model('cron_model');
        $this->load->model('project/project_model');
        $this->load->model('admin/mail_server_model');
        $this->load->model('email_model');
        $this->load->model('crawl_model');
        $this->load->model('mx_model');

        $this->data['queue_projects'] = $this->project_model->get_queue_projects();
    }

    /*     * ************************************ get template content for down time ************************************ */

    function get_temp_data($temp, $user_id, $project_url, $expire, $speed, $plugins) {

        $uesr = $this->common_model->get_uesr($user_id);
        $uesr['site_url'] = "<a href='" . $project_url . "'>" . $project_url . "</a>";
        $uesr['expire_date'] = $expire;
        $uesr['speed'] = $speed;
        $uesr['plugin_list'] = $plugins;
        preg_match_all("/\[([^\]]*)\]/", $temp, $matches);
        $this->data['email_temp'] = preg_replace_callback("/\[([^\]]*)\]/i", function($m) use($uesr) {
            return $uesr[$m[1]];
        }, $temp);
        $this->data['user'] = $uesr;
        return $this->data;
    }

    /*     * ************************* Send email to company when any website is down ************************************ */

    public function downTime($project) {
        $hit_response = array();
        try {
            if ($project->blacklist_status == 0) {
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
            }
        } catch (Exception $e) {
            print_r($e);
        }
        if ($hit_response)
            $this->cron_model->save_down_time($hit_response);
    }

    /*     * ************************************** update  project ssl info *************************************** */

    function sent_ssl_expire_alert() {
        $projects = $this->cron_model->get_projects();
        $save_date = array();
        if (!empty($projects)) {
            foreach ($projects as $project) {
                $project_url = $project->project_url;
                try {
                    $certinfo = get_ssl_detail($project_url);
                    if ($certinfo) {
                        $expirey_date = date('Y-m-d h:i:s    ', $certinfo['validTo_time_t']); // ssl expire on 
                        $current_date = date('Y-m-d H:i:s');
                        $domain_expire_date = date('Y-m-d H:i:s', strtotime($expirey_date));
                        $d_start = new DateTime($current_date);
                        $d_end = new DateTime($domain_expire_date);
                        $diff = $d_start->diff($d_end);
                        $this->day = $diff->format('%a');
                        if ($this->day < 90) {
                            $web_alert = sprintf($this->lang->line('SSL_EXPIRE_MONTHLY'), date('d M Y', strtotime($expirey_date)));
                            $save_date[] = array(
                                'alert_id' => '',
                                'project_id' => $project->project_id,
                                'user_id' => $project->user_id,
                                'created_at' => date('Y-m-d'),
                                'alert_type' => 11,
                                'message' => '',
                                'receiver_type' => 'critical',
                                'expire_date' => $expirey_date,
                                'web_alert' => $web_alert
                            );
                        }
                    }
                } catch (Exception $e) {
                    print_r($e);
                }
            }
            if ($save_date) {
                $this->cron_model->save_sent_alerts($save_date);
            }
        }
    }

    function sent_expire_domain_alert($id) {
        $save_date = array();
        $domains = $this->cron_model->get_domain_info($id);
        foreach ($domains as $domain) {
            try {
                $domain_info = json_decode($domain->domain_info);
                if (isset($domain_info->General->Registry_Expiry_Date) && !empty($domain_info->General->Registry_Expiry_Date)) {
                    $current_date = date('Y-m-d H:i:s');
                    $domain_expire_date = date('Y-m-d H:i:s', strtotime($domain_info->General->Registry_Expiry_Date));
                    $d_start = new DateTime($current_date);
                    $d_end = new DateTime($domain_expire_date);
                    $diff = $d_start->diff($d_end);
                    $this->day = $diff->format('%a');
                    if ($this->day < 90) {
                        $web_alert = sprintf($this->lang->line('DOMAIN_EXPIRE_MONTHLY'), date('d M Y', strtotime($domain_info->General->Registry_Expiry_Date)));
                        $save_date[] = array(
                            'alert_id' => '',
                            'project_id' => $domain->project_id,
                            'user_id' => $domain->user_id,
                            'created_at' => date('Y-m-d'),
                            'alert_type' => 7,
                            'receiver_type' => 'critical',
                            'expire_date' => $domain_info->General->Registry_Expiry_Date,
                            'web_alert' => $web_alert
                        );
                    }
                }
            } catch (Exception $rr) {
                
            }
        }
        if ($save_date) {
            $this->cron_model->save_sent_alerts($save_date);
        }
    }

    /*     * ************************************** update  project speed info *************************************** */

    function update_project_speed_info($project) {
        $this->load->model('admin/cron_setting_model');
        $save_date = array();
        $existing_info = $this->project_model->get_project_speed_info($project->project_id); // check speed info exist
        $project_url = $project->project_url;
        if ($project->speed_status == 0) {
            try {
                $this->data['queue_status'] = array('speed_status' => 2);
                $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                $googleApi = "https://www.googleapis.com/pagespeedonline/v4/runPagespeed?url=$project_url&key=AIzaSyBZjMGZS8wyNduKUtMbnY5VIwA2lspZoIo";
                $desktop = file_get_contents($googleApi); // get website speed info  for desktop

                $mobileUrl = "https://www.googleapis.com/pagespeedonline/v4/runPagespeed?url=$project_url&strategy=mobile&key=AIzaSyBZjMGZS8wyNduKUtMbnY5VIwA2lspZoIo";
                $mobile = file_get_contents($mobileUrl); // get website speed info  for Mobile

                $decode_desktop_speed = json_decode($desktop)->ruleGroups->SPEED->score;
                $decode_mobile_speed = json_decode($mobile)->ruleGroups->SPEED->score;

                $this->data['speed_info'] = array(
                    'project_id' => $project->project_id,
                    'mobile_speed' => $decode_mobile_speed,
                    'desktop_speed' => $decode_desktop_speed,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                if (!$existing_info) {
                    $result = $this->project_model->save_project_speed_info($this->data['speed_info']);
                    if ($result) {
                        $this->data['queue_status'] = array('speed_status' => 1, 'updated_at' => date('Y-m-d h:i:s'));
                        $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                    }
                    $speed = json_decode($desktop)->ruleGroups->SPEED->score;
                    $frequency = $this->cron_setting_model->find(array('cron_type' => 1));
                    if ($speed <= $frequency->frequency) {
                        $web_alert = sprintf($this->lang->line('SPEED_SCORE'), $speed);
                        $save_date[] = array(
                            'project_id' => $project->project_id,
                            'user_id' => $project->user_id,
                            'created_at' => date('Y-m-d'),
                            'alert_type' => 10,
                            'speed_score' => $speed,
                            'receiver_type' => 'reguler',
                            'web_alert' => $web_alert
                        );
                    }
                } else {
                    unset($this->data['speed_info']['created_at']);
                    $this->cron_model->update_speed_info($existing_info->speed_id, $this->data['speed_info']);
                    $this->data['queue_status'] = array('speed_status' => 1);
                    $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                }
            } catch (Exception $e) {
                print_r($e);
            }
        }
        if ($save_date) {
            $this->cron_model->save_sent_alerts($save_date);
        }
    }

    /*     * ************************************** update  project responsive info ************************************** */

    function update_project_responsive_info($project) {

        $project_url = $project->project_url;
        if ($project->responsive_status == 0) {
            try {
                $this->data['queue_status'] = array('responsive_status' => 2);
                $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                $mobile_friendly = "https://www.googleapis.com/pagespeedonline/v3beta1/mobileReady?url=$project_url";

                $mobile = file_get_contents($mobile_friendly);
                $m = json_decode($mobile);
                $friendly_status = isset($m->ruleGroups->USABILITY->pass) ? $m->ruleGroups->USABILITY->pass : 0;
                $this->data['res_info'] = array(
                    'project_id ' => $project->project_id,
                    'screenshot' => '',
                    'status' => $friendly_status,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $result = $this->project_model->save_responsibilty($this->data['res_info']);
                if ($result) {
                    $this->data['queue_status'] = array('responsive_status' => 1, 'updated_at' => date('Y-m-d-h:i:s'));
                    $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                }
            } catch (Exception $e) {
                print_r($e);
            }
        }
    }

    /*     * ************************************** update  project ssl info *************************************** */

    function update_project_ssl_info($project) {
        $project_url = $project->project_url;
        if ($project->ssl_status == 0) {
            try {
                $this->data['queue_status'] = array('ssl_status' => 2);
                $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                $certinfo = get_ssl_detail($project_url);
                if ($certinfo) {
                    $valid_to = (isset($certinfo['validTo_time_t']) && $certinfo['validTo_time_t']) ? date('Y-m-d h:i:s', $certinfo['validTo_time_t']) : '';
                    $this->data['ssl_info'] = array(
                        'valid_from ' => date('Y-m-d h:i:s', $certinfo['validFrom_time_t']),
                        'valid_to' => $valid_to,
                        'project_id' => $project->project_id,
                        'status' => 1,
                        'tls' => $this->check_tsl(domain_name($project_url)),
                        'project_url' => $project_url,
                        'sr_number' => $certinfo['serialNumber'],
                        'KeyIdentifier' => $certinfo['extensions']['subjectKeyIdentifier'],
                        'created_at' => date('Y-m-d-h:i:s')
                    );
                } else {
                    $this->data['ssl_info'] = array(
                        'project_id' => $project->project_id,
                        'status' => 0,
                        'tls' => $this->check_tsl(domain_name($project_url)),
                        'project_url' => $project_url,
                        'created_at' => date('Y-m-d-h:i:s')
                    );
                }
                $result = $this->project_model->save_ssl_info($this->data['ssl_info']);
                if ($result) {
                    $this->data['queue_status'] = array('ssl_status' => 1, 'updated_at' => date('Y-m-d-h:i:s'));
                    $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                }
                $this->sent_ssl_expire_alert();
            } catch (Exception $e) {
                print_r($e);
            }
        }
    }

    function check_tsl($domain) {
        exec("nmap --script ssl-enum-ciphers -p 443 $domain | grep TLS", $output);
        $array = array();
        $version = '';
        foreach ($output as $line) {
            $line = str_replace("|", "", $line);
            if (strpos($line, '-') !== false) {
                $array[$version][] = explode("-", $line)[1];
            } else {
                $version = trim($line);
            }
        }
        return json_encode($array);
    }

    /*     * ************************************** GET HOST dns RECORDS(SERVER NAMES) *************************************** */

    function get_dns_records($project) {
        $url = domain_name($project->project_url);
        try {
            if ($project->host_status == 0) {
                $this->data['queue_status'] = array('host_status' => 2, 'updated_at' => date('Y-m-d-h:i:s'));
                $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                $this->data['host'] = array();
                $records = dns_get_record($url, DNS_NS); // Get dns RECORDS
                $ipData = dns_get_record($url, DNS_A); // GET IP ADDRESS
                $IP = isset($ipData[0]['ip']) ? $ipData[0]['ip'] : '';
                $dns = '';
                if ($records) {
                    $counter = count($records) - 1;
                    foreach ($records as $key => $record) {
                        $separate = ($counter > $key) ? ',' : '';
                        $dns .= '' . strtoupper($record['target']) . $separate;
                    }
                }
                $this->data['host'][] = array(
                    'project_id' => $project->project_id,
                    'status' => 1,
                    'host_ip' => $IP,
                    'dns' => $dns,
                    'host_company' => '',
                    'company_url' => '',
                    'host_name' => '',
                    'created_at' => date('Y-m-d-h:i:s'),
                    'updated_at' => date('Y-m-d-h:i:s')
                );
                $this->project_model->delete_host_info($project->project_id);
                $result = $this->project_model->save_host_info($this->data['host']);
                if ($result) {
                    $this->data['queue_status'] = array('host_status' => 1, 'updated_at' => date('Y-m-d-h:i:s'));
                    $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                }
            }
        } catch (Exception $e) {
            
        }
    }

    /*     * ************************************** update  project domain info *************************************** */

    function update_project_domain_info($project) {
        $this->load->library('whois');
        $this->data['domain'] = array();
        $project_url = $project->project_url;
        if ($project->domain_status == 0) {
            try {
                $this->data['queue_status'] = array('domain_status' => 2, 'updated_at' => date('Y-m-d-h:i:s'));
                $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                $url = domain_name($project_url);
                $domain_info = $this->whois->LookupDomain($url); // GET DOMAIN INFO=
                if (!empty($domain_info)) {
                    $this->data['domain'] = array(
                        'domain_name ' => $url,
                        'project_id' => $project->project_id,
                        'status' => 1,
                        'domain_info' => $domain_info,
                        'created_at' => date('Y-m-d-h:i:s'),
                        'updated_at' => date('Y-m-d-h:i:s')
                    );
                    $existing_domain = $this->project_model->get_domain_info($project->project_id);
                    if ($existing_domain) :
                        $result = $this->project_model->update_domain_info($project->project_id, $this->data['domain']);
                    else:
                        $result = $this->project_model->save_domain_info($this->data['domain']);
                    endif;
                    if ($result) {
                        $this->data['queue_status'] = array('domain_status' => 1, 'updated_at' => date('Y-m-d-h:i:s'));
                        $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                    }
                }
                $this->sent_expire_domain_alert($project->project_id);
            } catch (Exception $e) {
                print_r($e);
            }
        }
    }

    function capture($project) {

        $project_url = $project->project_url;
        if ($project->screenshot == 0) {
            try {
                $this->data['queue_status'] = array(
                    'screenshot' => 1,
                    'updated_at' => date('Y-m-d-h:i:s')
                );
                $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                require_once (__DIR__ . '/../../../capture/vendor/autoload.php');
                $name = $project->project_id;
                $screenCapture = new Capture();
                $screenCapture->setUrl($project->project_url);

                $screenCapture->setWidth(1500);
                $screenCapture->setClipWidth(1500);
                $screenCapture->setClipHeight(800);
                $screenCapture->setLeft(10);
                $screenCapture->setImageType('jpg');
                $fileLocation1 = __DIR__ . '/../../../assets/photo/screenshot/' . $name . '-desktop.' . $screenCapture->getImageType()->getFormat();
                $screenCapture->save($fileLocation1);

                $screenCapture->jobs->clean();
                $screenCapture->setWidth(412);
                $screenCapture->setClipWidth(412);
                $screenCapture->setClipHeight(790);
                $screenCapture->setImageType('jpg');
                $fileLocation2 = __DIR__ . '/../../../assets/photo/screenshot/' . $name . '-mobile.' . $screenCapture->getImageType()->getFormat();
                $screenCapture->save($fileLocation2);

                $screenCapture->jobs->clean();
                $screenCapture->setWidth(768);
                $screenCapture->setClipWidth(768);
                $screenCapture->setClipHeight(790);
                $screenCapture->setImageType('jpg');

                $fileLocation3 = __DIR__ . '/../../../assets/photo/screenshot/' . $name . '-tablet.' . $screenCapture->getImageType()->getFormat();
                $screenCapture->save($fileLocation3);
                $screenCapture->jobs->clean();
            } catch (Exception $r) {
                
            }
        }
    }

    /*     * ************************************************ CHECK MALWARE *************************************************** */

    function check_malware($project) {
        $this->load->model('malware_model');

        $project_url = $project->project_url;
        if ($project->malware_status == 0) {
            $this->data['queue_status'] = array('malware_status' => 2);
            $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
            try {
                $url_send = "https://safebrowsing.googleapis.com/v4/threatMatches:find?key=AIzaSyDnFc8wXwl9BC2pw2uz00Y6eMFRliT8VSs";
                $data = '{"client": { "clientId": "TestClient", "clientVersion": "1.0" }, "threatInfo": {"threatTypes":      ["MALWARE", "SOCIAL_ENGINEERING"], "platformTypes":["LINUX"], "threatEntryTypes":["URL"],"threatEntries":[ {"url":"' . $project_url . '"}]}}';
                $googleRes = json_decode($this->sendPostData($url_send, $data));

                $malware_data = array(
                    'project_id' => $project->project_id,
                    'check_status' => (isset($googleRes->matches[0]->threatType) && $googleRes->matches[0]->threatType == 'MALWARE') ? 1 : 0
                );
                if (isset($googleRes->matches[0]->threatType) && $googleRes->matches[0]->threatType == 'MALWARE') :
                    $web_alert = sprintf($this->lang->line('MALWARE'));
                    $save_date[] = array(
                        'project_id' => $project->project_id,
                        'user_id' => $project->user_id,
                        'created_at' => date('Y-m-d'),
                        'alert_type' => 15,
                        'receiver_type' => 'reguler',
                        'blacklist_status' => 1,
                        'web_alert' => $web_alert
                    );
                    if ($save_date) {
                        $this->cron_model->save_sent_alerts($save_date);
                    }
                endif;
                $this->malware_model->save($malware_data);
                $this->data['queue_status'] = array('malware_status' => 1);
                $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
            } catch (Exception $e) {
                
            }
        }
    }

    /*     * ************************************************ END *************************************************** */

    function check_blacklist($project) {
        $save_date = array();
        $this->load->model('blacklist_model');
        $bl_report = $this->blacklist_model->single($project->project_id);
        $project_url = $project->project_url;
        if ($project->blacklist_status == 0) {
            try {
                $this->data['queue_status'] = array(
                    'blacklist_status' => 2,
                    'updated_at' => date('Y-m-d-h:i:s')
                );
                $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);

                $url = domain_name($project_url);
                $ipData = dns_get_record($url, DNS_A); // GET IP ADDRESS

                $IP = isset($ipData[0]['ip']) ? $ipData[0]['ip'] : '';
                exec("bl $IP IP", $output);
                $web_alert = sprintf($this->lang->line('BLACKLISTED'));
                $array = array();
                $listed = array();
                foreach ($output as $checked) {
                    $splitChecked = explode(",", $checked);
                    $array[] = trim($splitChecked[0]);
                    $listed[] = array("engine" => $splitChecked[1], 'status' => trim($splitChecked[0]));
                }
                if (in_array('blacklisted', $array)):
                    $save_date[] = array(
                        'project_id' => $project->project_id,
                        'user_id' => $project->user_id,
                        'created_at' => date('Y-m-d'),
                        'alert_type' => 14,
                        'receiver_type' => 'reguler',
                        'blacklist_status' => 1,
                        'web_alert' => $web_alert
                    );
                    if ($save_date) {
                        $this->cron_model->save_sent_alerts($save_date);
                    }
                endif;
                $this->data['black_list'] = array(
                    'blacklist_engine' => json_encode($listed),
                    'blacklist_data' => json_encode($array),
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
                } else {
                    $this->cron_model->update_blacklist_checked($bl_report[0]->black_id, $this->data['black_list']);
                }
            } catch (Exception $e) {
                print_r($e);
            }
        }
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

    /*     * *************************************************************************************
     * CRAWL
     * use for crawl a website for internal links only
     * ************************************************************************************* */

    function crawl($project) {
        if ($project->crawl == 0) {
            $project_url = $project->project_url;
            try {
                $this->project_model->update_queue_status($project->queue_id, array('crawl' => 2));
                $crawl_pages = array();
                include( __DIR__ . "/../../../getpages/index.php");
                $pages = crawl_site($project_url);
                foreach ($pages as $page):
                    $crawl_pages[] = array(
                        'project_id ' => $project->project_id,
                        'page_url' => $page,
                        'status' => 0
                    );
                endforeach;
                $this->crawl_model->save($crawl_pages);
                $this->project_model->update_queue_status($project->queue_id, array('crawl' => 1));
            } catch (Exception $e) {
                print_r($e);
            }
        }
    }

    /*     * *************************************************************************************
     * WORDPRESS
     * SAVE ALL OVER ONLY UPDATED INFO
     * ************************************************************************************* */

    function save_wp_update_info($project) {

        $save_date = array();

        $project_url = $project->project_url;
        $wpTempHTML['title'] = $wpPluginHTML['title'] = domain_name($project_url);
        if ($project->wp_status == 0) {
            try {
                $this->data['queue_status'] = array('wp_status' => 2);
                $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);

                $request = $project_url . '/wp-content/plugins/upkepr-Maintenance/public/template/wp_over_all_info.php';
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $request);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HEADER, false);
                $update_info = curl_exec($curl);
                curl_close($curl);
                if (is_json($update_info) == false) {
                    $update_info = '';
                }
                //$update_info = file_get_contents($request);

                $this->data['wp_info'] = array('wp_all_status' => $update_info, 'project_id' => $project->project_id);
                if ($update_info) {
                    $this->data['queue_status'] = array('wp_status' => 1);

                    $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                }
                $this->cron_model->save_wp_info($this->data['wp_info']);
                $wp_info_decoded = json_decode($update_info);

                $param['version'] = isset($wp_info_decoded->wordpress_info) ? ((trim($wp_info_decoded->wordpress_info->old_version) != trim($wp_info_decoded->wordpress_info->latest_virsion)) ? $wp_info_decoded->wordpress_info->latest_virsion : $wp_info_decoded->wordpress_info->latest_virsion) : '';

                $plugins_update['plugins'] = isset($wp_info_decoded->plugin_info->update_plugin) ? $wp_info_decoded->plugin_info->update_plugin : '';
                $wpTempHTML['plugins'] = $this->load->view('email-templates/health/table', $plugins_update, true);

                $avail_version = $wp_info_decoded->wordpress_info->latest_virsion;
                if (!empty($avail_version)) {
                    $web_alert = sprintf($this->lang->line('WORDPRESS_CORE'), $avail_version);
                    $save_date[] = array(
                        'alert_id' => '',
                        'project_id' => $project->project_id,
                        'user_id' => $project->user_id,
                        'created_at' => date('Y-m-d'),
                        'alert_type' => 9,
                        'receiver_type' => 'reguler',
                        'wp_available_version' => $avail_version,
                        'web_alert' => $web_alert
                    );

                    if ($save_date) {
                        $this->cron_model->save_sent_alerts($save_date);
                    }
                }
            } catch (Exception $e) {
                print_r($e);
            }
        }
    }

    function email_template($temp, $param) {
        preg_match_all("/\[([^\]]*)\]/", $temp, $matches);
        $data = preg_replace_callback("/\[([^\]]*)\]/i", function($m) use($param) {
            return $param[$m[1]];
        }, $temp);
        return $data;
    }

    /*     * *************************************************************************************
     * INITIAL CRON
     * use for auto run this function after each 2 minuts but it check if its already run.
     *  so its not run again
     * ************************************************************************************* */

    function initial() {
        $mail_servers = $this->mail_server_model->get();
        $read = fopen(BASEPATH . "../assets/cron_log.txt", "r"); // Read cron status its runing OR stop
        $readObj = json_decode(fgets($read));
        foreach ($this->data['queue_projects'] as $project) {
            if ($readObj->cron_status == 0 && $project->queue_status == 0) {
                $write = fopen(BASEPATH . "../assets/cron_log.txt", "w");
                $statusObj = json_encode(array('cron_status' => 1, 'run_on' => date('Y-m-d H:i:s'))); // Write crone status its runing
                fwrite($write, $statusObj);
                fclose($write);
                $this->update_project_speed_info($project);
                $this->update_project_domain_info($project);
                $this->get_dns_records($project);
                $this->get_mx_record($project, $mail_servers);
                $this->check_malware($project);
                $this->capture($project);
                $this->update_project_ssl_info($project);
                $this->update_project_responsive_info($project);
                $this->downTime($project);
                //$this->check_blacklist($project);
                $this->crawl($project);
                if ($project->installed != 'NOT_WP' && $project->status != 0) {
                    $this->save_wp_update_info($project);
                }
                if (!empty($this->cron_model->email_status($project->project_id)) && $this->cron_model->send_project_project_status_mail($project->project_id)->queue_status == 0) {
                    $this->project_model->update_basic_info($project->project_id, array('queue_status' => 1));
                    $this->welcome_project($project->project_id);
                }
            }
        }
        $writeExit = fopen(BASEPATH . "../assets/cron_log.txt", "w"); // Write crone status its stop
        $changeStatusObj = json_encode(array('cron_status' => 0, 'run_on' => date('Y-m-d H:i:s')));
        fwrite($writeExit, $changeStatusObj);
        fclose($writeExit);
    }

    /*     * *************************************************************************************
     * REPORT CRON 
     * use for send project report it running one time in a day 
     * ************************************************************************************* */

    function send_report() {
        $setting = $this->cron_model->get_report_setting();
        $reportTemplate = $this->cron_model->get_alert('Report');
        if (!empty($setting)) :
            foreach ($setting as $rep):
                if (isset($rep->custom_temp) && $rep->custom_temp) {
                    $tepmlate = $rep->custom_temp;
                } else {
                    $tepmlate = $reportTemplate[0]->email_template_text;
                }
                $data['rep_code'] = $rep->project_id . genrateReportCode();
                $link = site_url('get-report/' . $data['rep_code']);
                $param['link'] = '<a href="' . $link . '">' . $link . '</a>';
                if ($this->cron_model->update_project($rep->project_id, $data)):

                    require_once (__DIR__ . '/../../../capture/vendor/autoload.php');
                    $screenCapture = new Capture();
                    $screenCapture->setUrl($link);
                    $screenCapture->setWidth(1330);
                    $screenCapture->setClipWidth(1330);
                    $screenCapture->setImageType('pdf');

                    $ext = strtotime(date('Y-M-d H:i:s'));
                    $dwnLink = site_url('assets/reports/report' . $ext . '.pdf');
                    $param['download_report'] = '<a href="' . $dwnLink . '">Download</a>';
                    $fileLocation1 = __DIR__ . '/../../../assets/reports/report' . $ext . '.' . $screenCapture->getImageType()->getFormat();
                    $screenCapture->save($fileLocation1);
                endif;
                $param['company_name'] = $companyname = $rep->company_name;
                $param['website_name'] = domain_name($rep->project_url);
                $email_template = $this->email_model->email_template(array('temp_type' => 8));
                $from = 'upkepr.com (' . $companyname . ')';
                $param['site_url'] = $rep->project_url;
                $reportHTML['title'] = domain_name($rep->project_url);
                $reportHTML['reportText'] = $this->email_template($tepmlate, $param);
                if ($rep->report_time == 2 && date('D') == 'Sun') {
                    if (isset($rep->email) && $rep->email) {
                        mailgun($rep->email, $this->email_template($email_template->subject, $param), $this->load->view('email-templates/health/report-email', $reportHTML, TRUE));
                    } else {
                        mailgun($rep->email, $this->email_template($email_template->subject, $param), $this->load->view('email-templates/health/report-email', $reportHTML, TRUE));
                    }
                } else if ($rep->report_time == 3 && date('d') == 01) {
                    if (isset($rep->email) && $rep->email) {
                        mailgun($rep->email, $from, $this->email_template($email_template->subject, $param), $this->load->view('email-templates/health/report-email', $reportHTML, TRUE));
                    } else {
                        mailgun($rep->email, $from, $this->email_template($email_template->subject, $param), $this->load->view('email-templates/health/report-email', $reportHTML, TRUE));
                    }
                }
            endforeach;
        endif;
    }

    /*     * *************************************************************************************
     * REPORT CRON 
     * use for send project report it running one time in a day 
     * ************************************************************************************* */

    function fetch_domain_status($id) {
        $this->load->library('whois');
        $project = $this->common_model->get_project_detail($id);
        $project_url = $project->project_url;
        try {
            //Save project domain  info section
            $url = domain_name($project_url);
            $domain_info = $domain_info = $this->whois->LookupDomain($url);
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
            }
            $this->sent_expire_domain_alert($id);
        } catch (Exception $e) {
            print_r($e);
        }
    }

    /*     * ************************************** update  project ssl info *************************************** */

    function fetch_project_ssl_info($id) {
        $project = $this->common_model->get_project_detail($id);
        $project_url = $project->project_url;
        try {
            $certinfo = get_ssl_detail($project_url);
            if ($certinfo) {
                $this->data['ssl_info'] = array(
                    'valid_from ' => date('Y-m-d h:i:s    ', $certinfo['validFrom_time_t']),
                    'valid_to' => date('Y-m-d h:i:s    ', $certinfo['validTo_time_t']),
                    'project_id' => $project->project_id,
                    'status' => 1,
                    'tls' => $this->check_tsl(domain_name($project_url)),
                    'project_url' => $project_url,
                    'sr_number' => $certinfo['serialNumber'],
                    'KeyIdentifier' => $certinfo['extensions']['subjectKeyIdentifier'],
                    'created_at' => date('Y-m-d-h:i:s')
                );
            } else {
                $this->data['ssl_info'] = array(
                    'project_id' => $project->project_id,
                    'status' => 0,
                    'tls' => $this->check_tsl(domain_name($project_url)),
                    'project_url' => $project_url,
                    'created_at' => date('Y-m-d-h:i:s')
                );
            }
            $result = $this->project_model->save_ssl_info($this->data['ssl_info']);
            $this->send_ssl_notification($id);
        } catch (Exception $e) {
            print_r($e);
        }
    }

    /*     * ************************************** update  project ssl info *************************************** */

    function send_ssl_notification() {
        $projects = $this->cron_model->get_project();
        $save_date = array();
        if (!empty($projects)) {
            foreach ($projects as $project) {
                $project_url = $project->project_url;

                try {
                    $certinfo = get_ssl_detail($project_url);
                    if ($certinfo) {
                        $expirey_date = date('Y-m-d h:i:s    ', $certinfo['validTo_time_t']); // ssl expire on 
                        $current_date = date('Y-m-d H:i:s');
                        $domain_expire_date = date('Y-m-d H:i:s', strtotime($expirey_date));
                        $d_start = new DateTime($current_date);
                        $d_end = new DateTime($domain_expire_date);
                        $diff = $d_start->diff($d_end);
                        $this->day = $diff->format('%a');


                        if ($this->day < 90) {
                            $web_alert = sprintf($this->lang->line('SSL_EXPIRE_MONTHLY'), date('d M Y', strtotime($expirey_date)));

                            $save_date[] = array(
                                'alert_id' => '',
                                'project_id' => $project->project_id,
                                'user_id' => $project->user_id,
                                'created_at' => date('Y-m-d'),
                                'alert_type' => 11,
                                'message' => '',
                                'receiver_type' => 'critical',
                                'expire_date' => $expirey_date,
                                'web_alert' => $web_alert
                            );
                        }
                        $domainHTML['title'] = domain_name($project_url);
                        $param['expire_date'] = $expirey_date;
                        $param['site_url'] = domain_name($project_url);
                        $param['company_name'] = $project->company_name;
                        $domainHTML['sslText'] = $this->email_template($alert[0]->email_template_text, $param);
                        // mailgun($project->email, $this->email_template($alert[0]->subject, $param), $this->load->view('email-templates/health/ssl', $domainHTML, TRUE));
                    }
                } catch (Exception $e) {
                    print_r($e);
                }
                // }
            }
            if ($save_date) {
                $this->cron_model->save_sent_alerts($save_date);
            }
        }
    }

    /**     * ************************************************************************************
     * STATUS EMAIL
     * use for send initial project status and set format of mail
     * ************************************************************************************* */
    function welcome_project($project_id) {

        $this->data['projects'] = $this->project_model->get_project_detail($project_id);
        $wp_info_decoded = json_decode($this->data['projects']['wp_all_status']);
        $this->data['project_speed'] = $this->project_model->get_project_speed_info($project_id);
        $blacklist = $this->project_model->get_blacklist_data($project_id);
        $this->data['ssl'] = $this->project_model->get_ssl_info($project_id);
        $this->data['user'] = $this->common_model->get_uesr($this->data['projects']['user_id']);
        $domain_data = json_decode($this->data['projects']['domain_info']);
        $param['website_name'] = domain_name($this->data['projects']['project_url']);
        $param['site_url'] = $this->data['projects']['project_url'];
        if (isset($domain_data->General) && $domain_data->General):
            foreach ($domain_data->General as $key => $value):
                if (strpos($key, 'Expir') !== false || strpos($key, 'domain_datebilleduntil') !== false):
                    $param['domain_expire'] = date('d M Y', strtotime($value));
                endif;
            endforeach;

        endif;
        $param['desktop_speed'] = $this->data['project_speed']->desktop_speed;
        $param['mobile_speed'] = $this->data['project_speed']->mobile_speed;
        if ($this->data['ssl']['valid_to'])
            $param['ssl_expire'] = date('d M Y', strtotime($this->data['ssl']['valid_to']));

        $blacklisted_data = (isset($blacklist->blacklist_data) && $blacklisted_data = array_count_values(array_map('trim', json_decode($blacklist->blacklist_data)))) ? $blacklisted_data : '';
        $param['blacklisting_status'] = isset($blacklisted_data['blacklisted']) ? '<span style="color:#ff0000; font-weight: bold;"> Your website IP is found to be blacklisted(' . $blacklisted_data['blacklisted'] . ') </span>' : '<span style="color:#6aa84f;">Your website IP is found to be clean</span>';
        $param['down_time_status'] = check_down_status($this->data['projects']['project_url']);

        $param['mobile_friendly'] = $this->data['projects']['mobile_friendly'];

        $param['company_name'] = $companyname = $this->data['user']['company_name'];
        $param['malware'] = $this->data['projects']['malware_status'];

        $param['plugins'] = isset($wp_info_decoded->plugin_info->update_plugin) ? $wp_info_decoded->plugin_info->update_plugin : '';
        $param['core'] = isset($wp_info_decoded->wordpress_info) ? ((trim($wp_info_decoded->wordpress_info->old_version) != trim($wp_info_decoded->wordpress_info->latest_virsion)) ? $wp_info_decoded->wordpress_info->latest_virsion : $wp_info_decoded->wordpress_info->latest_virsion) : '';

        $this->data['data'] = $param;
        //$email_template = $this->email_model->email_template(array('temp_type' => 17));
        $from = 'upkepr.com (' . $companyname . ')';
        $subject = 'Congratulations! ' . $param['website_name'] . ' is successfully added.';

        mailgun($this->data['user']['user_email'], $from, $subject, $this->load->view('email-templates/health/project-status', $this->data, TRUE));
    }

    /**     * ************************************************************************************
     * HOST COMPANY CRON
     * use for update hosting company 
     * ************************************************************************************* */
    function update_host_company() {
        $dns = $this->cron_model->get_host();
        $this->data['company'] = array();
        $hostCompanies = $this->cron_model->host_company();
        if ($hostCompanies):
            foreach ($hostCompanies as $company):
                if ($dns) :
                    foreach ($dns as $serverName):
                        foreach (explode(",", $company->name_server) as $servername):
                            $matchs = ltrim(strstr(trim(strtoupper($servername)), '.'), '.');

                            if (stripos($serverName->dns, $matchs) !== false) {
                                $this->data['company'][] = array(
                                    'project_id' => $serverName->project_id,
                                    'host_company' => $company->host_company,
                                    'company_url' => $company->host_company_url
                                );
                            }
                        endforeach;
                    endforeach;
                endif;
            endforeach;
        endif;
        if (!empty($this->data['company'])):
            $this->cron_model->upadte_hosting($this->data['company']);
        endif;
    }

    function get_mx_record($project, $mail_servers) {
        $url = domain_name($project->project_url);

        try {
            if ($project->mx_status == 0) {
                $mx_records = dns_get_record($url, DNS_MX);
                if ($mx_records) {
                    $mx_data = array();
                    foreach ($mx_records as $mx_record):

                        $matchs = strtoupper(trim($mx_record['target']));
                        //loop working for mail server
                        if ($mail_servers):
                            foreach ($mail_servers as $mail_server):
                                $mail_server->mail_server;
                                if (stripos(strtoupper($mail_server->mail_server), $matchs) !== false) {
                                    $mx_data[] = array(
                                        'project_id' => $project->project_id,
                                        'priority' => $mx_record['pri'],
                                        'company_name' => $mail_server->mail_company,
                                        'company_url' => $mail_server->mail_company_url,
                                        'status' => 1,
                                        'ns_record' => $mx_record['target']
                                    );
                                } else {
                                    $mx_data[] = array(
                                        'project_id' => $project->project_id,
                                        'priority' => $mx_record['pri'],
                                        'company_name' => '',
                                        'company_url' => '',
                                        'status' => 1,
                                        'ns_record' => $mx_record['target']
                                    );
                                }
                            endforeach;
                        endif;
                        // end mail server loops 
                    endforeach;
                    $result = $this->mx_model->save($mx_data);
                    if ($result) {
                        $this->data['queue_status'] = array('mx_status' => 1, 'updated_at' => date('Y-m-d-h:i:s'));
                        $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                    }
                } else {
                    $this->data['queue_status'] = array('mx_status' => 1, 'updated_at' => date('Y-m-d-h:i:s'));
                    $this->project_model->update_queue_status($project->queue_id, $this->data['queue_status']);
                }
            }
        } catch (Exception $e) {
            
        }
    }

    /**     * ************************************************************************************
     * HOST COMPANY CRON
     * use for update hosting company 
     * ************************************************************************************* */
    function update_mail_company() {
        $this->load->model('admin/mail_server_model');
        $this->load->model('mx_model');

        $mail_servers = $this->mail_server_model->get();

        $this->data['company'] = array();
        $MX_Records = $this->mx_model->get();

        if ($MX_Records):
            foreach ($MX_Records as $MX_Record):

                $matchs = strtoupper(trim($MX_Record->ns_record));
                //loop working for mail server
                if ($mail_servers):
                    foreach ($mail_servers as $mail_server):
                        $mail_server->mail_server;
                        if (stripos(strtoupper($mail_server->mail_server), $matchs) !== false) {
                            echo $matchs . '</br>';
                            echo $mail_server->mail_server . '</br>';
                        }

                    endforeach;
                endif;
            endforeach;
        endif;
        if (!empty($this->data['company'])):
            $this->cron_model->upadte_hosting($this->data['company']);
        endif;
    }

    /*     * * ************************************************************************************
     * CHECK RESPONSIVENESS
     * use for checking crawl pages responsive or not
     * ************************************************************************************* */

    function reponsiveness_status_crawl_pages() {
        $crawl_data = $this->crawl_model->get();
        $mobileFriendly = array();
        foreach ($crawl_data as $data):
            $project_url = $data->page_url;
            $mobile_friendly = "https://www.googleapis.com/pagespeedonline/v3beta1/mobileReady?url=$project_url";

            $mobile = file_get_contents($mobile_friendly);
            $m = json_decode($mobile);
            $friendly_status = isset($m->ruleGroups->USABILITY->pass) ? $m->ruleGroups->USABILITY->pass : 0;
            $status = isset($m->ruleGroups->USABILITY->pass) ? 1 : 0;

            $mobileFriendly[] = array(
                'crawl_page_id' => $data->crawl_page_id,
                'responsive_status' => $friendly_status,
                'status' => $status,
                'request' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            );
        endforeach;
        if ($mobileFriendly)
            $this->crawl_model->update($mobileFriendly); // update responsiveness status in crawl table
    }

    /**     * ************************************************************************************
     * CHECK SPEED 
     * use for checking crawled pages speed on the google "DESKTOP and MOBILE"
     * ************************************************************************************* */
    function speed_status_crawl_pages() {
        $crawl_data = $this->crawl_model->get_speed_request();
        $Speed = array();
        foreach ($crawl_data as $data):
            $project_url = $data->page_url;
            $googleApi = "https://www.googleapis.com/pagespeedonline/v4/runPagespeed?url=$project_url&key=AIzaSyBZjMGZS8wyNduKUtMbnY5VIwA2lspZoIo";
            $desktop = file_get_contents($googleApi); // get website speed info  for desktop

            $mobileUrl = "https://www.googleapis.com/pagespeedonline/v4/runPagespeed?url=$project_url&strategy=mobile&key=AIzaSyBZjMGZS8wyNduKUtMbnY5VIwA2lspZoIo";
            $mobile = file_get_contents($mobileUrl); // get website speed info  for Mobile

            $decode_desktop_speed = json_decode($desktop)->ruleGroups->SPEED->score; // 
            $decode_mobile_speed = json_decode($mobile)->ruleGroups->SPEED->score;

            $Speed[] = array(
                'crawl_page_id' => $data->crawl_page_id,
                'mobile_speed' => $decode_mobile_speed,
                'desktop_speed' => $decode_desktop_speed,
                'speed_request' => ($decode_desktop_speed) ? 1 : 0,
            );
        endforeach;
        if ($Speed)
            $this->crawl_model->update($Speed); // update speed status in crawl table
    }

    /**     * ************************************************************************************
     * RESPONSIVE AND SPEED CRON 
     * use for auto checking "Responsive and Speed" status crawl data
     * ************************************************************************************* */
    function check_responsiveness_speed_cron() {

        $read = fopen(BASEPATH . "../assets/responsiveness_crn_log.txt", "r"); // Read cron status its runing OR stop
        $readObj = json_decode(fgets($read));
        if ($readObj->cron_status == 0) {
            $write = fopen(BASEPATH . "../assets/cron_log.txt", "w");
            $statusObj = json_encode(array('cron_status' => 1, 'run_on' => date('Y-m-d H:i:s'))); // Write crone status its runing
            fwrite($write, $statusObj);
            fclose($write);
            $this->reponsiveness_status_crawl_pages();
            $this->speed_status_crawl_pages();
        }
        $writeExit = fopen(BASEPATH . "../assets/responsiveness_crn_log.txt", "w"); // Write crone status its stop
        $changeStatusObj = json_encode(array('cron_status' => 0, 'run_on' => date('Y-m-d H:i:s')));
        fwrite($writeExit, $changeStatusObj);
        fclose($writeExit);
    }

}
