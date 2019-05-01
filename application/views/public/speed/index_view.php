<div class="ks-page-container ks-dashboard-tabbed-sidebar-fixed-tabs">
    <div class="ks-page-container common-section">
        <div class="ks-column ks-page">
            <div class="ks-content">
                <div class="ks-body Inner-container">
                    <div class=" col-md-8 offset-md-2 blacklist">


                        <div class="col-lg-12 table-responsive">
                            <div class="row ks-title-body">
                                <div class="card-header col-lg-12">
                                    <h3 class="text-center">
                                        <?= strtoupper($title); ?>
                                        <div class="ks-controls">
                                        </div>
                                    </h3>
                                </div>
                            </div>

                            <?php
                            if (!empty($speed)):

                                if ($avg_status):
                                    ?>
                                    <div class="row">
                                        <h5 class="card-header">
                                            Over all speed Status
                                        </h5>
                                        <table class="table ks-payment-card-rate-details-table">
                                            <thead class="thead-default">
                                                <tr>
                                                    <th>Total Pages</th>
                                                    <th>Average speed on mobile</th> 
                                                    <th> Average speed on desktop</th>
                                                </tr>
                                            </thead>
                                            <tr>
                                                <td class="ks-currency"> <?= isset($avg_status->total_pages) ? $avg_status->total_pages : ''; ?></td>
                                                <td class=""><?= isset($avg_status->avg_mobile_speed) ? round($avg_status->avg_mobile_speed,2): ''; ?></td>
                                                <td class=""><?= isset($avg_status->avg_desktop_speed) ? round($avg_status->avg_desktop_speed,2) : ''; ?></td>
                                            </tr>

                                        </table>
                                    </div>
                                <?php endif; ?>
                                <div class="row">
                                    <table class="table ks-payment-card-rate-details-table">
                                        <thead class="thead-default">
                                            <tr>
                                                <th>Pages</th>
                                                <th>Speed on mobile</th>
                                                <th>Speed on desktop</th>
                                                <th>Average speed</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        foreach ($speed as $speed_status):
                                            ?>
                                            <tr class="cursue-point" onclick="window.open('https://developers.google.com/speed/pagespeed/insights/?url=<?= urlencode($speed_status->page_url); ?>', '_blank');">
                                                <td class="ks-currency">
                                                    <?= $speed_status->page_url; ?><a href="https://developers.google.com/speed/pagespeed/insights/?url=<?= urlencode($speed_status->page_url); ?>" target="blank"><i class="fa fa-external-link-square" aria-hidden="true"></i></a>
                                                </td>
                                                <td class=""><?= $speed_status->mobile_speed; ?></td>
                                                <td class=""><?= $speed_status->desktop_speed; ?></td>
                                                <td class=""><?= ($speed_status->mobile_speed + $speed_status->desktop_speed) / 2; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


