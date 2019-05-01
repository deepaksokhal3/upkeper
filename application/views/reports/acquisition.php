    <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/fonts/line-awesome/css/line-awesome.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= site_url('assets/css/styles.css'); ?>">

    <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/fonts/montserrat/styles.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/styles/common.min.css')?>">
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- END THEME STYLES -->

<?php
//print_r($acquisition);die;
if (isset($acquisition->reports)):
    ?>
    <table class="table table-bordered text-light">
        <thead class="thead-title">
            <tr>
                <td></td>
                <td> Session</td>
                <td> % New Session</td>
                <td> New Users</td>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($acquisition->reports[0]->data->rows)) { ?>
                <tr>
                    <td></td>
                    <td><?= isset($acquisition->reports[0]->data->totals[0]->values[0]) ? $acquisition->reports[0]->data->totals[0]->values[0] : ''; ?></td>
                    <td><?= isset($acquisition->reports[0]->data->totals[0]->values[0]) ? number_format(round($acquisition->reports[0]->data->totals[0]->values[1], 2), 2) . '%' : ''; ?></td>
                    <td><?= isset($acquisition->reports[0]->data->totals[0]->values[0]) ? $acquisition->reports[0]->data->totals[0]->values[2] : ''; ?></td>
                </tr>
                <?php
                foreach ($acquisition->reports[0]->data->rows as $acq):
                    ?>
                    <tr>

                        <td><?= $acq->dimensions[0] == '(none)' ? 'Direct' : $acq->dimensions[0]; ?></td>
                        <td><?= $acq->metrics[0]->values ? $acq->metrics[0]->values[0] : ''; ?></td>
                        <td colspan='2' style="padding-left:0px;"><div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: <?= round_figure($acq->metrics[0]->values[0] / (($acquisition->reports[0]->data->totals[0]->values[0] != 0) ? $acquisition->reports[0]->data->totals[0]->values[0] : 1) * 100) ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div></td>

                    </tr>
                    <?php
                endforeach;
            }
            ?>
        </tbody>
    </table>

<?php endif; ?>