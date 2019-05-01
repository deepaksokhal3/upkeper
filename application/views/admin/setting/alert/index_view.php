<div class="ks-page-container">
    <div class="ks-column ks-page"> 
        <div class="ks-header">
            <section class="ks-title">
                <h3 style="width: 100%;"><?= $title ?> <a href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/alerts');?>" class="btn btn-primary float-right">Create Alert</a></h3>
            </section>
        </div>
        <div class="ks-content">
            <div class="ks-body tables-page">
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid ks-rows-section">
                        <div class="row">
                            <?php
                            if (isset($alerts)):
                                $selectorArray = array();
                                foreach ($alerts as $key => $alert):
                                    if ($alert['reminder_time'])
                                        $selectorArray = explode(",", $alert['reminder_time']);
                                    if ($alert['alert_type'] == 1):
                                        ?>
                                        <div class="col-lg-4">
                                            <div class="card panel panel-default panel-table">
                                                <h5 class="card-header">
                                                    <?= $alert['alert_name']; ?>
                                                </h5>
                                                <div class="card-block">
                                                    <form id="set-alert-<?= $key; ?>" class="">
                                                        <input type="hidden" name="alert_id" value="<?= $alert['alert_id']; ?>" >
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <div class="pull-left">
                                                                            <label class="ks-checkbox-slider ks-on-off ks-solid ks-success">
                                                                                <input type="checkbox" class="set-alert" name="reminder[]" value="1" <?= in_array('1', $selectorArray) ? 'checked' : ''; ?>>
                                                                                <span class="ks-indicator"></span>
                                                                                <span class="ks-on">On</span>
                                                                                <span class="ks-off">Off</span>
                                                                            </label> <span>Send alert <strong>One Month</strong> before <?= strtolower(str_replace('Renewal', '', $alert['alert_name'])); ?> expiry </span>
                                                                        </div>
                                                                        <div class="pull-right"> <span class="alert-error"></span> <span class="alert-success"></span></div>
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="pull-left">
                                                                            <label class="ks-checkbox-slider ks-on-off ks-solid ks-success">
                                                                                <input type="checkbox" class="set-alert" name="reminder[]" value="2" <?= in_array('2', $selectorArray) ? 'checked' : ''; ?>>
                                                                                <span class="ks-indicator"></span>
                                                                                <span class="ks-on">On</span>
                                                                                <span class="ks-off">Off</span>
                                                                            </label> <span>Send alert <strong>One Week</strong> before <?= strtolower(str_replace('Renewal', '', $alert['alert_name'])); ?> expiry </span>
                                                                        </div>
                                                                        <div class="pull-right"> <span class="alert-error"></span> <span class="alert-success"></span></div>
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                              
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                    endif;
                                endforeach;
                            endif;
                            ?>
                        </div>
                        <div class="row health-sectopn">
                            <?php
                            if (isset($alerts)):
                                $selectorArray = array();
                                foreach ($alerts as $key => $alert):
                                    if ($alert['alert_type'] == 2):
                                        ?>
                                        <div class="col-lg-3">
                                            <div class="card panel panel-default panel-table">
                                                <h5 class="card-header">
                                                    <?= $alert['alert_name']; ?> 
                                                    <div class="pull-right">
                                                        <form id="set-alert-<?= $key; ?>" class="">
                                                            <input type="hidden" name="alert_id" value="<?= $alert['alert_id']; ?>" >
                                                            <label class="ks-checkbox-slider ks-on-off ks-solid ks-success">
                                                                <input type="checkbox" class="set-happens-alert" name="status" value="1" <?= ($alert['status']== 1) ? 'checked' : ''; ?>>
                                                                <span class="ks-indicator"></span>
                                                                <span class="ks-on">On</span>
                                                                <span class="ks-off">Off</span>
                                                            </label>
                                                        </form>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?= site_url('assets/admin/js/setting.js') ?>"></script>