<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>{{ $setting->seo_title }}</title>
	<meta charset="UTF-8">
	<meta name="description" content="EndGam Gaming Magazine Template">
	<meta name="keywords" content="endGam,gGaming, magazine, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Favicon -->
	<link href="{{ asset($setting->favicon) }}" rel="shortcut icon"/>

    <meta property="og:title" content="{{ $setting->seo_title }}">
    <meta property="og:type" content="Website">
    <meta property="og:url" content="{{ route('index') }}">
    <meta property="og:image:alt" content="{{ $setting->seo_description }}">
    <meta property="og:image" content="{{ $setting->logo }}">
    <meta property="og:description" content="{{ $setting->seo_description }}">
    <meta property="og:site_name" content="{{ $setting->seo_title }}">
    <meta property="article:section" content="{{ $setting->seo_description }}">
    <meta property="article:tag" content="{{ $setting->keywords }}">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="{{ asset('endgame/css/bootstrap.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('endgame/css/font-awesome.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('endgame/css/slicknav.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/carousel/owl.carousel.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/carousel/owl.theme.default.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('endgame/css/magnific-popup.css') }}"/>
	<link rel="stylesheet" href="{{ asset('endgame/css/animate.css') }}"/>
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('AdminLTE-3.1.0/plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/jquery-ui/jquery-ui.min.css') }}">

	<!-- Main Stylesheets -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/dist/flags/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('endgame/css/style.css') }}"/>
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
    @yield('style')
</head>
<body>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>

	<!-- Header section -->
    @include('layout_index.header')
	<!-- Header section end -->


	<!-- Hero section -->
    @yield('content')

    <div class="modal fade" id="login_modal"></div>
    <div class="modal fade" id="register_modal"></div>
	<!-- Footer section -->
    @include('layout_index.footer')
	<!-- Footer section end -->

    {!!$setting->javascript!!}

	<!--====== Javascripts & Jquery ======-->

    <!-- jquery-validation -->
	<script src="{{ asset('endgame/js/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ asset('endgame/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('endgame/js/jquery.slicknav.min.js') }}"></script>
	<script src="{{ asset('endgame/js/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('endgame/js/jquery.sticky-sidebar.min.js') }}"></script>
	<script src="{{ asset('endgame/js/jquery.magnific-popup.min.js') }}"></script>
	<script src="{{ asset('endgame/js/main.js') }}"></script>
    <!-- jQuery -->
    <script src="{{ asset('AdminLTE-3.1.0/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <!-- Toastr -->
    <script src="{{ asset('AdminLTE-3.1.0/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{ asset('js/carousel/owl.carousel.js') }}"></script>
    <script>
        var required = "{{ __('This field is required') }}";
        var maxlength = "{{ __('190 characters limit') }}";
        var equalTo = "{{ __('Confirmation password is not correct') }}";
        var email = "{{ __('Incorrect email format') }}";
        var number = "{{ __('Only numbers can be entered') }}";
        var minlength = "{{ __('10 characters limit') }}";
        var minlength6 = "{{ __('6 characters limit') }}";
        var maxlength20 = "{{ __('20 characters limit') }}";
        var regex = "{{ __('Please do not enter spaces') }}";
        var register_successfully = "{{ __('Register successfully') }}";
        var login_successfully = "{{ __('Login successfully') }}";
        var logout = "{{ __('Logout') }}";
        var no_results_found = "{{ __('No results found') }}";
        var thanks = "{{ __('Thanks for subscribe') }}";

        $('#subscribe').submit(function(e){
            e.preventDefault();
            $('#subscribe')[0].reset();
            toastr.success(thanks)
        })

    </script>
    <script src="{{ asset('js/login.js') }}"></script>
    <script src="{{ asset('js/register.js') }}"></script>
    @yield('script')
	</body>
</html>
