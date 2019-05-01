/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function ($) {
    $('.check-responsibilty').click(function () {
        var web_url = $(this).attr('url');
        var page_id = $(this).attr('index');
        var project_id = $(this).attr('index-id');
        var row = $(this).attr('row-data');
        
        
        var card = $(this).closest('.card');
        $.ajax({
            type: 'post',
            beforeSend: function () {
                card.LoadingOverlay("show", {image: "", custom: $("<div>", {text: 'Updating project mobile friendly information. Please wait...'}), color: "rgba(255, 255, 255, 0.6)", zIndex: 2});
            },
            complete: function () {
                card.LoadingOverlay("hide");
            },
            url: '../project/update_mobile_friendly_data',
            data: {'project_id': project_id,'image_id': page_id, 'page_url': web_url, 'type': 'mfinfo'},
            async: true,
            success: function (data) {
                $('#'+row).html('');
                $('#'+row).html(data);
            }
        });
    });

})(jQuery);