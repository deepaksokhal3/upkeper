/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function editHostCompany(e) {
    var valid = e.getAttribute('data-type');
    if (valid) {
        $.ajax({
            type: 'post',
            url: 'edit-host-company',
            data: {'h_manager_id': e.getAttribute('data-type')},
            dataType: 'json',
            success: function (data) {
                document.getElementsByName("host_company")[0].value = data.host_company;
                document.getElementsByName("h_manager_id")[0].value = data.h_manager_id;
                document.getElementsByName("manage_submit")[0].innerHTML = 'Update Host Company';
            },
            error: function () {}
        });
    }

}