{{-- Include Header --}}
@include('mis.header')

<div class="main-wrapper">
    {{-- Sidebar --}}
    @include('mis.Sidebar');

    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            {{-- Page Header --}}
            @include('mis.breadcum')

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <button type="button" class="btn btn-success" onclick="openNewWindow();">
                                Camp Report
                            </button>

                            <table id="campTable" class="display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Camp id</th>
                                        <th>Employee ID</th>
                                        <th>Educator Name</th>
                                        <th>Doctor Name</th>
                                        <th>In Time</th>
                                        <th>Out Time</th>
                                        <th>Remarks</th>
                                        <th>Execution Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Data will be loaded by DataTables --}}
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include('mis.footer')

<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function() {
    $('#campTable').DataTable({
        dom: 'Bfrtip',
        buttons: [],
        processing: true,
        serverSide: true,
        order: [[0, 'desc']], // 👈 Default: Sr No DESC
            columnDefs: [
                { targets: 0, orderable: true },   // Sr No orderable
                { targets: '_all', orderable: true }
            ],
        ajax: {
            url: '{{ url("mis-Get-Camp-Details") }}',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
            data: function (d) {

                return JSON.stringify({
                    draw: d.draw,
                    start: d.start,
                    length: d.length,
                    search: { value: d.search.value },
                    order: d.order,
                    columns: d.columns
                });
            },
            dataSrc: function (json) {
                if (!json || json.error) {
                    console.error(json?.error || 'Empty response');
                    return [];
                }
                return json.data;
            }
        },
        columns: [
            { data: 'sr' },
            { data: 'id', visible: false  },
             { data: 'employee_id' },
            { data: 'first_name' },
            { data: 'hcp_name' },
            { data: 'in_time' },
            { data: 'out_time' },
            { data: 'remarks' },
            { data: 'execution_status' },
            { data: 'date' }
        ],
        error: function (xhr, error, thrown) {
            console.error('DataTables error:', error, thrown);
            $('#campTable').DataTable().clear().draw();
        }
    });
});

function openNewWindow() {
    window.location.href = '{{ url("campreport_excel") }}';
}

</script>
