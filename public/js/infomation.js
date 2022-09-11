function changeImg(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        }
    }
    $('#img').click(function() {
    $('#fImages').click();
});

$(".form-group a").click(function() {
    let _this = $(this);
    if (_this.hasClass('active')) {
        _this.parents('.form-group').find('input').attr('type', 'password')
        _this.removeClass('active');
        _this.removeClass('fa-eye');
        _this.addClass('fa-eye-slash');
    } else {
        _this.parents('.form-group').find('input').attr('type', 'text')
        _this.addClass('active')
        _this.removeClass('fa-eye-slash');
        _this.addClass('fa-eye');
    }
});

// infomation
$('form#information_form').validate({
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
        "phone": {
            number: true,
            minlength: 10,
            maxlength: 20
        },
    },
    messages: {
        "name": {
            required: required,
            maxlength:  maxlength
        },
        "email": {
            required: required,
            email: email,
            maxlength:  maxlength
        },
        "phone": {
            number: number,
            minlength: minlength,
            maxlength: maxlength20
        },
    }
});
$('form#information_form').submit(function(e) {
    e.preventDefault();
    if ($('form#information_form').valid() == true) {
        $('#information_submit').attr('disabled', true);
        let data = new FormData($('#information_form')[0]);
        $.ajax({
            method: 'POST',
            url: $(this).attr('action'),
            dataType: 'json',
            data: data,
            contentType: false,
            processData: false,
            success: function(result) {
                if (result.success == true) {
                    if (result.data.avatar != null) {
                        $('#avatar_profile').attr('src', window.location.origin + '/' + result.data.avatar);
                        $('.user-photo').attr('src', window.location.origin + '/' + result.data.avatar);
                    }
                    $('#information_submit').removeAttr('disabled');
                    $('.user-name').html(result.data.name)
                    $('.email').html(result.data.email)
                    $('.phone').html(result.data.phone)
                    toastr.success(result.msg);
                } else {
                    toastr.error(result.msg);
                    $('#information_submit').attr('disabled', false);
                }
            },
            error: function(err) {
                if (err.status == 422) {
                    $('#category-error').html('');
                    $.each(err.responseJSON.errors, function(i, error) {
                        $(document).find('[name="' + i + '"]').after($('<span id="category-error" class="error">' + error + '</span>'));
                    });
                }
                $('.submit_edit').attr('disabled', false);
            }
        });
    }
});
// change password
$('form#change_password_form').validate({
    rules: {
        "old_password": {
            required: true,
            maxlength: 190
        },
        "password": {
            required: true,
            maxlength: 190
        },
        "confirm_password": {
            required: false,
            equalTo: "#password",
            maxlength: 190
        }
    },
    messages: {
        "old_password": {
            required: required,
            maxlength:  maxlength
        },
        "password": {
            required: required,
            maxlength:  maxlength
        },
        "confirm_password": {
            required: required,
            equalTo:  equalTo,
            maxlength:  maxlength
        }
    }
});
$('form#change_password_form').submit(function(e) {
    e.preventDefault();
    if ($('form#change_password_form').valid() == true) {
        $('#change_password_submit').attr('disabled', true);
        let data = new FormData($('#change_password_form')[0]);
        $.ajax({
            method: 'POST',
            url: $(this).attr('action'),
            dataType: 'json',
            data: data,
            contentType: false,
            processData: false,
            success: function(result) {
                if (result.success == true) {
                    $('#change_password_submit').removeAttr('disabled');
                    toastr.success(result.msg);
                    $('#change_password_form')[0].reset()
                } else {
                    toastr.error(result.msg);
                    $('#change_password_submit').attr('disabled', false);
                }
            },
        });
    }
});

