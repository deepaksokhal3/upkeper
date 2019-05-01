<?php
if ($projects):
    foreach ($projects as $key => $project):
        $wp = ($project->wp_all_status) ? json_decode($project->wp_all_status) : '';
        $installed_rate = ($wp && $wp->plugin_info->plugins && $wp->plugin_info->actived_plugin) ? count($wp->plugin_info->actived_plugin) : '';
        $speed = $project->desktop_speed?$project->desktop_speed:0;
        $speed_color_rating = ($speed > 80) ? 'green' : (($speed < 80 && $speed > 60) ? 'yellow' : 'red');
        $uptime_color_rating = ($project->uptime) ? (($project->uptime > 80) ? 'green' : (($project->uptime < 80 && $project->uptime > 60) ? 'yellow' : 'red')) : 'green';
        ?>  
        <div class="prjt-cnt-sec col-sm-6 col-xs-12 project-queue-avil <?= ($key % 2 == 0) ? 'light-pink' : 'light-gray'; ?>" index="<?= $project->project_id; ?>"> 
            <div id="wait-<?= $project->project_id; ?>"  class="check-queue-sec" queue="<?= $project->queue_status; ?>">
                <div class="waiting" style="display:none;"></div>
                <div class="prjt-img cursue-point" onclick="location.href = '<?= site_url('project/detail/' . $project->project_id) ?>'">
                    <img src="<?= site_url('assets/images/desktop.png'); ?>" class="desktop-img">
                    <img src="<?= (file_exists(FCPATH . 'assets/photo/screenshot/' . $project->project_id . '-desktop.jpg')) ? site_url('assets/photo/screenshot/' . $project->project_id . '-desktop.jpg') : site_url('assets/img/placeholders/placeholder.png'); ?>" class="desktop-in-img">
                </div>
                <div class="prjt-cnt">
                    <ul>
                        <li><div class="prtj-spd cursue-point " onclick="location.href = '<?= site_url('project/detail/' . $project->project_id) ?>'" ><h3 title="<?= domain_name($project->project_url); ?>"><?= text_limit(explode('.', domain_name($project->project_url))[0], 18); ?></h3></div><div class="prtj-rtg"><a href="<?= isset($project->project_url) ? $project->project_url : '#'; ?>" target="blank"><span class="ks-amount-icon ks-icon-circled-up-right"></span></a></div></li>
                        <li><div class="prtj-spd">Speed</div><div class="prtj-rtg <?= $speed_color_rating; ?>"><?= $speed; ?>%</div></li>
                        <li><div class="prtj-spd">Uptime</div><div class="prtj-rtg <?= $uptime_color_rating; ?>"><?= ($project->uptime) ? $project->uptime : 100; ?>%</div></li>
                        <li><div class="prtj-spd">Responsive</div><div class="prtj-rtg <?= ($project->responsive_status == 1) ? 'green' : 'yellow'; ?>"><i class="<?= ($project->responsive_status == 1) ? 'la la-check-circle-o ks-color-success' : 'la la-times-circle-o ks-color-danger'; ?>"></i></div></li>
                        <?php if ($project->installed != 'NOT_WP'): ?>
                            <li><div class="prtj-spd">Plugin Installed</div><div class="prtj-rtg"><?= $installed_rate; ?></div></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <ul class="date-edit-sec">
                    <li><div class="prtj-spd">
                            <span><i class="fa fa-calendar" aria-hidden="true"></i></span><label><?= date('d M Y', strtotime($project->created_at)); ?></label></div><div class="prtj-rtg"><i class="fa fa-pencil-square-o cursue-point"  onclick="location.href = '<?= site_url('project/edit/' . $project->project_id) ?>'" aria-hidden="true"></i>
                            <sapn class="ks-datetime cursue-point delete-project" id="confirm-delete" url="<?= $project->project_url ?>" index="<?= $project->project_id; ?>"><i class="la la-trash ks-icon" aria-hidden="true"></i></sapn></div>
                    </li>
                </ul>
            </div>
        </div>
        <script>
            $(document).ready(function () {

                $('.check-queue-sec').each(function () {
                    var id = $(this).attr('id');
                    if ($(this).attr('queue') != 1) {
                        $('#' + id + ' .waiting').css('display', 'block');
                    } else {
                        $('#' + id + ' .waiting').css('display', 'none');
                    }
                });
            });


        </script>

        <?php
    endforeach;
else:
    ?>
    <div class="prj-hdng">
        <h3>Adding a website is very easy, just click the below button to start adding the project. </h3>
        <div class="row">
            <div class="col-lg-12 add"><a href="<?= site_url('add-project'); ?>" class="btn  btn-color">Create Project</a></div>

        </div>
    </div>
<?php endif;
?>
