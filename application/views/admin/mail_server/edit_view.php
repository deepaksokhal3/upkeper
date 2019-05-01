<div class="ks-page-container">
    <div class="ks-column ks-page"> 
        <div class="ks-header">
            <section class="ks-title">
                <h3><?= $title; ?></h3>
               <a class="btn btn-success" href="<?= site_url('21232f297a57a5a743894a0e4a801fc3/add-mail-server');?>">Add</a>
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
                                </div>
                                <div class="col-lg-12">

                                    <div class="card panel">
                                        <div class="card-block">
                                            <?php echo form_open('21232f297a57a5a743894a0e4a801fc3/add-mail-server', array('name' => 'company', 'class' => '', 'method' => 'post')); ?>
                                            <input type="hidden" value="<?= $mail_host->m_server_id; ?>" name="m_server_id"/>
                                            <div class="row">
                                                <div class="form-group col-xl-12">
                                                    <label>Company Name</label>
                                                    <input type="text"
                                                           name="mail_company"
                                                           class="form-control"
                                                           placeholder="Enter company name"
                                                           data-validation="length"
                                                           data-validation-length="3-50"
                                                           value="<?= (isset($mail_host->mail_company)) ? $mail_host->mail_company : ''; ?>"
                                                           data-validation-error-msg="please enter company name">
                                                </div> 
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-xl-12">
                                                    <label>Company Url</label>
                                                    <input type="text"
                                                           name="mail_company_url"
                                                           class="form-control"
                                                           placeholder="Please enter company url"
                                                           data-validation="length"
                                                           data-validation-length="3-50"
                                                           value="<?= (isset($mail_host->mail_company_url)) ? $mail_host->mail_company_url : ''; ?>"
                                                           data-validation-error-msg="please enter correct url">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-xl-12">
                                                    <label>Comment</label>
                                                    <textarea rows="5" name="comment" class="form-control" placeholder="Please enter comment"><?= (isset($mail_host->comment)) ? $mail_host->comment : ''; ?></textarea>
                                                </div>
                                            </div>

                                            <div id="server_namess" class="row">
                                                <?php
                                                $i = 1;
                                                foreach (explode(",", $mail_host->mail_server) as $key => $server) {
                                                    ?>
                                                    <div id="clonedInput<?= $key; ?>" class="row clonedInput col-xl-12">
                                                        <div class="form-group col-xl-11">
                                                            <label class="server-fil">Mail Server <?= $i; ?></label>
                                                            <input type="text"
                                                                   name="mail_server[]"
                                                                   class="form-control"
                                                                   data-validation="length"
                                                                   data-validation-length="3-50"
                                                                   placeholder="Please enter server name"
                                                                   value="<?= $server ?>"
                                                                   data-validation-error-msg="User name has to be an alphanumeric value (3-50 chars)">
                                                        </div>
                                                        <div class="form-group col-xl-1">
                                                            <label>&ensp;</label>
                                                            <div class="actions">
                                                                <?php if ($key == 0) { ?>
                                                                    <button type="button" class="clone btn btn-success"><i class='la la-plus-circle ks-icon'></i></button>
                                                                <?php } else { ?>
                                                                    <button type="button" class="remove btn btn-danger"><i class="la la-minus-circle ks-icon"></i></button>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>

                                            </div>
                                            <div class="row">
                                                <div class="form-group col-xl-12">
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
<script>
    var regex = /^(.+?)(\d+)$/i;
    var cloneIndex = $(".clonedInput").length;

    function clone() {
        cloneIndex++;
        $(this).parents(".clonedInput").clone()
                .appendTo("#server_namess")
                .attr("id", "clonedInput" + cloneIndex)
                .find("*")
                .each(function () {
                    var id = this.id || "";
                    var match = id.match(regex) || [];
                    if (match.length == 3) {
                        this.id = match[1] + (cloneIndex);
                    }
                    $(this).children('.server-fil').text('Server Name ' + cloneIndex);
                })
                .children('.actions').append('<button type="button" class="remove btn btn-danger"><i class="la la-minus-circle ks-icon"></i></button>')
                .on('click', 'button.remove', remove)
                .children('.clone').remove();

    }
    function remove() {
        $(this).parents(".clonedInput").remove();
    }
    $("button.clone").on("click", clone);

    $("button.remove").on("click", remove);
</script>
