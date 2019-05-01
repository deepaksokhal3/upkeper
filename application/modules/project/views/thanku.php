
<div class="ks-page background_color" style="padding:0px;">
    <div class="ks-body">
        <div class="ks-logo"><img src="<?= site_url('assets/images/logo-login.png'); ?>" width="150"/></div>

        <div class="card panel panel-default light ks-panel ks-confirm">
            <div class="card-block">
                <div class="ks-header">Thank you <?= isset($this->session_data['company_name']) ? $this->session_data['company_name'] : '' ?></div>
                <div class="ks-description">
                    We are working on your website to set it up & will email you once your site is ready for review. 
                </div>
                <div class="ks-description">
                    Meanwhile, you can configure cPanel details to use one click login for cPanel.
                </div>
                <div class="ks-resend">
                    <a href="<?= site_url(); ?>">Dashboard</a>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="tag_line" >
    <p style="padding: 0px 0 20px">UpKepr©2018, a venture of webgarh solutions</p>
</div>
</div>