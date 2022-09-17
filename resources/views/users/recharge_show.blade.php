<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>EndGame - Gaming Magazine Template</title>
	<meta charset="UTF-8">
	<meta name="description" content="EndGam Gaming Magazine Template">
	<meta name="keywords" content="endGam,gGaming, magazine, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('AdminLTE-3.1.0/plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/jquery-ui/jquery-ui.min.css') }}">

	<!-- Main Stylesheets -->
	<link rel="stylesheet" href="{{ asset('endgame/css/style.css') }}"/>
    <style>
        .invoice {
            max-width: 1200px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgb(0 0 0 / 15%);
            font-size: 16px;
            line-height: 24px;
            font-family: helvetica neue, helvetica, Helvetica, Arial, sans-serif;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <section class="content-header">
        </section>
        <section class="content" style="margin-top: 5em">
            <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                  <div class="col-12">
                    <h4>
                      <i class="fa fa-globe"></i> {{ $setting->logo_text }}
                      <small class="float-right">{{ __('Date') }}: {{ date('d/m/Y ', strtotime($recharge_show->created_at)) }}</small>
                    </h4>
                  </div>
                  <!-- /.col -->
                </div>
                <hr>
                <!-- info row -->
                <div class="row invoice-info">
                  <div class="col-sm-4 invoice-col">
                    {{ __('From') }}
                    <address>
                        <strong>{{ $admin->name }}</strong><br>
                        {{ __('Phone') }}: {{ $admin->phone }}<br>
                        {{ __('Email') }}: {{ $admin->email }}
                    </address>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 invoice-col">
                    {{ __('To') }}
                    <address>
                        <strong>{{ $recharge_show->user->name }}</strong><br>
                        {{ __('Phone') }}: {{ $recharge_show->user->phone }}<br>
                        {{ __('Email') }}: {{ isset($recharge_show->user->email) ? $recharge_show->user->email : '' }}
                    </address>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 invoice-col">
                    <b>{{ __('Invoice') }} #{{ $id }}</b><br>
                    <br>
                    <b>{{ __('Order code') }}:</b> {{ $recharge_show->order_id }}<br>
                    <b>{{ __('Payment Due') }}:</b> {{ date('d/m/Y ', strtotime($recharge_show->created_at)) }}<br>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                  <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Order code') }} #</th>
                                <th style="width: 25%">Description</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Point') }}</th>
                                <th>{{ __('Subtotal') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $recharge_show->order_id }}</td>
                                <td>{{ $recharge_show->description }}</td>
                                @if ($recharge_show->status == 'unpaid')
                                    <td><span class="badge badge-secondary">{{ __('Unpaid') }}</span></td>
                                @elseif ($recharge_show->status == 'paid')
                                    <td><span class="badge badge-success">{{ __('Paid') }}</span></td>
                                @elseif ($recharge_show->status == 'canceled')
                                    <td><span class="badge badge-danger">{{ __('Canceled') }}</span></td>
                                @endif
                                <td>{{ number_format($recharge_show->point_purchase) }} {{ __('Point') }}</td>
                                <td>{{ number_format($recharge_show->point_purchase) }} $</td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                  <!-- accepted payments column -->
                  <div class="col-6">
                    <p class="lead">{{ __('Payment Methods') }}</p>
                    @foreach ($banks as $bank)
                        <img src="{{ asset($bank->image) }}">
                    @endforeach
                  </div>
                  <!-- /.col -->
                  <div class="col-6">
                    <p class="lead">{{ __('Amount Due') }}</p>

                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">{{ __('Subtotal') }}</th>
                                <td>{{ number_format($recharge_show->point_purchase) }} $</td>
                            </tr>
                            <tr>
                                <th>{{ __('Tax') }}</th>
                                <td>0</td>
                            </tr>
                            <tr>
                                <th>{{ __('Shipping') }}</th>
                                <td>0</td>
                            </tr>
                            <tr>
                                <th>{{ __('Total') }}</th>
                                <td>{{ number_format($recharge_show->point_purchase) }} $</td>
                            </tr>
                        </table>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-12">
                      <a href="#" onclick="myFunction()" class="btn btn-default float-right"><i class="fa fa-print"></i> {{ __('Print') }}</a>
                    </div>
                  </div>
            </div>
            <!-- /.invoice -->
        </section>
    </div>
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
    <script type="text/javascript">
        function myFunction() {
            window.print();
        }
    </script>
	</body>
</html>
