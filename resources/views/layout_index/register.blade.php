<div class="modal-dialog">
    <div class="modal-content" style="background: linear-gradient(45deg, #501755 0%, #2d1854 100%);">
        <div class="modal-header" style="border-bottom: none">
            <h4 class="modal-title" style="color: #fff">{{__('Register')}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" style="color: #fff">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="padding: 2rem; padding-top: 0rem;">
            <form action="{{route('post.register')}}" method="post" id="register_form">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label" style="color: #fff" for="basic-url">{{__('Full name')}}</label><b class="text-danger"> *</b>
                            <input type="text" class="form-control" name="name" id="name" placeholder="{{__('Full name')}}">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label" style="color: #fff" for="basic-url">{{__('Email')}}</label><b class="text-danger"> *</b>
                            <input type="text" class="form-control" name="email" id="email" placeholder="{{__('Email')}}">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label" style="color: #fff" for="basic-url">{{__('Username')}}</label><b class="text-danger"> *</b>
                            <input type="text" class="form-control" name="username" id="username" placeholder="{{__('Username')}}">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label" style="color: #fff" for="basic-url">{{__('Password')}}</label><b class="text-danger"> *</b>
                            <input type="password" class="form-control" name="password" id="password" placeholder="{{__('Password')}}">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label" style="color: #fff" for="basic-url">{{__('Confirm password')}}</label><b class="text-danger"> *</b>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="{{__('Confirm password')}}">
                        </div>
                    </div>
                    <div class="col-lg-12" style="margin-top: 10px">
                        <button type="button" id="register_submit" class="btn btn-hover">{{__('Register')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
