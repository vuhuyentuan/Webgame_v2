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
                <div class="user-panel" id="user-panel">
                    @if(Auth::user())
                        <a href=""><i class="fa fa-user-o" aria-hidden="true"></i> {{Auth::user()->name}}</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{route('logout')}}"><i class="fa fa-power-off"></i> {{__('Logout')}}</a>
                    @else
                        <a href="{{route('login')}}" id="login">Login</a> / <a href="{{route('register')}}" id="register">Register</a>
                    @endif
                </div>
                <!-- Menu -->
                <ul class="main-menu primary-menu">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><a href="#">Games</a>
                        <ul class="sub-menu">
                            <li><a href="game-single.html">Game Singel</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Reviews</a></li>
                    <li><a href="#">News</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
