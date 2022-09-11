<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>EndGame - Gaming Magazine Template</title>
	<meta charset="UTF-8">
	<meta name="description" content="EndGam Gaming Magazine Template">
	<meta name="keywords" content="endGam,gGaming, magazine, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Favicon -->
	<link href="{{ asset($setting->favicon) }}" rel="shortcut icon"/>

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i,900,900i" rel="stylesheet">


	<!-- Stylesheets -->
	<link rel="stylesheet" href="{{ asset('endgame/css/bootstrap.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('endgame/css/font-awesome.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('endgame/css/slicknav.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('endgame/css/owl.carousel.min.css') }}"/>
	<link rel="stylesheet" href="{{ asset('endgame/css/magnific-popup.css') }}"/>
	<link rel="stylesheet" href="{{ asset('endgame/css/animate.css') }}"/>

	<!-- Main Stylesheets -->
	<link rel="stylesheet" href="{{ asset('endgame/css/style.css') }}"/>


	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

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

	<!-- Footer section -->
    @include('layout_index.footer')
	<!-- Footer section end -->


	<!--====== Javascripts & Jquery ======-->
	<script src="{{ asset('endgame/js/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ asset('endgame/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('endgame/js/jquery.slicknav.min.js') }}"></script>
	<script src="{{ asset('endgame/js/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('endgame/js/jquery.sticky-sidebar.min.js') }}"></script>
	<script src="{{ asset('endgame/js/jquery.magnific-popup.min.js') }}"></script>
	<script src="{{ asset('endgame/js/main.js') }}"></script>
    <!-- jQuery -->
    <script src="{{ asset('AdminLTE-3.1.0/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.1.0/plugins/jquery-validation/jquery.validate.min.js')}}"></script>

	</body>
</html>
