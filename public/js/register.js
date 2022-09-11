$(document).ready(function() {
    $(document).on('click', '#register', function(e) {
        e.preventDefault();
        $('div#register_modal').load($(this).attr('href'), function() {
            $(this).modal('show');
        });
    });

    $('#register_modal').on('shown.bs.modal', function (e) {
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

        $(document).on('click', '#register_submit', function() {
            if ($('form#register_form').valid() == true) {
                $('#register_submit').attr('disabled', true)
                var url = $('form#register_form').attr('action');
                var data = $('form#register_form').serialize();
                $.ajax({
                    method: 'POST',
                    url: url,
                    dataType: 'json',
                    data: data,
                    success: function(result) {
                        $('#user-panel').html(`<a href=""><i class="fa fa-user-o" aria-hidden="true"></i> ${result.data.name}</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="/logout"><i class="fa fa-power-off"></i> ${LANG.logout}</a>`)
                        $('div#register_modal').modal('hide');
                        toastr.success(LANG.register_successfully);
                    },
                    error: function(err) {
                        $('#register_submit').attr('disabled', false)
                        var data = err.responseJSON;
                        if (err.status == 422) {
                            if ($.isEmptyObject(data.errors) == false) {
                                console.log(data.errors);
                                $.each(data.errors, function(key, value) {
                                    $('#'+key+'-error').text('');
                                    $(document).find('#'+key).after($('<span id="'+key+'-error" class="error">' + value + '</span>'));
                                });
                            }
                        }
                    }
                });
            }
        })
    });
})
