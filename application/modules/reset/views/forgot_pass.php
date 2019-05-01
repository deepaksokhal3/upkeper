<div class="background_color forgot-col">
    <div class="sigIn middle_section_login">
        <div class=" left_section">
            <img src="<?= site_url('assets/images/logo-login.png'); ?>" />
            <!--div class="inner-text">
                <h2>Login Form</h2>
                <p>Please Login to continue</p>
            </div-->
        </div>
        <script src="https://www.google.com/recaptcha/api.js??hl=en"></script>

        <div class="right_section">
            <div class="error"></div>
            <?php echo $this->session->flashdata('success'); ?>
            <?php echo $this->session->flashdata('danger'); ?>
            <?php echo $this->session->flashdata('info'); ?>
            <h4 class="ks-header">
                Forgot Password
                <!--<span>Don't worry, this happens sometimes.</span>-->
            </h4>
            <div id="html_element"></div>
            <?php echo form_open('', array('name' => 'login', 'class' => 'orm-container', 'method' => 'post', 'id' => 'rest-pass')); ?>
            <div class="form-group">
                <label><img src="<?= site_url('assets/images/login_icon.png'); ?>" /></label><input type="text" id="email" name="email" placeholder="Please enter email address" />
            </div>
            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="6Le3lT4UAAAAAFHc6RYBqkjgLbVsumnBpvNp3031"></div>
            </div>
            <div class="form-group">

                <div class="col-xs-6 forget_password"><span class="text-muted">Remember It?</span> <a href="<?= site_url('login'); ?>">Login</a></div>
                <div class="col-xs-6 sign_in"><input type="button" class="submit" value="Submit"  /></div>
            </div>
            <?php echo form_close(); ?>

        </div>

        <div class="tag_line">
            <p>UpKepr©2018, a venture of webgarh solutions</p>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.submit').on('click', function () {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (!re.test($('#email').val())){
                $('#email').attr('placeholder','Please enter valid email');
                $('#email').css('border-bottom','1px solid #ef5350');
                return false;
            }
            $.ajax({
                url: SITE_URL + 'reset/captcha',
                type: 'post',
                dataType: 'json',
                data: $('#rest-pass').serialize(),
                success: function (data) {
                    if(data.error){
                         $('.error').html('');
                        $('.error').html(data.error);
                    }else{
                       $('#rest-pass').submit(); 
                    }
                }
            });
        });
    });

</script>
