/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('.health-edit').on('click', function () {
    $('#health-report-setting').css('display', 'block');
    $('.health-report').show('slow');

});

//$('.close-acc').on('click', function () {
//    $('#submit-close-acc-form').css('display', 'block');
//    $('.close-form').show('slow');
//
//});

$('.branding-acc').on('click', function () {
    $('#submit-brand-form').css('display', 'block');
    $('.branding-form').show('slow');

});

$('#profile_next').on('click', function () {
    $(this).css('display', 'block');
    $('#profile-info').submit();
});

$('#submit-close-acc-form').on('click', function () {
    var flag = '';
    $('#close-account textarea').each(function () {
        if ($(this).val() == '') {
            flag = 1;
            $(this).css('border', '1px solid #ef5350');
        }
    });
    if (flag) {
        return false;
    }
     $('#close-account').submit();
});

//$('#submit-brand-form').on('click', function () {
//    var flag = '';
//    $('#brand-account input').each(function () {
//        if ($(this).val() == '' && $(this).attr('type') != 'file') {
//            flag = 1;
//            $(this).css('border', '1px solid #ef5350');
//        }
//    });
//    if (flag) {
//        return false;
//    }
//     $('#brand-account').submit();
//});




