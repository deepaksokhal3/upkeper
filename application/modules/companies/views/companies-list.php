<div class="ks-page-container">
    <div class="ks-column ks-page"> 
        <div class="ks-header">
            <section class="ks-title">
                <h3><?= $title ?></h3>
            </section>
        </div>
        <div class="ks-content">
            <div class="ks-body tables-page">
                <div class="ks-nav-body-wrapper col-md-8 offset-md-2">
                    <div class="container-fluid ks-rows-section">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php echo $this->session->flashdata('success'); ?>
                                    <?php echo $this->session->flashdata('notice'); ?>
                                <div class="card panel panel-default panel-table">
                                    <div class="card-block">
                                        <table class="table table-bordered vertical-align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                    <th>Progress</th>
                                                    <th>Action</th>
                                                </tr>   
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($compay_data as $key => $company):
                                                    ?>
                                                    <tr id="<?= $key ?>" class="tet">
                                                        <td>
                                                            <div class="table-cell-block">
                                                                <div class="text-block-container">
                                                                    <div class="text-block-text"><?= ($company->company_name) ? $company->company_name : ''; ?> </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                           
                                                            <div class="table-cell-block status">
                                                                <?php if ($company->status  == 0) { ?>
                                                                    <div class="status-block-container">
                                                                        <span id="status-<?= $key ?>" class="status-block status-block-info"></span>
                                                                    </div>
                                                                    <div class="text-block-container">
                                                                        <div id="status-txt<?= $key ?>" class="text-block-text">In process</div>
                                                                    </div>
                                                                <?php } else if ($company->status == 1 && $company->c_acc_status == 0) { ?>
                                                                    <div class="status-block-container">
                                                                        <span  id="status-<?= $key ?>" class="status-block status-block-success"></span>
                                                                    </div>
                                                                    <div class="text-block-container">
                                                                        <div id="status-txt<?= $key ?>" class="text-block-text">Active</div>
                                                                    </div>
                                                                <?php } else { ?>
                                                                    <div class="status-block-container">
                                                                        <span id="status-<?= $key ?>" class="status-block status-block-pink"></span>
                                                                    </div>
                                                                    <div class="text-block-container">
                                                                        <div id="status-txt<?= $key ?>" class="text-block-text">Deactivated</div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="table-cell-block">
                                                                <?php if (!$company->status && !$company->prof_status == 0) { ?>
                                                                    <div class="progress-text-container">
                                                                        50%
                                                                    </div>
                                                                    <div class="progress-block-container">
                                                                        <div class="progress ks-progress-sm">
                                                                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                    </div>
                                                                <?php } else if ($company->status == 1  && $company->prof_status == 1) { ?>
                                                                    <div class="progress-text-container">
                                                                        100%
                                                                    </div>
                                                                    <div class="progress-block-container">
                                                                        <div class="progress ks-progress-sm">
                                                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                    </div>
                                                                <?php } else { ?>
                                                                    <div class="progress-text-container">
                                                                        100%
                                                                    </div>
                                                                    <div class="progress-block-container">
                                                                        <div class="progress ks-progress-sm">
                                                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a class="dropdown-item" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/edit-company-profile/'.$company->user_id);?>">
                                                                <span class="la la-pencil icon text-primary-on-hover"></span></a>
                                                      
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
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




