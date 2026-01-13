@include('yogaeducator/head')
@include('yogaeducator/header')
@section('content')
<div class="main-wrapper">
    {{-- Sidebar --}}
    @include('yogaeducator.Sidebar')
    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            @include('yogaeducator/breadcum')
            <div class="card">
                <div class="card-body">
                    <table id="patientTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr</th>
                                <th>Name</th>
                                <th>Mobile Number</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Weight</th>
                                <th>Height</th>
                                <th>Doctor Name</th>
                                <th>Cipla Brand Prescribed</th>
                                <th>Camp</th>
                                <th>Date</th>
                                <th>RM Approved Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@include('yogaeducator/footer')
<script>
$(document).ready(function () {
    // Initialize DataTable with server-side processing
    const table = $('#patientTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('yogaeducator.patientslist') }}",
            type: 'GET',
            data: function (d) {
                // You can add additional parameters here if needed
            },
            error: function (xhr, error, thrown) {
                console.log('DataTables error:', error, thrown);
                alert("Failed to load data.");
            }
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                orderable: false
            },
            { data: 'patient_name' },
            { data: 'mobile_number' },
            { data: 'gender' },
            { data: 'age' },
            {
                data: 'weight',
                render: function (data) {
                    return data ?? '-';
                }
            },
            {
                data: 'height',
                render: function (data) {
                    return data ?? '-';
                }
            },
            { data: 'doctor_name' },
            { data: 'cipla_brand_prescribed' },
            {
                data: 'camp_id',
                render: function (data) {
                    return data ? 'Camp ' + data : '-';
                }
            },
            { data: 'date' },
            {
                data: 'approved_status',
                render: function (data) {
                    if (!data) return '-';
                    let color = '';
                    switch (data.toLowerCase()) {
                        case 'approved': color = 'green'; break;
                        case 'pending': color = 'orange'; break;
                        case 'rejected': color = 'red'; break;
                        default: color = 'black';
                    }
                    return `<span style="color:${color}; font-weight:bold;">${data}</span>`;
                }
            },
            {
                data: 'id',
                render: function (data) {
                    return `<button class="btn btn-success" onclick="openForm(${data})">View Form</button>`;
                },
                orderable: false
            }
        ],
        order: [[0, 'desc']], // Default ordering
        scrollX: true,
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        }
    });

    // Define global function for form redirection
    window.openForm = function (patientId) {
        window.location.href = '/yogaeducator/educator-follow-up-form?patient_id=' + patientId;
    };
});
</script>
