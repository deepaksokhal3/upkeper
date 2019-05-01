<div class="ks-page-container ks-dashboard-tabbed-sidebar-fixed-tabs">
    <div class="ks-page-container common-section" pro-index="<?= $projects['project_id'] ?>" data-url="<?= (isset($projects['project_url']) && !empty($projects['project_url'])) ? $projects['project_url'] : ''; ?>">
        <div class="ks-column ks-page">
            <!--div class="ks-header">
                <section class="ks-title">
                    <h3><?= $title; ?> </h3>
                </section>
            </div-->
            <div class="ks-content">
                <div class="ks-body Inner-container">
                    <div class="ks-dashboard-tabbed-sidebar">
                        <div class="ks-dashboard-tabbed-sidebar-widgets col-md-8 offset-md-2">
                            <div class="row ks-title-body">
                                <div class=" card-header col-lg-12">
                                    <h3 class="text-center">
                                        <?= strtoupper($title); ?>
                                        <?= (isset($host_info[0]['Host_IP']) && !empty($host_info[0]['Host_IP'])) ? '<span class="ks-ip-title">(' . $host_info[0]['Host_IP'] . ')</span>' : ''; ?>
                                    </h3>
                                </div>
                            </div>
                            <?= $breadcrumb; ?>
                            <div class="row">
                                <div class="col-lg-12 ks-title-body">
                                    <h4 class="text-center">
                                        <?= strtoupper('Up-Time Status'); ?>
                                        <div class="ks-controls">
                                        </div>
                                    </h4>
                                </div>
                                <div class="col-lg-12">
                                    <?php if ($down_times) { ?>
                                        <div class=" ks-card-widget ks-widget-table">
                                           
                                            <div class="card-block">
                                                <div class="container-fluid down-time-sec">
                                                    <?php if (!empty($down_times)) { ?>
                                                        <table class="table text-light">
                                                            <thead class="thead-default">
                                                                <tr>
                                                                    <th>Daily</th>
                                                                    <th>Weekly</th>
                                                                    <th>Monthly</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($down_times as $key => $down_time) { ?>
                                                                    <tr>
                                                                        <td><?= ($down_time['DAILY_DOWN'] == 0)? '100%': round_figure(100 - ($down_time['DAILY_DOWN']/ $down_time['DAILY_UP'] * 100)) .'%'; ?></td>
                                                                        <td><?= ($down_time['MONTHLY_DOWN'] == 0)? '100%': round_figure(100 - ($down_time['WEEKLY_DOWN']/ $down_time['WEEKLY_UP'] * 100)) .'%'; ?></td>
                                                                        <td><?= ($down_time['MONTHLY_DOWN'] == 0)? '100%': round_figure(100 - ($down_time['MONTHLY_DOWN']/ $down_time['MONTHLY_UP'] * 100)) .'%'; ?></td>
                                                                       </tr>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table> 
                                                        <?php
                                                    } else {
                                                        echo '<p class="card-text">Uptime monitoring for your internet and intranet resources.</p>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }   ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= site_url('application/modules/project/js/uptime.js') ?>"></script>
