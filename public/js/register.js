$(document).ready(function() {
    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            if (regexp.constructor != RegExp)
                regexp = new RegExp(regexp);
            else if (regexp.global)
                regexp.lastIndex = 0;
            return this.optional(element) || regexp.test(value);
        },
    );
    $('form#register_form').validate({
        rules: {
            "name": {
                required: true,
                maxlength: 190
            },
            "email": {
                required: true,
                email: true,
                maxlength: 190
            },
            "username": {
                required: true,
                maxlength: 190,
                minlength: 6,
                regex: /^\S*$/
            },
            "password": {
                required: true,
                maxlength: 190

            },
            "confirm_password": {
                required: true,
                equalTo: "#password",
                maxlength: 190

            }
        },
        messages: {
            "name": {
                required: LANG.required,
                maxlength: LANG.maxlength
            },
            "email": {
                required: LANG.required,
                email: LANG.incorrect_email_format,
                maxlength: LANG.maxlength
            },
            "username": {
                required: LANG.required,
                maxlength: LANG.maxlength,
                minlength: LANG.minimum_6_characters,
                regex: LANG.please_do_not_enter_spaces
            },
            "password": {
                required: LANG.required,
                maxlength: LANG.maxlength
            },
            "confirm_password": {
                required: LANG.required,
                equalTo: LANG.equalpassword,
                maxlength: LANG.maxlength
            }
        }
    });

    $(document).on('change', '#username', function() {
        $('#username-error').html('')
    })

    $(document).on('click', '.register', function() {
        if ($('form#register_form').valid() == true) {
            $('.register').attr('disabled', true)
            var url = $('form#register_form').attr('action');
            var data = $('form#register_form').serialize();
            $.ajax({
                method: 'POST',
                url: url,
                dataType: 'json',
                data: data,
                success: function(result) {
                    toastr.options = {
                        "progressBar": true,
                        "timeOut": "2000",
                    }
                    toastr.success(LANG.register_successfully);
                    if (result.success == true) {
                        if(result.data == 0){
                            setTimeout(window.location = window.location.origin +'/user-dashboard', 2000);
                        }
                    }
                },
                error: function(err) {
                    $('.register').attr('disabled', false)
                    var data = err.responseJSON;
                    if (err.status == 422) {
                        if ($.isEmptyObject(data.errors) == false) {
                            $.each(data.errors, function(key, value) {
                                $('#'+key+'-error').text('');
                                $(document).find('#username').after($('<span id="'+key+'-error" class="error">' + value + '</span>'));
                            });
                        }
                    }
                }
            });
        }
    })
})
