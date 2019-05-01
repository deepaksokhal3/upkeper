/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//var page = 1;
//$(window).scroll(function () {
//    if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
//        page++;
//        loadMoreData(page);
//    }
//});
$("button.load-more").on("click", loadMoreData);
$("i.search").click('click', search);

$('.search-text').on('keyup', autocomplete);

function loadMoreData() {
    var page = $(this).attr('page');
    $.ajax({
        url: 'project-list/' + page,
        type: "get",
        async: true,
        beforeSend: function () {
            $('.ajax-load').show();
        }
    }).done(function (data) {
        if (data == '') {
            $("button.load-more").text("No more results");

        }
        $(".project-list-section").append(data);
        page = parseInt(page) + parseInt(1);

        $("button.load-more").attr('page', page);
    }).fail(function (jqXHR, ajaxOptions, thrownError)
    {
        alert('server not responding...');
    });
}
var page = $("button.load-more").attr('page');
$.ajax({
    url: 'project-list/' + $("button.load-more").attr('page'),
    type: "get",
    async: true,
    beforeSend: function ()
    {
        $('.ajax-load').show();
    }
}).done(function (data) {
    if (data == '') {
        $("button.load-more").css('display', 'none');
    }
    $(".project-list-section").append(data);
    page = parseInt(page) + parseInt(1);

    $("button.load-more").attr('page', page);
}).fail(function (jqXHR, ajaxOptions, thrownError) {
    //alert('server not responding...');
});

function search() {
    $.ajax({
        url: 'search/' + $('.search-text').val(),
        type: "get",
        async: true,
        beforeSend: function ()
        {
            $('.ajax-load').show();
        }
    }).done(function (data) {
        if (data == '') {
            $("button.load-more").css('display', 'none');
        }
        $('.action-title').text('Search Result`s');
        $('.load-more-section').hide();
        $(".project-list-section").html('');
        $(".project-list-section").append(data);
        page = parseInt(page) + parseInt(1);

        $("button.load-more").attr('page', page);
    }).fail(function (jqXHR, ajaxOptions, thrownError) {
        //alert('server not responding...');
    });
}


function autocomplete() {
    if ($(this).val().length >= 1) {
        $('.clear-search').css('display', 'block');
    }

    if ($(this).val().length >= 3) {
        $.ajax({
            url: 'autocomplete/' + $(this).val(),
            type: "get",
            async: true,
            beforeSend: function ()
            {
                $('.ajax-load').show();
            }
        }).done(function (data) {
            var dataObj = JSON.parse(data);
            if (dataObj != '') {
                $('.auto-list').html('');
                for (var i = 0; i < dataObj.length; i++) {
                    var url = new URL(dataObj[i].project_url);
                    var action = "location.href ='project/detail/" + dataObj[i].project_id + "'";
                    $('.auto-list').append('<li class="list-group-item cursue-point" onclick="' + action + '">' + url.hostname + '</li>');
                }
            }
        }).fail(function (jqXHR, ajaxOptions, thrownError) {
            // alert('server not responding...');
        });
    } else {
        $('.auto-list').html('');
    }
}

$(document).on('click', '#confirm-delete', function () {
    var WEB_URL = $(this).attr('url');
    var project_id = $(this).attr('index');
//
//    swal({
//        title: 'Delete ' + WEB_URL,
//        text: "Please follow the steps in an email to confirm the deletion.",
//        type: "info",
//        showCancelButton: true,
//        closeOnConfirm: false,
//        showLoaderOnConfirm: true
//    }, function () {
//        setTimeout(function () {
//            swal("Ajax request finished!");
//        }, 2000);
//    });








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
$(document).ready(function () {
    setInterval(function () {
        $('.project-queue-avil').each(function () {
            if ($(this).attr('queue') != 1) {
                var obj = $(this);
                $.get(SITE_URL + "queue-status/" + $(this).attr('index'), function (data, status) {
                    if (data) {
                        $(obj).html(data);
                        console.clear();
                    }
                });
            }
        });
    }, 5000);
});

/***********************************************************************************************************************************************************/
