<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('Add package') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('packages.store') }}" method="POST" enctype="multipart/form-data" id="package_add_form">
            @csrf
            <input type="hidden" name="id" id="id_product">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Package name') }}</label><b class="text-danger">*</b>
                            <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('Package name') }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Value') }}</label><b class="text-danger">*</b>
                            <input type="text" class="form-control" name="value" id="value" placeholder="{{ __('Value') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Point') }}</label><b class="text-danger">*</b>
                            <input type="text" class="form-control price" name="point" id="point" placeholder="{{ __('Point') }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Avatar') }}</label> <br>
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

    $('form#package_add_form').validate({
        rules: {
            "name": {
                required: true,
                maxlength: 190
            },
            "value": {
                required: true,
                maxlength: 190
            }
        },
        messages: {
            "name": {
                required: "{{ __('This field is required') }}",
                maxlength: "{{ __('190 characters limit') }}"
            },
            "value": {
                maxlength: "{{ __('190 characters limit') }}"
            }
        }
    });

    $('form#package_add_form').submit(function(e) {
        e.preventDefault();
        if ($('form#package_add_form').valid() == true) {
            $('.submit_add').attr('disabled', true);
            let data = new FormData($('#package_add_form')[0]);
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
                        $('div.package_modal').modal('hide');
                        toastr.success(result.msg);
                        if (typeof($('#package_table').DataTable()) != 'undefined') {
                            $('#package_table').DataTable().ajax.reload();
                        }
                    } else {
                        toastr.error(result.msg);
                        $('.submit_add').attr('disabled', false);
                    }
                }
            });
        }
    });
</script>
