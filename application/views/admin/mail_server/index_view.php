<div class="ks-page-container">
    <div class="ks-column ks-page"> 
        <div class="ks-header">
            <section class="ks-title">
                <h3><?= $title ?></h3>
                <a class="btn btn-success" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/add-mail-server');?>">Add</a>
            </section>
        </div>
        <div class="ks-content">
            <div class="ks-body tables-page">
                <div class="ks-nav-body-wrapper col-md-8 offset-md-2">
                    <div class="container-fluid ks-rows-section">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card panel panel-default panel-table">
                                    <div class="card-block">
                                        <table class="table table-bordered vertical-align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Company Name</th>
                                                    <th>Action</th>
                                                </tr>   
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($mail_hosting as $key => $mail_host): ?>
                                                    <tr id="<?= $key ?>" class="tet">
                                                        <td>
                                                            <div class="table-cell-block">
                                                                <div class="text-block-container">
                                                                    <div class="text-block-text"><?= ($mail_host->mail_company) ? $mail_host->mail_company : ''; ?> </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>   
                                                            <a class="" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/edit-mail-server/'.$mail_host->m_server_id) ?>" >
                                                                <span class="la la-pencil icon text-primary-on-hover"></span> 
                                                            </a>  
                                                            <a class="" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/delete-mail-server/'.$mail_host->m_server_id) ?>" >
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
    </div>
</div>




