<?php
if (isset($keywords->reports)):
    ?>
    <table class="table table-bordered text-light">
        <thead class="thead-title">
            <tr>
                <td colspan='6' style='text-align: center;'> <span >Keywords</span></td>
            </tr>
            <tr>
                <td> Page Title</td>
                <td> Keyword</td>
                <td> User</td>
                <td> Goal Completions</td>
                <td> Goal Conversion Rate</td>
                <td> Avg. Page Load Time (sec)</td>
            </tr>
        </thead>
        <tbody>

            <?php
            if (isset($keywords->reports[0]->data->rows)) {
                foreach ($keywords->reports[0]->data->rows as $acq):
                    ?>
                    <tr>

                        <td><?= $acq->dimensions[0] ? $acq->dimensions[0] : ''; ?></td>
                        <td><?= $acq->dimensions[0] ? $acq->dimensions[1] : ''; ?></td>
                        <td><?= $acq->metrics[0] ? $acq->metrics[0]->values[1] . '<span class="persantage">(' . round_figure($acq->metrics[0]->values[5]) . '%)</span>' : ''; ?></td>
                        <td><?= $acq->metrics[0] ? $acq->metrics[0]->values[2] : ''; ?></td>
                        <td><?= $acq->metrics[0] ? round_figure($acq->metrics[0]->values[3]) . '%' : ''; ?></td>
                        <td><?= $acq->metrics[0] ? $acq->metrics[0]->values[4] : ''; ?></td>
                    </tr>
                <?php
                endforeach;
            }
            ?>
        </tbody>
    </table>

<?php endif; ?>