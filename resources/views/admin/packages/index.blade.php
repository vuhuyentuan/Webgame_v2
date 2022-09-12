<div class="row">
    <div class="col-lg-12 group-btn">
        <div class="row">
            <div class="input-group col-lg-4">
            </div>
            <div class="col-lg-8 group-btn text-right">
                <button type="button" class="btn btn-primary add_package" data-container=".package_modal"
                data-href="{{ route('packages.create') }}"><i class="fa fa-plus"></i> {{ __('Add package') }}</button>
            </div>
        </div>
    </div>
    <div class="col-lg-12" style="margin-top: 15px">
        <table id="package_table" class="table table-bordered table-hover">
          <thead>
            <tr>
                <th>{{ __('Image') }}</th>
                <th>{{ __('Package name') }}</th>
                <th>{{ __('Value') }}</th>
                <th>{{ __('Point') }}</th>
                <th width="15%">{{ __('Action') }}</th>
              </tr>
          </thead>
        </table>
    </div>
</div>
<script>
 $(document).ready(function (e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var package_table = $('#package_table').DataTable({
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
            url: "{{ route('packages.index') }}",
            data: function(d) {
                d.id = $('.bg-row-child').data('id');
            }
        },
        order: [],
        "columns":[
            {"data": "image", class: 'bg-row-child text-center' },
            {"data": "name", class: 'bg-row-child' },
            {"data": "value", class: 'bg-row-child' },
            {"data": "point", class: 'bg-row-child' },
            {"data": "action", class: 'bg-row-child', orderable: false}
        ]
    });

    $(document).on('click', '.add_package', function(e) {
        e.preventDefault();
        $('div.package_modal').load($(this).attr('data-href'), function() {
            $('#id_product').attr('value', $('.bg-row-child').data('id'));
            $(this).modal('show');
        });
    });

    $(document).on('click', '.edit_package', function(e) {
        e.preventDefault();
        $('div.package_modal').load($(this).attr('data-href'), function() {
            $(this).modal('show');
        });
    });

    // delete
    $(document).on('click', '.delete_package', function(e) {
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
                dataType: "json",
                success: function(result) {
                    if (result.success == true) {
                        toastr.success(result.msg);
                    }else{
                        toastr.error(result.msg);
                    }
                    package_table.ajax.reload(null, false);
                }
            })
        }
        });
    });
});
</script>
