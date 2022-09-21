<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('Edit contact') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('contacts.update', $contact->id) }}" method="POST" enctype="multipart/form-data" id="contact_edit_form">
            @csrf
            @method('put')
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Name') }}</label><b class="text-danger">*</b>
                            <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('Name') }}" value="{{ $contact->name }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Link') }}</label><b class="text-danger">*</b><br>
                            <input type="text" class="form-control" name="link" id="link" placeholder="{{ __('Link') }}" value="{{ $contact->link }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Image') }}</label></label> <br>
                            <div class="input-group">
                                <input id="fImages" type="file" name="image" class="form-control" style="display: none" accept="image/gif, image/jpeg, image/png" onchange="changeImg(this)">
                                <img id="img" class="img" style="width: 100px; height: 100px;" src="{{ asset($contact->image ? $contact->image : 'AdminLTE-3.1.0/dist/img/no_img.jpg') }}">
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
    $('form#contact_edit_form').validate({
        rules: {
            "name": {
                required: true,
                maxlength: 190
            },
            "link": {
                required: true,
                maxlength: 190
            },
        },
        messages: {
            "name": {
                required: "{{ __('This field is required') }}",
                maxlength: "{{ __('190 characters limit') }}"
            },
            "link": {
                required: "{{ __('This field is required') }}",
                maxlength: "{{ __('190 characters limit') }}"
            },
        }
    });

    $('form#contact_edit_form').submit(function(e) {
        e.preventDefault();
        if ($('form#contact_edit_form').valid() == true) {
            $('.submit_edit').attr('disabled', true);
            let data = new FormData($('#contact_edit_form')[0]);
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
                        $('div.contact_modal').modal('hide');
                        toastr.success(result.msg);
                        if (typeof($('#contact_table').DataTable()) != 'undefined') {
                            $('#contact_table').DataTable().ajax.reload();
                        }
                    } else {
                        toastr.error(result.msg);
                        $('.submit_edit').attr('disabled', false);
                    }
                },
                error: function(err) {
                    if (err.status == 422) {
                        $('#image-error').remove();
                        $.each(err.responseJSON.errors, function(i, error) {
                            if(i == 'image'){
                                $(document).find('#image-lb').after($('<label id="image-error" class="error"> ' + error + '</label>'));
                            }
                        });
                    }
                    $('.submit_edit').attr('disabled', false);
                }
            });
        }
    });
</script>
