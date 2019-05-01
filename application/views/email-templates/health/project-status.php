<?= $this->load->view('email-templates/health/header'); ?>
<div style="margin:0px auto;max-width:600px;background:#fff;">
    <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#fff;" align="center" border="0">
        <tbody>
            <tr>
                <td style="word-wrap:break-word;font-size:0px;padding:10px 25px;">        
                    <div class="mj-column-per-100 outlook-group-fix" style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%;">
                        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                            <tbody>
                                <tr>    
                                    <td style="word-wrap:break-word;font-size:0px;padding:10px 0px;">
                                        <div class="" style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:22px;text-align:center;">
                                            <h2 class="ks-header-h2">
                                                <?= isset($data['website_name']) ? ucfirst($data['website_name']) : ''; ?>
                                            </h2>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="word-wrap:break-word;font-size:0px;padding:10px 0px;">
                                        <p style="font-size:1px;margin:0px auto;border-top:1px solid #e6e6e6;width:100%;"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="word-wrap:break-word;font-size:0px;padding:10px 0px;padding-bottom:0px;" align="left">
                                        <div class="" style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:15px;line-height:19px;text-align:left;">
                                            <p>Hi <?= $data['company_name']; ?></p>

                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="word-wrap:break-word;font-size:0px;padding:10px 0px;padding-bottom:0px;" align="left">
                                        <div class="" style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:15px;line-height:19px;text-align:left;">
                                            <p><?= lang_msg('EMAIL_TOP_CONTENT'); ?></p>

                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="word-wrap:break-word;font-size:0px;padding:10px 0px;padding-bottom:0px;" align="left">
                                        <div class="" style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:15px;line-height:19px;text-align:left;">
                                            <p><strong><?= lang_msg('EMAIL_MIDDLE_TITLE'); ?></strong></p>

                                        </div>
                                    </td>
                                </tr>
                                <?php
                                if (isset($data['domain_expire']) && $data['domain_expire']):
                                    ?>
                                    <tr>
                                        <td style="word-wrap:break-word;font-size:0px;padding:10px 0px;padding-bottom:0px; border: 1px solid #e6e6e6; padding: 0px 10px 0px 10px;" align="left">
                                            <div class="" style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:15px;line-height:19px;text-align:left;">
                                                <p>DOMAIN: <?= $data['site_url']; ?></p>
                                                <p>
                                                    Domain name is expiring on <?= $data['domain_expire']; ?>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                endif;

                                if (isset($data['desktop_speed']) && $data['desktop_speed']):
                                    ?>
                                    <tr>
                                        <td style="word-wrap:break-word;font-size:0px;padding:10px 0px;padding-bottom:0px; border: 1px solid #e6e6e6; padding: 0px 10px 0px 10px;" align="left">
                                            <div class="" style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:15px;line-height:19px;text-align:left;">
                                                <p>WEBSITE LOAD SPEED (Desktop):</p>
                                                <p>The website load speed on the desktop is   <?= $data['desktop_speed']; ?> and mobile <?= $data['mobile_speed']; ?> on the scale of 100 points, where 100 is the best speed that a website can achieve.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                endif;

                                if (isset($data['ssl_expire']) && $data['ssl_expire']):
                                    ?>
                                    <tr>
                                        <td style="word-wrap:break-word;font-size:0px;padding:10px 0px;padding-bottom:0px; border: 1px solid #e6e6e6; padding: 0px 10px 0px 10px;" align="left">
                                            <div class="" style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:15px;line-height:19px;text-align:left;">
                                                <p>SSL STATUS: </p>
                                                <p> SSL is expiring on <?= $data['ssl_expire']; ?> </p>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                endif;

                                if (isset($data['malware'])):
                                    ?>
                                    <tr>
                                        <td style="word-wrap:break-word;font-size:0px;padding:10px 0px;padding-bottom:0px; border: 1px solid #e6e6e6; padding: 0px 10px 0px 10px;" align="left">
                                            <div class="" style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:15px;line-height:19px;text-align:left;">
                                                <p>MALWARE STATUS:</p>
                                                <p><?= ($data['malware'] == 0) ? '<span style="color:#6aa84f;"> Your website is clean </span>' : '<span style="color:#ff0000; font-weight: bold;">Your website is malware infected</span>'; ?> </p>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                endif;
                                if (isset($data['mobile_friendly'])):
                                    ?>
                                    <tr>
                                        <td style="word-wrap:break-word;font-size:0px;padding:10px 0px;padding-bottom:0px; border: 1px solid #e6e6e6; padding: 0px 10px 0px 10px;" align="left">
                                            <div class="" style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:15px;line-height:19px;text-align:left;">
                                                <p>RESPONSIVENESS STATUS: </p>
                                                <p><?= $data['mobile_friendly'] == 1 ? 'Your website is mobile friendly' : 'Your website is not mobile friendly'; ?></p>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                endif;

                                if (isset($data['blacklisting_status']) && $data['blacklisting_status']):
                                    ?>
                                    <tr>
                                        <td style="word-wrap:break-word;font-size:0px;padding:10px 0px;padding-bottom:0px; border: 1px solid #e6e6e6; padding: 0px 10px 0px 10px;" align="left">
                                            <div class="" style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:15px;line-height:19px;text-align:left;">
                                                <p>EMAIL BLACKLISTING STATUS:</p>
                                                <p><?= $data['blacklisting_status']; ?></p>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                endif;

                                if (isset($data['down_time_status']) && $data['down_time_status']):
                                    ?>
                                    <tr>
                                        <td style="word-wrap:break-word;font-size:0px;padding:10px 0px;padding-bottom:0px; border: 1px solid #e6e6e6; padding: 0px 10px 0px 10px;" align="left">
                                            <div class="" style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:15px;line-height:19px;text-align:left;">
                                                <p>DOWN/UP TIME: </p>
                                                <p><?= ($data['down_time_status'] == 'up')? '<span style="color:#6aa84f;">Uptime status is more than 99%</span>':'<span style="color:#ff0000;">Uptime status is Not Good</span>'; ?>.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                endif;
                                if (isset($data['core']) && $data['core']):
                                    ?>
                                    <tr>
                                        <td style="word-wrap:break-word;font-size:0px;padding:10px 0px;padding-bottom:0px; border: 1px solid #e6e6e6; padding: 0px 10px 0px 10px;" align="left">
                                            <div class="" style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:15px;line-height:19px;text-align:left;">
                                                <p>WORDPRESS CORE STATUS:</p>
                                                <p>wordpress core available  :<?= $data['core']; ?></p>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                endif;

                                if (isset($data['plugins']) && $data['plugins']):
                                    ?>
                                    <tr>
                                        <td style="word-wrap:break-word;font-size:0px;padding:10px 0px;padding-bottom:0px;" align="left">
                                            <div class="" style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:15px;line-height:19px;text-align:left;">
                                                <p>WORDPRESS PLUGINS STATUS:</p>
                                                <p>
                                                <table id="customers">
                                                    <tr>
                                                        <th>Plugins</th>
                                                        <th>New Version</th>
                                                    </tr>
                                                    <?php foreach ($data['plugins'] as $key => $plugin) : ?>

                                                        <tr>
                                                            <td><?= $plugin->Name; ?> </td>
                                                            <td><?= $plugin->update->new_version; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>

                                                </table>   
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                endif;
                                ?>
                                <tr>
                                    <td style="word-wrap:break-word;font-size:0px;padding:10px 0px;padding-bottom:0px;" align="left">
                                        <div class="" style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:15px;line-height:19px;text-align:left;">
                                            <p>For more information about the website status. please log into your upkepr.com account. </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="word-wrap:break-word;font-size:0px;padding:10px 0px;padding-bottom:0px;" align="left">
                                        <div class="" style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:15px;line-height:19px;text-align:left;">
                                            <p>Upkepr aims to keep you updated on the working status of various components of your website. This email message is a step in that direction, if you have any feedback to make us better, please share your ideas with us on info@upkepr.com</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="word-wrap:break-word;font-size:0px;padding:10px 0px;padding-bottom:0px;" align="left">
                                        <div class="" style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:15px;line-height:19px;text-align:left;">
                                            </br>
                                            <p>Yours,</p>
                                            <p>UpKepr Team</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<?= $this->load->view('email-templates/health/footer'); ?>