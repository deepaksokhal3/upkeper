
<div class="ks-page-container">
    <div class="ks-column ks-page"> 
        <!--div class="ks-header">
            <section class="ks-title">
                <h3><?= isset($title) ? $title : 'Add Project'; ?></h3>
                <button type="button" class="btn btn-success back-btu" onclick="goBack()">Go Back</button>
            </section>
        </div-->
        <div class="ks-content">
            <div class="ks-body ks-content-nav">
                <div class="ks-nav-body Inner-container">
                    <div class="ks-nav-body-wrapper col-md-8 offset-md-2">
                        <div class="container-fluid">
                            <div class="ks-title-body">
                                <div class="col-lg-12">
                                    <div class="prj-hdng">
                                        <p>  <?= isset($title) ? strtoupper($title) : strtoupper('Add Project'); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 profile-alert">
                                <?php echo $this->session->flashdata('success'); ?>
                                <?php echo $this->session->flashdata('danger'); ?>
                                <?php echo $this->session->flashdata('info'); ?>
                            </div>
                            <div class="col-lg-12 profile-sec-col">
                                <div class="col-lg-12 pull-left">
                                    <div class=" ks-title-body">
                                        <div class="card-header col-lg-12">
                                            <h4 class="">
                                                General Profile Setting 
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <?php echo form_open_multipart('profile/update', array('name' => 'company', 'id' => 'profile-info', 'class' => 'ks-step', 'method' => 'post')); ?>
                                        <div class="row">
                                            <div class="form-group col-xl-6">
                                                <input type="text"
                                                       name="company_name"
                                                       class="form-control"
                                                       placeholder="Enter company name"
                                                       data-validation="length"
                                                       data-validation-length="3-100"
                                                       value="<?= ($user_profile['company_name']) ? $user_profile['company_name'] : '' ?>"
                                                       data-validation-error-msg="First name has to be an alphanumeric value (3-100 chars)">
                                                <em><?php echo form_error('company_name'); ?></em>
                                            </div>
                                            <div class="form-group col-xl-6">
                                                <input type="text"
                                                       name="email"
                                                       class="form-control"
                                                       placeholder="Enter email address"
                                                       data-validation-length="3-50"
                                                       value="<?= ($user_profile['user_email']) ? $user_profile['user_email'] : '' ?>"
                                                       readonly>
                                                <em><?php echo form_error('f_name'); ?></em>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-xl-6">
                                                <input type="text"
                                                       name="f_name"
                                                       class="form-control"
                                                       placeholder="Please enter first name"
                                                       data-validation="custom" data-validation-regexp="^([A-Za-z]+)$"
                                                       value="<?= ($user_profile['f_name']) ? $user_profile['f_name'] : '' ?>">
                                                <em><?php echo form_error('f_name'); ?></em>
                                            </div>
                                            <div class="form-group col-xl-6">
                                                <input type="text"
                                                       name="l_name"
                                                       class="form-control"
                                                       placeholder="Please enter last name"
                                                       data-validation="custom" data-validation-regexp="^([A-Za-z]+)$"
                                                       value="<?= ($user_profile['l_name']) ? $user_profile['l_name'] : '' ?>">
                                                <em><?php echo form_error('f_name'); ?></em>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-xl-6">
                                                <input type="text"
                                                       name="mobile_number"
                                                       class="form-control"
                                                       placeholder="Enter phone number"
                                                       data-validation="number"
                                                       data-validation-ignore="+"
                                                       data-validation-length="10-12"
                                                       value="<?= ($user_profile['mobile_number']) ? $user_profile['mobile_number'] : '' ?>"
                                                       data-validation-error-msg="please enter mobile number with country code">
                                                <em><?php echo form_error('mobile_number'); ?></em>
                                            </div>
                                            <div class="form-group col-xl-6">
                                                <select name="category" class="form-control">
                                                    <?php
                                                    foreach ($catagories as $category) {
                                                        $selected = ($user_profile['category'] == $category->cat_id) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?= $category->cat_id; ?>" <?= $selected; ?>><?= $category->cat_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>    
                                        <div class="row">
                                            <div class="form-group col-xl-6">
                                                <select class="form-control" name="country">
                                                    <option value="">--Select--</option>
                                                    <?php
                                                    foreach ($countries as $country) :
                                                        $selected = ($user_profile['country'] == $country['country_id']) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?= ($country['country_id']) ? $country['country_id'] : ''; ?>" <?= $selected; ?> ><?= ($country['country_name']) ? $country['country_name'] : ''; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-xl-6">
                                                <input type="text"
                                                       name="city"
                                                       class="form-control"
                                                       placeholder="Please enter city name"
                                                       value="<?= ($user_profile['city']) ? $user_profile['city'] : ''; ?>"
                                                       data-validation-error-msg="please enter your city">
                                                <em><?php echo form_error('city'); ?></em>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="form-group col-xl-6">

                                                <input type="text"
                                                       name="state"
                                                       class="form-control"
                                                       placeholder="Please enter state name"
                                                       value="<?= ($user_profile['state']) ? $user_profile['state'] : ''; ?>"
                                                       data-validation-error-msg="please enter your city">
                                                <em><?php echo form_error('state'); ?></em>
                                            </div>
                                            <div class="form-group col-xl-6">
                                                <textarea rows="3" 
                                                          id="ks-maxlength-area" 
                                                          class="form-control" 
                                                          name="address1" 
                                                          data-validation="length" 
                                                          placeholder="Please enter address"
                                                          data-validation-length=""
                                                          data-validation-error-msg=" Address has to be an alphanumeric value (10-500 chars)"
                                                          ><?= ($user_profile['address1']) ? $user_profile['address1'] : '' ?>
                                                </textarea>
                                            </div>
                                        </div> 
                                        <div class="row">

                                            <div class="form-group col-xl-6">
                                                <textarea name="address2" value="" placeholder="Please enter address (optional)" rows="3" placeholder="Please enter permanet address"  id="ks-maxlength-area" class="form-control" ><?= ($user_profile['address2']) ? $user_profile['address2'] : '' ?></textarea>
                                            </div>
                                        </div> 
                                        <?php echo form_close(); ?>
                                        <div class="row">
                                            <div class="form-group col-xl-12">
                                                <button  type="submit" id="profile_next" class="btn btn-color pull-right cursue-point">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--********************* Branding  *************************** -->
                                <div  id="branding" class="col-lg-12  pull-left brand-sec-col">
                                    <div class=" ks-title-body">
                                        <div class="card-header col-lg-12">
                                            <h4 class="">
                                                Branding 
                                            </h4>
                                        </div>
                                    </div>
                                    <div class=" branding-form" >
                                        <div class="col-lg-12">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="form-group col-xl-12">
                                                        <p>
                                                            <?= lang_msg("BRANDING_NOTIFICATION_TEXT"); ?>   
                                                        </p>
                                                    </div>
                                                </div>
                                                <?php echo form_open_multipart('save-brand', array('name' => 'company', 'id' => 'brand-account', 'class' => '', 'method' => 'post')); ?>
                                                <input type="hidden" name="brand_id" value="<?= ($user_profile['brand_id']) ? $user_profile['brand_id'] : '' ?>"/>
                                                <div class="row">
                                                    <div class="form-group col-xl-6" >
                                                        <input type="text"
                                                               name="b_suport_name"
                                                               data-validation="length alphanumeric"
                                                               data-validation-length="3-18"
                                                               class="form-control password"
                                                               placeholder="Please enter company/firm or your name (3-18 alphanumeric)"
                                                               value="<?= ($user_profile['firm_name']) ? $user_profile['firm_name'] : '' ?>">
                                                        <em><?php echo form_error('password'); ?></em>
                                                    </div>
                                                    <div class="form-group col-xl-6">
                                                        <div class="row">
                                                            <div class="form-group col-xl-5 text-center" style="width: auto;">
                                                                <img class="ks-avatar" src="<?= (isset($user_profile['b_thumb_logo']) && !empty($user_profile['b_thumb_logo'])) ? site_url($user_profile['b_thumb_logo']) : 'assets/img/avatars/image_upkpr.png'; ?>" width="75" height="75">
                                                            </div>
                                                            <div class="form-group col-xl-7" style="width: auto;">
                                                                <label for="profile_photo"></label>
                                                                <div class="ks-manage-avatar ks-group">
                                                                    <div class="ks-body">
                                                                        <div class="ks-header"></div>
                                                                        <button class="btn btn-color ks-btn-file">
                                                                            <span class="la la-cloud-upload ks-icon"></span>
                                                                            <span class="ks-text">Choose Brand Logo</span>
                                                                            <input type="file"
                                                                                   name="b_logo"
                                                                                   <?= (isset($user_profile['b_thumb_logo']) && !empty($user_profile['b_thumb_logo'])) ? '' : 'data-validation="mime size required"'; ?>
                                                                                   data-validation-allowing="jpg, png"
                                                                                   data-validation-max-size="1mb"
                                                                                   data-validation-error-msg-required="No image selected">
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-xl-6">
                                                        <input type="text"
                                                               name="b_suport_email"
                                                               class="form-control password"
                                                               data-validation="email"
                                                               placeholder="Please enter support email address"
                                                               value="<?= ($user_profile['support_email']) ? $user_profile['support_email'] : '' ?>">
                                                        <em><?php echo form_error('suport_email'); ?></em>
                                                    </div>
                                                    <div class="form-group col-xl-6">
                                                        <input type="text"
                                                               name="b_phone_no"
                                                               class="form-control password"
                                                               data-validation="number"
                                                               data-validation-ignore="+"
                                                               placeholder="Please enter mobile number"
                                                               value="<?= ($user_profile['phone']) ? $user_profile['phone'] : '' ?>">
                                                        <em><?php echo form_error('password'); ?></em>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-xl-12">
                                                        <textarea rows="5" 
                                                                  id="ks-maxlength-area" 
                                                                  class="form-control" 
                                                                  name="b_office_address" 
                                                                  value=""
                                                                  placeholder="Please enter physical office address"
                                                                  data-validation-error-msg=" Address has to be an alphanumeric value (10-500 chars)"
                                                                  ><?= ($user_profile['office_address']) ? $user_profile['office_address'] : '' ?></textarea>
                                                    </div>
                                                </div> 
                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <div class="ks-items-block pull-right">
                                                            <a class="btn btn-color cursue-point" href='<?= site_url('profile/reset-brand'); ?>'>Reset</a><button  type="submit" id="submit-brand-form" class="btn  btn-color cursue-point"><?= ($user_profile['brand_id']) ? 'Update' : 'Submit' ?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--********************* close my account *************************** -->
                                <div class="col-lg-12 float-left">
                                    <div class="ks-title-body">
                                        <div class="card-header col-lg-12">
                                            <h4 class="">
                                                Close My Account  

                                            </h4>
                                        </div>
                                    </div>
                                    <div class="close-form">
                                        <div class="col-lg-12">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="form-group col-xl-12">
                                                        <p><?= lang_msg("CLOSE_ACCOUNT_TEXT"); ?></p>
                                                    </div>
                                                </div>
                                                <?php echo form_open_multipart('close-account', array('name' => 'company', 'id' => 'close-account', 'class' => '', 'method' => 'post')); ?>
                                                <div class="row">
                                                    <div class="form-group col-xl-12">
                                                        <textarea rows="5" 
                                                                  id="ks-maxlength-area" 
                                                                  class="form-control" 
                                                                  name="reason" 
                                                                  value=""
                                                                  placeholder="We will value your feedback, please let us know why are you closing your account."
                                                                  data-validation="length" 
                                                                  data-validation-length=""
                                                                  data-validation-error-msg=" Address has to be an alphanumeric value (10-500 chars)"
                                                                  ></textarea>
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <div class="form-group col-xl-12">
                                                        <button type="button" id="submit-close-acc-form" class="btn btn-color pull-right cursue-point">Close Account </button>
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
</div>

<script src="<?= site_url('application/modules/profile/js/profile.js') ?>"></script>