@extends('layout_index.master')
@section('content')

<!-- Page top section -->
<section class="page-top-section set-bg" data-setbg="{{asset('endgame/img/page-top-bg/4.jpg')}}" style="height: 280px;">
    <div class="page-info">
        <div class="site-breadcrumb">
            <a href="">Home</a> / <span>Tạo mật khẩu mới</span>
        </div>
    </div>
</section>
<!-- Page top end-->

<!-- Contact page -->
<section class="contact-page" style="padding-top: 30px">
    <div class="container">
        @if(!empty($msg))
            <h3 class="text-white">{{$msg}}</h3>
        @else
        <div class="section-title text-white col-lg-12">
            <h2>Tạo mật khẩu mới</h2>
        </div>
        <div class="row">
            <div class="col-lg-7 order-2 order-lg-1">
                <form class="contact-form" action="{{route('pos_password_new')}}" method="post" id="password_new_form" style="margin-top: 20px">
                    @csrf
                    <div class="col-lg-12">
                        <div class="form-group">
                            <input type="password" name="password" id="password" placeholder="Mật khẩu mới">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                        <input type="password" name="repassword" id="repassword" placeholder="Xác nhận mật khẩu">
                    </div>
                    <input type="hidden" name="code" value="{{$_GET['code'] ?? ''}}">
                    <input type="hidden" name="email" value="{{$_GET['email'] ?? ''}}">
                    <button class="site-btn" id="password_new_submit">Tạo mật khẩu<img src="{{asset('endgame/img/icons/double-arrow.png')}}" alt="#"/></button>
                </form>
            </div>
        </div>

        @endif

    </div>
</section>
<!-- Contact page end-->
@endsection
@section('script')
<script src="{{asset('js/reset_password.js')}}"></script>
@endsection
