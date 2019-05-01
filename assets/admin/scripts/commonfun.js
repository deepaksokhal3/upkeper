/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var jsonObject = {};
function randomPassword(length) {
    var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
    var pass = "";
    for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    return pass;
}

/******************** Auto genrated password ****************/
function generate() {
    var p = randomPassword(14);
    company.genrated_password.value = p;
    jsonObject.created_password = p;
    if (document.getElementById("password_checked").checked && jsonObject.created_password)
        company.password.value = jsonObject.created_password;
}

/******************** paste genrated password ***************/
function copy(e) {
    if (e.checked && jsonObject.created_password)
        company.password.value = jsonObject.created_password;
}

/****************** Companies table checkbox ****************/
function select_rows(e) {
    var type = e.getAttribute('rel');
    if (type == 'All') {
        var checkboxes = document.getElementsByTagName('input');
        if (e.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = true;
                    checkboxes[i].parentNode.parentNode.parentNode.className = 'row-checked';
                }
            }
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = false;
                  checkboxes[i].parentNode.parentNode.parentNode.className = '';
                }
            }
        }
    } else {
        var attributeId = e.getAttribute('row-data');
        if (e.checked)
            document.getElementById(attributeId).className = 'row-checked';
        else
            document.getElementById(attributeId).className = '';
    }
}
/*******************************Ebable/desable *********************************/

function change_status(e){
    var counter = e.getAttribute('rel');
    
    if(e.getAttribute('data-status') == 1){
        var st = 0;
        var attClass = 'status-block-pink';
        var remove = 'status-block-success';
        var txt = 'Deactivated';
    }else{
        var attClass = 'status-block-success';
         var remove = 'status-block-pink';
        var txt = 'Active';
        var st = 1;
    }
    $.ajax({
        type:'post',
        url:'update_user',
        data:{'status':st,'user_id':e.getAttribute('index')},
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