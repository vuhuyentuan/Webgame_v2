@extends('layout_admin.master')
@section('title')
    <title>{{ __('Recharge history') }}</title>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{ __('Recharge history') }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Recharge history') }}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
  <!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="input-group col-lg-12">
                            <div class="col-lg-2">
                                <div class="form-inline">
                                    <div class="input-group" data-widget="sidebar-search">
                                    <input class="form-control" type="text" placeholder="{{ __('Search') }}" id="search-btn" class=" aria-label="Search">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group date" id="daterangepicker"
                                style="margin-left: 0px; padding-left: 0px;padding-right: 2px; margin-bottom: 3px">
                                <input class="form-control" name="date" id="date" data-date-format="yyyy-mm-dd" type="text"
                                value="{{ date('d/m/Y', strtotime($first_day)) . ' - ' . date('d/m/Y', strtotime($last_day)) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="recharge_history_table" class="table table-bordered table-hover ajax_view">
                    <thead>
                        <tr>
                            <th ></th>
                            <th >{{ __('Customer') }}</th>
                            <th >{{ __('Order code') }}</th>
                            <th >{{ __('Description') }}</th>
                            <th >{{ __('Points') }}</th>
                            <th >{{ __('Status') }}</th>
                            <th >{{ __('Date') }}</th>
                            <th >{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    </table>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('script')
<script>
    $(document).ready(function (e) {
        $('input[name="date"]').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            },
        });

        $(document).on('change', '#date', function(){
            recharge_history_table.ajax.reload();
        })

        var debounceTripDetail = null;
        $('#search-btn').on('input', function(){
            clearTimeout(debounceTripDetail);
            debounceTripDetail = setTimeout(() => {
                recharge_history_table.search($(this).val()).draw();
            }, 500);
        });
        var recharge_history_table =$('#recharge_history_table').DataTable({
            "destroy": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 15,
            aaSorting: [
                [0, 'desc']
            ],
            "pagingType": "full_numbers",
            "language": {
                "info": "{{ __('Show _START_ to _END_ of _TOTAL_ index') }}",
                "infoEmpty": "{{ __('Show 0 to 0 of 0 index') }}",
                "infoFiltered": '',
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "{{ __('Show _MENU_ index') }}",
                "loadingRecords": "{{ __('Loading...') }}",
                "processing": "{{ __('Processing...') }}",
                "emptyTable": "{{ __('Empty data') }}",
                "zeroRecords": "{{ __('No matching records found') }}",
                "search": "{{ __('Search') }}",
                "paginate": {
                    'first': '<i class="fa fa-angle-double-left"></i>',
                    'previous': '<i class="fa fa-angle-left" ></i>',
                    'next': '<i class="fa fa-angle-right" ></i>',
                    'last': '<i class="fa fa-angle-double-right"></i>'
                },
            },
            ajax: {
                url: "{{ route('admin.recharge_history') }}",
                data: function(d) {
                    var start = '';
                    var end = '';
                    if ($('#date').val()) {
                        start = $('#date')
                            .data('daterangepicker')
                            .startDate.format('YYYY-MM-DD');
                        end = $('#date')
                            .data('daterangepicker')
                            .endDate.format('YYYY-MM-DD');
                    }
                    d.start_date = start;
                    d.end_date = end;
                }
            },
            order: [],
            "columns":[
                {"data": "bills", class: 'text-center'},
                {"data": "avatar" },
                {"data": "order_id", class: 'text-center' },
                {"data": "description", class: 'text-center' },
                {"data": "point_purchase", class: 'text-center' },
                {"data": "status", class: 'text-center' },
                {"data": "created_at", class: 'text-center' },
                {"data": "action", class: 'text-center', orderable: false },
            ]
        });

        $(document).on('click', '.check_recharge', function(e){
            e.preventDefault();
            let order = $(this).data('order');
            let status = 'paid';
            Swal.fire({
                title: `{{ __('Do you want to browse :this order?', ['this'=> '${order}']) }}`,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                cancelButtonText: "{{ __('No') }}",
                confirmButtonText: "{{ __('Yes') }}",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        method: 'POST',
                        url: $(this).attr('data-href'),
                        dataType: 'json',
                        data: {
                            status: status
                        },
                        success: function(result) {
                            if (result.success == true) {
                                toastr.success(result.msg);
                                recharge_history_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        }
                    });
                }
            });
        })

        $(document).on('click', '.cancel_recharge', function(e){
            e.preventDefault();
            let order = $(this).data('order');
            let status = 'canceled';
            Swal.fire({
                title: `{{ __('Do you want to cancel :this order?', ['this'=> '${order}']) }}`,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                cancelButtonText: "{{ __('No') }}",
                confirmButtonText: "{{ __('Yes') }}",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        method: 'POST',
                        url: $(this).attr('data-href'),
                        dataType: 'json',
                        data: {
                            status: status
                        },
                        success: function(result) {
                            if (result.success == true) {
                                toastr.success(result.msg);
                                recharge_history_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        }
                    });
                }
            });
        })
    });
</script>
@endsection
