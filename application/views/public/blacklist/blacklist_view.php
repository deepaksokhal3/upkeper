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

                            <?php if (!empty($blacklist)): 
                                $blacklisted_data = array_count_values(array_map('trim',json_decode($blacklist->blacklist_data)));
                                
                                ?>
                                <table class="table ks-payment-card-rate-details-table blacklist-tbl">
                                    <tr> 
                                        <td colspan="2"><?= isset($blacklisted_data['blacklisted']) ? ' <img src="' . site_url('assets/images/malware_deduct.png') . '">  ' . $blacklisted_data['blacklisted'] . ' Blacklisting Found (117 Blacklists Checked).' : '<img src="' . site_url('assets/images/malware_not.png') . '"> No Blacklisting Found (117 Blacklists Checked).'; ?></td>
                                    </tr>
                                    <?php 
                                    foreach (json_decode($blacklist->blacklist_engine) as $key => $blacklist_status):
                                        $icon = (trim($blacklist_status->status) == 'blacklisted') ? 'assets/img/project/alerterroricon.png' : 'assets/img/project/success.png';
                                        ?>
                                        <tr>
                                            <td class="ks-currency">
                                                <?= $blacklist_status->engine; ?>
                                            </td>
                                            <td class="ks-amount"><img src="<?= site_url($icon) ?>" class="ks-flag"></td>
                                        </tr>


                                    <?php endforeach; ?>
                                </table>
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


