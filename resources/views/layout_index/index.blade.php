@extends('layout_index.master')
@section('content')
<section class="hero-section overflow-hidden">
    <div class="hero-slider owl-carousel">
        @foreach ($slides as $slide)
        <div class="hero-item set-bg d-flex align-items-center justify-content-center text-center" data-setbg="{{ asset($slide->images) }}">
            <div class="container">
                <h2 style="font-size: 80px">{{$slide->name}}</h2>
                <p class="text-white">{!! $slide->description !!}</p>
                <a href="#" class="site-btn">{{__('Read More')}}  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
            </div>
        </div>
        @endforeach
    </div>
</section>
<!-- Hero section end-->


<!-- Intro section -->
<section class="intro-section">
    <div class="container">
        <div class="row">
            @forelse ($product_featured as $product)
            <div class="col-md-4">
                <div class="intro-text-box text-box text-white">
                    <div class="top-meta"><a href="">{{$product->type}}</a></div>
                    <h3>{{$product->name}}</h3>
                    <p>{{$product->short_des}}</p>
                    <a href="#" class="read-more">{{__('Read More')}}  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
                </div>
            </div>
            @empty
            <div class="col-md-4">
                <div class="intro-text-box text-box text-white">
                    <div class="top-meta">11.11.18  /  in <a href="">Games</a></div>
                    <h3>The best online game is out now!</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida....</p>
                    <a href="#" class="read-more">Read More  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="intro-text-box text-box text-white">
                    <div class="top-meta">11.11.18  /  in <a href="">Playstation</a></div>
                    <h3>Top 5 best games in november</h3>
                    <p>Ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum  labore suspendisse ultrices gravida....</p>
                    <a href="#" class="read-more">Read More  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="intro-text-box text-box text-white">
                    <div class="top-meta">11.11.18  /  in <a href="">Reviews</a></div>
                    <h3>Get this game at a promo price</h3>
                    <p>Sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida ncididunt ut labore ....</p>
                    <a href="#" class="read-more">Read More  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
                </div>
            </div>
            @endforelse
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
                    <li><a class="support_system" data-system="Android" href="javascript:(0)">{{__('Android')}}</a></li>
                    <li><a class="support_system" data-system="IOS" href="javascript:(0)">{{__('IOS')}}</a></li>
                    <li><a class="support_system" data-system="Wallet" href="javascript:(0)">{{__('Wallet')}}</a></li>
                    <li><a class="support_system" data-system="Card" href="javascript:(0)">{{__('Card')}}</a></li>
                </ul>
                <div id="product_new_content">
                    @forelse ($product_news as $product_new)
                    <div class="blog-item">
                        <div class="blog-thumb">
                            <img src="{{ asset($product_new->image) }}" alt="">
                        </div>
                        <div class="blog-text text-box text-white">
                            <h3>{{$product_new->name}}</h3>
                            <p>{{$product_new->short_des}}</p>
                            <a href="#" class="read-more">{{__('Read More')}}  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
                        </div>
                    </div>
                    @empty
                    <!-- Blog item -->
                    <div class="blog-item">
                        <div class="blog-thumb">
                            <img src="{{ asset('endgame/img/blog/1.jpg') }}" alt="">
                        </div>
                        <div class="blog-text text-box text-white">
                            <div class="top-meta">11.11.18  /  in <a href="">Games</a></div>
                            <h3>The best online game is out now!</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eius-mod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Lorem ipsum dolor sit amet, consecte-tur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.....</p>
                            <a href="#" class="read-more">Read More  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
                        </div>
                    </div>
                    <!-- Blog item -->
                    <div class="blog-item">
                        <div class="blog-thumb">
                            <img src="{{ asset('endgame/img/blog/2.jpg') }}" alt="">
                        </div>
                        <div class="blog-text text-box text-white">
                            <div class="top-meta">11.11.18  /  in <a href="">Games</a></div>
                            <h3>The best online game is out now!</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eius-mod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Lorem ipsum dolor sit amet, consecte-tur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.....</p>
                            <a href="#" class="read-more">Read More  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
                        </div>
                    </div>
                    <!-- Blog item -->
                    <div class="blog-item">
                        <div class="blog-thumb">
                            <img src="{{ asset('endgame/img/blog/3.jpg') }}" alt="">
                        </div>
                        <div class="blog-text text-box text-white">
                            <div class="top-meta">11.11.18  /  in <a href="">Games</a></div>
                            <h3>The best online game is out now!</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eius-mod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Lorem ipsum dolor sit amet, consecte-tur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.....</p>
                            <a href="#" class="read-more">Read More  <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-5 sidebar">
                <div id="stickySidebar">
                    <div class="widget-item" style="margin-bottom: 35px;">
                        <div class="categories-widget" style="padding: 25px 0 25px;">
                            <h4 class="widget-title">categories</h4>
                            <ul>
                                <li><a href="">Games</a></li>
                                <li><a href="">Card</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="widget-item">
                        <h4 class="widget-title" style="margin-bottom: 30px;">{{__('More views')}}</h4>
                        <div class="trending-widget">
                        @forelse ($more_views as $view)
                        <div class="tw-item" style="margin-bottom: 20px;">
                            <div class="tw-thumb" style="margin-right: 0px;">
                                <img src="{{ asset($view->image) }}" style="width:300px; height:150px" alt="#">
                            </div>
                            <div class="tw-text">
                                <h5>{{$view->name}}</h5>
                                <div class="tw-meta"><i class="fa fa-eye" aria-hidden="true"></i> <a href="">{{$view->views}}</a></div>
                            </div>
                        </div>
                        @empty
                        <div class="tw-item">
                            <div class="tw-thumb">
                                <img src="{{ asset('endgame/img/blog-widget/1.jpg') }}" alt="#">
                            </div>
                            <div class="tw-text">
                                <div class="tw-meta">11.11.18  /  in <a href="">Games</a></div>
                                <h5>The best online game is out now!</h5>
                            </div>
                        </div>
                        <div class="tw-item">
                            <div class="tw-thumb">
                                <img src="{{ asset('endgame/img/blog-widget/2.jpg') }}" alt="#">
                            </div>
                            <div class="tw-text">
                                <div class="tw-meta">11.11.18  /  in <a href="">Games</a></div>
                                <h5>The best online game is out now!</h5>
                            </div>
                        </div>
                        <div class="tw-item">
                            <div class="tw-thumb">
                                <img src="{{ asset('endgame/img/blog-widget/3.jpg') }}" alt="#">
                            </div>
                            <div class="tw-text">
                                <div class="tw-meta">11.11.18  /  in <a href="">Games</a></div>
                                <h5>The best online game is out now!</h5>
                            </div>
                        </div>
                        <div class="tw-item">
                            <div class="tw-thumb">
                                <img src="{{ asset('endgame/img/blog-widget/4.jpg') }}" alt="#">
                            </div>
                            <div class="tw-text">
                                <div class="tw-meta">11.11.18  /  in <a href="">Games</a></div>
                                <h5>The best online game is out now!</h5>
                            </div>
                        </div>
                        @endforelse
                        </div>
                    </div>

                    {{-- <div class="widget-item">
                        <a href="#" class="add">
                            <img src="{{ asset('endgame/img/add.jpg') }}" alt="">
                        </a>
                    </div> --}}
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
            <h2>Promo video of the game</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
        </div>
    </div>
</section>
<!-- Intro section end -->
@endsection
@section('script')
<script src="{{asset('js/index.js')}}"></script>
@endsection
