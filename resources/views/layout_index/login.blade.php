<div class="modal-dialog">
    <div class="modal-content" style="background: linear-gradient(45deg, #501755 0%, #2d1854 100%);">
        <div class="modal-header" style="border-bottom: none">
            <h4 class="modal-title" style="color: #fff">{{__('Register')}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" style="color: #fff">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="padding: 2rem; padding-top: 0rem;">
            <form action="{{route('post.login')}}" method="post" id="login_form">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                        <label class="form-control-label" style="color: #fff" for="basic-url">{{__('Username or email')}}</label>
                        <input type="text" class="form-control" placeholder="{{__('Username or email')}}" name="username">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                        <label class="form-control-label" style="color: #fff" for="basic-url">{{__('Password')}}</label>
                        <input type="password" class="form-control" placeholder="{{__('Password')}}" name="password">
                        </div>
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
                        <a href="">{{__('Forgot your password?')}}</a>
                    </div>
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="button" class="btn btn-hover" id="login_submit">{{__('Login')}}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
