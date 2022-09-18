<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('Edit game') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="product_edit_form">
            @csrf
            @method('put')
            <div class="modal-body modal-overflow">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Name game') }}</label><b class="text-danger">*</b>
                            <input type="text" class="form-control" name="name" value="{{ $product->name }}" placeholder="{{ __('Name game') }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Short description') }}</label><b class="text-danger">*</b>
                            <input type="text" class="form-control" name="short_des" value="{{ $product->short_des }}" placeholder="{{ __('Short description') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleSelectRounded0">{{ __('Type game') }}</label>
                            <select class="custom-select rounded-0" name="type" id="exampleSelectRounded0">
                                @foreach (['Game' => __('Game'), 'Card' => __('Card')] as $key => $value)
                                    @if($product->type == $key)
                                        <option selected value="{{ $key }}">{{ $value }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleSelectRounded1">{{ __('Support system') }}</label>
                            <select class="custom-select rounded-1" name="os_supported" id="exampleSelectRounded1">
                                @foreach (['Android' => __('Android'), 'IOS' => __('IOS'), 'Wallet' => __('Wallet')] as $key => $value)
                                    @if($product->os_supported == $key)
                                        <option selected value="{{ $key }}">{{ $value }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Description') }}</label> <br>
                            <textarea name="description" id="description">{{ $product->description }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Avatar') }}</label> <br>
                            <div class="input-group">
                                <input id="fImages" type="file" name="image" class="form-control" style="display: none" accept="image/gif, image/jpeg, image/png" onchange="changeImg(this)">
                                <img id="img" class="img" style="width: 100px; height: 100px;" src="{{ asset( $product->image ? $product->image : 'AdminLTE-3.1.0/dist/img/no_img.jpg') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" for="basic-url">{{ __('Image detail') }}</label> <br>
                            <div class="input-group">
                                <input id="fImages_detail" type="file" name="image_detail" class="form-control" style="display: none" accept="image/gif, image/jpeg, image/png" onchange="changeImgDetail(this)">
                                <img id="img_detail" class="img_detail" style="width: 250px; height: 100px;" src="{{ asset( $product->image_detail ? $product->image_detail : 'AdminLTE-3.1.0/dist/img/no_img.jpg') }}">
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
    $(function () {
        $('#description').summernote({
            height: 200,
            callbacks: {
                onImageUpload: function(files) {
                    _this = $(this);
                    sendFile(files[0], _this);
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

    $('form#product_edit_form').validate({
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

    $('form#product_edit_form').submit(function(e) {
        e.preventDefault();
        if ($('form#product_edit_form').valid() == true) {
            $('.submit_edit').attr('disabled', true);
            let data = new FormData($('#product_edit_form')[0]);
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
                        $('div.product_modal').modal('hide');
                        toastr.success(result.msg);
                        if (typeof($('#product_table').DataTable()) != 'undefined') {
                            $('#product_table').DataTable().ajax.reload();
                        }
                    } else {
                        toastr.error(result.msg);
                        $('.submit_edit').attr('disabled', false);
                    }
                }
            });
        }
    });
</script>
