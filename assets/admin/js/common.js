/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    $('.block-action').on('click', function () {
        var obj = $(this);
        var counter = $(this).attr('counter');
        var status = $(this).attr('status');
        var CompanyId = $(this).attr('index');
        if (status != 4) {
            var block = 4;
            var close_status = 1;
        } else {
            var block = 1;
            var close_status = 0;
        }
        $.post(SITE_URL + "admin/dashboard_Controller/block_user", {user_id: CompanyId, status: block, c_acc_status:close_status}, function (data, status) {
            if (data) {
                $(obj).attr('status',block);
                if(block == 4){
                    $('.'+counter+'-status').text('Blocked');
                    $(obj).removeClass('la-unlock-alt');
                    $(obj).addClass('la-lock');
                }else{
                   $('.'+counter+'-status').text('Unblocked');
                    $(obj).addClass('la-unlock-alt');
                    $(obj).removeClass('la-lock'); 
                }
            }
        });
    });
});
