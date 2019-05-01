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
                                <div class="panel-table">
                                        <table class="table table-bordered vertical-align-middle" id='ks-datatable'>
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Key</th>
                                                    <th>Action</th>
                                                </tr>   
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if(isset($messages)){
                                                foreach ($messages as $key => $message): ?>
                                                   
                                                        <td>
                                                            <div class="table-cell-block">
                                                                <div class="text-block-container">
                                                                    <div class="text-block-text"><?= ($message->msg) ? $message->msg : ''; ?></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="table-cell-block">
                                                                <div class="text-block-container">
                                                                    <div class="text-block-text"><?= ($message->msg_key) ? $message->msg_key : ''; ?></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a class="" href="#" onclick="editErrorMessage(this)" data-type="<?= $message->error_id ?>">
                                                                <span class="la la-pencil icon text-primary-on-hover"></span> 
                                                            </a>
                                                            <a class="" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/delete/' . $message->error_id); ?>"><span class="la la-trash icon text-danger-on-hover"></span> </a>
                                                        </td>

                                                    </tr>
                                                <?php endforeach; } ?>
                                            </tbody>
                                        </table>
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
                                        <?php echo form_open('', array('name' => 'alerts', 'class' => '', 'method' => 'post')); ?>
                                        <input type="hidden" name="error_id" value="" readonly/>
                                      
                                       <div class="row">
                                         
                                           <div class="form-group col-xl-12">
                                                <label>Key</label>
                                                <input type="text"
                                                       id="msg_key"
                                                       name="msg_key"
                                                       class="form-control"
                                                       placeholder='Please enter "SUPPER_KEY"'
                                                       data-validation=""
                                                       data-validation-length="3-200"
                                                       value=""
                                                       data-validation-error-msg="Subject text should be between(3-200 chars)">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-xl-12">
                                                <label>Message</label>
                                                    <textarea name="e_msg" 
                                                          id="message"
                                                          rows="4"
                                                          cols="50"
                                                          class="form-control "
                                                          data-animation="false"
                                                          data-validation=""
                                                          data-validation-length="3-50"
                                                          data-validation-error-msg="Please type (3-50 chars)"
                                                          ></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-xl-6">
                                                <label></label>
                                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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


<script src="<?= site_url('assets/admin/js/error_message.js') ?>"></script>