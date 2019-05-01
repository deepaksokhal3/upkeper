
$('.profile-tab').click(function(){
    var task = $(this).children('span').attr('rel');
    var tab_id = $(this).children('span').attr('data-type');
    if(task){
        $('.tab-comman-prof').each(function(){
            $(this).removeClass('tab-active');
             $(this).addClass('tab-deactivated');
        });
        
        $('.profile-tab').each(function(){
            $(this).removeClass('ks-list-group-item-action ks-current');
        });
        $(this).addClass('ks-list-group-item-action ks-current');
        $('#'+tab_id).removeClass('tab-deactivated');
        $('#'+tab_id).addClass('tab-active');
        
    }
});