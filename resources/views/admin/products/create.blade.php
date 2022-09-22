<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('Add game') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="product_add_form">
            @csrf
            <div class="modal-body modal-overflow">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Name game') }}</label><b class="text-danger">*</b>
                            <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('Name game') }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Short description') }}</label><b class="text-danger">*</b>
                            <input type="text" class="form-control" name="short_des" id="short_des" placeholder="{{ __('Short description') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleSelectRounded0">{{ __('Type game') }}</label>
                            <select class="custom-select rounded-0" name="type" id="exampleSelectRounded0">
                              <option value="Game">{{ __('Game') }}</option>
                              <option value="Card">{{ __('Card') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleSelectRounded1">{{ __('Support system') }}</label>
                            <select class="custom-select rounded-1" name="os_supported" id="exampleSelectRounded1">
                              <option value="Android">{{ __('Android') }}</option>
                              <option value="IOS">{{ __('IOS') }}</option>
                              <option value="Wallet">{{ __('Wallet') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Description') }}</label> <br>
                            <textarea class="description" name="description" id="description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Avatar') }}</label> <br>
                            <div class="input-group">
                                <input id="fImages" type="file" name="image" class="form-control" style="display: none" accept="image/gif, image/jpeg, image/png" onchange="changeImg(this)">
                                <img id="img" class="img" style="width: 100px; height: 100px;" src="{{ asset('AdminLTE-3.1.0/dist/img/no_img.jpg') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Image detail') }}</label> <br>
                            <div class="input-group">
                                <input id="fImages_detail" type="file" name="image_detail" class="form-control" style="display: none" accept="image/gif, image/jpeg, image/png" onchange="changeImgDetail(this)">
                                <img id="img_detail" class="img_detail" style="width: 250px; height: 100px;" src="{{ asset('AdminLTE-3.1.0/dist/img/no_img.jpg') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary submit_add" data-submit="false">{{ __('Save') }}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(function () {
        $('#description').summernote({
            height: 200,
            callbacks: {
                onImageUpload: function(files) {
                    _this = $(this);
                    sendFile(files[0], _this);
                },
                onMediaDelete : function(target) {
                    _this = $(this);
                    deleteFile(target[0].src);
                }
            }
        });
        function sendFile(file, _this) {
            data = new FormData();
            data.append("file", file);
            $.ajax({
                data: data,
                type: "POST",
                url: "{{route('upload_image')}}",
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {
                    $(_this).summernote('insertImage', url)
                }
            });
        }
        function deleteFile(url) {
            $.ajax({
                data: {url : url},
                type: "POST",
                url: "{{route('remove_image')}}",
                cache: false,
            });
        }
    })
    jQuery.validator.setDefaults({
        ignore: ":hidden, [contenteditable='true']:not([name])"
    });

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

    function changeImgDetail(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img_detail').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            }
        }
        $('#img_detail').click(function() {
        $('#fImages_detail').click();
    });

    $('form#product_add_form').validate({
        rules: {
            "name": {
                required: true,
                maxlength: 190
            },
            "short_des": {
                required: true,
                maxlength: 190
            }
        },
        messages: {
            "name": {
                required: "{{ __('This field is required') }}",
                maxlength: "{{ __('190 characters limit') }}"
            },
            "short_des": {
                maxlength: "{{ __('190 characters limit') }}"
            }
        }
    });

    $('form#product_add_form').submit(function(e) {
        e.preventDefault();
        $('.submit_add').attr('data-submit', true);
        if ($('form#product_add_form').valid() == true) {
            $('.submit_add').attr('disabled', true);
            let data = new FormData($('#product_add_form')[0]);
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
                        $('div.product_modal').modal('hide');
                        toastr.success(result.msg);
                        if (typeof($('#product_table').DataTable()) != 'undefined') {
                            $('#product_table').DataTable().ajax.reload();
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
