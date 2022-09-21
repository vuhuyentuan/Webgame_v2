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
            <div class="row">
                @foreach ($contacts as $contact)
                    <div class="col-lg-4 text-center">
                        <span class="avatar avatar-md mb-3">
                            <a href="{{ $contact->link ? $contact->link : '#' }}" target="_blank"><img src="{{ asset($contact->image ? $contact->image : 'images/no_img.jpg') }}" style="height: 200px; width: 200px"
                                class="rounded-circle"></a>
                        </span><br>
                        <div style="margin-top: 20px">
                            <a href="{{ $contact->link ? $contact->link : '#' }}" target="_blank" class="mb-0" style="text-align: center; color: #ff1aef">{{ $contact->name  }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
		</div>
	</section>
	<!-- Games end-->
    <!-- Contact page -->
	<section class="contact-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-7 order-2 order-lg-1">
					<div class="map">
                        {!! $setting->contacts ? json_decode($setting->contacts)->map : '' !!}
                    </div>
				</div>
				<div class="col-lg-5 order-1 order-lg-2 contact-text text-white">
					<h3>{{ __('Contact with us') }}</h3>
                    <p>{{ __('If you have any questions, please feel free to contact us.') }}</p>
					<div class="cont-info">
						<div class="ci-icon"><img src="{{ asset('endgame/img/icons/location.png') }}" alt=""></div>
						<div class="ci-text">{{ $setting->contacts ? json_decode($setting->contacts)->address : '' }}</div>
					</div>
					<div class="cont-info">
						<div class="ci-icon"><img src="{{ asset('endgame/img/icons/phone.png') }}" alt=""></div>
						<div class="ci-text">{{ $setting->contacts ? json_decode($setting->contacts)->phone : '' }}</div>
					</div>
					<div class="cont-info">
						<div class="ci-icon"><img src="{{ asset('endgame/img/icons/mail.png') }}" alt=""></div>
						<div class="ci-text">{{ $setting->contacts ? json_decode($setting->contacts)->email : '' }}
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Contact page end-->
</div>
@endsection
