<div class="px-4 text-center mb-4">
    <span class="avatar avatar-md mb-3">
        @if(Auth::user()->avatar)
            <img src="{{ Auth::user()->avatar }}" class="rounded-circle user-photo" style="width: 100px; height: 100px;">
        @else
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="rounded-circle user-photo" style="width: 100px; height: 100px;">
        @endif
    </span>
    <div style="margin-top: 10px">
        <h6 class="text-muted">{{ __('Hello') }}, <b class="user-name" style="color: #fff">{{ Auth::user()->name }}</b></h6>
        <h6 class="text-muted surplus">{{ __('Surplus') }} : <b class="text-danger">{{ number_format(Auth::user()->point) }}</b> points</h6>
    </div>
    <hr>
    <ul class="list-group list-group-flush">
        <a href="{{ route('user.recharge') }}" class="btn btn-hover {{ URL::current() == route('user.recharge') ? 'active' : '' }}">
            <span class="aiz-side-nav-text">{{ __('Recharge') }}</span>
        </a>
        <a href="{{ route('user.recharge_history') }}" class="btn btn-hover">
            <span class="aiz-side-nav-text">{{ __('Recharge history') }}</span>
        </a>
    </ul>
</div>

