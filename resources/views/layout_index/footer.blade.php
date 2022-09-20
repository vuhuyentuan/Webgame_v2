<!-- Newsletter section -->
<section class="newsletter-section">
    <div class="container">
        <h2>{{ __('Subscribe to our newsletter') }}</h2>
        <form class="newsletter-form" id="subscribe">
            <input type="email" placeholder="{{ __('ENTER YOUR E-MAIL') }}" required>
            <button type="submit" class="site-btn">{{ __('subscribe') }} <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></button>
        </form>
    </div>
</section>
<!-- Newsletter section end -->
<footer class="footer-section">
    <div class="container">
        <div class="footer-left-pic">
            <img src="{{ asset('endgame/img/footer-left-pic.png') }}" alt="">
        </div>
        <div class="footer-right-pic">
            <img src="{{ asset('endgame/img/footer-right-pic.png') }}" alt="">
        </div>
        <a href="#" class="footer-logo">
            <img src="{{ asset('endgame/img/logo.png') }}" alt="">
        </a>
        <ul class="main-menu footer-menu">
            <li><a href="{{ route('index') }}">{{ __('Home') }}</a></li>
            <li><a href="{{ route('games', 'all') }}">{{ __('Games') }}</a></li>
            <li><a href="{{ route('about') }}">{{ __('About us') }}</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
        <div class="footer-social d-flex justify-content-center">
            <a href="#"><i class="fa fa-pinterest"></i></a>
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-dribbble"></i></a>
            <a href="#"><i class="fa fa-behance"></i></a>
        </div>
        <div class="copyright"><a href="#">Colorlib</a> 2018 @ All rights reserved</div>
    </div>
</footer>
