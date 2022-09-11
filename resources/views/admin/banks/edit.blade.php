<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('Edit bank') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('banks.update', $bank->id) }}" method="POST" enctype="multipart/form-data" id="bank_edit_form">
            @method('PUT')
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Full name') }}</label><b class="text-danger">*</b>
                            <input type="text" class="form-control" name="account_name" id="account_name" placeholder="{{ __('Full name') }}" value="{{ $bank->account_name }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Bank number') }}</label><b class="text-danger">*</b>
                            <input type="text" class="form-control" name="account_number" id="account_number" placeholder="{{ __('Bank number') }}" value="{{ $bank->account_number }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Bank name') }}</label><b class="text-danger">*</b>
                            <input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="{{ __('Bank name') }}" value="{{ $bank->bank_name }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Branch') }}</label><b class="text-danger">*</b>
                            <input type="text" class="form-control" name="branch" id="branch" placeholder="{{ __('Branch') }}" value="{{ $bank->branch }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Logo') }}</label> <br>
                            <div class="input-group">
                                <input id="fImages" type="file" name="image" class="form-control" style="display: none" accept="image/gif, image/jpeg, image/png" onchange="changeImg(this)">
                                <img id="img" class="img" style="width: 100px; height: 100px;" src="{{ asset($bank->image ? $bank->image : 'AdminLTE-3.1.0/dist/img/no_img.jpg') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary submit_edit">{{ __('Update') }}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </form>
    </div>
</div>
<script>
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

    $('form#bank_edit_form').validate({
        rules: {
            "account_name": {
                required: true,
                maxlength: 190
            },
            "account_number": {
                required: true,
                number: true,
                maxlength: 20
            },
            "bank_name": {
                required: true,
                maxlength: 190
            },
            "branch": {
                maxlength: 190
            },
        },
        messages: {
            "account_name": {
                required: "{{ __('This field is required') }}",
                maxlength: "{{ __('190 characters limit') }}"
            },
            "account_number": {
                required: "{{ __('This field is required') }}",
                number: "{{ __('Only numbers can be entered') }}",
                maxlength: "{{ __('20 characters limit') }}"
            },
            "bank_name": {
                required: "{{ __('This field is required') }}",
                maxlength: "{{ __('190 characters limit') }}"
            },
            "branch": {
                maxlength: "{{ __('190 characters limit') }}"
            },
        }
    });

    $('form#bank_edit_form').submit(function(e) {
        e.preventDefault();
        if ($('form#bank_edit_form').valid() == true) {
            $('.submit_edit').attr('disabled', true);
            let data = new FormData($('#bank_edit_form')[0]);
            $.ajax({
                method: 'POST',
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result.success == true) {
                        $('.submit_edit').removeAttr('disabled');
                        $('div.bank_modal').modal('hide');
                        toastr.success(result.msg);
                        if (typeof($('#bank_table').DataTable()) != 'undefined') {
                            $('#bank_table').DataTable().ajax.reload(null, false);
                        }
                    } else {
                        toastr.error(result.msg);
                        $('.submit_edit').attr('disabled', false);
                    }
                },
                error: function(err) {
                    $('.submit_edit').attr('disabled', false);
                }
            });
        }
    });
</script>
