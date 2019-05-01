<div class="ks-page-container ks-dashboard-tabbed-sidebar-fixed-tabs">
    <div class="ks-page-container common-section">
        <div class="ks-column ks-page">
            <div class="ks-content">
                <div class="ks-body Inner-container">
                    <div class=" col-md-8 offset-md-2 blacklist">


                        <div class="col-lg-12">
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
                            if (!empty($responsivness)):
                              
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
                                                    <th>Average</th> 
                                                </tr>
                                            </thead>
                                            <tr>
                                                <td class="ks-currency"> <?= isset($avg_status->total_pages) ? $avg_status->total_pages : ''; ?></td>
                                                <td class=""><?= isset($avg_status->avg_responsive_status) ? round($avg_status->avg_responsive_status,2) * 100 .'%': ''; ?></td>
                                            </tr>

                                        </table>
                                    </div>
                                <?php endif; ?>
                                <div class="row">
                                    <table class="table ks-payment-card-rate-details-table">
                                         <thead class="thead-default">
                                                <tr>
                                                    <th>Pages</th>
                                                    <th class="ks-amount">Status</th> 
                                                </tr>
                                            </thead>
                                        <?php
                                        foreach ($responsivness as $page_status):
                                            $icon = ($page_status->responsive_status == 0) ? 'assets/img/project/alerterroricon.png' : 'assets/img/project/success.png';
                                            ?>
                                            <tr class="cursue-point" onclick="window.open('https://search.google.com/test/mobile-friendly?url=<?= urlencode($page_status->page_url); ?>', '_blank');">
                                                <td class="ks-currency">
                                                    <?= $page_status->page_url; ?><a href="https://search.google.com/test/mobile-friendly?url=<?= urlencode($page_status->page_url); ?>" target="blank"><i class="fa fa-external-link-square" aria-hidden="true"></i></a>
                                                </td>
                                                <td class="ks-amount"><img src="<?= site_url($icon) ?>" class="ks-flag"></td>
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


