/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var dataObj = {};
var ids = [];
/****************** table checkbox ****************/
function select_rows(e) {
    var type = e.getAttribute('rel');
    if (type == 'All') {
        var checkboxes = document.getElementsByTagName('input');
        if (e.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = true;
                    ids.push(checkboxes[i].getAttribute('rel'));
                    checkboxes[i].parentNode.parentNode.parentNode.className = 'row-checked';
                }
            }
            dataObj.projects = ids;
           console.log(dataObj);
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

/********************************* Enable/Disable ********************************/

function activiation_on_off(){
    $.ajax({
        type:'post',
        url:'project/status',
        success:function(){},
        error:function(){}
    });
    
    
}