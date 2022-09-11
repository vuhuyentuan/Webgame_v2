<table id="statistical_table" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th style="text-align: center; ">{{ __('Date') }}</th>
            <th style="text-align: center; ">{{ __('Turnover') }}</th>
        </tr>
    </thead>
    <tbody id="statistical_content">
        @for ($i = 0; $i < count($arrRevenueMonthDone); $i++)
            <tr role="row">
                <td style="text-align: center">
                    <h6>{{ date('d/m/Y', strtotime($dates[$i])) }}</h6>
                </td>
                <td style="text-align: center">
                    <h6>{{ $arrRevenueMonthDone[$i] }} $</h6>
                </td>
            </tr>
        @endfor
    </tbody>
</table>
<script>
    $(document).ready(function(){
        $('#statistical_table').DataTable({
            "destroy": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 15,
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
        });
    })
</script>
