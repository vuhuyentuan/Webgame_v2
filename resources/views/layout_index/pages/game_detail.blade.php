@extends('layout_index.master')
@section('style')
    <style>
        h1, h2, h3, h4, h5, h6, p {
            color: #fff !important;
        }
    </style>
@endsection
@section('content')
<!-- Page top section -->
<section class="page-top-section set-bg" data-setbg="{{ asset('endgame/img/page-top-bg/1.jpg') }}">
    <div class="page-info">
        <h2>{{ __('Game detail') }}</h2>
        <div class="site-breadcrumb">
            <a href="#">{{ __('Home') }}</a>  /
            <span>{{ __('Game detail') }}</span>
        </div>
    </div>
</section>
<!-- Page top end-->
	<!-- Games section -->
	<section class="games-single-page">
		<div class="container">
			<div class="game-single-preview">
				<img src="{{ asset($game_detail->image_detail) }}" alt="" width="100%" height="500px">
			</div>
            <center style="margin-top: -7%">
                <h2 style="color: #fff">{{ __('Package game') }}</h2>
                <br>
                <div class="col-xl-9 order-1 order-lg-2 contact-text text-white">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">{{ __('Package Image') }}</th>
                                    <th scope="col">{{ __('Package Name') }}</th>
                                    <th scope="col">{{ __('Value') }}</th>
                                    <th scope="col">{{ __('Point') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($game_detail->package))
                                    @foreach ($game_detail->package as $package)
                                    <tr scope="row" class="text-center">
                                        <td>
                                            <img src="{{asset($package->image ? $package->image : 'images/no_img.jpg' )}}" class="popup" width="40px" height="40px" />
                                        </td>
                                        <td>{{ $package->name }}</a></td>
                                        <td>{{ $package->value }}</a></td>
                                        <td>{{ number_format($package->point) }} {{ __('Point') }}</a></td>
                                        <td><a href="{{ route('checkout', $package->id) }}" id="detail" class="btn btn-hover">{{ __('Order') }}</a></td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </center>
            <br>
			<div class="row">
				<div class="col-xl-9 col-lg-8 col-md-7 game-single-content">
					<div class="gs-meta">
                        <div class="nk-post-date float-left">
                            <svg class="svg-inline--fa fa-calendar-alt fa-w-14" aria-hidden="true" data-prefix="fa" data-icon="calendar-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M436 160H12c-6.6 0-12-5.4-12-12v-36c0-26.5 21.5-48 48-48h48V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h128V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h48c26.5 0 48 21.5 48 48v36c0 6.6-5.4 12-12 12zM12 192h424c6.6 0 12 5.4 12 12v260c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V204c0-6.6 5.4-12 12-12zm116 204c0-6.6-5.4-12-12-12H76c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12v-40zm0-128c0-6.6-5.4-12-12-12H76c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12v-40zm128 128c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12v-40zm0-128c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12v-40zm128 128c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12v-40zm0-128c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12v-40z"></path></svg>
                        </div>
                        {{ date('d-m-Y', strtotime($game_detail->created_at)) }}
                    </div>
					<h2 class="gs-title">{{ $game_detail->name }}</h2>
                    {!! $game_detail->description !!}
					<div class="geme-social-share pt-5 d-flex">
						<p>{{ __('Share') }}:</p>
						<a href="#"><i class="fa fa-pinterest"></i></a>
						<a href="#"><i class="fa fa-facebook"></i></a>
						<a href="#"><i class="fa fa-twitter"></i></a>
						<a href="#"><i class="fa fa-dribbble"></i></a>
						<a href="#"><i class="fa fa-behance"></i></a>
					</div>
				</div>
				<div class="col-xl-3 col-lg-4 col-md-5 sidebar game-page-sideber">
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
