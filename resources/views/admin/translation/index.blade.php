@extends('layout_admin.master')
@section('title')
    <title>{{ __('Translation') }}</title>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{ __('List translation') }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <div class="row">
                <div class="col-lg-12 group-btn text-right">
                    <a data-href="{{ route('translations.loadStrings') }}" class="btn btn-primary load_strings"><i class="fa fa-plus"></i> {{ __('Find translations') }}</a>
                </div>
            </div>
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
                    <div class="card-header d-flex justify-content-between" style="background-color: #fff3cd; border-color: #ffeeba">
                        <div class="header-title">
                            <h5 class="card-title">{{__("After translation. You must re-build language file to apply the change")}}</h5>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="transale_table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Percent') }}</th>
                                    <th>{{ __('Translated') }}</th>
                                    <th>{{ __('Last build at') }}</th>
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
        <div class="modal fade translate_modal" id="translate_modal" tabindex="-1" role="dialog"></div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@section('script')
<script>
    var transale_table = $('#transale_table').DataTable({
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
            url: "{{ route('translations.index') }}",
        },
        order: [],
        "columns":[
            {"data": "flag"},
            {"data": "percent" },
            {"data": "translated" },
            {"data": "last_build_at" },
            {"data": "action", orderable: false}
        ],
    });

    $(document).on('click', '.edit_translation', function(e) {
        e.preventDefault();
        $('div.translate_modal').load($(this).attr('data-href'), function() {
            $(this).modal('show');
        });
    });


    $('.load_strings').click(function(e){
        e.preventDefault();
        $.ajax({
            method: 'GET',
            url: $(this).attr('data-href'),
            dataType: 'json',
            success: function(result) {
                if (result.success == true) {
                    toastr.success(result.msg);
                    if (typeof($('#transale_table').DataTable()) != 'undefined') {
                        $('#transale_table').DataTable().ajax.reload();
                    }
                } else {
                    toastr.error(result.msg);
                }
            }
        });
    })
    $(document).on('click', '.build', function(e) {
        e.preventDefault();
        $.ajax({
            method: 'GET',
            url: $(this).attr('data-href'),
            dataType: 'json',
            success: function(result) {
                if (result.success == true) {
                    toastr.success(result.msg);
                    if (typeof($('#transale_table').DataTable()) != 'undefined') {
                        $('#transale_table').DataTable().ajax.reload();
                    }
                } else {
                    toastr.error(result.msg);
                }
            }
        });
    })
</script>
@endsection
