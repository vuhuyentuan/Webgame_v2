<div class="modal-dialog">
    <div class="modal-content" style="background: linear-gradient(45deg, #501755 0%, #2d1854 100%);">
        <div class="modal-header" style="border-bottom: none">
            <h4 class="modal-title" style="color: #fff" id="login_title">{{__('Register')}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" style="color: #fff">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="padding: 2rem; padding-top: 0rem;">
            <div id="login_content">
                <form action="{{route('post.login')}}" method="post" id="login_form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" style="color: #fff" for="basic-url">{{__('Username or email')}}</label>
                                <input type="text" class="form-control" placeholder="{{__('Username or email')}}" name="username">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" style="color: #fff" for="basic-url">{{__('Password')}}</label>
                                <input type="password" class="form-control" placeholder="{{__('Password')}}" name="password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-control-label" style="color: #fff" for="">Or social account</label>
                            <ul class="nk-social-links-2">
                                <li>
                                    <a class="nk-social-facebook"
                                        href="{{ route('social.login', ['facebook']) }}">
                                        {{-- <span  class="fa fa-facebook"></span> --}}
                                        <svg class="svg-inline--fa fa-facebook fa-w-14" aria-hidden="true" data-prefix="fab" data-icon="facebook" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M448 56.7v398.5c0 13.7-11.1 24.7-24.7 24.7H309.1V306.5h58.2l8.7-67.6h-67v-43.2c0-19.6 5.4-32.9 33.5-32.9h35.8v-60.5c-6.2-.8-27.4-2.7-52.2-2.7-51.6 0-87 31.5-87 89.4v49.9h-58.4v67.6h58.4V480H24.7C11.1 480 0 468.9 0 455.3V56.7C0 43.1 11.1 32 24.7 32h398.5c13.7 0 24.8 11.1 24.8 24.7z"></path></svg>
                                    </a>
                                </li>
                                {{-- <li><a class="nk-social-google-plus" href="#"><span
                                                class="fab fa-google-plus"></span></a></li>
                                    <li><a class="nk-social-twitter" href="#"><span class="fab fa-twitter"></span></a>
                                    </li> --}}
                            </ul>
                        </div>
                        <div class="col-6">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember" style="color:#fff">
                                {{__('Remember password')}}
                                </label>
                            </div>
                        </div>
                        <div class="col-6" style="text-align: right">
                            <a href="#" id="forgot_password">{{__('Forgot your password?')}}</a>
                        </div>
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="button" class="btn btn-hover" id="login_submit">{{__('Login')}}</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <div class="hide" id="reset_password_content">
                <span style="color: #fff"><i class="fa fa-info-circle" aria-hidden="true"></i> Hãy nhập email bạn đã đăng kí, chúng tôi sẽ gửi đường link tạo mật khẩu mới vào email của bạn.</span>
                <form action="{{route('reset_password')}}" method="post" id="reset_password_form" style="margin-top:10px">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                            <label class="form-control-label" style="color: #fff" for="basic-url">{{__('Email')}}</label>
                            <input type="text" class="form-control" autocomplete="off" placeholder="{{__('Email')}}" name="email">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="button" class="btn btn-hover" id="reset_password_submit">{{__('Recover password')}} <span id="recover_password_loadding"></span></button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- /.modal-content -->
</div>
