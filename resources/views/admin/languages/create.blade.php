<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ __('Add language') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('languages.store') }}" method="POST" enctype="multipart/form-data" id="language_add_form">
        @csrf
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="form-control-label" for="basic-url">{{ __('Language name') }}</label><b class="text-danger">*</b>
                        <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('Language name') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                      <label for="company_id">{{ __('Language') }}</label><b class="text-danger">*</b><br>
                      <select class="form-control select2" name="locale" id="locale" style="width: 100%;">
                        <option value="">{{ __('-- Select language --') }}</option>
                        @foreach (config('languages.locales') as $locale => $name)
                        <option value="{{$locale}}">{{$name}} - ({{$locale}})</option>
                        @endforeach
                      </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>{{__("Flag Icon")}}</label>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><span class="flag-icon  flag-icon-"></span></span>
                            </div>
                            <input type="text" placeholder="{{__("Eg: gb")}}" name="flag" class="form-control dungdt-input-flag-icon">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="exampleSelectRounded0">{{ __('Status') }}</label>
                        <select class="custom-select rounded-0" name="status" id="exampleSelectRounded0">
                          <option value="show">{{ __('Show') }}</option>
                          <option value="hide">{{ __('Hide') }}</option>
                        </select>
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
    $('.select2').select2({
        dropdownParent: $('#language_add_form')
    });
    $('form#language_add_form').validate({
        rules: {
            "name": {
                required: true,
                maxlength: 190
            },
            "locale": {
                required: true,
            },
            "flag": {
                required: true,
                maxlength: 190
            }
        },
        messages: {
            "name": {
                required: "{{ __('This field is required') }}",
                maxlength: "{{ __('190 characters limit') }}"
            },
            "locale": {
                required: "{{ __('This field is required') }}"
            },
            "flag": {
                required: "{{ __('This field is required') }}",
                maxlength: "{{ __('190 characters limit') }}"
            },
        }
    });

    $('.submit_add').on('click',function(e) {
        e.preventDefault();
        if ($('form#language_add_form').valid() == true) {
            $('.submit_add').attr('disabled', true);
            var data = new FormData($('form#language_add_form')[0]);
            $.ajax({
                method: 'POST',
                url: $('form#language_add_form').attr('action'),
                dataType: 'json',
                data: data,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result.success == true) {
                        $('div.language_modal').modal('hide');
                        toastr.success(result.msg);
                        if (typeof($('#language_table').DataTable()) != 'undefined') {
                            $('#language_table').DataTable().ajax.reload();
                            $('.submit_add').attr('disabled', false);
                        }
                    } else {
                        toastr.error(result.msg);
                        $('.submit_add').attr('disabled', false);
                    }
                },
                error: function(err) {
                    if (err.status == 422) {
                        $('#locale-error').html('');
                        $.each(err.responseJSON.errors, function(i, error) {
                            $(document).find('[name="' + i + '"]').after($('<span id="locale-error" class="error">' + error + '</span>'));
                        });
                    }
                    $('.submit_add').attr('disabled', false);
                }
            });
        }
    })
</script>
