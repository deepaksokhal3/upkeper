/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var domainLength;
var domaintext;
var companyText;

$(document).on('keyup','.search-user',function () {
    var thisObj = $(this).attr('list');
    $.get(SITE_URL + "21232f297a57a5a743894a0e4a801fc3/search-users", {company: $(this).val()}, function (data, status) {
        var obj = JSON.parse(data);
        if (obj.status == true) {
            $("#" + thisObj).html("");
            for (var i = 0; i < obj.data.length; i++) {
                $("#" + thisObj).append("<option  value='" + obj.data[i].company_name + "' data-customvalue='" + obj.data[i].user_id + "'>" + obj.data[i].company_name + "</option>");
            }
        }
    });
});

$(document).on('click','.move-project',function () {
    var dataObj = {};
    dataObj["project_id"] = $(this).attr('index');
    dataObj["url"]= $(this).attr('data-domain');
    dataObj[$(this).parent('div').children('div').children('input').attr('name')] = $('#' + $(this).parent('div').children('div').children('input').attr('list') + ' [value="' + $(this).parent('div').children('div').children('input').val() + '"]').data('customvalue');
    $.get(SITE_URL + "21232f297a57a5a743894a0e4a801fc3/move-project", dataObj, function (data, status) {
        var obj = JSON.parse(data);
        $('.errer-section').html(obj.message);
        setTimeout(function () {
            if(obj.status =='success')
            window.location.replace(window.location.href);
        }, 1000);
    });
});


$(document).on('click', '.short-proj', function () {
    var orderBy = $(this).attr('rel');
    var removeCls = $(this).hasClass('hasClass');
    var chnageOrderBy = (orderBy == "DESC") ? 'ASC' : 'DESC';
    $.get(SITE_URL + "21232f297a57a5a743894a0e4a801fc3/filter-project", {orderby: chnageOrderBy, project: $('.serach-domain').val().trim(), company: $('.serach-company').val().trim()}, function (data, status) {
        var obj = JSON.parse(data);
        $('.main-section-serch').html("");
        $('.main-section-serch').html(obj.message);
        $('#links').html('');
        $('#links').html(obj.links);
        $('.short-proj').attr('rel', chnageOrderBy);
        if($('.short-proj').hasClass('la-angle-up')){
            $('.short-proj').removeClass('la-angle-up');
            $('.short-proj').addClass('la-angle-down');  
        }else{
             $('.short-proj').removeClass('la-angle-down');
            $('.short-proj').addClass('la-angle-up'); 
        }
        
    });
});


$(document).on('click','.clear',function(){
    $(this).parent('span').parent('div').children('input').val('');
    $(this).css('display','none');
});






$(document).on('keyup', '.serach-domain, .serach-company', function (e) {
    if($(this).val().length > 0){$(this).parent('div').children('span').children('i').css('display','inline-block')}
    
    if (e.keyCode == 32 || e.keyCode === 13 || ($('.serach-domain').val().length == 0 && $('.serach-company').val().length == 0)) {
        $.get(SITE_URL + "21232f297a57a5a743894a0e4a801fc3/filter-project", {project: $('.serach-domain').val().trim(), company: $('.serach-company').val().trim()}, function (data, status) {
            var obj = JSON.parse(data);
            $('.main-section-serch').html("");
            $('.main-section-serch').html(obj.message);
            $('#links').html('');
            $('#links').html(obj.links);
        });
    }
});

$(document).on('click', '.serach-domain, .serach-company, .clear', function () { // this function get domain info on search icon
    $.get(SITE_URL + "21232f297a57a5a743894a0e4a801fc3/filter-project", {project: $('.serach-domain').val().trim(), company: $('.serach-company').val().trim()}, function (data, status) {
        var obj = JSON.parse(data);
        $('.main-section-serch').html("");
        $('.main-section-serch').html(obj.message);
        $('#links').html('');
        $('#links').html(obj.links);

    });
});

$(document).on('blur', '.serach-domain, .serach-company', function () { // this function get domain remove focus from text field
    $.get(SITE_URL + "21232f297a57a5a743894a0e4a801fc3/filter-project", {project: $('.serach-domain').val().trim(), company: $('.serach-company').val().trim()}, function (data, status) {
        var obj = JSON.parse(data);
       
        $('.main-section-serch').html("");
        $('.main-section-serch').html(obj.message);
        $('#links').html('');
        $('#links').html(obj.links);
    });
});


function get_hostname(url) {
    return url.replace('http://', '').replace('https://', '').split(/[/?#]/)[0];
}