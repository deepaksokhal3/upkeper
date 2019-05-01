<div class="ks-page-container">
    <div class="ks-column ks-page"> 
        <?php //print_r($tab);die; ?>
        <!--div class="ks-header">
            <section class="ks-title">
                <h3><?= isset($title) ? $title : 'Add Project'; ?></h3>
                <button type="button" class="btn btn-success back-btu" onclick="goBack()">Go Back</button>
            </section>
        </div-->

        <?php $editSession = (object) $this->session->userdata('add_project'); ?>
        <div class="ks-content">
            
            <div class="ks-body ks-content-nav">
                <div class="ks-nav-body edit-inner Inner-container " index="<?= isset($projects['project_id']) ? $projects['project_id'] : ''; ?>" url="<?= isset($projects['project_url']) ? $projects['project_url'] : ''; ?>">                  
                    <div class="ks-nav-body-wrapper col-md-8 offset-md-2">
                        <div class="container-fluid">
                            <div class="ks-body ks-form-steps-progress-page">
                                <div class="row"> <div class="col-lg-12"><?php echo $this->session->flashdata('error'); ?></div></div>
                                <div class="row ks-title-body">
                                    <div class="edit-step"><button class="btn btn-primary-outline ks-light ks-form-steps-progress-steps-block-toggle" data-block-toggle=".ks-form-steps-progress-page > .ks-wrapper > .ks-steps">Steps</button></div>
                                    <div class=" card-header col-lg-12">
                                        <h3 class="text-center">
                                            <?= isset($title) ? strtoupper($title) : strtoupper('Add Project'); ?>
                                            <span class="ks-ip-title"><?= domain_name($projects['project_url']); ?></span>
                                        </h3>

                                    </div>

                                </div>
                                <div class="ks-wrapper">
                                    
                                    <div class="list-group ks-steps col-lg-3">
<!--                                        <a href="#" id="edit-1" class="ks-step-tab ks-list-group-item <?php // ($projects['project_id']) ? 'ks-completed' : 'ks-list-group-item-action';         ?> <?php !isset($tab) ? 'ks-current' : ''; ?>" focus="website-link-form">
                                            <span class="ks-point"><span></span></span>
                                            <span class="ks-text">Website link</span>
                                            <span class="la la-info-circle ks-info"></span>
                                        </a>-->
                                        <?php if ($projects['installed'] != 'NOT_WP') { ?>
                                            <a href="#" action="plugin" class="ks-step-tab ks-list-group-item <?= ($projects['project_id'] && $projects['status'] == 1) ? 'ks-completed' : 'ks-list-group-item-action ks-invalid'; ?> <?= !isset($tab) && $projects['installed'] != 'NOT_WP' ? 'ks-current' : ''; ?>" focus="WP-plugin-form">
                                                <span class="ks-point"><span></span></span>
                                                <span class="ks-text">WP Plugin</span>
                                                <span class="la la-info-circle ks-info"></span>
                                            </a>
                                            <a href="#" action="snmt-admin-credentials" class="ks-step-tab ks-list-group-item  <?= (!empty($projects['credential_id']) && $projects['credentials_status'] == 1) ? 'ks-completed' : ((!empty($projects['credential_id']) && $projects['credentials_status'] == 0) ? 'ks-list-group-item-action ks-invalid' : 'ks-list-group-item-action'); ?>" focus="admin-login-form">
                                                <span class="ks-point"><span></span></span>
                                                <span class="ks-text">Admin Login</span>
                                                <span class="la la-info-circle ks-info"></span>
                                            </a>
                                        <?php } ?>
                                        <a href="#" action="google-analytics" class="ks-step-tab ks-list-group-item <?= isset($projects['access_token']) && !empty($projects['access_token']) ? 'ks-completed' : 'ks-list-group-item-action'; ?> <?= !isset($tab) && ($projects['installed'] == 'NOT_WP') ? 'ks-current' : ''; ?>" focus="google-analytics">
                                            <span class="ks-point"><span></span></span>
                                            <span class="ks-text">Google Analytics</span>
                                            <span class="la la-info-circle ks-info"></span>
                                        </a>
                                        <a href="#" action="reporting" class="ks-step-tab ks-list-group-item ks-list-group-item-action <?= isset($projects['report_id']) ? 'ks-completed' : ''; ?> <?= isset($tab) && $tab == 3 ? 'ks-current' : ''; ?>" focus="reporting-form">
                                            <span class="ks-point"><span></span></span>
                                            <span class="ks-text">Reporting</span>
                                            <span class="la la-info-circle ks-info"></span>
                                        </a>
                                        <a href="#" action="confirm-delete" class="ks-step-tab ks-list-group-item ks-list-group-item-action" focus="delete-form">
                                            <span class="ks-point"><span></span></span>
                                            <span class="ks-text">Delete</span>
                                            <span class="la la-info-circle ks-info"></span>
                                        </a>
                                    </div>
                                    <div class="ks-steps-content col-lg-9 edit-project">
                                        <div class="ks-steps-wrapper ">
                                            <div class="tab-forms-section" id="<?= isset($admindetail) ? $admindetail : ''; ?>">
                                                <div class="col-lg-12">

                                                    <!--===================================== website link section ===================================--> 

<!--                                                    <form class="ks-step website-link-form edt-url-form" style="<?= isset($tab) ? 'display:none;' : 'display:block;'; ?>">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  value="<?= ($projects['project_url']) ? $projects['project_url'] : ''; ?>" placeholder="Please enter website link" readonly>
                                                        </div>
                                                    </form>-->

                                                    <!--===================================== wp plugin verification section ===================================--> 

                                                    <div class="ks-step WP-plugin-form" style="<?= !isset($tab) && ($projects['installed'] != 'NOT_WP') ? 'display:block' : 'display:none'; ?>">
                                                        <div class="card panel section-step-1">
                                                            <div class="card-block ">

                                                                <div class="plugin-download-section" style="<?= ($plugin_status == 'no' && !isset($plugin)) ? 'display:block' : 'display:none'; ?>">
                                                                    <div class="row">
                                                                        <div class="col-lg-12 text-center">
                                                                            <div class="ks-error-page"><div class="ks-error-description"><p>Download the plugin below and install on your website.</p> <p>This plugin helps us get the required health data from your website.</p></div></div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12 text-center">
                                                                            <a href="<?= site_url('upkepr-Maintenance.zip'); ?>" class="btn download-plugin btn-color btn-lg">DOWNLOAD NOW</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="plugin-dectivate-section" style="<?= (isset($plugin) && $plugin == 'deactivated') ? 'display:block' : 'display:none'; ?>">
                                                                    <div class="row">

                                                                        <div class="col-lg-12 text-center">
                                                                            <div class="ks-error-page"><div class="ks-error-description"><p>If you owner of website <?= ($projects['project_url']) ? '"' . $projects['project_url'] . '"' : ''; ?>. Please Activate installed plugin for you website report.</p></div></div>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="plugin-activate-section">
                                                                    <div class="row">
                                                                        <div class="col-lg-12 text-center">
                                                                            <div class="ks-error-page"><div class="ks-error-description ks-color-success"><p><?= ($projects['status'] == 1) ? 'Verification successful. Please click here to proceed to next step' : ( ($plugin_status == 'Yes') ? 'The plugin is already installed, please click here to verify your installation' : 'After you install the plugin,  please click here to verify your installation'); ?>. </p></div></div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12 text-center">
                                                                            <button class="btn btn-color btn-lg <?= ($projects['status'] == 0) ? 'verify-plugin' : 'ks-split'; ?>"><?= ($projects['status'] == 1) ? '<span class="la la-check ks-icon"></span><span class="ks-text">INSTALLATION VERIFIED</span>' : ' VERIFY INSTALLATION '; ?></button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row successfully-pligin" style="display:none">
                                                                        <div class="col-lg-12 text-center">
                                                                            <div class="ks-error-page"><div class="ks-error-description ks-color-success"><p>Verification successful. Please click here to proceed to next step.  </p></div></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row error-pligin" style="display:none">
                                                                        <div class="col-lg-12 text-center">
                                                                            <div class="ks-error-page"><div class="ks-error-description ks-color-danger"><p>Verification failed. Please try again. You can click here to know how to install the plugin.</p><p> Click “verify installation” button again to verify.    </p></div></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!--===================================== Admin login section ===================================-->

                                                    <form class="ks-step admin-login-form admin-credentials" method="post" style="display:none;">
                                                        <div class="col-lg-12 text-center">
                                                            <input type="hidden" name="credential_id" value="<?= (isset($projects['credential_id'])) ? $projects['credential_id'] : ''; ?>"/>
                                                            <input type="hidden" value="<?= isset($projects['project_id']) ? $projects['project_id'] : '' ?>" name="project_id"/>
                                                            <div class="row">
                                                                <div class="form-group col-lg-12">
                                                                    <input type="text" class="form-control" name="login_url" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?= ($projects['project_url']) ? $projects['project_url'] : ''; ?>" readonly     placeholder="Please enter password">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-lg-12">
                                                                    <input type="text" class="form-control" name="username" id="exampleInputEmail1" value="<?= ($projects['user_name']) ? $projects['user_name'] : ''; ?>" aria-describedby="emailHelp" placeholder="Please enter user name">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-lg-12">
                                                                    <input type="password" class="form-control" name="password" id="exampleInputEmail1" value="<?php // ($projects['password']) ? $projects['password'] : ''; ?>" aria-describedby="emailHelp" placeholder="******************">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <!--===================================== Google Analytics ===================================-->

                                                    <div class="ks-step google-analytics" style="<?= !isset($tab) && ($projects['installed'] == 'NOT_WP') ? 'display:block' : 'display:none'; ?>">
                                                        <div class="card panel section-step-1">
                                                            <div class="card-block ">
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-center">
                                                                        <div class="ks-error-page">
                                                                            <div class="ks-error-description">
                                                                                <p> 
                                                                                    <?= lang_msg('ANALYTICS_NOTE'); ?>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-center">
                                                                        <a class=" btn btn-color btn-lg  <?= ($projects['access_token']) ? 'ks-split' : 'login-btn'; ?>" href=" <?= ($projects['access_token']) ? site_url('logout-analytics/' . $projects['project_id']) : ''; ?>" ><?= ($projects['access_token']) ? '<span class="la la-check ks-icon"></span><span class="ks-text">GOOGLE ANALYTICS LOGOUT</span>' : '<span class="ks-text"> GOOGLE LOGIN</span>'; ?></span></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!--===================================== Reporting  section ===================================--> 

                                                    <form id="reporting-form" class="ks-step reporting-form edt-url-form" style="<?= isset($tab) && $tab == 3 ? 'display:block;' : 'display:none;'; ?>">

                                                        <div class="form-section">
                                                            <div class="row">
                                                                <div class="form-group col-lg-12">
                                                                    <?= lang_msg('REPORT_NOTE'); ?>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" value="<?= isset($projects['project_id']) ? $projects['project_id'] : '' ?>" name="project_id"/>
                                                            <input type="hidden" id='notifiationId' value="<?= isset($alert_setting->notification_id) ? $alert_setting->notification_id : ''; ?>" name="notification_id"/>
                                                            <div class="row alert-section">
                                                                <?php
                                                                if (!empty($alerts)):
                                                                    foreach ($alerts as $key => $alert):

                                                                        if ($alert['alert_type'] == 1):
                                                                            $checkRenwAlt = ( $alert_setting && isset($alert_setting->renewal_alert)) ? (in_array($alert['alert_id'], explode(",", $alert_setting->renewal_alert)) ? 'checked' : '') : 'checked';
//                                                                          
                                                                            ?>
                                                                            <div class="col-lg-6">
                                                                                <div class="card panel panel-default panel-table">
                                                                                    <h5>
                                                                                        <span class="ks-title"><?= $alert['alert_name']; ?></span>
                                                                                        <span class="ks-description"><?= lang_msg($alert['description']); ?></span>
                                                                                        <div class="pull-right">
                                                                                            <label class="ks-checkbox-slider ks-on-off ks-solid ks-success">
                                                                                                <input type="checkbox" class="set-alert" name="renewal_alert[]" value="<?= $alert['alert_id']; ?>"  <?= $checkRenwAlt; ?>>
                                                                                                <span class="ks-indicator"></span>
                                                                                                <span class="ks-on">On</span>
                                                                                                <span class="ks-off">Off</span>
                                                                                            </label> 
                                                                                        </div>
                                                                                    </h5>

                                                                                </div>
                                                                            </div>

                                                                            <?php
                                                                        endif;
                                                                    endforeach;
                                                                endif;
                                                                ?>
                                                            </div>
                                                            <div class="row alert-section">

                                                                <?php
                                                                if (!empty($alerts)):
                                                                    foreach ($alerts as $key => $alert):
                                                                        $checkHapdAlt = (isset($alert_setting->happen_alert)) ? (in_array($alert['alert_id'], explode(",", $alert_setting->happen_alert)) ? 'checked' : '') : 'checked';

                                                                        if (($alert['alert_type'] == 2 && $projects['installed'] == 'NOT_WP') && !in_array($alert['alert_id'], array(9, 12, 13))):
                                                                            ?>
                                                                            <div class="col-lg-6">
                                                                                <div class="card panel panel-default panel-table">
                                                                                    <h5>
                                                                                        <span class="ks-title"><?= $alert['alert_name']; ?></span>
                                                                                        <span class="ks-description"><?= lang_msg($alert['description']); ?></span>
                                                                                        <div class="pull-right">
                                                                                            <label class="ks-checkbox-slider ks-on-off ks-solid ks-success">
                                                                                                <input type="checkbox" class="set-alert" name="happen_alert[]" value="<?= $alert['alert_id']; ?>"  <?= $checkHapdAlt; ?>>
                                                                                                <span class="ks-indicator"></span>
                                                                                                <span class="ks-on">On</span>
                                                                                                <span class="ks-off">Off</span>
                                                                                            </label> 
                                                                                        </div>
                                                                                    </h5>

                                                                                </div>
                                                                            </div>

                                                                            <?php
                                                                        elseif ($alert['alert_type'] == 2 && $projects['installed'] != 'NOT_WP'):
                                                                            ?>
                                                                            <div class="col-lg-6">
                                                                                <div class="card panel panel-default panel-table">
                                                                                    <h5>
                                                                                        <span class="ks-title"><?= $alert['alert_name']; ?></span>
                                                                                        <span class="ks-description"><?= lang_msg($alert['description']); ?></span>
                                                                                        <div class="pull-right">
                                                                                            <label class="ks-checkbox-slider ks-on-off ks-solid ks-success">
                                                                                                <input type="checkbox" class="set-alert" name="happen_alert[]" value="<?= $alert['alert_id']; ?>"  <?= $checkHapdAlt; ?>>
                                                                                                <span class="ks-indicator"></span>
                                                                                                <span class="ks-on">On</span>
                                                                                                <span class="ks-off">Off</span>
                                                                                            </label> 
                                                                                        </div>
                                                                                    </h5>

                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        endif;
                                                                    endforeach;
                                                                endif;
                                                                ?>

                                                            </div> 
                                                            <input type="hidden" id="reportId" name="report_id" value="<?= isset($projects['report_id']) ? $projects['report_id'] : ''; ?>">
                                                            <input type="hidden" name="project_id" value="<?= ($projects['project_id']) ? $projects['project_id'] : ''; ?>" >
                                                            <div class="row">
                                                                <div class="form-group col-lg-12">
                                                                    <label class="card-title">Email address to receive the reports email</label>
                                                                    <input type="email" class="form-control text-left" name="email" id="report-email" value="<?= ($projects['r_email']) ? $projects['r_email'] : $projects['u_email']; ?>" placeholder="Please enter email">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-lg-12">
                                                                    <label class="card-title">Send Reports</label>
                                                                    <select class="form-control" name="report_time" id="report-period">
                                                                        <option value="">Send project(s) maintenance report</option>
                                                                        <option value="2" <?= (isset($projects['report_time']) && trim($projects['report_time']) == 2) ? 'selected' : ''; ?>>Weekly</option>
                                                                        <option value="3" <?= (isset($projects['report_time']) && trim($projects['report_time']) == 3) ? 'selected' : (!isset($projects['report_time']) ? 'selected' : ''); ?>>Monthly</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-xl-12">
                                                                    <label class="card-title">Email Format </label> <code>Please do not changes under text [example]. </code>
                                                                </div>
                                                                <div class="form-group col-lg-12">
                                                                    <textarea name="custom_temp" class="email-temp" data-animation="false" id="ks-summernote-editor-default"><?= isset($projects['custom_temp']) && $projects['custom_temp'] ? $projects['custom_temp'] : $default_temp->template_text; ?></textarea>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-xl-12">
                                                                    Click here to see the sample email <a href="javascript:void(0);" class="display_report">Sample Email</a>

                                                                </div>
                                                                <div class="form-group col-xl-12">
                                                                    <a href="javascript:void(0);" class="restore">Restore Default Format</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </form>

                                                    <!--===================================== notification setting section ===================================-->

                                                    <div class="ks-step delete-form" style="display:none;">
                                                        <div class=" panel section-step-1">
                                                            <div class="card-block ">
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-center">
                                                                        <div class="ks-error-page"><div class="ks-error-description"><p>You will receive an email on the registered email address to confirm deletion of the project, once you confirm it, all the data about the project shall be permanently wiped off </p></div></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 text-center">
                                                                        <button  id="confirm-delete" class="btn btn-color">DELETE PROJECT</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ks-controls ks-flex-end e-flx">
                                                <button id="<?= !isset($tab) && $projects['installed'] != 'NOT_WP' ? 'plugin' : (isset($tab) && $tab == 3 ? 'reporting' : 'google-analytics'); ?>" class="btn btn-color ks-next">Save And Next</button>
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
<div class="modal fade bd-example-modal-horizontal-form" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sample Report Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="la la-close"></span>
                </button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function () {
        $('.display_report').on('click', function () {
            $.ajax({
                type: 'post',
                url: SITE_URL + 'project/display_sample_report',
                data: {template: document.getElementById("ks-summernote-editor-default").value},
                dataType: 'json',
                success: function (data) {
                    $(".modal-body").html(data.template);
                    $(".bd-example-modal-horizontal-form").modal('show');

                }
            });

        });


        $('.restore').on('click', function () {
            $.ajax({
                type: 'get',
                url: SITE_URL + 'project/restore_report',
                dataType: 'json',
                success: function (data) {
                    $('#ks-summernote-editor-default').summernote('code', data.template);
                }
            });
        });
        $(document).on('click', '.opt-out', function () {
            if ($($(this).children('input')[0]).is(':checked') == true) {
                $('.opt-out-alerts div').each(function (e, a) {
                    a.children[0].children[0].checked = false;
                });
            } else if ($($(this).children('input')[0]).is(':checked') == false) {

                $('.opt-out-alerts div').each(function (e, a) {
                    a.children[0].children[0].checked = true;
                });
            }
        });
    });</script>
<script src="<?= site_url('application/modules/project/js/project-verify.js') ?>"></script>