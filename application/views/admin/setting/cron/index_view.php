<div class="ks-page-container">
    <div class="ks-column ks-page"> 
        <div class="ks-header">
            <section class="ks-title">
                <h3><?= $title ?></h3>
            </section>
        </div>
        <div class="ks-content">
            <div class="ks-body tables-page">
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid ks-rows-section">

                        <div class="row health-sectopn">
                            <div class="col-lg-6">
                                <div class="card panel panel-default panel-table setting-frequebcy">
                                    <h5 class="card-header">
                                        Website Speed
                                        <?php echo form_open('21232f297a57a5a743894a0e4a801fc3/save-frequency', array('name' => 'company', 'class' => '', 'method' => 'post')); ?>
                                        <input type="hidden" name="cron_type" value="<?= $frequency_speed->cron_type; ?>">
                                        <input type="hidden" name="cron_st_id" value="<?= $frequency_speed->cron_st_id; ?>">

                                        <div class="col-lg-12">
                                            <div class="form-group col-lg-6"> 
                                                <input class="form-control" name="frequency" placeholder="speed" data-validation="number length" value="<?= $frequency_speed->frequency; ?>" data-validation-length="1-2" >
                                            </div>
                                            <div class="form-group col-lg-3"> 
                                                <button type="submit" class="btn btn-primary">set time</button>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>

                                    </h5>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card panel panel-default panel-table setting-frequebcy">
                                    <h5 class="card-header">
                                        Down time
                                        <?php echo form_open('21232f297a57a5a743894a0e4a801fc3/save-frequency', array('name' => 'company', 'class' => '', 'method' => 'post')); ?>
                                        <input type="hidden" name="cron_type" value="<?= $frequency_down->cron_type; ?>">
                                        <input type="hidden" name="cron_st_id" value="<?= $frequency_down->cron_st_id; ?>">

                                        <div class="col-lg-12">
                                            <div class="form-group col-lg-6"> 
                                                <input class="form-control" name="frequency" placeholder="Times like (30)" data-validation="number length" value="<?= $frequency_down->frequency; ?>" data-validation-length="1-2" >
                                            </div>
                                            <div class="form-group col-lg-3"> 
                                                <button type="submit" class="btn btn-primary">set time</button>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>

                                    </h5>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="<?= site_url('assets/admin/js/setting.js') ?>"></script>