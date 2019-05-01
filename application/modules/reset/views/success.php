<div class="ks-page background_color" style="padding:0px;">
    <div class="ks-body">
        <div class="ks-logo" style="margin-bottom: 30px;"> <img src="<?= site_url('assets/images/logo-login.png'); ?>" width="150"/></div>

        <div class="card panel panel-default light ks-panel ks-confirm">
            <div class="card-block">
                <div class="ks-header"><?= isset($title) ? $title : ''; ?></div>
                <div class="ks-description">
                    <?= isset($text) ? $text : ''; ?>
                </div>
                <?php if (isset($type) && $type == 'sent') { ?>
                    <div class="ks-resend">
                        Haven't received yet? <a href="">Recend</a>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="ks-panel-extra" style="color: #fff;">
            Go to home <a href="<?= site_url(); ?>" style="color:#fff; text-decoration: underline;">Login</a>
        </div>
    </div>
    <div class="tag_line" >
        <p style="padding: 0px 0 20px">UpKepr©2018, a venture of webgarh solutions</p>
    </div>
</div>