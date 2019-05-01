 <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/fonts/line-awesome/css/line-awesome.min.css') ?>">
    <!--<link rel="stylesheet" type="text/css" href="assets/fonts/open-sans/styles.css">-->

    <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/fonts/montserrat/styles.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/styles/common.min.css')?>">
<?php
if (isset($visitors->reports)):
    ?>
    <div class="card-header col-lg-12">
        <h3 class="text-center">
            New vs. Returning Visitors
        </h3>
    </div>
    <table class="table table-bordered text-light">
        <thead class="thead-default">
            <tr>
                <td rowspan="2">User Type</td>
                <td colspan="3"> Acquisition</td>
                <td colspan="3"> Behavior</td>
                <td colspan="3">Conversions</td>
            </tr>
            <tr>
                <td>Sessions</td>
                <td> % New Sessions</td>
                <td> New Users</td>
                <td>Bounce Rate</td>
                <td>Pages / Session</td>
                <td>Avg. Session Duration</td>
                <td>Page View (Goal 1 Conversion Rate)</td>
                <td>Page View (Goal 1 Completions)</td>
                <td>Page View (Goal 1 Value)</td>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($visitors->reports[0]->data->rows)) { ?>
                <tr>
                    <td></td>
                    <td><span class="td-title"><?= $visitors->reports[0]->data->totals[0]->values[0] ? $visitors->reports[0]->data->totals[0]->values[0] : ''; ?></span>
                        <span class="td-sub-title"> % of Total: 100.00% (<?= $visitors->reports[0]->data->totals[0]->values[0] ? $visitors->reports[0]->data->totals[0]->values[0] : ''; ?>) </span>
                    </td>

                    <td><span class="td-title"><?= $visitors->reports[0]->data->totals[0]->values[1] ? round_figure($visitors->reports[0]->data->totals[0]->values[4]) . '%' : ''; ?></span>
                        <span class="td-sub-title"> Avg for View: <?= $visitors->reports[0]->data->totals[0]->values[1] ? round_figure($visitors->reports[0]->data->totals[0]->values[1]) . '%' : ''; ?> (0.00%) </span>
                    </td>

                    <td><span class="td-title"><?= $visitors->reports[0]->data->totals[0]->values[2] ? $visitors->reports[0]->data->totals[0]->values[2] : ''; ?></span>
                        <span class="td-sub-title"> % of Total: 100.00% (<?= $visitors->reports[0]->data->totals[0]->values[2] ? $visitors->reports[0]->data->totals[0]->values[2] : ''; ?>) </span>
                    </td>

                    <td><span class="td-title"><?= $visitors->reports[0]->data->totals[0]->values[3] ? round_figure($visitors->reports[0]->data->totals[0]->values[3]) . '%' : ''; ?></span>
                        <span class="td-sub-title"> Avg for View: <?= $visitors->reports[0]->data->totals[0]->values[3] ? round_figure($visitors->reports[0]->data->totals[0]->values[3]) . '%' : ''; ?> (0.00%) </span>
                    </td>

                    <td><span class="td-title"><?= $visitors->reports[0]->data->totals[0]->values[4] ? round_figure($visitors->reports[0]->data->totals[0]->values[4]) : ''; ?></span>
                        <span class="td-sub-title"> Avg for View: <?= $visitors->reports[0]->data->totals[0]->values[4] ? round_figure($visitors->reports[0]->data->totals[0]->values[4]) : ''; ?> (0.00%) </span>
                    </td>

                    <td><span class="td-title"><?= $visitors->reports[0]->data->totals[0]->values[5] ? gmdate('H:i:s', floor($visitors->reports[0]->data->totals[0]->values[5])) : ''; ?></span>
                        <span class="td-sub-title"> Avg for View: <?= $visitors->reports[0]->data->totals[0]->values[5] ? gmdate('H:i:s', floor($visitors->reports[0]->data->totals[0]->values[5])) : ''; ?> (0.00%) </span>
                    </td>

                    <td><span class="td-title"><?= $visitors->reports[0]->data->totals[0]->values[6] ? round_figure($visitors->reports[0]->data->totals[0]->values[6]) . '%' : ''; ?></span>
                        <span class="td-sub-title"> Avg for View: <?= $visitors->reports[0]->data->totals[0]->values[6] ? round_figure($visitors->reports[0]->data->totals[0]->values[6]) . '%' : ''; ?> (0.00%) </span>
                    </td>

                    <td><span class="td-title"><?= $visitors->reports[0]->data->totals[0]->values[7] ? $visitors->reports[0]->data->totals[0]->values[7] : 0; ?></span>
                        <span class="td-sub-title"> % of Total: 100.00% (<?= $visitors->reports[0]->data->totals[0]->values[7] ? $visitors->reports[0]->data->totals[0]->values[7] : ''; ?>) </span>
                    </td>

                    <td><span class="td-title"><i class="la la-usd" aria-hidden="true"></i><?= $visitors->reports[0]->data->totals[0]->values[8] ? $visitors->reports[0]->data->totals[0]->values[8] : ''; ?></span>
                        <span class="td-sub-title"> % of Total: 100.00% (<i class="la la-usd" aria-hidden="true"></i><?= $visitors->reports[0]->data->totals[0]->values[8] ? $visitors->reports[0]->data->totals[0]->values[8] : ''; ?>) </span>
                    </td>

                </tr>
                <?php
                foreach ($visitors->reports[0]->data->rows as $acq):
                    ?>
                    <tr>
                        <td><?= $acq->dimensions[0] ? $acq->dimensions[0] : ''; ?></td>
                        <td><?= $acq->metrics[0]->values ? $acq->metrics[0]->values[0] . '<span class="persantage">(' . round_figure($acq->metrics[0]->values[0] / $visitors->reports[0]->data->totals[0]->values[0] * 100) . '%)</span>' : ''; ?></td>
                        <td><?= $acq->metrics[0]->values ? round_figure($acq->metrics[0]->values[1]) . '%' : ''; ?></td>
                        <td><?= $acq->metrics[0]->values ? $acq->metrics[0]->values[2] . '<span class="persantage">(' . round_figure($acq->metrics[0]->values[2] / $visitors->reports[0]->data->totals[0]->values[2] * 100) . '%)</span>' : ''; ?></td>
                        <td><?= $acq->metrics[0]->values ? round_figure($acq->metrics[0]->values[3]) . '%' : ''; ?></td>
                        <td><?= $acq->metrics[0]->values ? round_figure($acq->metrics[0]->values[4]) : ''; ?></td>
                        <td><?= $acq->metrics[0]->values ? gmdate('H:i:s', floor($acq->metrics[0]->values[5])) : ''; ?></td>
                        <td><?= $acq->metrics[0]->values ? round_figure($acq->metrics[0]->values[6]) . '%' : ''; ?></td>
                        <td><?= $acq->metrics[0]->values ? $acq->metrics[0]->values[7] . '<span class="persantage">(' . round_figure($acq->metrics[0]->values[7] / (($visitors->reports[0]->data->totals[0]->values[7] != 0) ? $visitors->reports[0]->data->totals[0]->values[7] : 1) * 100) . '%)</span>' : ''; ?></td>
                        <td><i class="la la-usd" aria-hidden="true"></i><?= $acq->metrics[0]->values ? $acq->metrics[0]->values[8] : ''; ?></td>
                    </tr>
                <?php
                endforeach;
            }
            ?>
        </tbody>
    </table>

<?php endif; ?>