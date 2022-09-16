@extends('layout_index.master')
@section('content')

<!-- Page top section -->
<section class="page-top-section set-bg" data-setbg="{{asset('endgame/img/page-top-bg/4.jpg')}}" style="height: 280px;">
    <div class="page-info">
        <div class="site-breadcrumb">
            <a href="#">{{ __('Home') }}</a> / <span>{{ __('Recharge') }}</span>
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
                        <form class="form-horizontal" action="#" method="POST" enctype="multipart/form-data" id="recharge_form">
                            <div class="row">
                                    <b style="color: white">{{ __('- Conversion rate: $100 = 100 Points') }}</b>
                                    <b style="color: white">{{ __('- After pressing the deposit button, you pay via MoMo with the transfer content recorded in
                                        the Deposit - Withdrawal history table') }}</b>
                                    <br>
                                    <div class="col-md-9">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-4 col-form-label">{{ __('Points to purchase') }}</label>
                                            <div class="col-sm-4">
                                                <input type="number" class="form-control" name="point_purchase" value="10" min="10">
                                            </div>
                                        </div>
                                    </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-hover submit_add" style="width: 30%">{{ __('Recharge') }}</button>
                                </div>
                            </div>
                        </form>
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

    $('form#recharge_form').submit(function(e){
        e.preventDefault();
        let data = new FormData($('form#recharge_form')[0]);
        $.ajax({
            method: 'POST',
            url: "{{ route('recharge.point', Auth::user()->id) }}",
            dataType: 'json',
            data: data,
            contentType: false,
            processData: false,
            success: function(result) {
                if (result.success == true) {
                    $('.submit_add').removeAttr('disabled');
                    toastr.success(result.msg);
                } else {
                    toastr.error(result.msg);
                    $('.submit_add').attr('disabled', false);
                }
            }
        });
    })
</script>
@endsection

