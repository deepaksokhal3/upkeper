/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function editErrorMessage(e) {
    var valid = e.getAttribute('data-type');
    if (valid) {
        $.ajax({
            type: 'post',
            url: 'edit-message',
            data: {'error_id': e.getAttribute('data-type')},
            dataType: 'json',
            success: function (data) {
                document.getElementById("message").value =data.msg;
                document.getElementsByName("msg_key")[0].value= data.msg_key;
                 document.getElementsByName('msg_key')[0].readOnly = true;
                document.getElementsByName("error_id")[0].value= data.error_id;
                document.getElementsByName("submit")[0].innerHTML = 'Update';
            },
            error: function () {}
        });
    }

}