/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function edit_alert(e) {
    var valid = e.getAttribute('data-type');
    if (valid) {
        $.ajax({
            type: 'post',
            url: 'edit-alert',
            data: {'alert_id': e.getAttribute('data-type')},
            dataType: 'json',
            success: function (data) {
                document.getElementById("aler_type").selectedIndex = data.alert_type;
                document.getElementsByName("alert_name")[0].value = data.alert_name
                document.getElementsByName("alert_id")[0].value = data.alert_id;
                document.getElementsByName("manage_submit")[0].innerHTML = 'Update';
            },
            error: function () {}
        });
    }

}