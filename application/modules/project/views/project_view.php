
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div class="ks-page-container" id="main-con"  pro-index="<?= $projects['project_id'] ?>" data-url="<?= (isset($projects['project_url']) && !empty($projects['project_url'])) ? $projects['project_url'] : ''; ?>">
    <span class="sitemap" site-index='<?= $submitted; ?>' ></span>
    <span class="ctr" site-index='<?= $CTR; ?>'></span>
    <div class="ks-column ks-page"> 
        <section id="middle">
            <div class="container">
                <h3 class="big-hdng"><?= isset($projects['project_url']) ? $projects['project_url'] : ''; ?></h3>
                <div class="left_section">
                    <?php
                    $speed = ($project_speed->desktop_speed) ? $project_speed->desktop_speed : 0;
                    $speed_color_rating = ($speed > 80) ? 'green-bar' : (($speed < 80 && $speed > 60) ? 'yellow-bar' : 'red-bar');

                    $speed_icon = ($speed > 80) ? 'ok-desktop' : (($speed < 80 && $speed > 60) ? 'low-desktop' : 'very-low-desktop');

                    $speed_m = ($project_speed->mobile_speed) ? $project_speed->mobile_speed : 0;
                    $speed_m_icon = ($speed_m > 80) ? 'ok-mobile' : (($speed_m < 80 && $speed_m > 60) ? 'low-mobile' : 'very-low-mobile');

                    $speed_m_color_rating = ($speed_m > 80) ? 'green-bar' : (($speed_m < 80 && $speed_m > 60) ? 'yellow-bar' : 'red-bar');

                    $upTime_status = (isset($down_times[0]['DAILY_DOWN']) && $down_times[0]['DAILY_DOWN'] == 0) ? '100' : round_figure(100 - ($down_times[0]['DAILY_DOWN'] / $down_times[0]['DAILY_UP'] * 100));
                    $upTime_color_rating = ($upTime_status == 100 || $upTime_status > 80) ? 'green-bar' : ($upTime_status > 60 && $upTime_status < 80 ? 'yellow-bar' : 'red-bar');
                    ?>

                    <div class="speed-main-section">
                        <div class="speed-box">
                            <span class="<?= $speed_color_rating; ?>" style= "width: <?= $speed . '%'; ?>"></span>
                            <p>Desktop Speed</p>
                            <p class="score"><?= $speed; ?><span>/100</span></p>
                            <div class="google-plus">
                                <span class="avg"> Average: <span> <?= round($avg_status->avg_desktop_speed, 2); ?></span></span>
                                <a href="<?= site_url('speed-status/' . $projects['project_id']); ?>" target="blank" class=""><i class="up-link-desktop fa fa-external-link-square" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div class="speed-box">
                            <span class="<?= $speed_m_color_rating; ?>" style= "width: <?= $speed_m . '%'; ?>"></span>
                            <p>Mobile Speed</p>
                            <p class="score"><?= $speed_m; ?><span>/100</span></p>
                            <div class="google-plus">
                                <span class="avg">Average: <span> <?= round($avg_status->avg_mobile_speed, 2); ?></span></span>
                                <a href="<?= site_url('speed-status/' . $projects['project_id']); ?>" target="blank" class=""><i class="up-link-mobile fa fa-external-link-square" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div class="speed-box">
                            <span class="<?= $upTime_color_rating ?>" style="width: <?= $upTime_status . '%'; ?>"></span>
                            <p>Uptime</p>
                            <p class="score"><?= $upTime_status; ?>%</p>
                            <div class="speed-icon">
                                <img src="<?= site_url('assets/images/uptime-icon.png'); ?>">
                            </div>
                        </div>
                        <?php $responsive_color_rating = (isset($projects['mobile_friendly']) && $projects['mobile_friendly'] == 1) ? 'green-bar' : 'red-bar'; ?>
                        <?php $responsive_status = (isset($projects['mobile_friendly']) && $projects['mobile_friendly'] == 1) ? 100 : 2; ?>

                        <div class="speed-box">
                            <span class="<?= $responsive_color_rating ?>" style="width: <?= $responsive_status . '%'; ?>"></span>
                            <p>Responsive</p>
                            <p class="score">  <?= (isset($projects['mobile_friendly']) && $projects['mobile_friendly'] == 1) ? 'True' : 'False'; ?></p>
                            <div class="google-plus">
                                <span class="avg">Average: <span><?= $avg_status->avg_responsive_status * 100; ?> </span></span>
                                <a href="<?= site_url('responsiveness/' . $projects['project_id']); ?>" target="blank"><i class="up-link-mobile fa fa-external-link-square" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <?php
                        if ($projects['installed'] != 'NOT_WP' && $plugin_status == 'yes'):
                            $plugin_per = round(count($wordpress_update_status->plugin_info->actived_plugin) / count((array) $wordpress_update_status->plugin_info->plugins) * 100);
                            $plugin_color_rating = ($plugin_per == 100 || $plugin_per > 80) ? 'green-bar' : (($plugin_per > 60 && $plugin_per < 80) ? 'yellow-bar' : 'red-bar');
                            ?>
                            <div class="speed-box">
                                <span class="<?= $plugin_color_rating; ?>" style="width: <?= $plugin_per . '%'; ?>"></span>
                                <p>active plugins</p>
                                <p class="score"><?= count($wordpress_update_status->plugin_info->actived_plugin); ?><span>/<?= count((array) $wordpress_update_status->plugin_info->plugins); ?></span></p>
                                <div class="speed-icon">
                                    <img src="<?= site_url('assets/images/active-plugin-icon.png'); ?>">
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!--p class="rating-bootom-hdng">If You want to configure alerts.Please </p-->
                </div>
                <div class="right-section">
                    <div class="banner-main-sec">
                        <div class="mobile-phone-sec">
                            <div class="desktop-banner" ><img src="<?php echo (file_exists(FCPATH . 'assets/photo/screenshot/' . $projects['project_id'] . '-desktop.jpg')) ? site_url('assets/photo/screenshot/' . $projects['project_id'] . '-desktop.jpg') : site_url('assets/img/placeholders/placeholder.png'); ?>" /></div>
                            <div class="tab-banner"><img src="<?php echo (file_exists(FCPATH . 'assets/photo/screenshot/' . $projects['project_id'] . '-tablet.jpg')) ? site_url('assets/photo/screenshot/' . $projects['project_id'] . '-tablet.jpg') : site_url('assets/img/placeholders/placeholdermt.png'); ?>" /></div>
                            <div class="phone-banner"><img src="<?php echo (file_exists(FCPATH . 'assets/photo/screenshot/' . $projects['project_id'] . '-mobile.jpg')) ? site_url('assets/photo/screenshot/' . $projects['project_id'] . '-mobile.jpg') : site_url('assets/img/placeholders/placeholdermt.png'); ?>" /></div>
                        </div>
                    </div>
                </div> 
            </div>
        </section>

        <section id="bootom-section">
            <?php
            if (isset($projects['domain_info']) && !empty($projects['domain_info']))
                $domain = json_decode($projects['domain_info']);
            else
                $domain = '';
            ?> 
            <div class="container">
                <div class="bootom-section">
                    <span class="edit-refrech"> 

                    </span>
                    <div class="left-bootom-section">
                        <div class="lft-sec-big-hdng">
                            <p><span><img src="<?= site_url('assets/images/project-info-icon.png') ?>"></span>PROJECT INFORMATION</p>
                        </div>

                        <div class="lft-bootom-cnt-box action-sec">
                            <a href="<?= site_url('congifure/' . $projects['project_id']); ?>">Configure Alerts</a> |
                            <a href="<?= site_url('project/edit/' . $projects['project_id']); ?>" target="blank">Edit</a> | <a class="fetch-website-info" href="#">Refresh</a>
                            <span class="fetch-date"> Last Updated On: <?= time_elapsed_string(date('d M Y H:i', strtotime($project_speed->updated_at))); ?></span>
                        </div>
                        <!------------------ WEB SITE INFORMATION  -------------------->

                        <div class="lft-bootom-cnt-box">
                            <p><span><img src="<?= site_url('assets/images/webinfo-icon.png'); ?>"></span>WEBSITE INFORMATION </p>
                            <ul>
                                <?= '<li class="meta-title">' . $projects['project_url'] . '</li>'; ?>
                                <?= isset($projects['meta_title']) && $projects['meta_title'] ? '<li class="meta-title">' . $projects['meta_title'] . '</li>' : ''; ?>
                                <?= isset($projects['description']) && $projects['description'] ? '<li>' . $projects['description'] . '</li>' : ''; ?>
                            </ul>
                        </div>

                        <!------------------ HOSTING  INFORMATION  -------------------->

                        <div class="lft-bootom-cnt-box">
                            <p><span><img src="<?= site_url('assets/images/hosting-icon.png') ?>"></span>HOSTING INFORMATION  </p>

                            <ul>
                                <?php
                                if (!empty($host_info->host_company)) {
                                    echo '<li> Your Hosting Company Is <a href="' . strtolower($host_info->company_url) . '" target="blank" >' . $host_info->host_company . '</a></li>';
                                } else {
                                    if (isset($host_info) && !empty($host_info)) {
                                        echo '<li><span class="meta-title" >Name Servers</span></li>';
                                        foreach (explode(",", $host_info->dns) as $host) {
                                            echo'<li>' . $host . '</li>';
                                        }
                                        echo'<li> IP Address:' . $host_info->host_ip . '</li>';
                                    } else {
                                        echo '<li> Your website hosting information in prosess. Please check in few minutes </li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>

                        <!------------------ DOMAIN   INFORMATION  -------------------->

                        <div class="lft-bootom-cnt-box">
                            <p><span><img src="<?= site_url('assets/images/domain-info.png') ?>"></span>DOMAIN INFORMATION </p>
                            <ul>
                                <?php
                                if (isset($domain->General->Registrar_URL) && $domain->General->Registrar_URL)
                                    preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain->General->Registrar_URL, $regs);
                                if (!empty($domain->General) && isset($domain->General->Domain_Name)) {
                                    foreach ($domain->General as $key => $value):

                                        if (strpos($key, 'Expir') !== false): $expire = $value;
                                        endif;
                                        if (strpos($key, 'Creat') !== false) : $create = $value;
                                        endif;

                                    endforeach;
                                    ?>
                                    <li><?= $domain->General->Domain_Name; ?></li>
                                    <li>Register Date : <?= date('d M Y', strtotime($create)); ?></li>
                                    <li>Expiry Date: <?= date('d M Y', strtotime($expire)); ?></li>
                                    <?php if (isset($regs['domain'])): ?> <li><p>The domain is registered at <span class="ks-text-bold update-date"><a href="<?= isset($domain->General->Registrar_URL) ? $domain->General->Registrar_URL : ''; ?>" target="blank"><?= $regs['domain']; ?></a></span></p></li> <?php
                                    endif;
                                } else if (isset($domain->General->domain_dateregistered) && !empty($domain->General)) {
                                    ?>
                                    <li><?= $domain->General->domain_name; ?></li>
                                    <li>Register Date: <?= date('d M Y', strtotime($domain->General->domain_dateregistered)); ?></li>
                                    <li>Expiry Date: <?= date('d M Y', strtotime($domain->General->domain_datebilleduntil)); ?></li>
                                    <?php
                                } else {
                                    echo '<li> Your website domain information in prosess. Please check in few minutes </li>';
                                }
                                ?>
                            </ul>
                        </div>

                        <!------------------ WORDPRESS   INFORMATION  -------------------->

                        <?php if ($projects['installed'] != 'NOT_WP' && $plugin_status == 'yes'): ?>
                            <div class="lft-bootom-cnt-box">
                                <p><span><img src="<?= site_url('assets/images/wordpress-icon.png') ?>"></span>WORDPRESS INFORMATION </p>
                                <ul>
                                    <?php
                                    if (isset($wordpress_update_status->wordpress_info)) {
                                        echo (trim($wordpress_update_status->wordpress_info->old_version) != trim($wordpress_update_status->wordpress_info->latest_virsion)) ? '<li>Wordpress Core: Update Available (' . $wordpress_update_status->wordpress_info->latest_virsion . ')</li>' : '<li> Wordpress Core: Running Latest Version </li>';
                                    } else {
                                        echo '<li> Wordpress core information is progressing... </li>';
                                    }

                                    if (isset($wordpress_update_status->plugin_info->update_future) && count((array) $wordpress_update_status->plugin_info->update_future) > 0) {
                                        echo '<li>Wordpress Plugin(s): Update Available (' . count((array) $wordpress_update_status->plugin_info->update_future) . ')</li>';
                                    } else if (isset($wordpress_update_status->plugin_info->update_future) && empty($wordpress_update_status->plugin_info->update_future)) {
                                        echo '<li>Wordpress Plugin(s): All Running Latest </li>';
                                    } else {
                                        echo '<li> We are fetching you wp-plugin status. progressing...</li>';
                                    }

                                    if (isset($wordpress_update_status->themes_info->update_future) && $wordpress_update_status->themes_info->update_future != '') {
                                        echo '<li>Wordpress Theme(s): Update Available</li>';
                                    } else if (isset($wordpress_update_status->themes_info->update_future) && $wordpress_update_status->themes_info->update_future == '') {
                                        echo '<li>Wordpress Theme(s): All running latest</li>';
                                    } else {

                                        echo '<li> We are fetching you wp-theme status. progressing...</li>';
                                    }
                                    echo '<li> <a class="cursue-point" href="' . site_url('wp-info/' . $projects['project_id']) . '"  target="blank">More Detail</a>';
                                    echo ($projects['credential_id']) ? '<a class="cursue-point admin-ligin" href="' . site_url('wp-admin-auth/' . $projects['project_id']) . '"  target="blank">Login as admin</a>' : '';
                                    echo '</li>';
                                    ?>

                                </ul>
                            </div>
                        <?php endif; ?>

                        <!------------------ SSLINFORMATION  -------------------->

                        <?php if (isset($ssl) && !empty($ssl) && $ssl['status'] == 1): ?>
                            <div class="lft-bootom-cnt-box">
                                <p><span><img src="<?= site_url('assets/images/hosting-icon.png') ?>"></span>SSL INFORMATION</p>
                                <ul>
                                    <?= isset($ssl['valid_from']) ? '<li>Valid From: ' . date('d M Y', strtotime($ssl['valid_from'])) . '</li>' : ''; ?>
                                    <?= isset($ssl['valid_to']) ? '<li>Valid To: ' . date('d M Y', strtotime($ssl['valid_to'])) . '</li>' : ''; ?> 
                                    <?php
                                    if (isset($ssl['tls']) && !empty($ssl['tls'])) {
                                        foreach (json_decode($ssl['tls']) as $key => $tls) {
                                            if ($tls) {
                                                echo "<li><p class='label-icon'>$key </p><span class='okay-icon'><img src='" . site_url('assets/images/okay-icon.png') . "' /></span></li>";
                                            }
                                        }
                                    }
                                    ?> 
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!------------------ BLACKLIST    INFORMATION  -------------------->

                        <div class="lft-bootom-cnt-box">
                            <p><span><img src="<?= site_url('assets/images/black-list.png') ?>"></span>MALWARE STATUS </p>
                            <ul>
                                <li class="malware-section"> <img src="<?= ($projects['malware_status'] == 0) ? site_url('assets/images/malware_not.png') : site_url('assets/images/malware_deduct.png'); ?>"> <?= ($projects['malware_status'] == 0) ? 'CLEAN' : 'Malware Detected'; ?></li>
                            </ul>
                        </div>

                        <!------------------ MX RECORDS INFORMATION  -------------------->
                        <?php
                        if (!empty($mx_records)):
                            if (isset($blacklist->blacklist_data)):
                                $blacklisted_data = array_count_values(array_map('trim', json_decode($blacklist->blacklist_data)));

                            endif;
                            ?>
                            <div class="lft-bootom-cnt-box">
                                <p><span><img src="<?= site_url('assets/images/mx-entry.png') ?>"></span>MAIL/BLACKLISTING <span class="small"> (MX Records)</span></p>
                                <ul>

                                    <li class="malware-section">
                                        <?= isset($blacklisted_data['blacklisted']) ? ' <img src="' . site_url('assets/images/malware_deduct.png') . '">  ' . $blacklisted_data['blacklisted'] . ' Blacklisting Found (117 Blacklists Checked).' : '<img src="' . site_url('assets/images/malware_not.png') . '"> No Blacklisting Found (117 Blacklists Checked).'; ?> 
                                        <a href="<?= site_url('blacklist-report/' . $projects['project_id']); ?>" target="blank">
                                            <i class='la la-external-link visit' aria-hidden='true'></i>
                                        </a>
                                    </li>
                                    <?php
//                                    foreach ($mx_records as $mx_record) :
                                       if ($mx_records->company_name):
                                            echo '<li>Your email provider is <a href="'.$mx_records->company_url. '" target="blank">' . $mx_records->company_name . '</a></li>';
                                       else:
                                            echo '<li>'.$mx_records->ns_record . '</li>';
                                       endif;
//                                    endforeach;
                                    ?> 
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="right-bootom-section">
                        <div class="main-grap-sec">
                            <div class="lft-sec-big-hdng">
                                <p><span><img src="<?= site_url('assets/images/statics-icon.png') ?>"></span>STATISTICS </p>
                            </div>
                            <div class="grap-sec">
                                <div class="form-group">
                                    <div class="col-lg-12 Outh-option text-center"></div>
                                    <?php if (isset($projects['account_id']) && $projects['account_id']): ?>
                                        <div class="col-lg-12 date-option text-center" style="display:none">
                                            <div class="col-lg-1 float-right">
                                                <i class="la la-search get-report"></i>
                                            </div>
                                            <div class="col-lg-3 float-right">
                                                <input class="form-control flatpickr1 end-date" id="end-date"  name="end_date"  value="" data-min-date="" data-max-date="today"  data-default-date="today" placeholder="Please Enter End Date">
                                            </div>
                                            <div class="col-lg-3 float-right">
                                                <input class="form-control flatpickr start-date" id="start-date" name="start_date"  value="" data-min-date="<?= date('Y-m-d', strtotime('-89 days')); ?>"  data-max-date="today"  data-default-date="<?= date('Y-m-d', strtotime('-30 days')); ?>" placeholder="Please Enter Start Date">
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($projects['account_id']) && $projects['account_id']): ?>

                            <!------------------------------------- MOBILE VS DESKTOP PEROFORMANE GRAPH ------------------------------------->

                            <div class="main-grap-sec">
                                <div class="right-sec-big-hdng">
                                    <p class="lft-sec-big-hdng loader device_chart-loader"><span><img class="icon-img" src="<?= site_url('assets/images/mobile-vs-desktop.png') ?>"></span>Mobile Vs Desktop Performance Graph <span class="loader-sec"><img src="<?= site_url('assets/img/loaders/svg-loaders/ajax-loader.gif'); ?>" /></span><i class="icon expend la la-minus tab-icons" data-toggle="collapse" data-target="#mobile-tab"></i></p>
                                </div>
                                <div id="mobile-tab" class="grap-sec collapse show">
                                    <div id="device_chart" style="width:100%;"></div>
                                </div>
                            </div>

                            <!------------------------------------- ACQUISITION REPORT------------------------------------>

                            <div class="main-grap-sec">
                                <div class="right-sec-big-hdng">
                                    <p class="lft-sec-big-hdng acquisition-loader"><span><img  class="icon-img" src="<?= site_url('assets/images/acquisition-report.png') ?>"></span>Acquisition Report <span class="loader-sec"> <img src="<?= site_url('assets/img/loaders/svg-loaders/ajax-loader.gif'); ?>" /></span> <i class="icon expend la la-minus tab-icons" data-toggle="collapse" data-target="#acquisition-tab"></i></p>
                                </div>
                                <div id="acquisition-tab" class="grap-sec collapse show">
                                    <div class="acquisition table-responsive"></div>
                                </div>
                            </div>

                            <!------------------------------------- KEYWORDS REPORTS ------------------------------------->

                            <div class="main-grap-sec" >
                                <div class="right-sec-big-hdng">
                                    <p class="lft-sec-big-hdng kewyord-analytic-loader"><span><img class="icon-img" src="<?= site_url('assets/images/Keywords-Report.png') ?>"></span>Keywords Report <span class="loader-sec"> <img src="<?= site_url('assets/img/loaders/svg-loaders/ajax-loader.gif'); ?>" /></span><i class="icon expend la la-plus tab-icons" data-toggle="collapse" data-target="#key-report"></i></p>
                                </div>
                                <div id="key-report" class="grap-sec collapse">
                                    <div class="kewyord-analytic table-responsive"></div>
                                </div>
                            </div>

                            <!------------------------------------- NEW VS RETURNING VISITORS GRAPH ------------------------------------->

                            <div class="main-grap-sec">
                                <div class="right-sec-big-hdng">
                                    <p class="lft-sec-big-hdng returningVsNew-loader"><span><img src="<?= site_url('assets/images/new-grpicon.png') ?>"></span>New vs Returning Visitor's Graph <span class="loader-sec"> <img src="<?= site_url('assets/img/loaders/svg-loaders/ajax-loader.gif'); ?>" /></span><i class="icon expend la la-minus tab-icons" data-toggle="collapse" data-target="#vistor-grap"></i></p>
                                </div>
                                <div id="vistor-grap" class="grap-sec collapse show">
                                    <div id="returningVsNew" style="width:100%;"></div>
                                </div>
                            </div>

                            <!------------------------------------- NEW VS RETURNING VISITORS REPORTS ------------------------------------->

                            <div class="main-grap-sec">
                                <div class="right-sec-big-hdng">
                                    <p class="lft-sec-big-hdng visitor-analytic-loader"><span><img src="<?= site_url('assets/images/new-grpicon.png') ?>"></span>New vs. Returning Visitors Report <span class="loader-sec"> <img src="<?= site_url('assets/img/loaders/svg-loaders/ajax-loader.gif'); ?>" /></span><i class="icon expend la la-plus tab-icons" data-toggle="collapse" data-target="#visitors"></i></p>
                                </div>
                                <div id="visitors" class="grap-sec collapse">
                                    <div class="visitor-analytic table-responsive"></div>
                                </div>
                            </div>

                            <!------------------------------------- LANDING PAGES REPORT ------------------------------------->

                            <div class="main-grap-sec" >
                                <div class="right-sec-big-hdng">
                                    <p class="lft-sec-big-hdng langing-report-analytic-loader"><span><img class="icon-img" src="<?= site_url('assets/images/landing-page.png') ?>"></span>Landing Pages Report <span class="loader-sec"> <img src="<?= site_url('assets/img/loaders/svg-loaders/ajax-loader.gif'); ?>" /></span><i class="icon expend la la-plus tab-icons" data-toggle="collapse" data-target="#land-pg"></i></p>
                                </div>
                                <div id="land-pg" class="grap-sec collapse">
                                    <div class="langing-report-analytic table-responsive"> </div>
                                </div>
                            </div>

                            <!------------------------------------- BOUNCE RATE AND EXIT RATE GRAPH ------------------------------------->

                            <div class="main-grap-sec">
                                <div class="right-sec-big-hdng">
                                    <p class="lft-sec-big-hdng bounce-exit-loader"><span><img class="icon-img" src="<?= site_url('assets/images/rate-graph.png') ?>"></span>Bounce Rate vs Exit Rate Graph <span class="loader-sec"> <img src="<?= site_url('assets/img/loaders/svg-loaders/ajax-loader.gif'); ?>" /></span><i class="icon expend la la-minus tab-icons" data-toggle="collapse" data-target="#bon-exirt"></i></p>
                                </div>
                                <div id="bon-exirt" class="grap-sec collapse show">
                                    <div id="bounce-exit" style="width:100%;"></div>
                                </div>
                            </div>

                            <?php
                        endif;
                        if (isset($search_query) && !empty($search_query)):
                            ?>
                            <!------------------------------------- CLICK THROUGH RATE GRAPH ------------------------------------->

                            <div class="main-grap-sec" >
                                <div class="right-sec-big-hdng">
                                    <p class="lft-sec-big-hdng ctr-graph-loader"><span><img class="icon-img" src="<?= site_url('assets/images/bounce-rate.png') ?>"></span>Click Through Rate Graph <i class="icon expend la la-minus tab-icons" data-toggle="collapse" data-target="#click-tab"></i></p>
                                </div>
                                <div id="click-tab" class="grap-sec collapse show">
                                    <div id="ctr-graph" style="width:100%;"></div>
                                </div>
                            </div>
                            <!------------------------------------- TOP SEARCH QUERY ------------------------------------->
                            <div class="main-grap-sec">
                                <div class="right-sec-big-hdng">
                                    <p class="lft-sec-big-hdng"><span><img class="icon-img" src="<?= site_url('assets/images/Keywords-Report.png') ?>"></span>Top Search Queries <i class="icon expend la la-plus tab-icons" data-toggle="collapse" data-target="#serch-q"></i></p>
                                </div>
                                <div id="serch-q" class="grap-sec top-search-query collapse table-responsive">
                                    <table class="table table-bordered text-light">
                                        <thead class="thead-default">
                                            <tr>
                                                <td> Title</td>
                                                <td> Clicks</td>
                                                <td> Click Through Rate</td>
                                                <td> Impressions</td>
                                                <td> Position</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($search_query->rows)) :
                                                foreach ($search_query->rows as $query):
                                                    ?>
                                                    <tr>
                                                        <td title="<?= $query[0] ? ucwords($query[0]) : ''; ?>"><?= text_limit($query[0] ? ucwords($query[0]) : '', 25); ?></td>
                                                        <td><?= $query->clicks ? $query->clicks : 0; ?></td>
                                                        <td><?= $query->ctr ? round_figure(($query->ctr * 100)) . '%' : 0.00; ?></td>
                                                        <td><?= $query->impressions ? $query->impressions : 0; ?></td>
                                                        <td><?= $query->position ? round_figure($query->position) : 0.00; ?></td>
                                                    </tr>
                                                    <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!------------------------------------- SUBMITTED AND INDEXED CONTENT ------------------------------------->
                            <div class="main-grap-sec">
                                <div class="right-sec-big-hdng">
                                    <p class="lft-sec-big-hdng"><span><img class="icon-img" src="<?= site_url('assets/images/sitemap-icon.png') ?>"></span>Sitemap Submitted and Indexed Content <i class="icon expend la la-minus tab-icons" data-toggle="collapse" data-target="#index-submit"></i></p>
                                </div>
                                <div id="index-submit" class="grap-sec collapse show">
                                    <div id="site-map" style="width:100%;"></div>
                                </div>
                            </div>
                        <?php endif;
                        ?>

                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
    (function ($) {

        $(document).ready(function () {
            $(".overflow-wrapper").animate('left', 2000);
            //$("#b").animate({left: "-=300"}, 1000);
        });

        $('.fetch-speed').on('click', function () {
            var card = $('.speed-loading');
            var Id = $('#main-con').attr('pro-index');
            card.LoadingOverlay("show", {image: "", custom: $("<div>", {text: 'Loading...'}), color: "rgba(255, 255, 255, 0.6)", zIndex: 2});
            $.get(SITE_URL + "fetch-site-speed/" + Id, function (data, status) {
                if (data) {
                    var data = JSON.parse(data);
                    $('.speed-loading .ks-time').text(data.last_update + ' ' + data.ago);
                    card.LoadingOverlay("hide");
                    $('.fetch-speed').fadeOut();
                }
            });
        });

        $('.fetch-mobile-friendly-status').on('click', function () {
            var card = $('.responsive-loading');
            var Id = $('#main-con').attr('pro-index');
            card.LoadingOverlay("show", {image: "", custom: $("<div>", {text: 'Loading...'}), color: "rgba(255, 255, 255, 0.6)", zIndex: 2});
            $.get(SITE_URL + "fetch-responsive-status/" + Id, function (data, status) {
                if (data) {
                    var data = JSON.parse(data);
                    $('.responsive-loading .ks-time').text(data.last_update + ' ' + data.ago);
                    card.LoadingOverlay("hide");
                    $('.fetch-mobile-friendly-status').fadeOut();
                }
            });
        });

        $('.fetch-blacklist-status').on('click', function () {
            var card = $('.blacklist-loading');
            var Id = $('#main-con').attr('pro-index');
            card.LoadingOverlay("show", {image: "", custom: $("<div>", {text: 'Loading...'}), color: "rgba(255, 255, 255, 0.6)", zIndex: 2});
            $.get(SITE_URL + "fetch-blacklist-status/" + Id, function (data, status) {
                if (data) {
                    var data = JSON.parse(data);
                    $('.blacklist-loading .ks-time').text(data.last_update + ' ' + data.ago);
                    card.LoadingOverlay("hide");
                    $('.fetch-blacklist-status').fadeOut();
                }
            });
        });

        $('.fetch-up-time-status').on('click', function () {
            var card = $('.uptime-loading');
            var Id = $('#main-con').attr('pro-index');
            card.LoadingOverlay("show", {image: "", custom: $("<div>", {text: 'Loading...'}), color: "rgba(255, 255, 255, 0.6)", zIndex: 2});
            $.get(SITE_URL + "fetch-uptime-status/" + Id, function (data, status) {
                if (data) {
                    var data = JSON.parse(data);
                    $('.uptime-loading .ks-time').text(data.last_update + ' ' + data.ago);
                    card.LoadingOverlay("hide");
                    $('.fetch-up-time-status').fadeOut();
                }
            });
        });


        $('.fetch-website-info').on('click', function () {
            // var url      = window.location.href;
            var card = $('body');
            var Id = $('#main-con').attr('pro-index');
            card.LoadingOverlay("show", {image: "", custom: $("<div>", {text: 'We are refreshing the website data, please wait...'}), color: "rgba(255, 255, 255, 0.6)", zIndex: 2});
            $.get(SITE_URL + "fetch-website-info/" + Id, function (data, status) {
                if (data) {
                    card.LoadingOverlay("hide");
                    location.reload();

                }
            });
        });
    })(jQuery);
</script>
<script src="<?= site_url('assets/public/chart/highcharts.js') ?>"></script>
<script src="<?= site_url('assets/public/chart/series-label.js') ?>"></script>
<script src="<?= site_url('assets/public/chart/exporting.js') ?>"></script>
<script src="<?= site_url('assets/public/flatpickr/flatpickr.min.js'); ?>"></script>
<script src="<?= site_url('application/modules/project/js/analyticsCharts.js') ?>"></script>
<script src="<?= site_url('assets/public/bootstrap-table/bootstrap-table.min.js') ?>"></script>
<script src="<?= site_url('application/modules/project/js/projects.js') ?>"></script>
