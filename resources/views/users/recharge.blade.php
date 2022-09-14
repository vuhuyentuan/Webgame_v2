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
                    <div class="card-body">

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

