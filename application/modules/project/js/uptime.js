/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function ($) {
    var x = document.getElementsByClassName("ks-page-container");
// Get down time data from local database
    $('.get-down-time').on('click', function () {
        var card = $(this).closest('.card');
        var down_time_date = $(this).attr('date');
        var type = $(this).attr('date-type');
        $.ajax({
            type: 'get',
            beforeSend: function () {
                card.LoadingOverlay("show", {image: "", custom: $("<div>", {text: 'Loading...'}), color: "rgba(255, 255, 255, 0.6)", zIndex: 2});
            },
            complete: function () {
                card.LoadingOverlay("hide");
            },
            url: '../project/down-time',
            data: {down_time_date: down_time_date, request: $(this).attr('date-type'), project_id: $(this).attr('index')},
            dataType: 'html',
            async: true,
            success: function (data) {
                if (type == 'M') {
                    $('.down-time-m-sec').html(data);
                } else if (type == 'Y') {
                    $('.down-time-y-sec').html('');
                    $('.down-time-y-sec').html(data);
                } else {
                    $('.down-time-sec').html('');
                    $('.down-time-sec').html(data);
                }
            }
        });
    });
    // End Down time section
    $('.refresh-down-time').click(function () {
        var projectId = x[1].getAttribute('pro-index');
        var web_url = x[1].getAttribute('data-url');
        var card = $(this).closest('.card');
        var date = $(this).attr('date');
        $.ajax({
            type: 'get',
            beforeSend: function () {
                card.LoadingOverlay("show", {image: "", custom: $("<div>", {text: 'Loading...'}), color: "rgba(255, 255, 255, 0.6)", zIndex: 2});
            },
            complete: function () {
                card.LoadingOverlay("hide");
            },
            url: '../project/refresh_down_time',
            data: {id: projectId, url: web_url},
            dataType: 'html',
            async: true,
            success: function (data) {
                if (data) {
                    $('.down-time-date').html('<span class="la la-calendar"></span>' + date);
                    $('.down-time-sec').html(data);
                }
            }
        });
    });


})(jQuery);
     