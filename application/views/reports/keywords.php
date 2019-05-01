<link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/bootstrap/css/bootstrap.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/fonts/line-awesome/css/line-awesome.min.css') ?>">
<!--<link rel="stylesheet" type="text/css" href="assets/fonts/open-sans/styles.css">-->

<link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/fonts/montserrat/styles.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= site_url('assets/admin/styles/common.min.css') ?>">
<?php
if (isset($keywords->reports)):
    ?>

    <table class="table table-bordered text-light">
        <thead class="thead-title">
            <tr>
                <td> Page Title</td>
                <td> Keyword</td>
                <td> User</td>
            </tr>
        </thead>
        <tbody>

            <?php
            if (isset($keywords->reports[0]->data->rows)) {
                foreach ($keywords->reports[0]->data->rows as $acq):
                    ?>
                    <tr>

                        <td title="<?= $acq->dimensions[0] ? $acq->dimensions[0] : ''; ?>"> <?= text_limit($acq->dimensions[0] ? $acq->dimensions[0] : '',25); ?></td>
                        <td><?= $acq->dimensions[0] ? $acq->dimensions[1] : ''; ?></td>
                        <td><?= $acq->metrics[0] ? $acq->metrics[0]->values[1] . '<span class="persantage">(' . round_figure($acq->metrics[0]->values[5]) . '%)</span>' : ''; ?></td>
                    </tr>
                    <?php
                endforeach;
            }
            ?>
        </tbody>
    </table>

<?php endif; ?>