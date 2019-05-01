<script src="https://www.google.com/recaptcha/api.js??hl=en"></script>
<style>
    .g-recaptcha {
       
    }
</style>
<div class="background_color" id="background_color">
    <div class="sigIn middle_section_login">
        <div class=" left_section">
            <img src="<?= site_url('assets/images/logo-login.png'); ?>" />
            <!--div class="inner-text">
                <h2>Login Form</h2>
                <p>Please Login to continue</p>
            </div-->
        </div>

        <div class="right_section">
            <?php echo $this->session->flashdata('success'); ?>
            <?php echo $this->session->flashdata('danger'); ?>
            <?php
            echo $this->session->flashdata('info');
            if ($this->form_validation->error_array()) {
                foreach ($this->form_validation->error_array() as $key => $error) {
                    echo sprintf($this->lang->line('DANDER_ALERT'), $error);
                }
            }
            ?>
            <?php echo form_open('', array('name' => 'login', 'class' => '', 'method' => 'post')); ?>
            <div class="form-group">
                <label><img src="<?= site_url('assets/images/login_icon.png'); ?>" /></label><input type="text" name="email" placeholder="Username" />
            </div>
            <div class="form-group">
                <label><img src="<?= site_url('assets/images/password_icon.png'); ?>" /></label><input type="password" data-validation="strength" data-validation-strength="2" name="password" placeholder="Password" />
            </div>
            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="6Le3lT4UAAAAAFHc6RYBqkjgLbVsumnBpvNp3031"></div>
            </div>
            <div class="form-group">
                <div class="col-xs-6 forget_password"><a href="<?= site_url('reset-password'); ?>">Forgot Password?</a></div>
                <div class="col-xs-6 sign_in"><input type="submit" value="Sign In" /></div>
            </div>
            <?php echo form_close(); ?>
        </div>

        <div class="tag_line">
            <p>UpKepr©2018, a venture of webgarh solutions</p>
        </div>
    </div>
</div>

<script type="text/javascript">
    var images = ['background1.jpg', 'background_login.jpg', 'background2.jpg'];
    $('#background_color').css({'background-image': 'url(' + SITE_URL + '/assets/images/' + images[Math.floor(Math.random() * images.length)] + ')'});
</script>
<script src="<?= site_url('assets/public/bootstrap/js/bootstrap.min.js'); ?>"></script>
