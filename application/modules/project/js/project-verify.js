/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('.check-cms').on('click', function () {
    $(this).parent('.form-group').removeClass('has-danger');
    $(this).parent('.form-group').addClass('has-success');
});
/**************************************************************** STEP-1 ********************************************************/
$("#step-0").on('click', function () {
    if ($('.check-cms').val() != '') {
        $('.btn-color').prop("disabled", true);
        var card = $(this).closest('.loading');
        card.LoadingOverlay("show", {image: "", custom: $("<img >", {src: SITE_URL + 'assets/img/loaders/svg-loaders/three-dots.svg'}), color: "rgba(255, 255, 255, 0.6)", zIndex: 2});
        checkCms(function (data, status) {
            var data = JSON.parse(data);
            if (data.url == 'error') {
                $('.error-section').html('');
                $('.error-section').html('<div class="alert alert-warning ks-solid-light ks-active-border" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" class="la la-close"></span></button><strong> Warning </strong>' + data.error + '.</div>');
                $('.check-cms').removeClass('form-control-success');
                $('.check-cms').parent('.form-group').removeClass('has-success');
                $('.check-cms').parent('.form-group').addClass('has-danger');
                $('.check-cms').addClass('form-control-danger');
                $('.btn-color').prop("disabled", false);
                card.LoadingOverlay("hide");
            } else if (data.url == 'exist') {
                $('.error-section').html('');
                $('.error-section').html('<div class="alert alert-warning ks-solid-light ks-active-border" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" class="la la-close"></span></button><strong> Sorry ! </strong> Your website is already register.</div>');
                $('.check-cms').removeClass('form-control-success');
                $('.check-cms').parent('.form-group').removeClass('has-success');
                $('.check-cms').parent('.form-group').addClass('has-danger');
                $('.check-cms').addClass('form-control-danger');
                card.LoadingOverlay("hide");
                $('.btn-color').prop("disabled", false);
            } else {
                $('.check-cms').addClass('form-control-success');
                $('.check-cms').parent('.form-group').addClass('has-success');
                $('.check-cms').parent('.form-group').removeClass('has-danger');
                $('.error-displayer').text('');
                $('.addurl').val(data.url);
                card.LoadingOverlay("hide");
                $('.add-url').submit();
            }
        });
    } else {
        $('.check-cms').parent('.form-group').removeClass('has-success');
        $('.check-cms').parent('.form-group').addClass('has-danger');
    }
});

function checkCms(fn) {
    var web_url = $('.check-cms').val();
    if (web_url.length > 3) {
        var obj = $('.check-cms');
        $.post("check-cms", {url: web_url}, function (data, status) {
            fn(data, status);
        });
    }
}
$(document).on('click', '#plugin,edit-1', function () {
    move_next();
});
/************************************************************ END STEP-1 *********************************************************/

/****************************************************************  STEP-2 ********************************************************/
$(document).on('click', '.download-plugin', function () {
    $('.plugin-section').css('display', 'block');
});
$('.verify-plugin').on('click', function () {
    var card = $(this).closest('.section-step-1');
    card.LoadingOverlay("show", {image: "", custom: $("<img >", {src: SITE_URL + 'assets/img/loaders/svg-loaders/three-dots.svg'}), color: "rgba(255, 255, 255, 0.6)", zIndex: 2});
    var WEB_URL = $('.Inner-container').attr('url');
    VerifyPlugin(function (data, status) {
        if (data == 'verified') {
            $('.successfully-pligin').css('display', 'block');
            $('.error-pligin').css('display', 'none');
            card.LoadingOverlay("hide");
        } else {
            $('.error-pligin').css('display', 'block');
            $('.successfully-pligin').css('display', 'none');
            card.LoadingOverlay("hide");
        }
    });
});

$('#next-step-2').on('click', function () {
    //var current_url = window.location.href;
    $.post(SITE_URL + "public/local_Controller/step_second", function (data, status) {
        if (data == 1) {
            $('.section-step-2').show();
            $('.Inner-container .section-step-1').hide();

            // window.location.href = current_url;
        }
    });
});

function VerifyPlugin(fn) {
    var WEB_URL = $('.Inner-container').attr('url');
    var project_id = $('.Inner-container').attr('index');
    if (WEB_URL) {
        $.post(SITE_URL + "project/verify_plugin", {url: WEB_URL, project_id: project_id}, function (data, status) {
            //debugger;
            fn(data, status);
        });
    }
}


/************************************************************ END STEP-2 *********************************************************/

$(document).on('click', '.wp-verify', function () {
    $('.login_url').val();
    $.post("wp-auth-verify", {wpp: $('.password').val(), wpu: $('.username').val(), wpurl: $('.login_url').val()},
            function (data, status) {

            });
});

/********************************************************** STEP -3 **************************************************/

$(document).on('click', '.snmt-admin-credentials, #snmt-admin-credentials', function () {
    var obj = {};
    var flag = '';
    $('.admin-credentials input').each(function (index, val) {
        if ($(this).val()) {
            obj[this.name] = $(this).val();
        } else {
            if (index != 0) {
                flag = 1;
                $(this).css('border', '1px solid #ef5350');
            }
        }
    });
    if (flag) {
        return false;
    }
    var dataObj = $('.admin-credentials input').serializeArray();
    if (dataObj) {
        var card = $(this).closest('.Inner-container');
        card.LoadingOverlay("show", {image: "", custom: $("<img >", {src: SITE_URL + 'assets/img/loaders/svg-loaders/three-dots.svg'}), color: "rgba(255, 255, 255, 0.6)", zIndex: 2});
        $.ajax({
            type: 'post',
            url: SITE_URL + 'project/verifyWpAdmin',
            data: {user_login: obj.username, user_password: obj.password, url: obj.login_url},
            dataType: 'json',
            success: function (data) {
                var jsonObj = data;
                if (jsonObj.success) {
                    $.post(SITE_URL + "project/save-admin-credential", dataObj, function (data, status) {
                        if (status == 'success') {
                            if (!obj.credential_id && !$('#adminupdate')) {
                                window.location.href = 'project/thanku';
                            } else {
                                card.LoadingOverlay("hide");
                            }
                        }
                    });
                    move_next();
                } else {
                    card.LoadingOverlay("hide");
                    $('.error-section').html('');
                    $('.error-section').html('<div class="alert alert-danger ks-solid-light ks-active-border" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" class="la la-close"></span></button><strong>Sorry !</strong> Your entireed username and password is wrong.Please enter valid detail.</div>');
                }

            }
        });

    } else {
        return false;
    }
});

/***************************************************** proceed *****************************************************/

$('.proceed').on('click', function () {
    window.location.href = 'project/thanku';
});


/************************************************************ PROJECT EDIT SECTION ***************************************************/
//$('#edit-1').on('click', function () {
//    move_next();
//});

$(document).ready(function () {
    $('.ks-step-tab').each(function (index, val) {
        step_counter = parseInt(index) + parseInt(1);
        $(this).children('span').children('span').text(step_counter);
    });
});
$('.ks-step-tab').on('click', function () {
   if($('.ks-steps').hasClass('ks-open')){
       $('.ks-steps').removeClass('ks-open');
   }
 
    
    var target_tab = $(this).attr('focus');
    if (target_tab == 'delete-form') {
        $('.ks-next').hide();
    } else {
        $('.ks-next').show();
    }
    var action = $(this).attr('action');
    $('.tab-forms-section .ks-step').each(function () {
        $(this).css('display', 'none');
    });
    $('.ks-step-tab').each(function () {
        $(this).removeClass('ks-current');
    });
    $(this).addClass('ks-current');
    $('.' + target_tab).css('display', 'block');
    $('.ks-next').attr('id', action);
    if ($('.' + target_tab).height() < 650) {
        $('.ks-page-container').css('min-height', '900px');
    } else {
        $('.ks-page-container').css('min-height', '');
    }

});

/********************************************************* MOVE NEXT STEP TAB ********************************************************/

function move_next() {
    var level_counter;
    var target_tab;
    var action;
    $('.ks-step-tab').each(function () {
        if ($(this).hasClass('ks-current')) {
            level_counter = $(this).children('span').children('span').text();
        }
    });
    $('.ks-step-tab').each(function () {
        $(this).removeClass('ks-current');
    });
    $('.tab-forms-section .ks-step').each(function () {
        $(this).css('display', 'none');
    });
    level_counter = parseInt(level_counter) + parseInt(1);
    $('.ks-step-tab').each(function () {
        var level_next = $(this).children('span').children('span').text();
        if (level_next == level_counter) {
            target_tab = $(this).attr('focus');
            action = $(this).attr('action');
            $(this).addClass('ks-current');
        }
    });
    $('.' + target_tab).css('display', 'block');
    if (action == 'confirm-delete') {
        $('.ks-next').hide();
    } else {
        $('.ks-next').show();
    }
    $('.ks-next').attr('id', action);
    if ($('.' + target_tab).height() < 650) {
        $('.ks-page-container').css('min-height', '900px');
    } else {
        $('.ks-page-container').css('min-height', '');
    }

}

/******************************************************* Chnage notification and reoprt setting *****************************************************/

$(document).on('click', '#reporting', function () {
    var obj = {};
    var flag = '';
    var card = $(this).closest('.ks-wrapper');
    card.LoadingOverlay("show", {image: "", custom: $("<img >", {src: SITE_URL + 'assets/img/loaders/svg-loaders/three-dots.svg'}), color: "rgba(255, 255, 255, 0.6)", zIndex: 2});
    $.post(SITE_URL + 'report-setting', $('#reporting-form').serialize(), function (data, status) {
        var data = JSON.parse(data);
        if (data) {
            $('#reportId').val(data.report_id);
            $('.ks-current').addClass('ks-completed');
            $('#notifiationId').val(data.notificationId);
            card.LoadingOverlay("hide");
            move_next();
        }
    });
});

$(document).on('click', '#google-analytics', function () {
    move_next();
});

///***************************************************************** DELETE PROJECT ************************************************************/
////showLoaderOnConfirm: true,
$('#confirm-delete').on('click', function () {
    var WEB_URL = $('.Inner-container').attr('url');
    var project_id = $('.Inner-container').attr('index');
    swal.queue([{
            title: 'Delete ' + WEB_URL,
            confirmButtonText: 'Delete Project',
            text:
                    'Please follow the steps in an email to confirm the deletion.',
            showCancelButton: true,
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.post(SITE_URL + "project/confirm_delete_project", {project_id: project_id, web_url: WEB_URL}, function (data, status) {
                        if (status == 'success') {
                            swal(
                                    'Email Sent!',
                                    'Thank you, we have sent you email. Please check your email box.',
                                    'success'
                                    )
                        }
                    });
                })
            }
        }]);
});



/************************************************************ CHECK GOOGLE ANALYTICS ACCESS CODE *********************************************************/
jQuery(document).ready(function () {
    $.get(SITE_URL + "login-google", function (data, status) {
        var obj = JSON.parse(data);
        if (obj) {
            $('.login-btn').attr('href', obj.link);
        }
    });
});
