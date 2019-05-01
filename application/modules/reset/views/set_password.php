

<div class="background_color forgot-col">
    <div class="sigIn middle_section_login">
        <div class=" left_section">
            <img src="<?= site_url('assets/images/logo-login.png'); ?>" />
           
        </div>
        
        <div class="right_section">
            <?php echo $this->session->flashdata('success'); ?>
                <?php echo $this->session->flashdata('error'); ?>
                <?php echo $this->session->flashdata('info'); ?>
            <h4 class="ks-header">
                Set new password
            </h4>
             <?php echo form_open('save-password', array('name' => 'login', 'class' => 'orm-container', 'method' => 'post')); ?>
                <input type="hidden" name="token" value="<?= isset($token) ? $token : ''; ?>">
            <div class="form-group">
                <label><img src="<?= site_url('assets/images/password_icon.png'); ?>" /></label>
                <input name="password_confirmation"
                       type="password"
                       placeholder="New password" 
                       data-validation="length"
                       data-validation-length="min5"
                       data-validation-error-msg="You have not given a correct password" />
            </div>
            <div class="form-group">
                <label><img src="<?= site_url('assets/images/password_icon.png'); ?>" /></label>
                <input name="password" type="password"
                       placeholder="Confirm password" 
                       data-validation="confirmation"
                       data-validation-confirm="password_confirmation"
                       data-validation-error-msg="You have not given a correct password" />
            </div>
            <div class="form-group">
                <div class="col-xs-6 forget_password"><span class="text-muted">Remember It?</span> <a href="<?= site_url('login'); ?>">Login</a></div>
                <div class="col-xs-6 sign_in"><input type="submit" value="Submit" /></div>
            </div>
            <?php echo form_close(); ?>
        </div>

        <div class="tag_line">
            <p>UpKepr©2018, a venture of webgarh solutions</p>
        </div>
    </div>
</div>

