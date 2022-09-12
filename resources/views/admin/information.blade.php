@extends('layout_admin.master')
@section('title')
    <title>{{ __('Information') }}</title>
@endsection
@section('style')
<style>
    .eye-password{
        position: absolute;
        top: 29%;
        right: 22px;
        color: #777777;
        font-size: 18px;
    }
</style>
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Information') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Information') }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" style="width: 130px; height: 130px;" id="avatar_profile" src="{{asset(Auth::user()->avatar ? Auth::user()->avatar : 'images/avatar/default_avatar.jpg') }}" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center user-name">{{Auth::user()->name}}</h3>

                            <p class="text-muted text-center">@if(Auth::user()->role == 1) {{ __('Admin') }} @else {{ __('User') }} @endif</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b> {{ __('Username') }}</b> <a class="float-right">{{Auth::user()->username}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Email') }}</b> <a class="float-right email">{{Auth::user()->email}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ __('Phone') }}</b> <a class="float-right phone">{{Auth::user()->phone}}</a>
                                </li>
                            </ul>

                            {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#activity"data-toggle="tab">{{ __('Information') }}</a></li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab"> {{ __('Change password') }}</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <form class="form-horizontal" action="{{route('info.update')}}" method="POST" enctype="multipart/form-data" id="information_form">
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
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="btn btn-primary" id="information_submit">{{ __('Update') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="settings">
                                    <form action="{{route('info.change-password')}}" method="post" enctype="multipart/form-data" id="change_password_form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row" style="position: relative;">
                                                    <label class="col-sm-3 col-form-label">{{ __('Old password') }} <span class="error">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="password" name="old_password" id="old_password" class="form-control" placeholder="{{ __('Old password') }}">
                                                        <a class="eye-password fa fa-eye-slash"></a>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="position: relative;">
                                                    <label class="col-sm-3 col-form-label">{{ __('New password') }} <span class="error">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('New password') }}">
                                                        <a class="eye-password fa fa-eye-slash"></a>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="position: relative;">
                                                    <label class="col-sm-3 col-form-label">{{ __('New confirm password') }} <span class="error">*</span></label>
                                                    <div class="col-sm-9">
                                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="{{ __('New confirm password') }} ">
                                                        <a class="eye-password fa fa-eye-slash"></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="btn btn-primary" id="change_password_submit">{{ __('Change password') }}</button>
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
<script>
    var required = "{{ __('This field is required') }}";
    var maxlength = "{{ __('190 characters limit') }}";
    var equalTo = "{{ __('Confirmation password is not correct') }}";
    var email = "{{ __('Incorrect email format') }}";
    var number = "{{ __('Only numbers can be entered') }}";
    var minlength = "{{ __('10 characters limit') }}";
    var maxlength20 = "{{ __('20 characters limit') }}";
</script>
<script src="{{asset('js/infomation.js')}}"></script>
@endsection
