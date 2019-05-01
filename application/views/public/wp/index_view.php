<?php
$wpObj = (isset($wordpress_current_status->wp_all_status)) ? json_decode($wordpress_current_status->wp_all_status) : '';
?>


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
                            <ul class="nav ks-nav-tabs ks-tabs-page-default ks-tabs-full-page">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#" data-toggle="tab" data-target="#in-patient">
                                        General
                                        <!--<span class="badge badge-info badge-pill">15</span>-->
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="tab" data-target="#discharged">
                                        Plugins
                                        <span class="badge badge-pink badge-pill"><?= count((array) $wpObj->plugin_info->plugins); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="tab" data-target="#reconciliation">
                                        Themes
                                        <span class="badge badge-danger-outline badge-pill"><?= count($wpObj->themes_info->info); ?></span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active ks-column-section" id="in-patient" role="tabpanel">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card ks-card-widget ks-widget-payment-table-invoicing">
                                                <h5 class="card-header">
                                                    Wordpress
                                                </h5>
                                                <div class="card-block">
                                                    <table class="table ks-table-tasks">
                                                        <tbody>
                                                            <?php if (trim($wpObj->wordpress_info->old_version) == trim($wpObj->wordpress_info->latest_virsion)): ?>
                                                                <tr>
                                                                    <td>Active wordpress version</td>
                                                                    <td class="ks-text-right"><span class="badge badge-default"> Running Latest Version (<?= $wpObj->wordpress_info->latest_virsion; ?>)</span></td> 
                                                                </tr>
                                                            <?php else: ?>
                                                                <tr>
                                                                    <td>Active wordpress version</td>
                                                                    <td class="ks-text-right"><span class="badge badge-default"> Running Version (<?= $wpObj->wordpress_info->old_version; ?>)</span></td> 
                                                                </tr>
                                                                <tr>
                                                                    <td>Latest Wordpress Version</td>
                                                                    <td class="ks-text-right"><span class="badge badge-default"> Available Version (<?= $wpObj->wordpress_info->latest_virsion; ?>)</span></td> 
                                                                </tr>
                                                            <?php endif; ?>

                                                        </tbody>
                                                    </table>
                                                </div>

                                                <?php if (isset($wpObj->server) && $wpObj->server): ?>
                                                    <h5 class="card-header">
                                                        Server
                                                    </h5>
                                                    <div class="card-block">
                                                        <table class="table ks-table-tasks">
                                                            <tbody>
                                                                <?= isset($wpObj->server->HEADER->SERVER_SOFTWARE) ? '<tr><td>Web Server</td><td class="ks-text-right"><span class="badge badge-default">' . $wpObj->server->HEADER->SERVER_SOFTWARE . '</span></td></tr>' : '' ?>
                                                                <?= isset($wpObj->server->phpversion) ? '<tr><td>PHP version</td><td class="ks-text-right"><span class="badge badge-default">' . $wpObj->server->phpversion . '</span></td></tr>' : '' ?>
                                                                <?= isset($wpObj->server->mysql_version) ? '<tr><td>MYSQL version</td><td class="ks-text-right"><span class="badge badge-default">' . $wpObj->server->mysql_version . '</span></td></tr>' : '' ?>
                                                                <?php
                                                                if (isset($wpObj->server->all_memory_status[1])) {
                                                                    $mem = explode(" ", $wpObj->server->all_memory_status[1]);
                                                                    $mem = array_filter($mem);
                                                                    $mem = array_merge($mem);
                                                                    $memory_usage = $mem[2] / $mem[1] * 100;
                                                                    echo isset($mem[1]) ? '<tr><td>Total memory</td><td class="ks-text-right"><span class="badge badge-default">' . $mem[1] . '</span></td></tr>' : '';
                                                                    echo isset($mem[2]) ? '<tr><td>Free memory</td><td class="ks-text-right"><span class="badge badge-default">' . $mem[2] . '</span></td></tr>' : '';
                                                                    echo isset($mem[6]) ? '<tr><td>Cached memory</td><td class="ks-text-right"><span class="badge badge-default">' . $mem[6] . '</span></td></tr>' : '';
                                                                }
                                                                ?>
                                                                <?= isset($wpObj->server->usage_memory) ? '<tr><td>PHP use memory</td><td class="ks-text-right"><span class="badge badge-default">' . $wpObj->server->usage_memory . '</span></td></tr>' : '' ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="discharged" role="tabpanel">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card ks-card-widget ks-widget-payment-table-invoicing">

                                                <div class="card-block">
                                                    <table id="shotTable" class="table ks-table-tasks">
                                                        <thead class="">
                                                            <tr>
                                                                <th>Title</th>
                                                                <th>Active</th>
                                                                <th>Update Available</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $wordpress_obj = $wpObj;
                                                            $plugins = $wordpress_obj->plugin_info->plugins;
                                                            $updates = $wordpress_obj->plugin_info->update_plugin;
                                                            $act_plugins = $wordpress_obj->plugin_info->actived_plugin;
                                                            $plugins_template = '';
                                                            foreach ($plugins as $key => $plugin) {
                                                                $status = false;
                                                                if (isset($plugin->TextDomain) && $plugin->TextDomain) {
                                                                    foreach ($act_plugins as $plu) {
                                                                        if (strpos(strtolower(trim($plu)), strtolower(trim($plugin->TextDomain))) !== false) {
                                                                            $status = true;
                                                                        }
                                                                    }
                                                                }
                                                                $update_plug = '';
                                                                if (!empty($updates)) {
                                                                    foreach ($updates as $key => $update) {
                                                                        if ($plugin->TextDomain == $update->TextDomain) {
                                                                            $update_plug = $update->update;
                                                                        }
                                                                    }
                                                                }
                                                                $update_version = ($update_plug) ? '<span class="ks-name"><span class="badge badge-success ks-sm"> Latest: ' . $update_plug->new_version . '</span></span>' : '<span class="ks-name"><span class="badge badge-success ks-sm">Latest : ' . $plugin->Version . '</span></span>';
                                                                $backgroundColor = isset($update_plug->new_version) ? "background-color: #f9eaea;" : "";
                                                                $plugins_template .= '<tr style="' . $backgroundColor . '">';
                                                                $plugins_template .= '<td><a href="' . $plugin->PluginURI . '" >' . $plugin->Name . '</a></td>';
                                                                $plugins_template .= '<td class="ks-text-light ks-text-right ks-text-no-wrap"><div class="table-cell-block status ">';
                                                                if ($status) {
                                                                    $plugins_template .= '<div " class="text-block-container cursue-point" >';
                                                                    $plugins_template .= '<div class="text-block-text">Activated</div>';
                                                                    $plugins_template .= '</div>';
                                                                } else {
                                                                    $plugins_template .= '<div class="text-block-container cursue-point" >';
                                                                    $plugins_template .= '<div class="text-block-text">Deactivated</div>';
                                                                    $plugins_template .= '</div>';
                                                                }
                                                                $plugins_template .= '</div></td>';
                                                                $plugins_template .= isset($update_plug->new_version) ? '<td class="ks-text-light" >Yes</td>' : '<td class="ks-text-light" >No</td>';
                                                                $plugins_template .= '</tr>';
                                                            }
                                                            echo $plugins_template;
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="reconciliation" role="tabpanel">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card ks-card-widget ks-widget-payment-table-invoicing">

                                                <div class="card-block">
                                                    <table  id="shotTable" class="table ks-table-tasks">
                                                        <thead class="">
                                                            <tr>
                                                                <th>Title</th>
                                                                <th>Active</th>
                                                                <th class="ks-text-right">Update Available</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $themes_info = $wpObj->themes_info->info;
                                                            $Template = '';
                                                            foreach ($themes_info as $key => $theme) {
                                                                $update = ($theme->latest_verison && trim($theme->old_version) != trim($theme->latest_verison)) ? 'Yes' : 'No';
                                                                $active = (trim($theme->status) == 'Active' ) ? 'Active' : 'Deactivated';
                                                                $backgroundColor = ($update == 'Yes') ? "background-color: #f9eaea;" : "";
                                                                $Template .= '<tr style="' . $backgroundColor . '">';
                                                                $Template .='<td>' . $theme->theme_name . '</td>';
                                                                $Template .='<td>' . $active . '</td>';
                                                                $Template .='<td class="ks-text-right">' . $update . '</td>';
                                                                $Template .= '</tr>';
                                                            }
                                                            echo $Template;
                                                            ?>
                                                        </tbody>
                                                    </table>
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
        sortTable();
    });
    function sortTable() {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("shotTable");
        switching = true;
        /*Make a loop that will continue until
         no switching has been done:*/
        while (switching) {
            //start by saying: no switching is done:
            switching = false;
            rows = table.getElementsByTagName("TR");
            /*Loop through all table rows (except the
             first, which contains table headers):*/
            for (i = 1; i < (rows.length - 1); i++) {
                //start by saying there should be no switching:
                shouldSwitch = false;
                /*Get the two elements you want to compare,
                 one from current row and one from the next:*/
                x = rows[i].getElementsByTagName("TD")[1];
                y = rows[i + 1].getElementsByTagName("TD")[1];
                //check if the two rows should switch place:
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                /*If a switch has been marked, make the switch
                 and mark that a switch has been done:*/
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }
</script>