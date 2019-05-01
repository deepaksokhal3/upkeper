<div class="ks-page-container">
    <div class="ks-column ks-page"> 
        <div class="ks-header">
            <section class="ks-title">
                <h3>Create Company</h3>
            </section>
        </div>
        <div class="ks-content">
            <div class="ks-body ks-content-nav">
                <div class="ks-nav-body">
                    <div class="ks-nav-body-wrapper col-md-8 offset-md-2">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php echo $this->session->flashdata('success'); ?>
                                    <?php echo $this->session->flashdata('danger'); ?>
                                    <?php echo $this->session->flashdata('notice'); ?>
                                </div>
                                <div class="col-lg-12">

                                    <div class="card panel">
                                        <div class="card-block">
                                            <?php echo form_open('', array('name' => 'company', 'class' => '', 'method' => 'post')); ?>
                                            <input type="hidden" name="type" value="ADD" readonly/>
                                            <div class="row">
                                                <div class="form-group col-xl-6">
                                                    <label>Company Name</label>
                                                    <input type="text"
                                                           name="company_name"
                                                           class="form-control"
                                                           placeholder="Enter company name"
                                                           data-validation="length"
                                                           data-validation-length="3-15"
                                                           value="<?= set_value('company_name') ?>"
                                                           data-validation-error-msg="User name has to be an alphanumeric value (3-15 chars)">
                                                    <em><?php echo form_error('f_name'); ?></em>
                                                </div>
                                                <div class="form-group col-xl-6">
                                                    <label>E-mail</label>
                                                    <input type="text" name="email" class="form-control" aria-describedby="emailHelp" value="<?= set_value('email') ?>" placeholder="Enter email" data-validation="email">
                                                    <em><?php echo form_error('email'); ?></em>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-xl-6">
                                                    <label>First Name</label>
                                                    <input type="text"
                                                           name="f_name"
                                                           class="form-control"
                                                           placeholder="Enter first name"
                                                            data-validation="custom"
                                                           data-validation-regexp="^([A-Za-z]+)$"
                                                           data-validation-has-keyup-event="true"
                                                           value="<?= set_value('f_name') ?>">
                                                    <em><?php echo form_error('f_name'); ?></em>
                                                </div>
                                                <div class="form-group col-xl-6">
                                                    <label>Last Name</label>
                                                    <input type="text"
                                                           name="l_name"
                                                           class="form-control"
                                                           placeholder="Enter last name"
                                                           data-validation="custom"
                                                           data-validation-regexp="^([A-Za-z]+)$"
                                                           data-validation-has-keyup-event="true"
                                                           value="<?= set_value('l_name') ?>">
                                                    <em><?php echo form_error('f_name'); ?></em>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-xl-6">
                                                    <label>Phone Number</label>
                                                    <input type="text"
                                                           name="mobile_number"
                                                           class="form-control"
                                                           placeholder="Enter phone number"
                                                           data-validation="number"
                                                           data-validation-ignore="+"
                                                           value="<?= set_value('mobile_number') ?>">
                                                    <em><?php echo form_error('mobile_number'); ?></em>
                                                </div>
                                                <div class="form-group col-xl-6">
                                                    <label>Category</label>
                                                    <select name="category" class="form-control">
                                                        <?php foreach ($catagories as $category) {
                                                            ?>
                                                            <option value="<?= $category->cat_id; ?>" ><?= $category->cat_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <em><?php echo form_error('category'); ?></em>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-xl-6">
                                                    <label>Country</label>
                                                    <select class="form-control" name="country">
                                                        <option value="">--Select--</option>
                                                        <?php
                                                        foreach ($countries as $country) :
                                                            ?>
                                                            <option value="<?= ($country['country_id']) ? $country['country_id'] : '' ?>"><?= ($country['country_name']) ? $country['country_name'] : '' ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-xl-6">
                                                    <label>City</label>
                                                    <input type="text"
                                                           name="city"
                                                           class="form-control"
                                                           placeholder="Enter city"
                                                           value="<?= set_value('city') ?>">
                                                    <em><?php echo form_error('f_name'); ?></em>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="form-group col-xl-6">
                                                    <label>State</label>
                                                    <input type="text"
                                                           name="state"
                                                           class="form-control"
                                                           placeholder="Enter state"
                                                           value="<?= set_value('state') ?>">
                                                    <em><?php echo form_error('city'); ?></em>
                                                </div>
                                                <div class="form-group col-xl-6">
                                                    <label  id="copy_pass" class="custom-control custom-checkbox ks-checkbox copy_pass"></label>
                                                    <label  id="copy_pass" class="custom-control custom-checkbox ks-checkbox copy_pass">
                                                        <input type="checkbox" id="password_checked" name="send_email" class="custom-control-input" value="1">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Send email</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-xl-6">
                                                    <label>Address 1 (<span id="ks-maxlength-label">50</span> characters left)</label>
                                                    <textarea rows="3" id="ks-maxlength-area" name="address1" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group col-xl-6">
                                                    <label>Address 2 (<span id="ks-maxlength-label">50</span> characters left)</label>
                                                    <textarea rows="3" id="ks-maxlength-area" name="address2" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-xl-6">
                                                    <label>Password</label>
                                                    <input type="password"
                                                           class="form-control"
                                                           name="password"
                                                           placeholder="Enter Password"
                                                           data-validation="strength"
                                                           value="<?= set_value('password') ?>"
                                                           data-validation-strength="2">
                                                    <em><?php echo form_error('password'); ?></em>
                                                </div>
                                                <div class="form-group col-xl-6">
                                                    <label  id="copy_pass" class="custom-control custom-checkbox ks-checkbox copy_pass">
                                                        <input type="checkbox" id="password_checked" onchange="copy(this)" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Copy to password</span>
                                                    </label>
                                                    <input type="text"  id="genrated-pass" name="genrated_password" class="form-control genrated-pass" placeholder="Genrate password" readonly >
                                                    <input type="button" class="btn btn-primary" value="Generate" onClick="generate()" tabindex="2">

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-xl-6">
                                                    <label></label>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
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
</div>
