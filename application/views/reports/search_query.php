<?php
if (isset($keywords->reports)):
    ?>
    <div class="card-header col-lg-12">
        <h3 class="text-center">
            Top Search Queries
        </h3>
    </div>
    <table class="table table-bordered text-light">
        <thead class="thead-default">
            <tr>
                <td> Title</td>
                <td> Clicks</td>
                <td> Click Through Rate</td>
                <td> Impressions</td>
                <td> Position</td>
            </tr>
        </thead>
        <tbody>

            <?php
            if (isset($search_query->rows)) {
                foreach ($search_query->rows as $query):
                    ?>
                    <tr>

                        <td><?= $query[0] ? ucwords($query[0]) : ''; ?></td>
                        <td><?= $query->clicks ? $query->clicks : 0; ?></td>
                        <td><?= $query->ctr ? round_figure(($query->ctr * 100)) . '%' : 0.00; ?></td>
                        <td><?= $query->impressions ? $query->impressions : 0; ?></td>
                        <td><?= $query->position ? round_figure($query->position) : 0.00; ?></td>
                    </tr>
                    <?php
                endforeach;
            }
            ?>
        </tbody>
    </table>

<?php endif; ?>