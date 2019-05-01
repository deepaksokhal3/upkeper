/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {

    // Renewal alert setting 
    $('.set-alert').on('click', function () {
        thisObj = $(this).parent('td');
        $.ajax({
            type: "POST",
            url: SITE_URL + '21232f297a57a5a743894a0e4a801fc3/update-alert-setting',
            data: $(this).closest('form').serialize(),
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.message) {
                    $(thisObj).parent('td').find('.alert-success').text(obj.message);
                } else {
                    $(thisObj).parent('td').find('.alert-error').text(obj.error);
                }
            }
        });
    });

    // Happens alert
    $('.set-happens-alert').on('click', function () {
        thisObj = $(this).parent('td');
        $.ajax({
            type: "POST",
            url: SITE_URL + '21232f297a57a5a743894a0e4a801fc3/update-alert-setting',
            data: $(this).closest('form').serialize(),
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.message) {
                    $(thisObj).parent('td').find('.alert-success').text(obj.message);
                } else {
                    $(thisObj).parent('td').find('.alert-error').text(obj.error);
                }
            }
        });
    });

});