<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{__("Translate Manager for: :name",['name'=>$lang->name])}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
            <div class="modal-body">
                <div class="filter-div d-flex ">
                    <div class="col-left">
                        <form method="get" action="" class="filter-form filter-form-left d-flex justify-content-start flex-column flex-sm-row">
                            <select name="type" id="type" class="form-control">
                                <option value="">{{__("All text")}}</option>
                                <option @if(Request()->type == 'not_translated') selected @endif value="not_translated">{{__("Not translated")}}</option>
                                <option @if(Request()->type == 'translated') selected @endif value="translated">{{__("Translated")}}</option>
                            </select>
                            <select name="search_by" id="search_by" class="form-control" style="margin-left: 10px">
                                <option value="">{{__("Search By")}}</option>
                                <option @if(Request()->search_by == 'original_text') selected @endif value="original_text">{{__("Original Text")}}</option>
                                <option @if(Request()->search_by == 'translated_text') selected @endif value="translated_text">{{__("Translated Text")}}</option>
                            </select>
                            <input type="text" name="s" id="s" value="{{ Request()->s }}" placeholder="{{__('Search by key...')}}" class="form-control" style="margin-left: 10px">
                            <button class="btn-info btn btn-icon filter" style="margin-left: 10px" type="button">{{__('Filter')}}</button>
                        </form>
                    </div>
                </div>
                <form action="{{route('translations.update', $lang->id)}}" method="post" id="translate_form">
                @method('PUT')
                    <table class="table table-bordered table-hover" id="edit_trans_table">
                        <thead>
                        <tr>
                            {{-- <th width="50px"></th> --}}
                            <th width="50%">{{__("Origin")}}</th>
                            <th>{{__("Translated")}}</th>
                        </tr>
                        </thead>
                    </table>
                    <br>
                    <div class="text-center">
                        <button class="btn btn-primary"><i class="fa fa-save"></i> {{__('Save changes')}}</button>
                    </div>
                </form>
            </div>
    </div>
</div>
<script>
    var edit_trans_table = $('#edit_trans_table').DataTable({
        "destroy": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "pageLength": 25,
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
            url: "{{ route('translations.list-trans', $lang->id) }}",
            data: function(d) {
                d.search_by = $('#search_by').val();
                d.type = $('#type').val();
                d.s = $('#s').val();
            }
        },
        order: [],
        "columns":[
            // {"data": "action"},
            {"data": "string" },
            {"data": "translated" }
        ],
    });

    $(document).on('click', '.filter', function(e){
        edit_trans_table.ajax.reload();
    })

    $('form#translate_form').submit(function(e) {
        e.preventDefault();
        let data = new FormData($('#translate_form')[0]);
        $.ajax({
            method: 'POST',
            url: $(this).attr('action'),
            dataType: 'json',
            data: data,
            contentType: false,
            processData: false,
            success: function(result) {
                if (result.success == true) {
                    toastr.success(result.msg);
                    if (typeof($('#edit_trans_table').DataTable()) != 'undefined') {
                        $('#edit_trans_table').DataTable().ajax.reload(null, false);
                    }
                } else {
                    toastr.error(result.msg);
                }
            }
        });
    });
</script>
