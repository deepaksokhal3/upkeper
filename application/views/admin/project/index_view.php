<div class="ks-page-container">
    <div class="ks-column ks-page"> 
        <div class="ks-header">
            <section class="ks-title">
                <h3><?= $title ?></h3>
            </section>
        </div>
        <div class="ks-content">
            <div class="ks-body tables-page">
                <div class="ks-nav-body-wrapper col-xl-8 offset-xl-2">
                    <div class="container-fluid ks-rows-section">
                        <div class="row">
                            <div class="col-lg-12 ">
                                <div class="errer-section"></div>
                                <?php echo $this->session->flashdata('success'); ?>
                                <?php echo $this->session->flashdata('notice'); ?>
                                <div class="row">

                                </div>
                                <div>
                                    <div class="card panel panel-default panel-table">
                                        <div class="card-block">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <div class="col-xl-12">
                                                                <span>Title</span>
                                                                <input class="form-control serach-domain" placeholder="Type domain name"type="text">
                                                                <span class="icon-addon custom-serch serach-domain-btn">
                                                                    <i style="display:none;" class="clear la la-times ks-icon"></i>
                                                                    <span class="la la-search ks-icon"></span>
                                                                </span>
                                                          
                                                            </div>
                                                        </th>
                                                        <th>
                                                            <div class="col-xl-12">
                                                                <span>Company Name</span>
                                                                <input class="form-control serach-company"  placeholder="Type company name"type="text">
                                                                <span class="icon-addon custom-serch serach-company-btn">
                                                                    <i style="display:none;" class="clear la la-times ks-icon"></i>
                                                                    <span class="la la-search ks-icon"></span>
                                                                </span>
                                                                
                                                            </div>

                                                        </th>
                                                        <th>Created Date <i rel="ASC" class="short-proj la la-angle-down"></i></th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody class="main-section-serch">
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
                                                                    <button type='button' rel="move-to-user-<?= $key; ?>" index="<?= $project->project_id; ?>" data-domain="<?=$project->project_url; ?>" class="btn btn-success move-project">Move</button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class="col-lg-12">
                                            <div class="col-md-8 offset-md-4">
                                                <div class="card-block">
                                                    <div class="ks-items-block">
                                                        <nav id="links">
                                                            <?= $links ?>
                                                        </nav>
                                                    </div>
                                                    <div class="card-block">
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
</div>


<script src="<?= site_url('assets/admin/js/project.js'); ?>"></script>



