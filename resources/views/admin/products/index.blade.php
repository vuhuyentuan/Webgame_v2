@extends('layout_admin.master')
@section('title')
    <title>{{ __('Games') }}</title>
@endsection
@section('style')
<style>
.select2-container .select2-selection--single{
    height: 38px;
}
.modal-overflow {
   overflow-y: scroll;
   height: 70vh;
}
</style>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{ __('List games') }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('List games ') }}</li>
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
                            <button type="button" class="btn btn-primary add_game" data-container=".product_modal"
                            data-href="{{ route('products.create') }}"><i class="fa fa-plus"></i> {{ __('Add game') }}</button>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="product_table" class="table table-bordered table-hover ajax_view">
                    <thead>
                        <tr>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Name game') }}</th>
                            <th>{{ __('Type game') }}</th>
                            <th>{{ __('Support system') }}</th>
                            <th>{{ __('Featured') }}</th>
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
    </div><!-- /.container-fluid -->
    <div class="modal fade product_modal" id="product_modal" tabindex="-1" role="dialog"></div>
    <div class="modal fade package_modal" id="package_modal" tabindex="-1" role="dialog"></div>
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
            product_table.search($(this).val()).draw();
        }, 500);
    });

    var product_table = $('#product_table').DataTable({
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
            url: "{{ route('products.index') }}",
        },
        order: [],
        "columns":[
            {"data": "image", orderable: false , class: 'text-center'},
            {"data": "name" },
            {"data": "type" },
            {"data": "os_supported"},
            {"data": "featured", class: 'bg-row-child'},
            {"data": "action", orderable: false}
        ]
    });

    $(document).on('click', '.add_game', function(e) {
        e.preventDefault();
        $('div.product_modal').load($(this).attr('data-href'), function() {
            $(this).modal('show');
        });
    });

    $(document).on('click', '.edit_game', function(e) {
        e.preventDefault();
        $('div.product_modal').load($(this).attr('data-href'), function() {
            $(this).modal('show');
        });
    });

    $('.package_modal').on('shown.bs.modal', function (e) {
        function formatNumber(num) {
            var n = Number(num.replace(/,/g, ''));
            return n.toLocaleString("en");
        }
        $('.price').on('keyup', function() {
            var num = $(this).val().replace(/[^0-9]+/i, '');

            if (num != '') {
                let money = formatNumber(num);

                $(this).val(money)
            } else {
                $(this).val(0)
            }
        });
    })

     // delete
     $(document).on('click', '.delete_game', function(e) {
        let name = $(this).data('name');
        let url = $(this).data('href');
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
                method: "DELETE",
                url: url,
                data: {
                    url: window.location.href
                },
                dataType: "json",
                success: function(result) {
                    if (result.success == true) {
                        toastr.success(result.msg);
                    }else{
                        toastr.error(result.msg);
                    }
                    product_table.ajax.reload(null, false);
                }
            })
        }
        });
    });

    $(document).on('click', '#product_table tbody tr td:not(:last-child, .bg-row-child)', function() {
        var tr = $(this).closest('tr');
        var row = $('#product_table').DataTable().row(tr);
        if (row.child.isShown()) {
            $('div.slide', row.child()).slideUp(function() {
                tr.removeClass('bg-row');

                row.child.hide();
            });

        } else {
            $('tr.bg-row').removeClass('bg-row');
            $('#product_table').DataTable().rows().every(function() {
                var rows = this;
                if (rows.child.isShown()) {
                    rows.child.hide();
                }
            });
            tr.addClass('bg-row');

            row.child(getPackage(row.data()), 'no-padding bg-row-child').show();
            $('div.slide', row.child()).slideDown("fast");
        }

    });

    function getPackage(rowData) {
        var div = $('<div class="slide"/>')
            .addClass('loading')
            .text('Loading...');
        $.ajax({
            url: "{{ route('products.showPackage') }}",
            data: {
                id: rowData.id
            },
            dataType: 'html',
            success: function(data) {
                div.html(data).removeClass('loading');
                $('.bg-row-child').attr('data-id', rowData.id)
            },
        });

        return div;
    }

    $(document).on('click','.check_featured', function() {
        let url = $(this).data('href');
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
                product_table.ajax.reload(null, false);
            }
        })
    })
</script>
@endsection
