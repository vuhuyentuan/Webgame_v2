@extends('layout_admin.master')
@section('title')
    <title>{{ __('User') }}</title>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{ __('List user') }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('List user') }}</li>
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
                        <div class="col-lg-4">
                            <div class="form-inline">
                                <div class="input-group" data-widget="sidebar-search">
                                <input class="form-control form-control-sidebar" type="search" placeholder="{{ __('Search') }}" id="search-btn">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 group-btn text-right">
                            <button type="button" class="btn btn-primary add_user" data-container=".user_modal"
                            data-href="{{ route('users.create') }}"><i class="fa fa-plus"></i> {{ __('Add user') }}</button>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="user_table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('Avatar') }}</th>
                            <th>{{ __('Full name') }}</th>
                            <th>{{ __('Username') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Action') }}</th>
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
        <div class="modal fade user_modal" id="user_modal" tabindex="-1" role="dialog"></div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var debounceTripDetail = null;
    $('#search-btn').on('input', function(){
        clearTimeout(debounceTripDetail);
        debounceTripDetail = setTimeout(() => {
            users_table.search($(this).val()).draw();
        }, 500);
    });

    var users_table = $('#user_table').DataTable({
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
            url: "{{ route('users.index') }}",
        },
        order: [],
        "columns":[
            {"data": "avatar", orderable: false , class: 'text-center'},
            {"data": "name" },
            {"data": "username" },
            {"data": "email"},
            {"data": "phone" },
            {"data": "point" },
            {"data": "action", orderable: false}
        ],
    });

    $(document).on('click', '.add_user', function(e) {
        e.preventDefault();
        $('div.user_modal').load($(this).attr('data-href'), function() {
            $(this).modal('show');
        });
    });

    $(document).on('click', '.edit_user', function(e) {
        e.preventDefault();
        $('div.user_modal').load($(this).attr('data-href'), function() {
            $(this).modal('show');
        });
    });

    $('#user_modal').on('shown.bs.modal', function (e) {
        function formatNumber(num) {
            var n = Number(num.replace(/,/g, ''));
            return n.toLocaleString("en");
        }
        $('.amount').on('keyup', function() {
            var num = $(this).val().replace(/[^0-9]+/i, '');

            if (num != '') {
                let money = formatNumber(num);

                $(this).val(money)
            } else {
                $(this).val(0)
            }
        });
    })

    $(document).on('click', '.ban_user',function(e){
        let url = $(this).data('href');
        $.ajax({
            method: "POST",
            url: url,
            dataType: "json",
            success: function(result) {
                if (result.success == true) {
                    toastr.success(result.msg);
                    users_table.ajax.reload();
                }
            }
        })
    })

     // delete
     $(document).on('click', '.delete_user', function(e) {
        let name = $(this).data('name');
        var url = $(this).data('href');
        Swal.fire({
            title: `{{ __('Are you sure :name', ['name'=> '${name}']) }}`,
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            cancelButtonText: "{{ __('Cancel') }}",
            confirmButtonText: "{{ __('Delete') }}",
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    method: "GET",
                    url: url,
                    dataType: "json",
                    success: function(result) {
                        if (result.success == true) {
                            toastr.success(result.msg);
                        }else{
                            toastr.error(result.msg);
                        }
                        users_table.ajax.reload();
                    }
                })
            }
        });
    });
</script>
@endsection
