$(document).on('click', '#password_new_submit', function() {
    $('#password_new_submit').attr('disabled', true)
    var url = $('form#password_new_form').attr('action');
    var data = $('form#password_new_form').serialize();
    $.ajax({
        method: 'POST',
        url: url,
        dataType: 'json',
        data: data,
        success: function(result) {
            $('#password_new_submit').attr('disabled', false)
            if(result.success == true){
                toastr.success(result.msg);
                setTimeout(window.location = window.location.origin +'/dashboard', 2000);
            }else{
                toastr.error(result.msg);
            }
        },
        error: function(err) {
            $('#password_new_submit').attr('disabled', false)
            var data = err.responseJSON;
            if (err.status == 422) {
                if ($.isEmptyObject(data.errors) == false) {
                    $.each(data.errors, function(key, value) {
                        $('#'+key+'-error').text('');
                        $(document).find('#'+key).after($('<span id="'+key+'-error" class="error">' + value + '</span>'));
                    });
                }
            }
        }
    });
})
