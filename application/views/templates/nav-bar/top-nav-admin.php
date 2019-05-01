<!-- BEGIN HEADER -->
<nav class="navbar ks-navbar">
    <!-- BEGIN HEADER INNER -->
    <!-- BEGIN LOGO -->
    <div href="index.html" class="navbar-brand">
        <!-- BEGIN RESPONSIVE SIDEBAR TOGGLER -->
        <a href="#" class="ks-sidebar-toggle"><i class="ks-icon la la-bars" aria-hidden="true"></i></a>
        <a href="#" class="ks-sidebar-mobile-toggle"><i class="ks-icon la la-bars" aria-hidden="true"></i></a>
        <!-- END RESPONSIVE SIDEBAR TOGGLER -->

        <div class="ks-navbar-logo">
            <a href="<?= site_url('21232f297a57a5a743894a0e4a801fc3') ?>" class="ks-logo"><img src="<?= site_url('assets/img/avatars/logo-white-color.png'); ?>" width="118"/></a>
            <!-- END GRID NAVIGATION -->
        </div>
    </div>
    <!-- END LOGO -->

    <!-- BEGIN MENUS -->
    <div class="ks-wrapper">
        <nav class="nav navbar-nav">
            <!-- BEGIN NAVBAR MENU -->
            <div class="ks-navbar-menu">
            </div>
            <!-- END NAVBAR MENU -->

            <!-- BEGIN NAVBAR ACTIONS -->
            <div class="ks-navbar-actions">
                <!-- BEGIN NAVBAR NOTIFICATIONS -->

                <!-- END NAVBAR NOTIFICATIONS -->

                <!-- BEGIN NAVBAR USER -->
                <div class="nav-item dropdown ks-user">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="ks-avatar">
                            <img src="<?= (isset($this->admin_session['prof_pic']) && !empty($this->admin_session['prof_pic'])) ? site_url($this->admin_session['prof_pic']) : site_url('assets/photo/profile/default-profile.png'); ?>" width="36" height="36">
                        </span>
                        <span class="ks-info">
                            <span class="ks-name"><?= (isset($this->admin_session['f_name'])) ? $this->admin_session['f_name'] : ''; ?></span>
                            <span class="ks-description"><?= (isset($this->admin_session['user_email'])) ? $this->admin_session['user_email'] : ''; ?></span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Preview">
                        <a class="dropdown-item" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/sign-out'); ?>">
                            <span class="la la-sign-out ks-icon" aria-hidden="true"></span>
                            <span>Logout</span>
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
<!-- BEGIN NAVBAR HORIZONTAL ICONBAR -->
<div class="ks-navbar-horizontal  ks-info">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link <?= (isset($tab) && $tab == 1) ? 'active' : ''; ?>" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3') ?>">

                <span class="ks-text">Dashboard</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link <?= (isset($tab) && $tab == 8) ? 'active' : ''; ?>" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/projects') ?>">

                <span class="ks-text">Projects</span>
            </a>
        </li>
        
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?= (isset($tab) && $tab == 3) ? 'active' : ''; ?> " data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">

                <span class="ks-text">Companies</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/register') ?>">Create Account</a>
                <a class="dropdown-item active" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/companies') ?>">Companies</a>
            </div>
        </li>
        <li class="nav-item ">
            <a class="nav-link  <?= (isset($tab) && ($tab == 2 || $tab == 6)) ? 'active' : ''; ?> " href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/email-templates') ?>">

                <span class="ks-text">Email Templates</span>
            </a>
<!--            <div class="dropdown-menu">
                <a class="dropdown-item <?php (isset($tab) && $tab == 2) ? 'active' : ''; ?>" href="<?php site_url('21232f297a57a5a743894a0e4a801fc3/alerts') ?>">Alert Templates</a>
                <a class="dropdown-item <?php (isset($tab) && $tab == 6) ? 'active' : ''; ?>" href="<?php site_url('21232f297a57a5a743894a0e4a801fc3/email-templates') ?>">Common Template</a>
            </div>-->
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?= (isset($tab) && $tab == 7) ? 'active' : ''; ?> " data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">

                <span class="ks-text">Setting</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item " href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/alert-setting') ?>">Alerts</a>
                 <a class="dropdown-item" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/cron-frequency') ?>">Cron Frequency</a>
            </div>

        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?= (isset($tab) && $tab == 4) ? 'active' : ''; ?> " data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">

                <span class="ks-text">Host Companies</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item " href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/hostmanager') ?>">Hosting Company</a>
                 <a class="dropdown-item" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/mail-server') ?>">Mailer Company</a>
            </div>

        </li>
        
        <li class="nav-item">
            <a class="nav-link <?= (isset($tab) && $tab == 5) ? 'active' : ''; ?>" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/errro-massage') ?>">

                <span class="ks-text">Error Manager</span>
            </a>
        </li>
    </ul>
</div>

<!-- END NAVBAR HORIZONTAL ICONBAR -->
