<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* * ***********************************SEND MAIL********************************* */

function mailgun($to, $from, $subject, $html) {
    require __DIR__ . "../../../mailgun/vendor/autoload.php";
    $mailObj = new \Mailgun\Mailgun("key-6db0a6d81058dee81621980d0cf376db");
    $domain = "mg.upkepr.com";
    $mailObj->sendMessage($domain, array(
        'from' => 'UpKepr.com(cWebCo India) info@upkepr.com',
        'to' => $to,
        'subject' => $subject,
        'html' => $html,
            )
    );
}

function attachmentReport($to, $from, $subject, $html, $filepath) {
    require __DIR__ . "../../../mailgun/vendor/autoload.php";
    $mailObj = new \Mailgun\Mailgun("key-6db0a6d81058dee81621980d0cf376db");
    $domain = "mg.upkepr.com";
    $mailObj->sendMessage($domain, array(
        'from' => 'UpKepr.com(cWebCo India) info@upkepr.com ',
        'to' => $to,
        'subject' => $subject,
        'html' => $html), array(
        'attachment' => array($filepath)
            )
    );
}

function email_template($temp, $param) {
    preg_match_all("/\[([^\]]*)\]/", $temp, $matches);
    $data = preg_replace_callback("/\[([^\]]*)\]/i", function($m) use($param) {
        return $param[$m[1]];
    }, $temp);
    return $data;
}

function footer_content($type) {
    $ci = & get_instance();
    $ci->load->database();
    return $ci->db->select('*')->where('temp_type', $type)->get('upkepr_email_template')->row();
}

function lang_msg($type) {
    $ci = & get_instance();
    $ci->load->database();
    $res = $ci->db->select('msg')->where('msg_key', $type)->get('upkepr_error_message')->row();
    return ($res) ? $res->msg : '';
}

/* * ********************************** cerate token********************************* */

function genrate_token($id) {
    return $token = date('Y-m-d h:i:s') . $id;
}

function valid_url($url) {
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url)) {
        return FALSE;
    } else {
        return TRUE;
    }
}

/* * ************************************ word limit ****************************** */

function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}

/* * ************************************ char limit ****************************** */

function text_limit($x, $length) {
    if (strlen($x) <= $length) {
        return $x;
    } else {
        $y = substr($x, 0, $length) . '...';
        return $y;
    }
}

/* * ************************************************ get ssl info **************** */

function get_ssl_detail($url) {
    $url = (strpos($url, "https://") !== false) ? $url : '';
    $certinfo = '';
    if ($url) {
        $orignal_parse = parse_url($url, PHP_URL_HOST);
        $get = stream_context_create(array("ssl" => array("capture_peer_cert" => TRUE)));
        $read = stream_socket_client("ssl://" . $orignal_parse . ":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $get);
        $cert = stream_context_get_params($read);
        $certinfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);
    }
    return ($certinfo) ? $certinfo : false;
}

/* * ************************************ get user profile photo **************************************** */

function get_user_profile_pic() {
    $ci = & get_instance();
    $sessionData = $ci->session->userdata('user_data');
    if (!empty($sessionData))
        return $ci->db->select('thumb_nail,prof_image,status')->from('upkepr_user_profile')->where('user_id', $sessionData['user_id'])->get()->row_array();
    else
        return false;
}

function page_title($url) {
    $fp = file_get_contents($url);
    if (!$fp)
        return null;
    $res = preg_match("/<title>(.*)<\/title>/siU", $fp, $title_matches);
    if (!$res)
        return null;
    $title = preg_replace('/\s+/', ' ', $title_matches[1]);
    $title = trim($title);
    return $title;
}

/* * ****************************** Display domain name ******************************************* */

function domain_name($url) {
    $pieces = parse_url($url);
    $domain = isset($pieces['host']) ? $pieces['host'] : '';
    if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
    }
    return false;
}

/* * ***************************** get user profile photo **************************************** */

function domain_fields() {
    return array(
        'Domain Name:',
        'Registry Domain ID:',
        'Registrar WHOIS Server:',
        'Registrar URL:',
        'Updated Date:',
        'Creation Date:',
        'Expiration Date:',
        'Created On:',
        'Last Updated On:',
        'Registry Expiry Date:',
        'Registrar Registration Expiration Date:',
        'Registrant Name:',
        'Registrant Organization:',
        'Registrant Street:',
        'Registrant City:',
        'Registrant State/Province:',
        'Registrant Postal Code:',
        'Registrant Country:',
        'Registrant Phone:',
        'Registrant Fax:',
        'Registrant Email:',
        'Registry Admin ID:',
        'Admin Name:',
        'Admin Organization:',
        'Admin Street:',
        'Admin City:',
        'Admin State/Province:',
        'Admin Postal Code:',
        'Admin Country:',
        'Admin Phone:',
        'Admin Phone Ext:',
        'Admin Fax:',
        'Admin Email:',
        'Registry Tech ID:',
        'Tech Name:',
        'Tech Organization:',
        'Tech Street:',
        'Tech City:',
        'Tech State/Province:',
        'Tech Postal Code:',
        'Tech Country:',
        'Tech Phone:',
        'Tech Fax:',
        'Tech Email:',
        'Name Server:',
        'Name Server:'
    );
}

function domain_fields2() {
    return array(
        'version:',
        'query_datetime:',
        'domain_name:',
        'query_status:',
        'domain_dateregistered:',
        'domain_datebilleduntil:',
        'domain_datelastmodified:',
        'domain_delegaterequested:',
        'domain_signed:'
    );
}

function blacklist_engine() {
    return $blacklist_check = array('0spam-killlist.fusionzero.com', '0spam.fusionzero.com', 'access.redhawk.org', 'all.rbl.jp', 'all.spam-rbl.fr', 'all.spamrats.com', 'aspews.ext.sorbs.net', 'b.barracudacentral.org', 'backscatter.spameatingmonkey.net', 'badnets.spameatingmonkey.net', 'bb.barracudacentral.org', 'bl.drmx.org', 'bl.konstant.no', 'bl.nszones.com', 'bl.spamcannibal.org', 'bl.spameatingmonkey.net', 'bl.spamstinks.com', 'black.junkemailfilter.com', 'blackholes.five-ten-sg.com', 'blacklist.sci.kun.nl', 'blacklist.woody.ch', 'bogons.cymru.com', 'bsb.empty.us', 'bsb.spamlookup.net', 'cart00ney.surriel.com', 'cbl.abuseat.org', 'cbl.anti-spam.org.cn', 'cblless.anti-spam.org.cn', 'cblplus.anti-spam.org.cn', 'cdl.anti-spam.org.cn', 'cidr.bl.mcafee.com', 'combined.rbl.msrbl.net', 'db.wpbl.info', 'dev.null.dk', 'dialups.visi.com', 'dnsbl-0.uceprotect.net', 'dnsbl-1.uceprotect.net', 'dnsbl-2.uceprotect.net', 'dnsbl-3.uceprotect.net', 'dnsbl.anticaptcha.net', 'dnsbl.aspnet.hu', 'dnsbl.inps.de', 'dnsbl.justspam.org', 'dnsbl.kempt.net', 'dnsbl.madavi.de', 'dnsbl.rizon.net', 'dnsbl.rv-soft.info', 'dnsbl.rymsho.ru', 'dnsbl.sorbs.net', '', 'dnsbl.zapbl.net', 'dnsrbl.swinog.ch', 'dul.pacifier.net', 'dyn.nszones.com', 'dyna.spamrats.com', 'fnrbl.fast.net', 'fresh.spameatingmonkey.net', 'hostkarma.junkemailfilter.com', 'images.rbl.msrbl.net', 'ips.backscatterer.org', 'ix.dnsbl.manitu.net', 'korea.services.net', 'l2.bbfh.ext.sorbs.net', 'l3.bbfh.ext.sorbs.net', 'l4.bbfh.ext.sorbs.net', 'list.bbfh.org', 'list.blogspambl.com', 'mail-abuse.blacklist.jippg.org', 'netbl.spameatingmonkey.net', 'netscan.rbl.blockedservers.com', 'no-more-funn.moensted.dk', 'noptr.spamrats.com', 'orvedb.aupads.org', 'pbl.spamhaus.org', 'phishing.rbl.msrbl.net', 'pofon.foobar.hu', 'psbl.surriel.com', 'rbl.abuse.ro', 'rbl.blockedservers.com', 'rbl.dns-servicios.com', 'rbl.efnet.org', 'rbl.efnetrbl.org', 'rbl.iprange.net', 'rbl.schulte.org', 'rbl.talkactive.net', 'rbl2.triumf.ca', 'rsbl.aupads.org', 'sbl-xbl.spamhaus.org', 'sbl.nszones.com', 'sbl.spamhaus.org', 'short.rbl.jp', 'spam.dnsbl.anonmails.de', 'spam.pedantic.org', 'spam.rbl.blockedservers.com', 'spam.rbl.msrbl.net', 'spam.spamrats.com', 'spamrbl.imp.ch', 'spamsources.fabel.dk', 'st.technovision.dk', 'tor.dan.me.uk', 'tor.dnsbl.sectoor.de', 'tor.efnet.org', 'torexit.dan.me.uk', 'truncate.gbudb.net', 'ubl.unsubscore.com', 'uribl.spameatingmonkey.net', 'urired.spameatingmonkey.net', 'virbl.dnsbl.bit.nl', 'virus.rbl.jp', 'virus.rbl.msrbl.net', 'vote.drbl.caravan.ru', 'vote.drbl.gremlin.ru', 'web.rbl.msrbl.net', 'work.drbl.caravan.ru', 'work.drbl.gremlin.ru', 'wormrbl.imp.ch', 'xbl.spamhaus.org', 'zen.spamhaus.org');
}

function curl_post_async($url, $params) {
    $CI = & get_instance();
    $CI->session_data = $CI->session->userdata('user_data');
    $post_string = http_build_query($params);
    $parts = parse_url($url);

    $fp = fsockopen($parts['host'], isset($parts['port']) ? $parts['port'] : 80, $errno, $errstr, 30);
    if (!$fp) {
        echo "ERROR: $errno - $errstr<br />\n";
    }
    $out = "POST " . $parts['path'] . " HTTP/1.1\r\n";
    $out.= "Host: " . $parts['host'] . "\r\n";
    $out .= "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
    $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
    $out.= "Content-Length: " . strlen($post_string) . "\r\n";
    $out.= "Connection: Close\r\n\r\n";
    if (isset($post_string))
        $out.= $post_string;
    fwrite($fp, $out);
    fclose($fp);
}

function getRealIpAddr() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function host_service() {
    return $servicePorts = array('cpanel' => 2083, 'whm' => 2087, 'webmail' => 2096);
}

function get_response($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function round_figure($float) {
    return number_format(round($float, 2), 2);
}

function subArraysToString($ar, $sep = ', ') {
    $str = '';
    foreach ($ar as $val) {
        $str .= implode($sep, $val);
        $str .= $sep; // add separator between sub-arrays
    }
    $str = rtrim($str, $sep); // remove last separator
    return $str;
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $now->format('h:i:s a m/d/Y');
    $ago->format('h:i:s a m/d/Y');
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full)
        $string = array_slice($string, 0, 1);

    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function time_availability($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $now->format('h:i:s a m/d/Y');
    $ago->format('h:i:s a m/d/Y');
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full)
        $string = array_slice($string, 0, 1);
    return explode(" ", implode(', ', $string)) ? explode(" ", implode(', ', $string)) : '';
}

/* * *************************** GENRATE CODE FOR REPORT ********************************** */

function genrateReportCode() {
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ023456789";
    srand((double) microtime() * 1000000);
    $i = 0;
    $pass = '';

    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}

function check_down_status($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_exec($ch);
    $info = curl_getinfo($ch);
    if ($info['http_code'] != 200)
        return 'Down';
    else 
      return 'up';    
}

function is_json($string,$return_data = false) {
      $data = json_decode($string);
     return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;
}