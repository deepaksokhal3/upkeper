/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function ($) {
    var x = document.getElementsByClassName("ks-page-container");
    $('.refresh-speed-info').click(function () {
        var card = $(this).closest('.card');
        $.ajax({
            type: 'post',
            beforeSend: function () {
                card.LoadingOverlay("show", {image: "", custom: $("<div>", {text: 'Updating site speed status. Please wait...'}), color: "rgba(255, 255, 255, 0.6)", zIndex: 2});
            },
            complete: function () {
                card.LoadingOverlay("hide");
            },
            data: {"url": x[1].getAttribute('data-url'), "project_id": x[1].getAttribute('pro-index'), "type": "speedinfo"},
            url: '../project/update_project_speed',
            async: true,
            success: function (data) {
                debugger;
                if (data) {
                    $('.speed-info-section').html('');
                    $('.speed-info-section').html(data);
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

})(jQuery);