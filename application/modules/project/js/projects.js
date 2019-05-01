/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('click','.expend',function(){
   if($($(this).attr('data-target')).hasClass('show')){
       $(this).addClass('la-plus');
      $(this).removeClass('la-minus'); 
      
   }else{
      $(this).removeClass('la-plus');
       $(this).addClass('la-minus'); 
   }
   
});
function wp_login(e) {
    $.post(SITE_URL + 'project/admin_login_details', {project_id: $('.Inner-container').attr('index')}, function (data, status) {
        var detailObj = JSON.parse(data);
        $.post($('.Inner-container').attr('url') + '/wp-admin-login.php', {user_login: detailObj.user_name, user_password: detailObj.password}, function (data, status) {
            var dataObj = JSON.parse(data);
            if (dataObj.success == true) {
                window.open(dataObj.redirect_to);
            }
        });
    });
}

function enable_disable(e) {
    var status_val = e.getAttribute('active-status');
    if (status_val == 1) {
        status_val = 0;
        var text = 'Disabled';
        var addclass = 'badge-danger';
        var rm_class = 'badge-success';
        var rm_id = e.getAttribute('alert-id');
    } else {
        status_val = 1;
        var text = 'Enabled';
        var addclass = 'badge-success';
        var rm_class = 'badge-danger';
    }
    var project_id = e.getAttribute('index');
    var row = e.getAttribute('rel');
    var alert_id = e.getAttribute('alert-id');
    var alert_type = e.getAttribute('active-alert-type').split(",");
    alert_type = jQuery.grep(alert_type, function (value) {
        return value != alert_id;
    });
    $.ajax({
        type: 'post',
        url: '../update_alerts',
        data: {"project_id": project_id, "alert_id": alert_id, "rm_id": rm_id, "exist_alert_status": alert_type},
        dataType: 'json',
        async: true,
        success: function (data) {
            if (data.status == true) {
                $('#row-' + row).children('span').attr('active-alert-type', data.exsit_status);
                $('#row-' + row).children('span').removeClass(rm_class);
                $('#row-' + row).children('span').addClass(addclass);
                $("#row-" + row).children('span').text(text);
                $("#row-" + row).children('span').attr("active-status", status_val);
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}
/*********************************** configure hosting *********************************/

$('.configure-host').on('click', host_configure);
function host_configure() {
    var formData = {expire_hosting:$('#datepic').val(), project_id: $('#main-con').attr('pro-index')};
    $.ajax({
        type: 'post',
        url: '../configure_host_expire',
        data: formData,
        async: true,
        success: function (data) {
            if (data == 'success') {
              $('.host-config-sec').css('display','none');
            }
        },
        error: function (error) {
            console.log();
        }
    });
}
/*********************************** Enf configure hosting *********************************/

(function ($) {
    var monthNames = ["Jan", "Feb", "March", "April", "May", "June",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];
    var currentDate = new Date();
    var x = document.getElementsByClassName("ks-page-container");
    var projectId = x[0].getAttribute('pro-index');
    var web_url = x[0].getAttribute('data-url'); // scope with in web url

    $('.common-tab').on('click', function () {
        var target = '#' + $(this).attr('target-data');
        $('.ks-nav-tabs a').each(function () {
            $(this).removeClass('active');
            $(this).attr('aria-expanded', false);
            if ($(this).attr('data-target'))
                if (target == $(this).attr('data-target')) {
                    $(this).addClass('active');
                    $(this).attr('aria-expanded', true);
                }
        });
        $('.tab-content div').each(function () {
            $(this).removeClass('active');
            $(this).attr('aria-expanded', false);
        });
        $(target).addClass('active');
        $(target).attr('aria-expanded', true);
    });

    // check website Responsive 
    $('.check-responsibilty').click(function () {
        var web_url = x[0].getAttribute('data-url');
        var card = $(this).closest('.card');
        $.ajax({
            type: 'get',
            beforeSend: function () {
                card.LoadingOverlay("show", {image: "", custom: $("<div>", {text: 'Loading...'}), color: "rgba(255, 255, 255, 0.6)", zIndex: 2});
            },
            complete: function () {
                card.LoadingOverlay("hide");
            },
            url: 'https://www.googleapis.com/pagespeedonline/v3beta1/mobileReady?url=' + web_url,
            dataType: 'json',
            async: true,
            success: function (data) {
                if (data.screenshot.data) {
                    //var base = data.screenshot.data.replace(/_/g, "/").replace(/-/g, "+");
                    //document.getElementById('responsive_image').src = "data:" + data.screenshot.mimeType + ';base64,' + base;
                    $.ajax({
                        type: 'post',
                        url: '../update_mobile_friendly_data',
                        data: {'project_id': projectId, 'mobile_data': data, 'type': 'dashboard'},
                        async: true,
                        success: function (data) {
                        }
                    });
                }
            }
        });
    });

    $('.speed_checker').click(function () {
        var card = $(this).closest('.card');
        $.ajax({
            beforeSend: function () {
                card.LoadingOverlay("show", {image: "", custom: $("<div>", {text: 'Loading...'}), color: "rgba(255, 255, 255, 0.6)", zIndex: 2});
            },
            complete: function () {
                card.LoadingOverlay("hide");
            },
            type: 'get',
            url: 'https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=' + web_url + '&key=AIzaSyDMYlOv5CUPrT4gSHLx5TJ0ZmtMB4w4Zxs',
            dataType: 'json',
            async: true,
            success: function (data) {
                if (data.ruleGroups.SPEED.score) {
                    $('.speed-check-date').text(data.ruleGroups.SPEED.score + '/100');
                    //$('.speed-check-date').html(currentDate.getDate() + ' ' + monthNames[currentDate.getMonth()] + ' ' + currentDate.getFullYear());

                }
                $.ajax({
                    type: 'post',
                    data: {'post_data': data, 'project_id': projectId, 'type': 'dashbord'},
                    url: '../update_project_speed',
                    async: true,
                    success: function (data) {
                        console.log(data);
                    }
                });
            }
        });
    });

})(jQuery);