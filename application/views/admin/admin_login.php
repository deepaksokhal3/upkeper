<div class="ks-page">
    <div class="ks-body">
    <div class="ks-logo">UPKEPR</div>
        <div class="card panel panel-default ks-light ks-panel ks-login">
            <div class="card-block">
                <?php echo $this->session->flashdata('success'); ?>
                 <?php echo $this->session->flashdata('danger'); ?>
                <?php echo $this->session->flashdata('info'); ?>
                  <?php echo form_open('', array('name' => 'login', 'class' => '', 'method' => 'post')); ?>
                    <h4 class="ks-header">Admin Login</h4>
                    <div class="form-group">
                        <div class="input-icon icon-left icon-lg icon-color-primary">
                            <input  type="text" name="email" 
                                    class="form-control"
                                    placeholder="Email"
                                    data-validation="email"
                                    data-validation-length="1-100"
                                    data-validation-error-msg="Please enter valid email address" >
                            <span class="icon-addon">
                                <span class="la la-at"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon icon-left icon-lg icon-color-primary">
                            <input type="password" 
                                   name="password" 
                                   class="form-control" 
                                   placeholder="Password" 
                                   data-validation="length text"
                                    data-validation-length="1-100"
                                    data-validation-error-msg="Please enter valid password"
                                   >
                            <span class="icon-addon">
                                <span class="la la-key"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                    <!--div class="ks-text-center">
                        Don't have an account. <a href="pages-signup.html">Sign Up</a>
                    </div>
                    <!--div class="ks-text-center">
                        <a href="pages-forgot-password.html">Forgot your password?</a>
                    </div>
                    <!--div class="ks-social">
                        <div>or Log In with social</div>
                        <div>
                            <a href="#" class="facebook la la-facebook"></a>
                            <a href="#" class="twitter la la-twitter"></a>
                            <a href="#" class="google la la-google"></a>
                        </div>
                    </div-->
                  <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <div class="ks-footer">
        <span class="ks-copyright">UpKepr©2017, a venture of webgarh solutions</span>
      
    </div>
</div>