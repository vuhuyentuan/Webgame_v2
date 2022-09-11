@extends('layout_admin.master')
@section('title')
    <title>{{ __('Settings') }}</title>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{ __('Settings') }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Settings') }}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    @if(Session::has('flag'))
        <div class="alert alert-{{Session::get('flag')}}">{{Session::get('messege')}} </div>
    @endif
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#general"data-toggle="tab">{{ __('General') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="#template"data-toggle="tab">{{ __('Template') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact" data-toggle="tab"> {{ __('Contact') }}</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="general">
                            <form class="form-horizontal" action="{{ route('settings.update_general', $setting->id) }}" method="POST" enctype="multipart/form-data"  id="general_form">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{ __('Seo title') }}</label>
                                            <input type="text" class="form-control" name="seo_title" value="{{ $setting->seo_title }}" placeholder="{{ __('Seo title') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{ __('Seo description') }}</label>
                                            <input type="text" class="form-control" name="seo_description" value="{{ $setting->seo_description }}" placeholder="{{ __('Seo description') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{ __('Keywords') }}</label>
                                            <input type="text" class="form-control" name="keywords" value="{{ $setting->keywords }}" placeholder="{{ __('Keywords') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{ __('Main color') }}</label>
                                            <input type="color" class="form-control" name="main_color" value="{{ $setting->main_color }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{ __('Secondary color') }}</label>
                                            <input type="color" class="form-control" name="secondary_color" value="{{ $setting->secondary_color }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{ __('Maintenance') }}</label>
                                            <select class="custom-select rounded-0" name="maintenance" id="exampleSelectRounded0">
                                                @foreach (['on' => __('On'), 'off' => __('Off')] as $key => $value)
                                                    @if($setting->maintenance == $key)
                                                        <option selected value="{{ $key }}">{{ $value }}</option>
                                                    @else
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{__("Insert JavaScripts (Live Chat, Website Effects, etc.)")}}</label>
                                    <div class="form-controls">
                                        <div id="topbar_left_text_editor" class="ace-editor" style="height: 200px" data-theme="textmate" data-mod="html">{{ $setting->javascript }}</div>
                                        <textarea class="d-none" name="javascript"> {{ $setting->javascript }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-danger" id="general_submit">{{ __('Update') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="template">
                            <form class="form-horizontal" action="{{ route('settings.update', $setting->id) }}" method="POST" enctype="multipart/form-data"  id="temple_form">
                                @csrf
                                @method('put')
                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label">{{ __('Logo') }}</label>
                                    <div class="col-sm-10">
                                        <input id="fImages" type="file" name="logo" class="form-control" style="display: none" accept="image/gif, image/jpeg, image/png" onchange="changeImg(this)">
                                        <img id="img" class="img" style="width: 250px; height: 100px;" src="{{ asset($setting->logo) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                  <label for="name" class="col-sm-2 col-form-label">{{ __('Logo text') }}</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" name="logo_text" placeholder="{{ __('Logo text') }}" value="{{ $setting->logo_text }}">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger" id="temple_submit">{{ __('Update') }}</button>
                                  </div>
                                </div>
                              </form>
                        </div>
                        <div class="tab-pane" id="contact">
                            <form class="form-horizontal" action="{{ route('settings.update_contact', $setting->id) }}" method="POST" enctype="multipart/form-data"  id="contact_form">
                                @csrf
                                <div class="form-group row">
                                  <label for="name" class="col-sm-2 col-form-label">{{ __('Facebook') }}</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" name="facebook" placeholder="https://www.facebook.com/admin" value="{{ $setting->contacts ? json_decode($setting->contacts)->facebook : ''}}">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="name" class="col-sm-2 col-form-label">{{ __('Zalo') }}</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" name="zalo" placeholder="https://zalo.me/011564897" value="{{ $setting->contacts ? json_decode($setting->contacts)->zalo : '' }}">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="name" class="col-sm-2 col-form-label">{{ __('Phone') }}</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control" name="phone" placeholder="{{ __('Phone') }}" value="{{ $setting->contacts ? json_decode($setting->contacts)->phone : '' }}">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="name" class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                                  <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" placeholder="{{ __('Email') }}" value="{{ $setting->contacts ? json_decode($setting->contacts)->email : '' }}">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger" id="contact_submit">{{ __('Update') }}</button>
                                  </div>
                                </div>
                              </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection
@section('script')
<script src="{{ asset('js/src-min-noconflict/ace.js') }}"></script>
<script>
    (function ($) {
        $('.ace-editor').each(function () {
            var editor = ace.edit($(this).attr('id'));
            editor.setTheme("ace/theme/"+$(this).data('theme'));
            editor.session.setMode("ace/mode/"+$(this).data('mod'));
            var me = $(this);

            editor.session.on('change', function(delta) {
                // delta.start, delta.end, delta.lines, delta.action
                me.next('textarea').val(editor.getValue());
            });
        });
    })(jQuery)

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

    function changeBanner(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#banner-img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            }
        }
        $('#banner-img').click(function() {
        $('#banner').click();
    });

    $('form#general_form').submit(function(e) {
        e.preventDefault();
        $('#generale_submit').attr('disabled', true);
        let data = new FormData($('#general_form')[0]);
        $.ajax({
            method: 'POST',
            url: $(this).attr('action'),
            dataType: 'json',
            data: data,
            contentType: false,
            processData: false,
            success: function(result) {
                if (result.success == true) {
                    $('#generale_submit').removeAttr('disabled');
                    toastr.success(result.msg);
                } else {
                    toastr.error(result.msg);
                    $('#generale_submit').removeAttr('disabled');
                }
            }
        });
    });

    $('form#temple_form').submit(function(e) {
        e.preventDefault();
        $('#temple_submit').attr('disabled', true);
        let data = new FormData($('#temple_form')[0]);
        $.ajax({
            method: 'POST',
            url: $(this).attr('action'),
            dataType: 'json',
            data: data,
            contentType: false,
            processData: false,
            success: function(result) {
                if (result.success == true) {
                    if (result.data.logo != null) {
                        $('#img').attr('src', window.location.origin + '/' + result.data.logo);
                        $('.brand-image').attr('src', window.location.origin + '/' + result.data.logo);
                    }
                    if (result.data.banner != null) {
                        $('#banner-img').attr('src', window.location.origin + '/' + result.data.banner);
                    }
                    $('.logo_text').html(result.data.logo_text)
                    $('#temple_submit').removeAttr('disabled');
                    toastr.success(result.msg);
                } else {
                    toastr.error(result.msg);
                    $('#temple_submit').attr('disabled', false);
                }
            },
            error: function(err) {
                toastr.error(err.msg);
                $('#temple_submit').attr('disabled', false);
            }
        });
    });

    $('form#contact_form').validate({
        rules: {
            "email": {
                email: true,
                maxlength: 190
            },
            "phone": {
                number: true,
                maxlength: 20
            },
        },
        messages: {
            "email": {
                required: "{{ __('This field is required') }}",
                email: "{{ __('Incorrect email format') }}",
                maxlength: "{{ __('190 characters limit') }}"
            },
            "phone": {
                number: "{{ __('Only numbers can be entered') }}",
                maxlength: "{{ __('20 characters limit') }}"
            },
        }
    });

    $('form#contact_form').submit(function(e) {
        e.preventDefault();
        if ($('form#contact_form').valid() == true) {
            $('#contact_submit').attr('disabled', true);
            let data = new FormData($('#contact_form')[0]);
            $.ajax({
                method: 'POST',
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result.success == true) {
                        $('#contact_submit').removeAttr('disabled');
                        toastr.success(result.msg);
                    }
                },
                error: function(err) {
                    toastr.error(err.msg);
                    $('#contact_submit').attr('disabled', false);
                }
            });
        }
    });

</script>
@endsection
