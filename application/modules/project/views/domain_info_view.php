
<div class="ks-page-container ks-dashboard-tabbed-sidebar-fixed-tabs">
    <div class="ks-page-container common-section" pro-index="<?= $projects['project_id'] ?>" data-url="<?= (isset($projects['project_url']) && !empty($projects['project_url'])) ? $projects['project_url'] : ''; ?>">
        <div class="ks-column ks-page">
            <!--div class="ks-header">
                <section class="ks-title">
                    <h3><?= $title; ?> </h3>
                    <div class="ks-items-block">
                        <button type="button" class="btn btn-primary back-btu" onclick="goBack()">Go Back</button>
                        <a style="float: right;" class="btn btn-primary refresh" href="" >Refresh</a>
                    </div>
                </section>
            </div-->
            <?php
            if (isset($projects['domain_info']) && !empty($projects['domain_info']))
                $domain = json_decode($projects['domain_info']);
            else
                $domain = '';
            ?>
            <div class="ks-content">
                <div class="ks-body Inner-container">
                    <div class="ks-dashboard-tabbed-sidebar">
                        <div class="ks-dashboard-tabbed-sidebar-widgets col-md-8 offset-md-2">
                            <div class="row ks-title-body">
                                <div class="card-header col-lg-12">
                                    <h3 class="text-center">
                                        <?= strtoupper($title); ?>
                                        <?= (isset($host_info[0]['Host_IP']) && !empty($host_info[0]['Host_IP'])) ? '<span class="ks-ip-title">(' . $host_info[0]['Host_IP'] . ')</span>' : ''; ?>
                                        <div class="ks-controls">
                                        </div>
                                    </h3>
                                </div>
                            </div>
                            <?= $breadcrumb; ?>
                            <div class="row">
                                <div class="col-lg-12 ks-title-body">
                                    <h4 class="text-center">
                                        <?= strtoupper('Current Information'); ?>
                                        <div class="ks-controls">
                                        </div>
                                    </h4>
                                </div>
                                <div class="col-lg-12">
                                    <div class="list-group" id="mg-multisidetabs">
                                        <a href="#" class="list-group-item sub-list-item">General information  check at  <?= (isset($projects['created_at'])) ? '<span class="badge badge-default">' . date('d M Y', strtotime($projects['created_at'])) . '</span>' : ''; ?><span class="la la-minus ks-icon pull-right"></span></a>
                                        <div class="panel list-sub mg-show" style="display:block;">
                                            <div class="panel-body">
                                                <?php if (isset($domain->General)) : ?> 
                                                    <div class="col-lg-12">
                                                        <div class=" ks-card-widget ks-widget-table">
                                                            <div class="card-block">
                                                                <table class="table table-bordered">
                                                                    <?php
                                                                    foreach ($domain->General as $key => $fields) {
                                                                        if ($fields) {
                                                                            ?>
                                                                            <tr>
                                                                                <td><?= str_replace("_", " ", $key); ?></td>
                                                                                <td><?= $fields; ?></td>
                                                                            </tr>  
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                else:
                                                    echo '<div class="col-lg-12"><div class="ks-error-page"><div class="ks-error-description">No General information is available. Please check back in few minuts</div></div></div>';
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                        <a href="#" class="list-group-item sub-list-item">Admin information  check at  <?= (isset($projects['created_at'])) ? '<span class="badge badge-default">' . date('d M Y', strtotime($projects['created_at'])) . '</span>' : ''; ?><span class="la la-plus ks-icon pull-right"></span></a>
                                        <div class="panel list-sub" >
                                            <div class="panel-body">
                                                <?php if (isset($domain->Admin)) : ?> 
                                                    <div class="col-lg-12">
                                                        <div class=" ks-card-widget ks-widget-table">
                                                            <div class="card-block">
                                                                <table class="table table-bordered">
                                                                    <?php
                                                                    foreach ($domain->Admin as $key => $fields) {
                                                                        if ($fields) {
                                                                            ?>
                                                                            <tr>
                                                                                <td><?= str_replace("_", " ", $key); ?></td>
                                                                                <td><?= $fields; ?></td>
                                                                            </tr>  
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                else:
                                                    echo '<div class="col-lg-12"><div class="ks-error-page"><div class="ks-error-description">No Admin information is available. Please check back in few minuts</div></div></div>';
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                        <a href="#" class="list-group-item sub-list-item">Technical information  check at  <?= (isset($projects['created_at'])) ? '<span class="badge badge-default">' . date('d M Y', strtotime($projects['created_at'])) . '</span>' : ''; ?><span class="la la-plus ks-icon pull-right"></span></a>
                                        <div class="panel list-sub">
                                            <div class="panel-body">
                                                <?php if (isset($domain->Technical)) : ?> 
                                                    <div class="col-lg-12">
                                                        <div class=" ks-card-widget ks-widget-table">
                                                            <div class="card-block">
                                                                <table class="table table-bordered">
                                                                    <?php
                                                                    foreach ($domain->Technical as $key => $fields) {
                                                                        if ($fields) {
                                                                            ?>
                                                                            <tr>
                                                                                <td><?= str_replace("_", " ", $key); ?></td>
                                                                                <td><?= $fields; ?></td>
                                                                            </tr>  
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                else:
                                                    echo '<div class="col-lg-12"><div class="ks-error-page"><div class="ks-error-description">No Technical information is available. Please check back in few minuts</div></div></div>';
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                        <a href="#" class="list-group-item sub-list-item">Registrant information  check at  <?= (isset($projects['created_at'])) ? '<span class="badge badge-default">' . date('d M Y', strtotime($projects['created_at'])) . '</span>' : ''; ?><span class="la la-plus ks-icon pull-right"></span></a>
                                        <div class="panel list-sub">
                                            <div class="panel-body">
                                                <?php if (isset($domain->Registrant)) : ?> 
                                                    <div class="col-lg-12">
                                                        <div class=" ks-card-widget ks-widget-table">
                                                            <div class="card-block">
                                                                <table class="table table-bordered">
                                                                    <?php
                                                                    foreach ($domain->Registrant as $key => $fields) {
                                                                        if ($fields) {
                                                                            ?>
                                                                            <tr>
                                                                                <td><?= str_replace("_", " ", $key); ?></td>
                                                                                <td><?= $fields; ?></td>
                                                                            </tr>  
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                else:
                                                    echo '<div class="col-lg-12"><div class="ks-error-page"><div class="ks-error-description">No Registrant information is available. Please check back in few minuts</div></div></div>';
                                                endif;
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
<script src="<?= site_url('application/modules/project/js/multitabs.js') ?>"></script>
<script src = "<?= site_url('application/modules/project/js/wp.js') ?>"></script>
