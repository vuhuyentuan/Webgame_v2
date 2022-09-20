@extends('layout_index.master')
@section('style')
<style>
    .row.vertical-gap {
        margin-top: -30px;
    }
    .row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }
    .nk-feature-1, .nk-feature-2 {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        width: 100%;
        min-height: 50px;
        padding: 10px;
        background-color: #081624;
        border: 1px solid #081624;
        border-radius: 4px;
    }
    .nk-feature-1 .nk-feature-icon, .nk-feature-2 .nk-feature-icon {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        width: 116px;
        height: 50px;
        padding-right: 10px;
        font-size: 3rem;
        line-height: 50px;
        color: #fff;
        text-align: center;
        border-right: 1px solid #293139;
        border-radius: 3px;
    }
    .nk-feature-1 .nk-feature-cont, .nk-feature-2 .nk-feature-cont {
        padding-top: 8px;
        padding-left: 38px;
    }
    .nk-feature-title {
        margin-bottom: 0.5rem;
        font-size: 1.25rem;
    }
    .nk-feature-title {
        margin-bottom: 0.5rem;
        font-size: 1.25rem;
    }
    .text-main-2 {
        color: #fff;
    }
    .text-main-1 {
        color: #dd163b;
    }
    h3{
        text-transform: uppercase;
    }
</style>
@endsection
@section('content')
<!-- Page top section -->
<section class="page-top-section set-bg" data-setbg="{{ asset('endgame/img/page-top-bg/1.jpg') }}">
    <div class="page-info">
        <h2>{{ __('Games') }}</h2>
        <div class="site-breadcrumb">
            <a href="#">{{ __('Home') }}</a>  /
            <span>{{ __('Games') }}</span>
        </div>
    </div>
</section>
<!-- Page top end-->
<!-- Games section -->
<section class="games-section">
    <div class="container">
        <div class="row vertical-gap">
            <div class="col-lg-3">
                <div class="nk-feature-1">
                    <div class="nk-feature-icon" style="width:70px">
                        <img src="{{ asset('images/card-itunes.png') }}" alt="">
                    </div>
                    <div class="nk-feature-cont">
                        <h3 class="nk-feature-title"><a class="text-main-2" href="{{ route('games', 'Card') }}">Card</a></h3>
                        <h4 class="nk-feature-title"><a class="text-main-1" href="{{ route('games', 'Card') }}">View Card</a></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="nk-feature-1">
                    <div class="nk-feature-icon" style="width:70px">
                        <img src="{{ asset('images/android.png') }}" alt="">
                    </div>
                    <div class="nk-feature-cont">
                        <h3 class="nk-feature-title"><a class="text-main-2" href="{{ route('games', 'Android') }}">ANDROID</a></h3>
                        <h4 class="nk-feature-title"><a class="text-main-1" href="{{ route('games', 'Android') }}">View Games</a></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="nk-feature-1">
                    <div class="nk-feature-icon" style="width:70px">
                        <img src="{{ asset('images/ios.png') }}" alt="">
                    </div>
                    <div class="nk-feature-cont">
                        <h3 class="nk-feature-title"><a class="text-main-2" href="{{ route('games', 'IOS') }}">IOS</a></h3>
                        <h4 class="nk-feature-title"><a class="text-main-1" href="{{ route('games', 'IOS') }}">View Games</a></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="nk-feature-1">
                    <div class="nk-feature-icon" style="width:70px">
                        <img src="{{ asset('images/wallet.png') }}" alt="">
                    </div>
                    <div class="nk-feature-cont">
                        <h3 class="nk-feature-title"><a class="text-main-2" href="{{ route('games', 'Wallet') }}">Wallet  IOS</a></h3>
                        <h4 class="nk-feature-title"><a class="text-main-1" href="{{ route('games', 'Wallet') }}">View Games</a></h4>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-xl-9 col-lg-8 col-md-9">
                <form action="{{ route('search', $type) }}" method="get"  class="search-widget">
                    <input type="text" name="search" placeholder="{{ __('Search') }}" value="{{ request()->search }}">
                    <button>{{ __('Search') }}</button>
                </form>
                <br>
                <div class="row">
                    @if (count($products) != 0)
                        @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6">
                            <div class="game-item">
                                <a href="{{ route('game.detail', $product->id) }}">
                                    <img src="{{ asset($product->image) }}" style="width: 100%; height: 250px">
                                </a>
                                <a href="{{ route('game.detail', $product->id) }}">
                                    <h5>{{ $product->name.' - '.$product->os_supported }}</h5>
                                </a>
                                <p>{{ $product->short_des }}</p>
                                <a href="{{ route('game.detail', $product->id) }}" style="color: #fff">{{ __('Order') }} <img src="{{ asset('endgame/img/icons/double-arrow.png') }}" alt="#"/></a>
                                <div class="nk-post-date float-right">
                                    <svg class="svg-inline--fa fa-calendar-alt fa-w-14" aria-hidden="true" data-prefix="fa" data-icon="calendar-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M436 160H12c-6.6 0-12-5.4-12-12v-36c0-26.5 21.5-48 48-48h48V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h128V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h48c26.5 0 48 21.5 48 48v36c0 6.6-5.4 12-12 12zM12 192h424c6.6 0 12 5.4 12 12v260c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V204c0-6.6 5.4-12 12-12zm116 204c0-6.6-5.4-12-12-12H76c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12v-40zm0-128c0-6.6-5.4-12-12-12H76c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12v-40zm128 128c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12v-40zm0-128c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12v-40zm128 128c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12v-40zm0-128c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12v-40z"></path></svg>
                                    {{ date('d-m-Y', strtotime($product->created_at)) }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="col-xl-9 col-lg-8 col-md-9">
                        <div class="game-item">
                            <h5 >{{ __('No results found') }}</h5>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="site-pagination">
                    {{ $products->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-5 sidebar game-page-sideber">
                <div id="stickySidebar">
                    <div class="widget-item">
                        <h4 class="widget-title" style="margin-bottom: 30px;">{{__('More views')}}</h4>
                        <div class="trending-widget">
                            @foreach ($more_views as $view)
                            <div class="d-flex mt-4 ml-4 mr-4 mb-2">
                                <a href="{{ route('game.detail', $view->id) }}">
                                    <div class="flex-shrink-0">
                                        <div class="image">
                                            <img src="{{ asset($view->image) }}" style="width:80px; height:80px" alt="#">
                                        </div>
                                    </div>
                                </a>&nbsp;&nbsp;&nbsp;
                                <div class="tw-text">
                                    <a href="{{ route('game.detail', $view->id) }}">
                                        <h5>{{$view->name}}</h5>
                                    </a>
                                    <div class="tw-meta"><i class="fa fa-eye" aria-hidden="true"></i> <a href="#">{{$view->views}}</a></div>
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
<!-- Games end-->
@endsection
