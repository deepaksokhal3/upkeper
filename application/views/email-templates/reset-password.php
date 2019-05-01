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
                                    <td style="word-wrap:break-word;font-size:0px;padding:10px 0px;padding-bottom:0px;" align="left">
                                      <div class="" style="cursor:auto;color:#000000;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:15px;line-height:19px;text-align:left;">
                                            <p>
                                                <?= isset($emailText)?$emailText:'No text'; ?> 
                                            </p>
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