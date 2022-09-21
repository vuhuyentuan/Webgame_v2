<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('Add slide') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('slides.store') }}" method="POST" enctype="multipart/form-data" id="slide_add_form">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Title') }}</label><b class="text-danger">*</b>
                            <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('Title') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Description') }}</label><b class="text-danger">*</b><br>
                            <textarea name="description" id="description" cols="60" rows="5" style="width: 100%" placeholder="{{ __('Description') }}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Logo') }}</label></label><b class="text-danger" id="image-lb">*</b> <br>
                            <div class="input-group">
                                <input id="fImages" type="file" name="image" class="form-control" style="display: none" accept="image/gif, image/jpeg, image/png" onchange="changeImg(this)">
                                <img id="img" class="img" style="width: 100px; height: 100px;" src="{{ asset('AdminLTE-3.1.0/dist/img/no_img.jpg') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary submit_add">{{ __('Save') }}</button>
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
    $('form#slide_add_form').validate({
        rules: {
            "name": {
                required: true,
                maxlength: 190
            },
            "description": {
                maxlength: 190
            },
        },
        messages: {
            "name": {
                required: "{{ __('This field is required') }}",
                maxlength: "{{ __('190 characters limit') }}"
            },
            "description": {
                maxlength: "{{ __('190 characters limit') }}"
            },
        }
    });

    $('form#slide_add_form').submit(function(e) {
        e.preventDefault();
        if ($('form#slide_add_form').valid() == true) {
            $('.submit_add').attr('disabled', true);
            let data = new FormData($('#slide_add_form')[0]);
            $.ajax({
                method: 'POST',
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result.success == true) {
                        $('.submit_add').removeAttr('disabled');
                        $('div.slide_modal').modal('hide');
                        toastr.success(result.msg);
                        if (typeof($('#slide_table').DataTable()) != 'undefined') {
                            $('#slide_table').DataTable().ajax.reload();
                        }
                    } else {
                        toastr.error(result.msg);
                        $('.submit_add').attr('disabled', false);
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
                    $('.submit_add').attr('disabled', false);
                }
            });
        }
    });
</script>
