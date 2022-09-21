<header class="header-section">
    <div class="header-warp">
        <div class="header-social d-flex justify-content-end">
            <p>Follow us:</p>
            <a href="#"><i class="fa fa-pinterest"></i></a>
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-dribbble"></i></a>
            <a href="#"><i class="fa fa-behance"></i></a>
        </div>
        <div class="header-bar-warp d-flex">
            <!-- site logo -->
            <a href="{{ route('index') }}" class="site-logo">
                <img src="{{ asset('endgame/img/logo.png') }}" alt="">
            </a>
            <nav class="top-nav-area w-100">
                @if (Auth::check())
                    <div class="user-panel" style="margin-top: -10px;">
                        <ul class="main-menu">
                            <li>
                                <a href="#" class="nav-item nav-icon pr-0 search-toggle" id="user-panel">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ Auth::user()->avatar }}" class="rounded-circle user-photo" style="width:40px; height:40px">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="rounded-circle user-photo" style="width:40px; height:40px">
                                    @endif
                                </a>
                                <ul class="sub-menu" style="background: #081624; margin-left: -100px;">
                                    <div class="d-flex mt-2 ml-4 mr-4 mb-2">
                                        <div class="flex-shrink-0">
                                            <div class="image">
                                                @if(Auth::user()->avatar)
                                                    <img src="{{ Auth::user()->avatar }}" class="rounded-circle user-photo" style="width:40px; height:40px">
                                                @else
                                                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="rounded-circle user-photo" style="width:40px; height:40px">
                                                @endif
                                            </div>
                                        </div>&nbsp;&nbsp;&nbsp;
                                        <div class="flex-grow-1">
                                            <span class="fw-semibold d-block" style="height: 25px;">
                                                @if (Auth::user()->role == 1)
                                                    <a href="{{ route('dashboard') }}" class="user-name">{{ Auth::user()->name }}</a>
                                                @else
                                                    <a href="{{ route('user.info') }}" class="user-name">{{ Auth::user()->name }}</a>
                                                @endif
                                            </span>
                                            <h6 class="text-muted surplus">{{ __('Surplus') }} : <b class="text-danger">{{ number_format(Auth::user()->point) }}</b></h6>
                                        </div>
                                    </div>
                                    <hr>
                                    <center>
                                        <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer" style="height: 25px;">
                                            <svg class="svg-icon mr-0 text-secondary" id="h-05-p" width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            {{ __('Logout') }}
                                        </a>
                                    </center>
                                </ul>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="user-panel" style="padding-top: 3px;">
                        <a href="{{route('login')}}" id="login">Login</a> / <a href="{{route('register')}}" id="register">Register</a>
                    </div>
                @endif

                <!-- Menu -->
                <ul class="main-menu primary-menu">
                    <li><a href="{{ route('index') }}">{{ __('Home') }}</a></li>
                    <li><a href="{{ route('games', 'all') }}">{{ __('Games') }}</a></li>
                    <li><a href="{{ route('about') }}">{{ __('About us') }}</a></li>
                    <li><a href="#">{{ __('Contact') }}</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
