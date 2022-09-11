<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ __('Add user') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" id="user_form">
        @csrf
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-control-label" for="basic-url">{{ __('Full name') }}</label><b class="text-danger">*</b>
                        <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('Full name') }}">
                    </div>
                  </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-control-label" for="basic-url">{{ __('Username') }}</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="{{ __('Username') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-control-label" for="basic-url">{{ __('Email') }} </label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="{{ __('Email') }}">
                    </div>
                  </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-control-label" for="basic-url">{{ __('Phone') }}</label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="{{ __('Phone') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-control-label" for="basic-url">{{ __('Password') }}</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="{{ __('Password') }}">
                    </div>
                  </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-control-label" for="basic-url">{{ __('Confirm password') }}</label>
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="{{ __('Confirm password') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-control-label" for="basic-url">{{ __('Amount') }}</label>
                        <input type="text" class="form-control amount" name="amount" id="amount" value="0">
                    </div>
                  </div>
            </div>
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary submit_add">{{ __('Save') }}</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
      </div>
    </div>
 </div>
<script>
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

    $('form#user_form').validate({
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
            "phone": {
                number: true
            },
            "password": {
                maxlength: 190

            },
            "confirm_password": {
                equalTo: "#password",
                maxlength: 190

            }
        },
        messages: {
            "name": {
                required: "{{ __('This field is required') }}",
                maxlength: "{{ __('190 characters limit') }}"
            },
            "email": {
                required: "{{ __('This field is required') }}",
                email: "{{ __('Incorrect email format') }}",
                maxlength: "{{ __('190 characters limit') }}"
            },
            "username": {
                required: "{{ __('This field is required') }}",
                maxlength: "{{ __('190 characters limit') }}",
                minlength: "{{ __('Minimum 6 characters') }}",
                regex: "{{ __('Please do not enter spaces') }}"
            },
            "phone": {
                number: "{{ __('Only numbers can be entered') }}"
            },
            "password": {
                maxlength: "{{ __('190 characters limit') }}"
            },
            "confirm_password": {
                equalTo: "{{ __('Confirmation password is not correct') }}",
                maxlength: "{{ __('190 characters limit') }}"
            }
        }
    });

    $('.submit_add').on('click', function(e) {
        e.preventDefault();
        if ($('form#user_form').valid() == true) {
            $('.submit_add').attr('disabled', true);
            var data = new FormData($('form#user_form')[0]);
            $.ajax({
                method: 'POST',
                url: $('form#user_form').attr('action'),
                dataType: 'json',
                data: data,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result.success == true) {
                        $('div.user_modal').modal('hide');
                        toastr.success(result.msg);
                        if (typeof($('#user_table').DataTable()) != 'undefined') {
                            $('#user_table').DataTable().ajax.reload();
                            $('.submit_add').attr('disabled', false);
                        }
                    } else {
                        toastr.error(result.msg);
                        $('.submit_add').attr('disabled', false);
                    }
                },
                error: function(err) {
                    if (err.status == 422) {
                        $('#username-error').html('');
                        $.each(err.responseJSON.errors, function(i, error) {
                            $(document).find('[name="' + i + '"]').after($('<span id="username-error" class="error" for="username-error">' + error + '</span>'));
                        });
                    }
                }
            });
        }
    })
</script>
