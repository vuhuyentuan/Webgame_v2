@extends('layout_index.master')
@section('content')
<section class="hero-section overflow-hidden">
    <div class="hero-slider owl-carousel">
        @forelse ($slides as $slide)
        <div class="hero-item set-bg d-flex align-items-center justify-content-center text-center" data-setbg="{{ asset($slide->images) }}">
            <div class="container">
                <h2 style="font-size: 80px">{{$slide->name}}</h2>
                <p class="text-white">{!! $slide->description !!}</p>
                <a href="{{ route('games', 'all') }}" class="site-btn">{{__('Read More')}}  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
            </div>
        </div>
        @empty
        <div class="hero-item set-bg d-flex align-items-center justify-content-center text-center" data-setbg="{{ asset('endgame/img/slider-bg-1.jpg') }}">
            <div class="container">
                <h2>Game on!</h2>
                <p>Fusce erat dui, venenatis et erat in, vulputate dignissim lacus. Donec vitae tempus dolor,<br>sit amet elementum lorem. Ut cursus tempor turpis.</p>
                <a href="{{ route('games', 'all') }}" class="site-btn">Read More  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
            </div>
        </div>
        <div class="hero-item set-bg d-flex align-items-center justify-content-center text-center" data-setbg="{{ asset('endgame/img/slider-bg-2.jpg') }}">
            <div class="container">
                <h2>Game on!</h2>
                <p>Fusce erat dui, venenatis et erat in, vulputate dignissim lacus. Donec vitae tempus dolor,<br>sit amet elementum lorem. Ut cursus tempor turpis.</p>
                <a href="{{ route('games', 'all') }}" class="site-btn">Read More  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
            </div>
        </div>
        @endforelse
    </div>
</section>
<!-- Hero section end-->


<!-- Intro section -->
<section class="intro-section">
    <div class="container">
        <div class="row">
            <div class="featured_slider owl-carousel owl-theme">
                @forelse ($product_featured as $product)
                <div class="col-md-12">
                    <div class="intro-text-box text-box text-white">
                        <div class="top-meta"><a href="#">{{$product->type}}</a></div>
                        <h3>{{$product->name}}</h3>
                        <p class="show-less">{{$product->short_des}}</p>
                        <a href="{{ route('game.detail', $product->id) }}" class="read-more">{{__('Read More')}}  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
                    </div>
                </div>
                @empty
                <div class="item">
                    <div class="col-md-12">
                        <div class="intro-text-box text-box text-white">
                            <div class="top-meta">11.11.18  /  in <a href="#">Games</a></div>
                            <h3>The best online game is out now!</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida....</p>
                            <a href="{{ route('games', 'all') }}" class="read-more">Read More  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="col-md-12">
                        <div class="intro-text-box text-box text-white">
                            <div class="top-meta">11.11.18  /  in <a href="#">Playstation</a></div>
                            <h3>Top 5 best games in november</h3>
                            <p>Ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum  labore suspendisse ultrices gravida....</p>
                            <a href="{{ route('games', 'all') }}" class="read-more">Read More  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="col-md-12">
                        <div class="intro-text-box text-box text-white">
                            <div class="top-meta">11.11.18  /  in <a href="#">Reviews</a></div>
                            <h3>Get this game at a promo price</h3>
                            <p>Sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida ncididunt ut labore ....</p>
                            <a href="{{ route('games', 'all') }}" class="read-more">Read More  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
<!-- Intro section end -->


<!-- Blog section -->
<section class="blog-section spad">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8 col-md-7">
                <div class="section-title text-white">
                    <h2>{{__('LATEST GAMES')}}</h2>
                </div>
                <ul class="blog-filter">
                    <li><a class="support_system active" data-system="Android" href="javascript:(0)">{{__('Android')}}</a></li>
                    <li><a class="support_system" data-system="IOS" href="javascript:(0)">{{__('IOS')}}</a></li>
                    <li><a class="support_system" data-system="Wallet" href="javascript:(0)">{{__('Wallet')}}</a></li>
                    <li><a class="support_system" data-system="Card" href="javascript:(0)">{{__('Card')}}</a></li>
                </ul>
                <div id="product_new_content">
                    @forelse ($product_news as $product_new)
                    <div class="d-flex mt-4 ml-4 mr-4 mb-2">
                        <div class="flex-shrink-0">
                            <div class="image">
                                <a href="{{ route('game.detail', $product_new->id) }}">
                                    <img src="{{ asset($product_new->image) }}" width="300px" height="250px" alt="">
                                </a>
                            </div>
                        </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="blog-text text-box text-white">
                            <a href="{{ route('game.detail', $product_new->id) }}">
                                <h3>{{$product_new->name}}</h3>
                            </a>
                            <p>{{$product_new->short_des}}</p>
                            <a href="{{ route('game.detail', $product_new->id) }}" class="read-more">{{__('Detail')}}  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
                        </div>
                    </div>
                    @empty
                    <!-- Blog item -->
                    <div class="blog-item">
                        <div class="blog-thumb">
                            <img src="{{ asset('endgame/img/blog/1.jpg') }}" alt="">
                        </div>
                        <div class="blog-text text-box text-white">
                            <div class="top-meta">11.11.18  /  in <a href="#">Games</a></div>
                            <h3>The best online game is out now!</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eius-mod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Lorem ipsum dolor sit amet, consecte-tur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.....</p>
                            <a href="{{ route('games', 'all') }}" class="read-more">Read More  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
                        </div>
                    </div>
                    <!-- Blog item -->
                    <div class="blog-item">
                        <div class="blog-thumb">
                            <img src="{{ asset('endgame/img/blog/2.jpg') }}" alt="">
                        </div>
                        <div class="blog-text text-box text-white">
                            <div class="top-meta">11.11.18  /  in <a href="#">Games</a></div>
                            <h3>The best online game is out now!</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eius-mod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Lorem ipsum dolor sit amet, consecte-tur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.....</p>
                            <a href="{{ route('games', 'all') }}" class="read-more">Read More  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
                        </div>
                    </div>
                    <!-- Blog item -->
                    <div class="blog-item">
                        <div class="blog-thumb">
                            <img src="{{ asset('endgame/img/blog/3.jpg') }}" alt="">
                        </div>
                        <div class="blog-text text-box text-white">
                            <div class="top-meta">11.11.18  /  in <a href="#">Games</a></div>
                            <h3>The best online game is out now!</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eius-mod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Lorem ipsum dolor sit amet, consecte-tur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.....</p>
                            <a href="{{ route('games', 'all') }}" class="read-more">Read More  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-5 sidebar">
                <div id="stickySidebar">
                    <div class="widget-item">
                        <h4 class="widget-title" style="margin-bottom: 30px;">{{__('More views')}}</h4>
                        <div class="trending-widget">
                        @foreach ($more_views as $view)
                        <div class="d-flex mt-4 ml-4 mr-4 mb-2">
                            <div class="flex-shrink-0">
                                <div class="image">
                                    <a href="{{ route('game.detail', $view->id) }}">
                                        <img src="{{ asset($view->image) }}" style="width:80px; height:80px" alt="#">
                                    </a>
                                </div>
                            </div>&nbsp;&nbsp;&nbsp;
                            <div class="tw-text">
                                <a href="{{ route('game.detail', $view->id) }}">
                                    <h6 style="color: #fff">{{$view->name.' - '.$view->os_supported}}</h6>
                                </a>
                                <div class="tw-meta"><i class="fa fa-eye" aria-hidden="true"></i> <a href="javascript:0">{{$view->views}}</a></div>
                            </div>
                        </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog section end -->


<!-- Intro section -->
<section class="intro-video-section set-bg d-flex align-items-end " data-setbg="{{ asset('endgame/img/promo-bg.jpg') }}">
    <a href="https://www.youtube.com/watch?v=uFsGy5x_fyQ" class="video-play-btn video-popup"><img src="{{ asset('endgame/img/icons/solid-right-arrow.png') }}" alt="#"></a>
    <div class="container">
        <div class="video-text">
            <h2>{{ __('video of the game') }}</h2>
        </div>
    </div>
</section>
<!-- Intro section end -->
@endsection
@section('script')
<script src="{{asset('js/index.js')}}"></script>
@endsection
