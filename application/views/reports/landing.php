 <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/fonts/line-awesome/css/line-awesome.min.css') ?>">
    <!--<link rel="stylesheet" type="text/css" href="assets/fonts/open-sans/styles.css">-->

    <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/fonts/montserrat/styles.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/styles/common.min.css')?>">
<?php
if (isset($landing_pages->reports)):
    ?>

    <table class="table table-bordered text-light">
        <thead class="thead-title">
            <tr>
                <td rowspan="2">Landing Page</td>
                <td colspan="3"> Acquisition</td>
              
            </tr>
            <tr>
                <td>Sessions</td>
                <td> % New Sessions</td>
                <td> New Users</td>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($landing_pages->reports[0]->data->rows)) { ?>
                <tr>

                    <td></td>
                    <td><span class="td-title"><?= $landing_pages->reports[0]->data->totals[0]->values[0] ? $landing_pages->reports[0]->data->totals[0]->values[0] : ''; ?></span>
                        <span class="td-sub-title"> % of Total: 100.00% (<?= $landing_pages->reports[0]->data->totals[0]->values[0] ? $landing_pages->reports[0]->data->totals[0]->values[0] : ''; ?>) </span>
                    </td>

                    <td><span class="td-title"><?= $landing_pages->reports[0]->data->totals[0]->values[1] ? round_figure($landing_pages->reports[0]->data->totals[0]->values[4]) . '%' : ''; ?></span>
                        <span class="td-sub-title"> Avg for View: <?= $landing_pages->reports[0]->data->totals[0]->values[1] ? round_figure($landing_pages->reports[0]->data->totals[0]->values[1]) . '%' : ''; ?> (0.00%) </span>
                    </td>

                    <td><span class="td-title"><?= $landing_pages->reports[0]->data->totals[0]->values[2] ? $landing_pages->reports[0]->data->totals[0]->values[2] : ''; ?></span>
                        <span class="td-sub-title"> % of Total: 100.00% (<?= $landing_pages->reports[0]->data->totals[0]->values[2] ? $landing_pages->reports[0]->data->totals[0]->values[2] : ''; ?>) </span>
                    </td>
                </tr>
                <?php
                foreach ($landing_pages->reports[0]->data->rows as $page):
                    ?>
                    <tr>
                        <td title="<?= $page->dimensions[0] ? $page->dimensions[0] : '';?>"><?= text_limit($page->dimensions[0] ? $page->dimensions[0] : '',25); ?></td>
                        <td><?= $page->metrics[0]->values ? $page->metrics[0]->values[0] . '<span class="persantage">(' . round_figure($page->metrics[0]->values[0] / $landing_pages->reports[0]->data->totals[0]->values[0] * 100) . '%)</span>' : ''; ?></td>
                        <td><?= $page->metrics[0]->values ? round_figure($page->metrics[0]->values[1]) . '%' : ''; ?></td>
                        <td><?= $page->metrics[0]->values ? $page->metrics[0]->values[2] . '<span class="persantage">(' . round_figure($page->metrics[0]->values[2] / $landing_pages->reports[0]->data->totals[0]->values[2] * 100) . '%)</span>' : ''; ?></td>
                       
                    </tr>
                    <?php
                endforeach;
            }
            ?>
        </tbody>
    </table>
    <table class="table table-bordered text-light">
        <thead class="thead-title">
            <tr>
                <td rowspan="2">Landing Page</td>
                <td colspan="3"> Behavior</td>
            </tr>
            <tr>
                <td>Bounce Rate</td>
                <td>Pages / Session</td>
                <td>Avg. Session Duration</td>
               
            </tr>
        </thead>
        <tbody>
            <?php if (isset($landing_pages->reports[0]->data->rows)) { ?>
                <tr>

                    <td></td>
                    <td><span class="td-title"><?= $landing_pages->reports[0]->data->totals[0]->values[3] ? round_figure($landing_pages->reports[0]->data->totals[0]->values[3]) . '%' : ''; ?></span>
                        <span class="td-sub-title"> Avg for View: <?= $landing_pages->reports[0]->data->totals[0]->values[3] ? round_figure($landing_pages->reports[0]->data->totals[0]->values[3]) . '%' : ''; ?> (0.00%) </span>
                    </td>

                    <td><span class="td-title"><?= $landing_pages->reports[0]->data->totals[0]->values[4] ? round_figure($landing_pages->reports[0]->data->totals[0]->values[4]) : ''; ?></span>
                        <span class="td-sub-title"> Avg for View: <?= $landing_pages->reports[0]->data->totals[0]->values[4] ? round_figure($landing_pages->reports[0]->data->totals[0]->values[4]) : ''; ?> (0.00%) </span>
                    </td>

                    <td><span class="td-title"><?= $landing_pages->reports[0]->data->totals[0]->values[5] ? gmdate('H:i:s', floor($landing_pages->reports[0]->data->totals[0]->values[5])) : ''; ?></span>
                        <span class="td-sub-title"> Avg for View: <?= $landing_pages->reports[0]->data->totals[0]->values[5] ? gmdate('H:i:s', floor($landing_pages->reports[0]->data->totals[0]->values[5])) : ''; ?> (0.00%) </span>
                    </td>

                </tr>
                <?php
                foreach ($landing_pages->reports[0]->data->rows as $page):
                    ?>
                    <tr>
                        <td title="<?= $page->dimensions[0] ? $page->dimensions[0] : '';?>"><?= text_limit($page->dimensions[0] ? $page->dimensions[0] : '',25); ?></td>
                        <td><?= $page->metrics[0]->values ? round_figure($page->metrics[0]->values[3]) . '%' : ''; ?></td>
                        <td><?= $page->metrics[0]->values ? round_figure($page->metrics[0]->values[4]) : ''; ?></td>
                        <td><?= $page->metrics[0]->values ? gmdate('H:i:s', floor($page->metrics[0]->values[5])) : ''; ?></td>
                    </tr>
                    <?php
                endforeach;
            }
            ?>
        </tbody>
    </table>
    <table class="table table-bordered text-light">
        <thead class="thead-title">
            <tr>
                <td rowspan="2">Landing Page</td>
                <td colspan="3">Conversions</td>
            </tr>
            <tr>
                <td>Page View (Goal 1 Conversion Rate)</td>
                <td>Page View (Goal 1 Completions)</td>
                <td>Page View (Goal 1 Value)</td>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($landing_pages->reports[0]->data->rows)) { ?>
                <tr>

                    <td></td>
                    <td><span class="td-title"><?= $landing_pages->reports[0]->data->totals[0]->values[6] ? round_figure($landing_pages->reports[0]->data->totals[0]->values[6]) . '%' : ''; ?></span>
                        <span class="td-sub-title"> Avg for View: <?= $landing_pages->reports[0]->data->totals[0]->values[6] ? round_figure($landing_pages->reports[0]->data->totals[0]->values[6]) . '%' : ''; ?> (0.00%) </span>
                    </td>

                    <td><span class="td-title"><?= $landing_pages->reports[0]->data->totals[0]->values[7] ? $landing_pages->reports[0]->data->totals[0]->values[7] : 0; ?></span>
                        <span class="td-sub-title"> % of Total: 100.00% (<?= $landing_pages->reports[0]->data->totals[0]->values[7] ? $landing_pages->reports[0]->data->totals[0]->values[7] : 0; ?>) </span>
                    </td>

                    <td><span class="td-title"><i class="la la-usd" aria-hidden="true"></i><?= $landing_pages->reports[0]->data->totals[0]->values[8] ? $landing_pages->reports[0]->data->totals[0]->values[8] : ''; ?></span>
                        <span class="td-sub-title"> % of Total: 100.00% (<i class="la la-usd" aria-hidden="true"></i><?= $landing_pages->reports[0]->data->totals[0]->values[8] ? $landing_pages->reports[0]->data->totals[0]->values[8] : ''; ?>) </span>
                    </td>

                </tr>
                <?php
                foreach ($landing_pages->reports[0]->data->rows as $page):
                    ?>
                    <tr>
                        <td title="<?= $page->dimensions[0] ? $page->dimensions[0] : '';?>"><?= text_limit($page->dimensions[0] ? $page->dimensions[0] : '',25); ?></td>
                        <td><?= $page->metrics[0]->values ? round_figure($page->metrics[0]->values[6]) . '%' : ''; ?></td>
                        <td><?= $page->metrics[0]->values ? $page->metrics[0]->values[7] . '<span class="persantage">(' . round_figure($page->metrics[0]->values[7] / (($landing_pages->reports[0]->data->totals[0]->values[7] != 0) ? $landing_pages->reports[0]->data->totals[0]->values[7] : 1) * 100) . '%)</span>' : ''; ?></td>
                        <td><i class="la la-usd" aria-hidden="true"></i><?= $page->metrics[0]->values ? $page->metrics[0]->values[8] : ''; ?></td>
                    </tr>
                    <?php
                endforeach;
            }
            ?>
        </tbody>
    </table>

<?php endif; ?>