@extends('layout_index.master')
@section('style')
<style>
    .eye-password{
        position: absolute;
        top: 29%;
        right: 22px;
        font-size: 18px;
    }
</style>
@endsection
@section('content')

<!-- Page top section -->
<section class="page-top-section set-bg" data-setbg="{{asset('endgame/img/page-top-bg/4.jpg')}}" style="height: 280px;">
    <div class="page-info">
        <div class="site-breadcrumb">
            <a href="#">{{ __('Home') }}</a> / <span>{{ __('Information') }}</span>
        </div>
    </div>
</section>
<!-- Page top end-->

<!-- Contact page -->
<section class="contact-page" style="padding-top: 30px">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 order-2 order-lg-1">
                @include('users.nav')
            </div>
            <div class="col-lg-9 order-1 order-lg-2 contact-text text-white">
                <div class="card card-primary card-outline">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#info"data-toggle="tab">{{ __('Information') }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#change_pasword" data-toggle="tab"> {{ __('Change password') }}</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="info">
                                <form class="form-horizontal" action="{{ route('info.update') }}" method="POST" enctype="multipart/form-data" id="information_form">
                                    <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group row">
                                                    <label for="inputName" class="col-sm-3 col-form-label">{{ __('Full name') }}</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Họ Tên" value="{{Auth::user()->name}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputUsername" class="col-sm-3 col-form-label">{{ __('Username') }}</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="username" readonly placeholder="{{ __('Username') }}" value="{{Auth::user()->username}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputEmail" class="col-sm-3 col-form-label">{{ __('Email') }}</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="email" name="email" placeholder="{{ __('Email') }}" value="{{Auth::user()->email}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="phone" class="col-sm-3 col-form-label">{{ __('Phone') }}</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="{{ __('Phone') }}" value="{{Auth::user()->phone}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="basic-url">{{ __('Avatar') }}</label> <br>
                                                    <div class="input-group">
                                                        <input id="fImages" type="file" name="avatar" class="form-control" style="display: none" accept="image/gif, image/jpeg, image/png" onchange="changeImg(this)">
                                                        <img id="img" style="width: 200px; height: 170px;" class="img-thumbnail" src="{{ asset(Auth::user()->avatar ? Auth::user()->avatar : 'AdminLTE-3.1.0/dist/img/no_img.jpg') }}">
                                                    </div>
                                                </div>
                                            </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-hover" style="width: 40%" id="information_submit">{{ __('Update') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="change_pasword">
                                <form action="{{route('info.change-password')}}" method="post" enctype="multipart/form-data" id="change_password_form">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row" style="position: relative;">
                                                <label class="col-sm-3 col-form-label">{{ __('Old password') }} <span class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="password" name="old_password" id="old_password" class="form-control" placeholder="{{ __('Old password') }}">
                                                    <a class="eye-password fa fa-eye-slash" style="color: black"></a>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="position: relative;">
                                                <label class="col-sm-3 col-form-label">{{ __('New password') }} <span class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('New password') }}">
                                                    <a class="eye-password fa fa-eye-slash" style="color: black"></a>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="position: relative;">
                                                <label class="col-sm-3 col-form-label">{{ __('New confirm password') }} <span class="error">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="{{ __('New confirm password') }} ">
                                                    <a class="eye-password fa fa-eye-slash" style="color: black"></a>
                                                </div>
                                            </div>
                                        </div><br>
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-hover" style="width: 40%" id="change_password_submit">{{ __('Change password') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact page end-->
@endsection
@section('script')
<script>
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script src="{{asset('js/infomation.js')}}"></script>
@endsection

