<div class="ks-page-container">
    <div class="ks-column ks-page"> 

        <div class="ks-page-container ks-dashboard-tabbed-sidebar-fixed-tabs">

            <div class="ks-column ks-page">
                <!-- <div class="ks-header">
                    <section class="ks-title-and-subtitle">
                        <div class="ks-title-block">
                            <h3 class="ks-main-title">Dashboard / Tabbed Sidebar</h3>
                            <div class="ks-sub-title">This is header sub title</div>
                        </div>
                        <button class="btn btn-secondary-outline ks-light ks-no-text ks-tabbed-sidebar-navigation-block-toggle" data-block-toggle=".ks-dashboard-tabbed-sidebar-sidebar">
                            <span class="ks-icon la la-bars"></span>
                        </button>
                    </section>
                </div> -->
                <div class="ks-content">
                    <div class="ks-body">
                        <div class="ks-dashboard-tabbed-sidebar">
                            <div class="ks-dashboard-tabbed-sidebar-widgets">
                                <div class="row">
                                    <div class="col-xl-12 error-msg"></div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="card ks-widget-payment-simple-amount-item ks-purple">
                                            <div class="payment-simple-amount-item-icon-block">
                                                <span class="ks-icon-combo-chart ks-icon"></span>
                                            </div>

                                            <div class="payment-simple-amount-item-body">
                                                <div class="payment-simple-amount-item-amount">
                                                    <span class="ks-amount"><?= 'Total Projects: ' . count($projects); ?></span>
                                                    <span class="ks-amount-icon ks-icon-circled-up-right"></span>
                                                </div>
                                                <div class="payment-simple-amount-item-description">
                                                    Deactivated <span class="ks-progress-type">(0)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="card ks-widget-payment-simple-amount-item ks-pink">
                                            <div class="payment-simple-amount-item-icon-block">
                                                <span class="ks-icon-user ks-icon"></span>
                                            </div>

                                            <div class="payment-simple-amount-item-body">
                                                <div class="payment-simple-amount-item-amount">
                                                    <span class="ks-amount">Total Company:  <?= count($users) ?></span>
                                                    <span class="ks-amount-icon ks-icon-circled-down-left"></span>
                                                </div>
                                                <div class="payment-simple-amount-item-description">
                                                    Active Clients <span class="ks-progress-type">(<?= $active_users; ?>)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-xl-8">
                                        <div class="card ks-card-widget ks-widget-payment-table">
                                            <h5 class="card-header">
                                                Users

                                                <div class="ks-controls">
                                                    <a href="#" class="ks-control-link"></a>
                                                </div>
                                            </h5>
                                            <div class="card-block">
                                                <table class="table ks-payment-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Logo/Name</th>
                                                            <th>Email Address</th>
                                                            <th>Total Projects</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($users as $key => $user) { ?>
                                                            <tr>
                                                                <td class="ks-text-bold ks-text-no-wrap">
                                                                    <img src="<?= site_url('assets/img/profile/ava-256.png'); ?>" width="28" height="28" class="ks-avatar ks-img-circle"> <?= $user->company_name; ?>
                                                                </td>
                                                                <td class="ks-text-light"><?= $user->user_email; ?></td>
                                                                <td class="ks-text-light"><?= $user->total_projects; ?></td>
                                                                <td class="ks-text-light <?= $key; ?>-status"><?= $user->status == 4 ? 'Blocked' : ($user->status == 1 ? 'Unblocked' : 'Pending'); ?> </td>
                                                                <td class="ks-text-light ks-text-right ks-text-no-wrap">
                                                                    <span class="la <?= $user->status == 4 ? 'la-lock' : 'la-unlock-alt'; ?> cursue-point block-action" counter="<?= $key; ?>" index="<?= $user->user_id; ?>" status="<?= $user->status; ?>"></span>
                                                                    <span class=" la la-sign-in icon cursue-point text-primary-on-hover" onclick="location.href = '<?= site_url('21232f297a57a5a743894a0e4a801fc3/login_user/' . $user->user_id) ?>'"></span>
                                                                    <span  data-toggle="tooltip" data-placement="bottom" title="Edit" onclick="location.href = '<?= site_url('21232f297a57a5a743894a0e4a801fc3/edit-company-profile/' . $user->user_id) ?>'" class="la la-pencil icon cursue-point text-primary-on-hover"></span>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="panel card-block">
                                            <h4 id="select2-single-select-boxes">Move Project</h4>
                                            <form id="moveProject" class="" method="post" action="">
                                                <div class="row">
                                                    <div class="form-group col-xl-6">
                                                        <input class="form-control search-to-move" name="project_id" list="project-move-plan" placeholder="Search project"type="text">
                                                        <datalist id="project-move-plan">
                                                        </datalist>
                                                    </div>
                                                    <div class="form-group col-xl-6">
                                                        <input class="form-control search-user" name="user_id" list="move-to-user" placeholder="Search Users"type="text">
                                                        <datalist id="move-to-user">
                                                        </datalist>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-xl-6">
                                                        <button type="button" class="btn btn-success right move-project" >Move</button>
                                                    </div>
                                                </div>
                                            </form>
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
<script src="<?= site_url('assets/admin/js/common.js'); ?>"></script>
<script src="<?= site_url('assets/admin/js/dashbord.js'); ?>"></script>