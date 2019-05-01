<div class="ks-page-container">
    <div class="ks-column ks-page"> 
        <div class="ks-page-container ks-dashboard-tabbed-sidebar-fixed-tabs">
            <div class="ks-column ks-page">

                <div class="ks-content">
                    <div class="ks-body Inner-container">
                        <div class="ks-dashboard-tabbed-sidebar">
                            <div class="ks-dashboard-tabbed-sidebar-widgets col-md-8 offset-md-2">
                                <div class="row ks-title-body">
                                    <div class="card-header col-lg-12">
                                        <h3 class="text-center">
                                            <?= strtoupper($title); ?>
                                            <div class="ks-controls">
                                            </div>
                                        </h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12"> 
                                        <div class="ks-tabs-container ks-tabs-default ks-tabs-no-separator ks-full ks-light">
                                            <ul class="nav ks-nav-tabs notification-page">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#" data-toggle="tab" data-target="#critical" aria-expanded="true">
                                                        <span class="ks-icon la la-exclamation-triangle text-danger"></span><?= (!empty($criticals)) ? '<span class="badge badge-pill badge-danger ks-badge ks-sm">' . count($criticals) . '</span>' : ''; ?>
                                                        Critical Alerts  
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link " href="#" data-toggle="tab" data-target="#reguler" aria-expanded="false">
                                                        <span class="ks-icon la la-exclamation-triangle text-warning"></span><?= (!empty($regulers)) ? '<span class="badge badge-pill badge-warning ks-badge ks-sm">' . count($regulers) . '</span>' : ''; ?>
                                                        Regular Alerts
                                                    </a>
                                                </li>                                               
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="critical" role="tabpanel">
                                                    <div class="card-block">
                                                        <?php
                                                        $flag = '';
                                                        if (!empty($criticals)) {
                                                            foreach ($criticals as $critical) {
                                                                $current_date = date('Y-m-d H:i:s');
                                                                $domain_expire_date = date('Y-m-d H:i:s', strtotime($critical->expire_date));
                                                                $d_start = new DateTime($current_date);
                                                                $d_end = new DateTime($domain_expire_date);
                                                                $diff = $d_start->diff($d_end);
                                                                $this->day = $diff->format('%m');
                                                                $flag = 1;
                                                                ?>
                                                                <div class="alert alert-danger ks-solid-light ks-active-border cursue-point" role="alert" onclick="location.href = '<?= site_url('project/detail/' . $critical->project_id) ?>'">
                                                                    <div class="ks-image-block">
                                                                        <img src="<?= (file_exists(FCPATH . 'assets/photo/screenshot/' . $critical->project_id . '-desktop.jpg')) ? site_url('assets/photo/screenshot/' . $critical->project_id . '-desktop.jpg') : site_url('assets/img/placeholders/placeholder.png'); ?> " width="36" height="36" class="ks-image rounded-circle">
                                                                        <div class="ks-info">
                                                                            <span class="ks-name" title="<?= ($critical->meta_title) ? $critical->meta_title : $critical->project_url; ?>"><?= explode('.', domain_name($critical->project_url))[0]; ?></span>
                                                                            <span class="ks-text"><?= $critical->web_alert; ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        if (!$flag) {
                                                            ?>
                                                            <div class="alert alert-success ks-solid-light ks-active-border" role="alert">
                                                                <div class="ks-image-block">
                                                                    <div class="ks-info">
                                                                        <span class="ks-name">Not upcoming task  is available</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="reguler" role="tabpanel">
                                                    <div class="card-block">
                                                        <?php
                                                        $flag = '';
                                                        if (!empty($regulers)) {
                                                            foreach ($regulers as $reguler) {
                                                                $current_date = date('Y-m-d H:i:s');
                                                                $domain_expire_date = date('Y-m-d H:i:s', strtotime($reguler->expire_date));
                                                                $d_start = new DateTime($current_date);
                                                                $d_end = new DateTime($domain_expire_date);
                                                                $diff = $d_start->diff($d_end);
                                                                $this->day = $diff->format('%m');
                                                                $flag = 1;
                                                                ?>
                                                                <div class="alert alert-warning ks-solid-light ks-active-border cursue-point" role="alert" onclick="location.href = '<?= site_url('project/detail/' . $reguler->project_id) ?>'">
                                                                    <div class="ks-image-block">
                                                                        <img src="<?= (file_exists(FCPATH . 'assets/photo/screenshot/' . $reguler->project_id . '-desktop.jpg')) ? site_url('assets/photo/screenshot/' . $reguler->project_id . '-desktop.jpg') : site_url('assets/img/placeholders/placeholder.png'); ?> " width="36" height="36" class="ks-image rounded-circle">
                                                                        <div class="ks-info">
                                                                            <span class="ks-name" title="<?= ($reguler->meta_title) ? $reguler->meta_title : $reguler->project_url; ?>"><?= explode('.', domain_name($reguler->project_url))[0]; ?></span>
                                                                            <span class="ks-text"><?= $reguler->web_alert; ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        if (!$flag) {
                                                            ?>
                                                            <div class="alert alert-warning ks-solid-light ks-active-border" role="alert">
                                                                <div class="ks-image-block">
                                                                    <div class="ks-info">
                                                                        <span class="ks-name">Not upcoming task  is available</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
//    $(document).ready(function () {
//        if ($('.Inner-container').height() < ($(window).height() - 190)) {
//            $('.Inner-container').css('height', $(window).height() - 190);
//        }
//    });
</script>