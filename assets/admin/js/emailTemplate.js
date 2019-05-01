/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function editTemplate(e) {
    var valid = e.getAttribute('data-type');
    if (valid) {
        $.ajax({
            type: 'post',
            url: 'edit-email-template',
            data: {'temp_id': e.getAttribute('data-type')},
            dataType: 'json',
            success: function (data) {
                $('#ks-summernote-editor-default').summernote('code', data.template_text);
                document.getElementById("temp_type").value = data.temp_type;
                document.getElementsByName("subject")[0].value = data.subject;
                document.getElementsByName("temp_title")[0].value = data.temp_title;
                document.getElementsByName("temp_id")[0].value = data.template_id;
                document.getElementsByName("manage_submit")[0].innerHTML = 'Update';
            },
            error: function () {}
        });
    }

}