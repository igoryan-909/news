$('body').on('click', '.showModalButton', function (e) {
    e.preventDefault();
    $("#modal").modal('show');
    $.ajax({
        'url' : $(this).attr('href'),
        'async' : true,
        'success' : function (data) {
            $("#modal").find("#modalContent").html(data);
        }
    });
});

function submitForm($form) {
    var formData = new FormData($form[0]);
    $.ajax({
        url : $form.attr("action"),
        type : 'POST',
        data : formData,
        success : function (response) {
            console.log(response);
            $('#modal').modal('hide');
            $.pjax.reload('#post-all, #post-view, #p0, #w0');
        },
        error : function () {
            console.log('error');
        },
        cache : false,
        contentType : false,
        processData : false
    });

    return false;
}
