<div class="ks-page-container">
    <div class="ks-column ks-page"> 
        <div class="ks-header">
            <section class="ks-title">
                <h3><?= $title ?> </h3>
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
                                                    <th>Title</th>
                                                    <th>Subject</th>
                                                    <th>Action</th>
                                                </tr>   
                                            </thead>
                                            <tbody>
                                                <?php foreach ($templates as $key => $template):
                                                    ?>
                                                    <tr id="<?= $key ?>" class="tet">
                                                        <td>
                                                            <div class="table-cell-block">
                                                                <div class="text-block-container">
                                                                    <div class="text-block-text"><?= ($template->temp_title) ? $template->temp_title : ''; ?></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="table-cell-block">
                                                                <div class="text-block-container">
                                                                    <div class="text-block-text"><?= ($template->subject) ? $template->subject : ''; ?></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a class="" href="#" onclick="editTemplate(this)" data-type="<?= $template->template_id; ?>">
                                                                <span class="la la-pencil icon text-primary-on-hover"></span> 
                                                            </a>
                                                            <a class="" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/delete-email-template/' . $template->template_id); ?>"><span class="la la-trash icon text-danger-on-hover"></span> </a>
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
                                        <?php echo form_open('21232f297a57a5a743894a0e4a801fc3/add-email-template', array('name' => 'emailTemplate', 'class' => '', 'method' => 'post')); ?>
                                        <input type="hidden" name="temp_id" value="" readonly/>
                                        <div class="row">
                                            <div class="form-group col-xl-6">
                                                <label>Title</label>
                                                <input type="text"
                                                       name="temp_title"
                                                       class="form-control"
                                                       placeholder="Please enter title"
                                                       data-validation=""
                                                       data-validation-length="3-50"
                                                       value="<?= set_value('temp_title') ?>"
                                                       data-validation-error-msg="Please enter alert name  (3-50 chars)">
                                            </div>
                                            <div class="form-group col-xl-6">
                                                <label>Template Type</label>
                                                <select id="temp_type" class="ks-selectpicker form-control" data-live-search="true" name="temp_type">
                                                    <option value="">--Select--</option>
                                                    <?php foreach ($alerts as $alert) { ?>
                                                        <option value="<?= $alert['alert_id'] ?>"><?= $alert['alert_name']; ?></option>
                                                        <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class="form-group col-xl-12">
                                                <label>Subject</label>
                                                <input type="text"
                                                       id="subject"
                                                       name="subject"
                                                       class="form-control"
                                                       placeholder="Please enter subject"
                                                       data-validation=""
                                                       data-validation-length="3-200"
                                                       value="<?= set_value('subject') ?>"
                                                       data-validation-error-msg="Subject text should be between(3-200 chars)">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div id="email_template"class="form-group col-xl-12">
                                                <label>Email Template</label>
                                                <textarea name="email_template" data-animation="false" id="ks-summernote-editor-default"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-xl-6">
                                                <label></label>
                                                <button type="submit" name="manage_submit" class="btn btn-primary">Add Template</button>
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

<script src="<?= site_url('assets/admin/js/emailTemplate.js') ?>"></script>


