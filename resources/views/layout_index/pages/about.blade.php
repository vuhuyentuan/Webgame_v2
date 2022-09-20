@extends('layout_index.master')
@section('style')
<style>
    p {
        color: #c313b7;
    }
    li {
        color: #c313b7;
    }
    b {
        font-size: 18;
    }
</style>
@endsection
@section('content')
<!-- Page top section -->
<section class="page-top-section set-bg" data-setbg="{{ asset('endgame/img/page-top-bg/1.jpg') }}">
    <div class="page-info">
        <h2>{{ __('About us') }}</h2>
        <div class="site-breadcrumb">
            <a href="#">{{ __('Home') }}</a>  /
            <span>{{ __('About us') }}</span>
        </div>
    </div>
</section>
<!-- Page top end-->
	<!-- Games section -->
	<section class="games-single-page">
		<div class="container">
            <div class="notepaper">
                <figure class="quote">
                  <blockquote class="curly-quotes">
                    <b>{{ __('Playing and depositing money into the game is a very normal action. However,
                    with a specific game market like Vietnam, recharging to strengthen characters has become a rule in
                    many online games.') }}</b>
                  </blockquote>
                  <figcaption class="quote-by">— {{ __('Samuel Marlow') }}</figcaption>
                </figure>
                <div class="row">
                    <div class="col-lg-4" style="float: left">
                        <div class="nk-box-2 ">
                            <h4>{{ __('1. Experience many of the game features') }}</h4>
                           <p>{{ __('As you probably know, some games, including Online Games or Offline Games, have sections or items that can only be unlocked by making a deposit. There are also games that can be achieved if you work hard for a while. However, it is also advisable to spend reasonable money to be able to experience all the features of the game or not to waste time and effort.') }}</p>
                        </div>
                    </div>
                    <div class="col-lg-4" style="float: left">
                        <div class="nk-box-2">
                            <h4>{{ __('2. Saving') }}</h4>
                           <p>{{ __('Tshop.com will save you more than 25%, save a lot of money when buying in-game items') }}</p>
                        </div>
                    </div>
                    <div class="col-lg-4" style="float: left">
                        <div class="nk-box-2">
                            <h4>{{ __('3. Why safe?') }} </h4>
                                <li>{{ __('You will be guaranteed the recharge packages when using the service at') }} <b style="color: #dd163b">Tshop.com</b></li>
                                <li>{{ __('Enthusiastic support team') }}</li>
                                <li>{{ __('Refund when you do not use') }}</li>
                                <li>{{ __('We do not keep logs (products, customers) to ensure the highest security') }}</li>
                                <li>{{ __('We offer the best price in the market') }}</li>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</section>
	<!-- Games end-->
</div>
@endsection
