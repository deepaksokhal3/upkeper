<div class="ks-page-container">
    <div class="ks-column ks-page"> 
        <div class="ks-header">
            <section class="ks-title">
                <h3><?= $title ?></h3>
            </section>
        </div>
        <div class="ks-content">
            <div class="ks-body tables-page">
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid ks-rows-section">
                        <div class="row">
                            <div class="col-lg-6">
                                <?php echo $this->session->flashdata('manage_success'); ?>
                                <?php echo $this->session->flashdata('manage_error'); ?>
                                <div class="card panel panel-default panel-table">
                                    <div class="card-block">
                                        <table class="table table-bordered vertical-align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Host Company</th>
                                                    <th>Action</th>
                                                </tr>   
                                            </thead>
                                            <tbody>
                                                <?php foreach ($host_companies as $key => $host_compay):
                                                    ?>
                                                    <tr id="<?= $key ?>" class="tet">
                                                        <td>
                                                            <div class="table-cell-block">
                                                                <div class="text-block-container">
                                                                    <div class="text-block-text"><?= ($host_compay->host_company) ? $host_compay->host_company : ''; ?></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a class="" href="#" onclick="editHostCompany(this)" data-type="<?= $host_compay->h_manager_id ?>">
                                                                <span class="la la-pencil icon text-primary-on-hover"></span> 
                                                            </a>
                                                            <a class="" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/delete-host-company/' . $host_compay->h_manager_id); ?>"><span class="la la-trash icon text-danger-on-hover"></span> </a>
                                                        </td>

                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <?php echo $this->session->flashdata('success'); ?>
                                <?php echo $this->session->flashdata('error'); ?>
                                <?php
                                if ($this->form_validation->error_array()) {
                                    foreach ($this->form_validation->error_array() as $key => $error) {
                                        echo sprintf($this->lang->line('DANDER_ALERT'), $error);
                                    }
                                }
                                ?>
                                <div class="card panel">
                                    <div class="card-block">
                                        <?php echo form_open('21232f297a57a5a743894a0e4a801fc3/add-host-company', array('name' => 'alerts', 'class' => '', 'method' => 'post')); ?>
                                        <input type="hidden" name="h_manager_id" value="<?= isset($companyData['h_manager_id'])?$companyData['h_manager_id']:''; ?>" readonly/>
                                        <div class="row">
                                            <div class="form-group col-xl-9">
                                                <input type="text"
                                                       name="host_company"
                                                       class="form-control"
                                                       placeholder="Please enter host company"
                                                       data-validation=""
                                                       data-validation-length="3-400"
                                                       value="<?= isset($companyData['host_company'])?$companyData['host_company']:''; ?>"
                                                       data-validation-error-msg="Please enter alert name  (3-400 chars)">
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-xl-6">
                                                    <button type="submit" name="manage_submit" class="btn btn-primary"><?= isset($companyData['h_manager_id'])?'Update Host Company':'Add Host Company'; ?></button>
                                                </div>
                                            </div>
                                            <?php echo form_close(); ?>
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

    <script src="<?= site_url('application/modules/hostmanager/js/hostmanage.js') ?>"></script>











    <!--<div class="ks-page-container">
        <div class="ks-column ks-page"> 
            <div class="ks-header">
                <section class="ks-title">
                    <h3><?= $title ?></h3>
                    <a class="btn btn-success" href="<?= site_url('admin/hostmanager/add'); ?>">Add Hosting</a>
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
                                                        <th>Web url</th>
                                                        <th>Action</th>
                                                    </tr>   
                                                </thead>
                                                <tbody>
    <?php //foreach ($hosts as $key => $hosts): ?>
                                                        <tr id="<?= $key ?>" class="tet">
                                                            <td>
                                                                <div class="table-cell-block">
                                                                    <div class="text-block-container">
                                                                        <div class="text-block-text"><?= ($hosts->company_name) ? $hosts->company_name : ''; ?> </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="table-cell-block">
                                                                    <div class="text-block-container">
                                                                        <div class="text-block-text"><?= ($hosts->ref_weburl) ? $hosts->ref_weburl : ''; ?> </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>   
                                                                <a class="" href="<?= site_url('admin/hostmanager/edit/' . $hosts->h_manager_id) ?>" >
                                                                    <span class="la la-pencil icon text-primary-on-hover"></span> 
                                                                </a>  
                                                                <a class="" href="<?= site_url('admin/hostmanager/delete_host/' . $hosts->h_manager_id) ?>" >
                                                                    <span class="la la-trash-o icon text-primary-on-hover"></span> 
                                                                </a>
                                                            </td>
                                                        </tr>
    <?php // endforeach;  ?>
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
    
    
    
    -->
