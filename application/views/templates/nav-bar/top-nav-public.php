<div class="nav-section">
    
    <?php //print_r($active_nav);die;?>
    <nav class="navbar ks-navbar">
        <!-- BEGIN HEADER INNER -->
        <!-- BEGIN LOGO -->
        <div href="<?= site_url(); ?>" class="navbar-brand">

            <!-- END RESPONSIVE SIDEBAR TOGGLER -->

            <div class="ks-navbar-logo">
                <a href="<?= site_url(); ?>" class="ks-logo"><?= isset($this->session_data['company_name']) ? $this->session_data['company_name'] : '' ?></a>

                <!-- END GRID NAVIGATION -->
            </div>
        </div>
        
        <!-- END LOGO -->
        <?php $user_profile_data = get_user_profile_pic(); ?>
        <!-- BEGIN MENUS -->
        <div   class="ks-wrapper">
            <nav  class="nav navbar-nav">
                <!-- BEGIN NAVBAR MENU -->
                <div class="ks-navbar-menu">
                    <?php echo form_open('search', array('name' => 'search', 'class' => 'ks-search-form', 'method' => 'post')); ?>

                    <div class="ks-wrapper">
                        <div class="input-icon icon-right icon icon-lg icon-color-primary">
                            <!--div class="input_search">
                                <!--input type="text" name="keywords" placeholder="search projects..." />
                                <input type="button" />
                            </div-->
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                    <a class="nav-item nav-link <?= isset($active_nav) && $active_nav == 1?'nav-active':'';?>" href="<?= site_url(); ?>">Dashboard</a>
                    <a class="nav-item nav-link <?= isset($active_nav) && $active_nav == 2?'nav-active':'';?>" href="<?= site_url('add-project'); ?>">Add New Project</a>

                </div>
                <!-- END NAVBAR MENU -->
                <!-- BEGIN NAVBAR ACTIONS -->
                <div class="ks-navbar-actions">
                    <div class="nav-item dropdown ks-notifications">
                        <a class="nav-link dropdown-toggle notifications-counter-update" index="<?= $new_notifications ? subArraysToString($new_notifications) : ''; ?>" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="la la-bell ks-icon" aria-hidden="true">
                                <?= (isset($alert_total) && !empty($alert_total)) ? '<span class="badge badge-pill badge-info">' . $alert_total . '</span>' : ''; ?>
                            </span>
                            <span class="ks-text">Alert`s</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Preview">
                            <ul class="nav nav-tabs ks-nav-tabs ks-info notificatiob" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#" data-toggle="tab" data-target="#navbar-notifications-all" role="tab"><span class="ks-icon la la-exclamation-triangle text-danger"></span><?= (!empty($critical)) ? '<span class="badge badge-pill badge-danger ks-badge ks-sm">' . count($critical) . '</span>' : ''; ?> Critical Alerts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="tab" data-target="#navbar-notifications-activity" role="tab"><span class="ks-icon la la-exclamation-triangle text-warning"></span><?= (!empty($reguler)) ? '<span class="badge badge-pill badge-warning ks-badge ks-sm">' . count($reguler) . '</span>' : ''; ?> Regular Alerts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="tab" data-target="#navbar-notifications-activity" role="tab"></a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane <?= (!empty($critical)) ? 'ks-notifications-tab' : 'ks-empty'; ?> active" id="navbar-notifications-all" role="tabpanel">
                                    <?php
                                    $flag = '';
                                    if (!empty($critical)) {

                                        echo ' <div class="ks-wrapper ks-scrollable">';
                                        foreach ($critical as $important) {
                                            $current_date = date('Y-m-d H:i:s');
                                            $domain_expire_date = date('Y-m-d H:i:s', strtotime($important->expire_date));
                                            $d_start = new DateTime($current_date);
                                            $d_end = new DateTime($domain_expire_date);
                                            $diff = $d_start->diff($d_end);
                                            $this->day = $diff->format('%m');
                                            // if ($this->day > 3) {
                                            $flag = 1;
                                            ?>
                                            <a href="#" class="ks-notification">
                                                <div class="ks-avatar">
                                                    <img src="<?= (file_exists(FCPATH . 'assets/photo/screenshot/' . $important->project_id . '-desktop.jpg')) ? site_url('assets/photo/screenshot/' . $important->project_id . '-desktop.jpg') : site_url('assets/img/placeholders/placeholder.png'); ?>" width="36" height="36">
                                                </div>
                                                <div class="ks-info">
                                                    <div class="ks-user-name"><?= domain_name($important->project_url) ?></div>
                                                    <div class="ks-text"><?= $important->web_alert; ?></div>
                                                    <div class="ks-datetime"><?= date('d M Y', strtotime($important->created_at)); ?></div>
                                                </div>
                                            </a>
                                            <?php
                                            // }
                                        }
                                        echo '</div><div class="ks-view-all"><a href="' . site_url('alerts') . '">Show more</a></div>';
                                    } else {
                                        echo 'There are no alert`s';
                                    }
                                    ?>
                                </div>
                                <div class="tab-pane <?= (!empty($reguler)) ? 'ks-notifications-tab' : 'ks-empty'; ?>" id="navbar-notifications-activity" role="tabpanel">
                                    <?php
                                    $flag = '';
                                    if (!empty($reguler)) {
                                        echo ' <div class="ks-wrapper ks-scrollable">';
                                        foreach ($reguler as $important) {
                                            $current_date = date('Y-m-d H:i:s');
                                            $domain_expire_date = date('Y-m-d H:i:s', strtotime($important->expire_date));
                                            $d_start = new DateTime($current_date);
                                            $d_end = new DateTime($domain_expire_date);
                                            $diff = $d_start->diff($d_end);
                                            $this->day = $diff->format('%m');
                                            // if ($this->day > 3) {
                                            $flag = 1;
                                            ?>
                                            <a href="#" class="ks-notification">
                                                <div class="ks-avatar">
                                                    <img src="<?= (file_exists(FCPATH . 'assets/photo/screenshot/' . $important->project_id . '-desktop.jpg')) ? site_url('assets/photo/screenshot/' . $important->project_id . '-desktop.jpg') : site_url('assets/img/placeholders/placeholder.png'); ?>" width="36" height="36">
                                                </div>
                                                <div class="ks-info">
                                                    <div class="ks-user-name"><?= domain_name($important->project_url) ?></div>
                                                    <div class="ks-text"><?= $important->web_alert; ?></div>
                                                    <div class="ks-datetime"><?= date('d M Y', strtotime($important->created_at)); ?></div>
                                                </div>
                                            </a>
                                            <?php
                                            // }
                                        }
                                        echo '</div><div class="ks-view-all"><a href="' . site_url('alerts') . '">Show more</a></div>';
                                    } else {
                                        echo 'There are no alert`s';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END NAVBAR NOTIFICATIONS -->

                    <div class="nav-item dropdown ks-user">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="ks-avatar">
                                <img src="<?=  site_url('assets/img/profile/ava-256.png'); ?>" width="36" height="36">
                            </span>
                            <span class="ks-info">
                                <span class="ks-name"><?= isset($this->session_data['company_name']) ? $this->session_data['company_name'] : '' ?></span>
                                <span class="ks-description"><?= isset($this->session_data['user_email']) ? $this->session_data['user_email'] : '' ?></span>
                            </span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right my-acc" aria-labelledby="Preview">
                            <?php if ($this->session_data) { ?>
                                <a class="dropdown-item" href="<?= site_url('profile') ?>">
                                    <span class="la la-user ks-icon"></span>
                                    <span>My Account</span>
                                </a>    
                            <?php } ?>

                            <a class="dropdown-item" href="<?= ($this->session_data) ? site_url('logout') : site_url('login') ?>">
                                <span class="la la-sign-out ks-icon" aria-hidden="true"></span>
                                <span><?= ($this->session_data) ? 'Logout' : 'Login'; ?> </span>
                            </a>
                        </div>
                    </div>
                    <!-- END NAVBAR USER -->
                </div>
                <!-- END NAVBAR ACTIONS -->
            </nav>

            <!-- BEGIN NAVBAR ACTIONS TOGGLER -->
            <nav class="nav navbar-nav ks-navbar-actions-toggle">
                <a class="nav-item nav-link" href="#">
                    <span class="la la-ellipsis-h ks-icon ks-open"></span>
                    <span class="la la-close ks-icon ks-close"></span>
                </a>
            </nav>
            <!-- END NAVBAR ACTIONS TOGGLER -->

            <!-- BEGIN NAVBAR MENU TOGGLER -->
            <nav class="nav navbar-nav ks-navbar-menu-toggle">
                <a class="nav-item nav-link" href="#">
                    <span class="la la-th ks-icon ks-open"></span>
                    <span class="la la-close ks-icon ks-close"></span>
                </a>
            </nav>
            <!-- END NAVBAR MENU TOGGLER -->
        </div>
        <!-- END MENUS -->
        <!-- END HEADER INNER -->
    </nav>
    <!-- END HEADER -->
</div>
<script>
    $(document).ready(function () {
        $('.notifications-counter-update').click(function () {
            var alert_ids = this.getAttribute('index');
            $.post(SITE_URL + 'update-counter', {ids: alert_ids}, function (data, status) {
                if (data) {
                    $('.la-bell .badge-info').remove();
                }
            });
        });
    });
</script>
