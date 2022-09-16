$(document).on('click', '#login', function(e) {
    e.preventDefault();
    $('div#login_modal').load($(this).attr('href'), function() {
        $(this).modal('show');
    });

    $(document).on('click', '#forgot_password', function(e){
        e.preventDefault();
        $('#login_content').hide(0, function(){
            $('#login_title').text('Recover password')
            $('#reset_password_content').show(0)
        })
    })
    $('#login_modal').on('shown.bs.modal', function (e) {
        $(document).on('click', '#login_submit', function(e) {
            $('#login_submit').attr('disabled', true)
            var url = $('form#login_form').attr('action');
            var data = $('form#login_form').serialize();
            $.ajax({
                method: 'POST',
                url: url,
                dataType: 'json',
                data: data,
                success: function(result) {
                    $('#login_submit').attr('disabled', false)
                    if(result.success == true){
                        // $('#user-panel').html(`<a href=""><i class="fa fa-user-o" aria-hidden="true"></i> ${result.data.name}</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/logout"><i class="fa fa-power-off"></i> ${logout}</a>`)
                        $('div#login_modal').modal('hide');
                        toastr.success(login_successfully);
                        if (result.data.role == 1) {
                            setTimeout(window.location = window.location.origin +'/dashboard', 2000);
                        }
                        setTimeout(window.location = window.location.origin +'/', 2000);
                    }else{
                        toastr.error(result.msg)
                    }
                }
            });
        })
        $(document).on('click', '#reset_password_submit', function(e) {
            $('form#reset_password_form').validate({
                rules: {
                    "email": {
                        required: true,
                        email: true,
                    },
                },
                messages: {
                    "email": {
                        required: required,
                        email: email,
                    },
                }
            });
            if ($('form#reset_password_form').valid() == true) {
                $('#recover_password_loadding').html('<span class="spinner-border text-light" style="width: 1rem; height: 1rem;"></span>')
                $('#reset_password_submit').attr('disabled', true)
                var url = $('form#reset_password_form').attr('action');
                var data = $('form#reset_password_form').serialize();
                $.ajax({
                    method: 'POST',
                    url: url,
                    dataType: 'json',
                    data: data,
                    success: function(result) {
                        $('#reset_password_submit').attr('disabled', false)
                        if(result.success == true){
                            $('div#login_modal').modal('hide');
                            toastr.success(result.msg);
                        }else{
                            $('#email-error').remove();
                            $(document).find('#email').after($('<span id="email-error" class="error">' + result.msg + '</span>'));
                        }
                    }
                })
            }
        })
    })
})

