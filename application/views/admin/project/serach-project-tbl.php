
<?php if ($projects) { ?>
    <?php foreach ($projects as $key => $project): ?>
        <tr>
            <td><?= domain_name($project->project_url); ?></td>
            <td><?= $project->company_name; ?></td>
            <td><?= $project->created_at; ?></td>
            <td class=""> 
                <div class="row">
                    <div class="col-md-6">
                        <input class="form-control search-user"  name="user_id" list="move-to-user-<?= $key; ?>" placeholder="Type company name" type="text">
                        <datalist id="move-to-user-<?= $key; ?>">
                        </datalist>
                    </div>
                    <button type='button' rel="move-to-user-<?= $key; ?>" index="<?= $project->project_id; ?>" data-domain="<?= $project->project_url; ?>" class="btn btn-success move-project">Move</button>
                </div>
            </td>

        </tr>
    <?php endforeach; ?>
<?php }else { ?>
    <tr>
        <td>
            <div class="row">
                <div class="col-lg-12">
                    <h5>Record not found</h5>
                </div>

            </div>
        </td>
    </tr>
<?php } ?>
