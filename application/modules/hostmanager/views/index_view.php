<div class="ks-page-container">
    <div class="ks-column ks-page"> 
        <div class="ks-header">
            <section class="ks-title">
                <h3><?= $title ?></h3>
                <a class="btn btn-success" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/add-host-company'); ?>">Add Hosting</a>
            </section>
        </div>
        <div class="ks-content">
            <div class="ks-body tables-page">
                <div class="ks-nav-body-wrapper col-md-8 offset-md-2">
                    <div class="container-fluid ks-rows-section">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered vertical-align-middle" id='ks-datatable'>
                                    <thead>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Action</th>
                                        </tr>   
                                    </thead>
                                    <tbody>
                                        <?php foreach ($hosts as $key => $hosts): ?>
                                            <tr id="<?= $key ?>" class="tet">
                                                <td>
                                                    <div class="table-cell-block">
                                                        <div class="text-block-container">
                                                            <div class="text-block-text"><?= ($hosts->host_company) ? $hosts->host_company : ''; ?> </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>   
                                                    <a class="" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/edit-host-company/' . $hosts->h_manager_id) ?>" >
                                                        <span class="la la-pencil icon text-primary-on-hover"></span> 
                                                    </a>  
                                                    <a class="" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/delete-host-company/' . $hosts->h_manager_id) ?>" >
                                                        <span class="la la-trash-o icon text-primary-on-hover"></span> 
                                                    </a>
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




