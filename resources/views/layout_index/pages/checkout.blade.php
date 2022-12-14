@extends('layout_index.master')
@section('content')
<!-- Page top section -->
<section class="page-top-section set-bg" data-setbg="{{ asset('endgame/img/page-top-bg/1.jpg') }}">
    <div class="page-info">
        <h2>{{ __('Check out') }}</h2>
        <div class="site-breadcrumb">
            <a href="#">{{ __('Home') }}</a>  /
            <span>{{ __('Check out') }}</span>
        </div>
    </div>
</section>
<!-- Page top end-->
	<!-- Games section -->
	<section class="games-single-page">
		<div class="container">
            <div class="order-1 order-lg-2 contact-text text-white">
                <div class="table-responsive">
                    <form action="{{ route('checkout.payment', $package->id) }}" method="post" id="order_form">
                    @csrf
                        <input type="text" value="" id="uid" name="username" style="display: none">
                        <input type="text" value="" id="pass" name="password_game" style="display: none">
                        <input type="text" value="" id="sv" name="sever" style="display: none">
                        <input type="text" value="" id="cd" name="code" style="display: none">
                        <input type="text" value="" id="ch" name="character" style="display: none">
                        <input type="text" value="" id="lg" name="login_with" style="display: none">
                        <table class="table table-striped custom-table">
                            <tbody>
                                <tr class="text-center">
                                    <td>
                                        <img src="{{asset($package->product->image ? $package->product->image : 'images/no_img.jpg' )}}" class="popup" width="200px" height="150px" />
                                    </td>
                                    <td>
                                        <h5>{{ __('Game name') }}</h5><br>
                                        <h3>{{$package->product->name}}</h3>
                                    </td>
                                    <td>
                                        <h5>{{ __('Package name') }}</h5><br>
                                        <h5>{{$package->name}}</h5>
                                    </td>
                                    <td>
                                        <h5>{{ __('Value') }}</h5><br>
                                        <h5>{{$package->value}}</h5>
                                    </td>
                                    <td>
                                        <h5>{{ __('Support system') }}</h5><br>
                                        <h5>{{$package->product->os_supported}}</h5>
                                    </td>
                                    <td>
                                        <h5>{{ __('Quantity') }}</h5><br>
                                        <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" max="21" onchange="totalPoint()">
                                    </td>
                                    <td>
                                        <h5>{{ __('Total') }}</h5><br>
                                        <h5 id="total">{{ $package->point }} $</h5>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                    <button type="button" class="btn btn-hover float-right" id="order" style="width: 10%">{{ __('Order') }}</button>
                </div>
            </div>
		</div>
	</section>
	<!-- Games end-->
    <div class="modal fade" id="termsmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background: linear-gradient(45deg, #501755 0%, #2d1854 100%);">
            <div class="modal-header">
                <h4 style="color: #fff" id="exampleModalLabel">{{ __('Confirm') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 style="color: #fff">{{ __('After clicking confirm, you much contact the supporter for assistance in loading money into the game.') }}</h6>
                <h6 style="color: #fff">{{ __('NOTE: Please send the game account.') }}</h6>
                <h6 style="color: #fff">{{ __('Before sending, please enable Two-factor Authentication for your account to avoid bad situations.') }}</h6>
                <h6 style="color: #fff">{{ __('Webgame.vn secures 100% of customer information absolutely and safely.') }}</h6>
                <hr>
                <p style="color: yellow">{{ __('After clicking confirm, the money will be deducted from your account, support
                    will contact you via facebook page or phone number/email you have registered.') }}</p>
                <h6 style="color:red">{{ __('Account information') }}</h6>
                <br>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <input type="text" value="" id="username" name="username" class="required form-control"  maxlength="100" placeholder="{{ __('Username') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <input type="text" value="" id="password_game" name="password_game" class="required form-control"  maxlength="100" placeholder="{{ __('Password') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <input type="text" value="" id="sever" name="sever" class="required form-control" maxlength="100" placeholder="{{ __('Sever (if there is server)') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <input type="text" value="" id="code" name="code" class="required form-control" maxlength="100" placeholder="{{ __('Code (if there is code)') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <input type="text" value="" id="character" name="character" class="required form-control" maxlength="100" placeholder="{{ __('Your name game character') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <input type="text" value="" id="note" name="note" class="required form-control" maxlength="100" placeholder="{{ __('Login with Facebook or Gmail') }}">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" class="btn btn-hover" id="confirm_terms" style="width: 20%">{{ __('Confirm') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var point = "{{ $package->point }}";
    function totalPoint() {
        $("#total").html(Number($("#quantity").val()*point).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + ' $');
    }

    $(document).ready(function(){
        $('#order').click(function(e){
            e.preventDefault();
            $('#termsmodal').modal('show');
        })

        $('#confirm_terms').click(function(){
            let user = "{{ Auth::check() }}";
            if (!user) {
                $('#termsmodal').modal('hide');
                $('#login').click();
            }else{
                var username = $('#username').val();
                var password_game = $('#password_game').val();
                if(username == '' || password_game == '' ){
                    toastr.error("{{ __('Please enter game account information!') }}");
                }else{
                    $('#confirm_terms').attr('disabled', true);
                    $('#uid').val($('#username').val());
                    $('#pass').val($('#password_game').val());
                    $('#sv').val($('#sever').val());
                    $('#cd').val($('#code').val());
                    $('#ch').val($('#character').val());
                    $('#lg').val($('#note').val());
                    let data = new FormData($('#order_form')[0]);
                    $.ajax({
                        method: 'POST',
                        url: $('#order_form').attr('action'),
                        dataType: 'json',
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function(result) {
                            if (result.success == true) {
                                $('#confirm_terms').removeAttr('disabled');
                                $('#termsmodal').modal('hide');
                                toastr.success(result.msg);
                                setTimeout(window.location = window.location.origin +'/order-history', 2000);
                            } else {
                                toastr.error(result.msg);
                                $('#termsmodal').modal('hide');
                                $('.submit_add').attr('disabled', false);
                            }
                        }
                    });
                }
            }
        })
    })
</script>
@endsection
