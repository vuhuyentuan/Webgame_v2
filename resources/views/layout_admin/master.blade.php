<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @yield('title')
  <!-- Open Graph data -->
  <meta property="og:title" content="{{ $setting->seo_title }}">
  <meta property="og:type" content="Website">
  <meta property="og:url" content="{{ route('index') }}">
  <meta property="og:image:alt" content="{{ $setting->seo_description }}">
  <meta property="og:image" content="{{ $setting->logo }}">
  <meta property="og:description" content="{{ $setting->seo_description }}">
  <meta property="og:site_name" content="{{ $setting->seo_title }}">
  <meta property="article:section" content="{{ $setting->seo_description }}">
  <meta property="article:tag" content="{{ $setting->keywords }}">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" href="{{ asset($setting->favicon) }}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/summernote/summernote-bs4.min.css') }}">
  <!-- DataTable -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/select2/css/select2.min.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/toastr/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/jquery-ui/jquery-ui.min.css') }}">

  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/dist/flags/css/flag-icon.min.css') }}">
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/dist/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/dist/css/countrySelect.css') }}">
  @yield('style')
  <style>
    .justify-content-between{
        background: {{ $setting->main_color }}
    }
    @supports not (-webkit-touch-callout:none){
        .layout-fixed .wrapper .sidebar {
            height: calc(96vh - (3.5rem + 1px));
        }
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset($setting->favicon) }}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  @include('layout_admin.header')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('layout_admin.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  {{-- <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer> --}}
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  {{-- {!!$setting->javascript!!} --}}
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('AdminLTE-3.1.0/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('AdminLTE-3.1.0/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('AdminLTE-3.1.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('AdminLTE-3.1.0/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- DataTable -->
<script src="{{ asset('AdminLTE-3.1.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('AdminLTE-3.1.0/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('AdminLTE-3.1.0/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{ asset('AdminLTE-3.1.0/plugins/toastr/toastr.min.js')}}"></script>
<!-- jquery-validation -->
<script src="{{ asset('AdminLTE-3.1.0/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/jquery-validation/additional-methods.min.js')}}"></script>
<!-- File Input -->
{{-- <script src="{{ asset('js/fileinput.min.js')}}"></script> --}}
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('AdminLTE-3.1.0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('AdminLTE-3.1.0/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('AdminLTE-3.1.0/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE-3.1.0/dist/js/adminlte.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/dist/js/countrySelect.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/dist/js/clipboard.min.js') }}"></script>
@yield('script')
<script>

</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
        $('.nav-link.active').parent().parent().parent().addClass('menu-is-opening menu-open');
    });
    $("div.alert").delay(3000).slideUp();

    $(document).on('click', '.view', function(e) {
        e.preventDefault();
        $('div.view_modal').load($(this).attr('data-href'), function() {
            $(this).modal('show');
        });
    });

    function copyToClipboard(element) {
        navigator.clipboard.writeText(element);
        toastr.success("{{ __('Copied to clipboard') }}");
    }
</script>
</body>
</html>
