/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$('.open_tab').click(function(){
    var task = $(this).children('span').attr('rel');
    var tab_id = $(this).children('span').attr('data-type');
    if(task){
        $('.tab-comman-cls').each(function(){
            $(this).removeClass('tab-active');
             $(this).addClass('tab-deactivated');
        });
        
        $('.open_tab').each(function(){
            $(this).removeClass('ks-list-group-item-action ks-current');
        });
        $(this).addClass('ks-list-group-item-action ks-current');
        $('#'+tab_id).removeClass('tab-deactivated');
        $('#'+tab_id).addClass('tab-active');
        
    }
});


/*******************************Ebable/desable *********************************/

function change_project_status(e){
    var counter = e.getAttribute('rel');
    
    if(e.getAttribute('data-status') == 1){
        var st = 0;
        var attClass = 'status-block-pink';
        var remove = 'status-block-success';
        var txt = 'Disabled';
    }else{
        var attClass = 'status-block-success';
         var remove = 'status-block-pink';
        var txt = 'Enabled';
        var st = 1;
    }
    $.ajax({
        type:'post',
        url:'project/on-off',
        data:{'status':st,'project_id':e.getAttribute('index')},
        dataType:'json',
        success:function(data){
           $('#status-'+counter).removeClass(remove); 
           $('#status-'+counter).addClass(attClass); 
           $('#status-txt'+counter).text(txt); 
           e.setAttribute('data-status',st);
        },
        error:function(error){
            console.log(error);
            
        }
        
    }); 
}
console.clear();
setInterval(function(){ console.clear();},1000);