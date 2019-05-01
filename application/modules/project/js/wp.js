/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function ($) {
    var x = document.getElementsByClassName("ks-page-container");
    var projectId = x[1].getAttribute('pro-index');
    var web_url = x[1].getAttribute('data-url'); 
// $.ajax({
//        type: 'get',
//        url: '../wp-update-info/?url='+web_url+'&type=theme',
//        dataType: 'html',
//        contentType: 'html',
//        async: true,
//        success: function (data) {
//            $('.wp-theme-results').html(data);
//        },
//        error: function (error) {
//            //  console.log(error);
//        }
//    });
//    $.ajax({
//        type: 'get',
//        url: '../wp-update-info/?url='+web_url+'&type=plugin',
//        dataType: 'html',
//        contentType: 'html',
//        async: true,
//        success: function (data) {
//            $('.wp-plugins').html(data);
//        }
//    });
//    $.ajax({
//        type: 'get',
//        url: '../wp-update-info/?url='+web_url+'&type=info',
//        dataType: 'html',
//        contentType: 'html',
//        async: true,
//        success: function (data) {
//            $('.wp-general-info').html(data);
//        }
//    });
    // check website hosting 
    $('.get_domain_info').on('click', function () {
        $.ajax({
            type: 'post',
            url: '../host_domain_ssl',
            data: {"web_url": web_url},
            dataType: 'html',
            async: true,
            success: function (data) {
                $('.domain-hostoss-sec').html(data);
            },
            error: function (error) {
                console.log(error);
            }
        });

    });
})(jQuery);