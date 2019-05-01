<div class="ks-page-container">
    <div class="ks-column ks-page"> 
        <div class="ks-content">
            <div class="ks-body ks-content-nav">
                <div class="ks-nav-body Inner-container" index="<?= isset($process_session['project_id']) ? $process_session['project_id'] : ''; ?>" url="<?= isset($process_session['project_url']) ? $process_session['project_url'] : ''; ?>">
                    <div class="ks-nav-body-wrapper col-md-8 offset-md-2">
                        <div class="container-fluid">
                            <div class="row ks-title-body">
                                <div class="col-lg-12">
                                    <h3 class="text-center">
                                        <?php //echo '<pre>'; print_r($process_session);die;?>
                                        <?= isset($process_session['project_url']) ? strtoupper(domain_name($process_session['project_url'])) : strtoupper($title); ?>
                                    </h3>
                                    <?php if(isset($process_session['step'])){ ?>
                                    <h5 class="text-center">Upload Wordpress Plugin To Your Website </h5>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row step-0">
                                <div class="col-lg-12 error-section">
                                    <?php // echo sprintf($this->lang->line('DOWNLOAD_PLUGIN')); ?>
                                    <?php echo $this->session->flashdata('success'); ?>
                                    <?php echo $this->session->flashdata('danger'); ?>
                                    <?php echo $this->session->flashdata('info'); ?>
                                </div>
                                <div class="col-lg-12 loading">
                                    <?php if (!isset($process_session['project_id']) && !isset($process_session['step'])) { ?>
                                        <div class="card-block ">
                                            <?php echo form_open('', array('name' => 'company', 'class' => 'add-url', 'method' => 'post')); ?>
                                            <input type="hidden" name="project_url" class="form-control addurl" value="">
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <div class="ks-error-page"><div class="ks-error-description"><h3>Please enter your website URL</h3></div></div>
                                                    <div class="form-group date-display">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <fieldset class="form-group col-xl-12">
                                                    <input type="text"
                                                           placeholder="i.e. example.com"
                                                           class="form-control check-cms"
                                                           value="<?= set_value('project_url') ?>">
<!--                                                    <select class="form-group scheme" name="scheme" required>
                                                        <option value="">-select-</option>
                                                        <option value="http://">http://</option>
                                                        <option value="https://">https://</option>
                                                    </select>-->
                                          
                                                </fieldset>
                                            </div>
                                            <div class="row text-center">
                                                <div class="form-group col-xl-12">
                                                    <button id="step-0" type="button" class="btn btn-color btn-lg">Submit Project</button>
                                                </div>
                                            </div>
                                            <?php echo form_close(); ?>
                                        </div>


                                    <?php } ?>
                                    <div class="card panel section-step-1" style="<?= (isset($process_session['project_id']) && $process_session['step'] == 1) ? 'display:block' : 'display:none'; ?>">
                                        <div class="card-block ">
                                                <div class="plugin-download-section" style="<?= (isset($process_session['plugin_status']) && $process_session['plugin_status'] == 'no' && !isset($process_session['plugin']))? 'display:block':'display:none'; ?>">
                                                    <div class="row">
                                                        <div class="col-lg-12 text-center">
                                                            <div class="ks-error-page"><div class="ks-error-description"><p><strong>Download the plugin below and install on your website.</strong></p> <p>(This plugin helps in fetching the required health data from your website regularly)</p></div></div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 text-center">
                                                            <a href="<?= site_url('skip'); ?>" class="btn btn-color btn-lg ">SKIP</a> <a href="<?= site_url('upkepr-Maintenance.zip'); ?>" class="btn btn-color btn-lg download-plugin">DOWNLOAD NOW</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plugin-deactivated-section" style="<?= (isset($process_session['plugin']) && $process_session['plugin'] == 'deactivated')? 'display:block':'display:none'; ?>">
                                                    <div class="row">
                                                        <div class="col-lg-12 text-center">
                                                            <div class="ks-error-page"><div class="ks-error-description"><p>If you are owner of website please install and active plugin.</p></div></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="plugin-section" style="<?= (isset($process_session['plugin_status']) && $process_session['plugin_status'] == 'no' && !isset($process_session['plugin']))? 'display:none':'display:block'; ?>">
                                                     <div class="row">
                                                        <div class="col-lg-12 text-center">
                                                            <div class="ks-error-page"><div class="ks-error-description"><p><?= (isset($process_session['plugin_status']) && $process_session['plugin_status'] == 'yes') ? 'Plugin already installed,' : 'Once the plugin is installed successfully,'; ?>  please click the below button to verify the installation.</p></div></div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 text-center">
                                                            <button class="btn btn-color btn-lg verify-plugin">VERIFY INSTALLATION</button>
                                                        </div>
                                                    </div>
                                                    <div class="row successfully-pligin" style="display:none">
                                                        <div class="col-lg-12 text-center">
                                                            <div class="ks-error-page"><div class="ks-error-description ks-color-success"><p>Verification successful. Please click here to proceed to next step.  </p></div></div>
                                                        </div>
                                                        <div class="col-lg-12 text-center">
                                                            <button id="next-step-2" class="btn btn-color btn-lg ">PROCEED</button>
                                                        </div>
                                                    </div>
                                                    <div class="row error-pligin" style="display:none">
                                                        <div class="col-lg-12 text-center">
                                                            <div class="ks-error-page"><div class="ks-error-description ks-color-danger"><p>Verification Failed. Please try again.  </p><p>(For repeated verification failure, download the fresh plugin and install again)</p></div></div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="card panel section-step-2" style="<?= (isset($process_session['project_id']) && $process_session['step'] == 2) ? 'display:block' : 'display:none'; ?>">
                                        <div class="card-block">
                                            <?php echo form_open('', array('name' => 'company', 'class' => 'admin-credentials', 'method' => 'post')); ?>
                                            <input type="hidden" value="<?= isset($process_session['project_id']) ? $process_session['project_id'] : '' ?>" name="project_id"/>

                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <div class="ks-error-page"><div class="ks-error-description"><p>Please enter your admin login details of your wordpress website.  </p></div></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-xl-12">
                                                    <input type="text"
                                                           name="login_url"
                                                           class="form-control login_url"
                                                           placeholder="Please enter login url"
                                                           value="<?= isset($process_session['project_url']) ? $process_session['project_url'] : ''; ?>">
                                                    <em><?php echo form_error('login_url'); ?></em>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="form-group col-xl-12">
                                                    <input type="text"
                                                           name="username"
                                                           class="form-control username"
                                                           placeholder="Please enter username"
                                                           value="<?= set_value('username') ?>">
                                                    <em><?php echo form_error('username'); ?></em>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-xl-12">
                                                    <input type="password"
                                                           name="password"
                                                           class="form-control password"
                                                           placeholder="Please enter password"
                                                           value="<?= set_value('password') ?>">
                                                    <em><?php echo form_error('password'); ?></em>
                                                </div>
                                            </div>
                                            <div class="row text-center">
                                                <div class="form-group col-xl-12">
                                                    <button type="button" class="btn btn-color snmt-admin-credentials">Verify Login Information</button>
                                                </div>
                                            </div>
                                            <?php echo form_close(); ?>

                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <div class="ks-error-page"><div class="ks-error-description"><p>This will help us to allow you to use our “One Click Login to admin” feature.</p><p>
                                                                To skip this step and complete later, please below button. </p></div></div>

                                                </div>
                                            </div>



                                            <div class="row text-center">
                                                <div class="form-group col-xl-12">
                                                    <button type="button" class="btn btn-success proceed">Proceed</button>
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
    $(document).ready(function () {
        $('.check-cms').keypress(function (e) {
            var key = e.which;
            if (key == 13)
            {
                $('#step-0').click();
                return false;
            }
        });
    });
</script>
<script src="<?= site_url('application/modules/project/js/project-verify.js') ?>"></script>