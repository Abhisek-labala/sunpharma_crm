@include('educator.header')
<style>
    /* Make table cells wrap text on small screens */
    @media screen and (max-width: 767px) {

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_paginate {
            text-align: left;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.3em 0.6em;
        }

        table.dataTable thead>tr>th {
            padding-right: 30px;
            /* Space for sort icons */
        }
    }

    /* Responsive breakpoint */
    @media screen and (max-width: 991px) {

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_length {
            float: none;
            text-align: center;
        }

        .dataTables_wrapper .dataTables_filter {
            float: none;
            text-align: center;
            margin-top: 10px;
        }
    }
</style>
@section('content')
<div class="main-wrapper">
    @include('educator.Sidebar')
    <div class="page-wrapper">
        <div class="content container-fluid">
            @include('educator.breadcum')

            <div class="card">
                <div class="card-body">
                    <form id="filterForm">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Date Range</label>
                            <div class="col-md-5">
                                <label>From Date</label>
                                <input type="text" class="form-control" id="from_date" name="from_date"
                                    value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-5">
                                <label>To Date</label>
                                <input type="text" class="form-control" id="to_date" name="to_date"
                                    value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Camp</label>
                            <div class="col-md-10">
                                <select class="form-control" id="campId" name="campId">
                                    <option value="">-- Select --</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">HCP Name</label>
                            <div class="col-md-10">
                                <select class="form-control" id="doctor" name="doctorId">
                                    <option value="">-- Select --</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-form-label col-md-2"></label>
                            <div class="col-md-10">
                                <!-- Submit Button -->
                                <button type="button" class="btn btn-primary" id="submitbtn">
                                    Submit
                                </button>

                                <!-- Patient Report Button -->
                                <button type="button" class="btn btn-success" onclick="downloadExcelFile();">
                                    Patient Report
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <table id="patientTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr</th>
                                <th>Date</th>
                                <th>Patient Name</th>
                                <th>Mobile</th>
                                <th>Gender</th>
                                <th>Blood Pressure</th>
                                <th>BMI</th>
                                <th>Consent Form</th>
                                <th>Prescription</th>
                                <th>Educator Name</th>
                                <th>Rm Name</th>
                                <th>City</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@include('educator.footer')
<script>
    $(document).ready(function () {
        // Initialize datepickers
        $("#from_date, #to_date").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            maxDate: new Date(),
            onSelect: function () {
                loadCamps(); // Load camps on date change
            }
        });
        $('#from_date, #to_date').on('change', function () {
            loadCamps(); // Load camps and then patient data
        });

        let patientTable = $('#patientTable').DataTable({
            processing: true,
            serverSide: true,
            // responsive: true,
            scrollX: true,
            // scrollY: '600px',
            lengthMenu: [10, 25, 50, 100],
            pageLength: 10,
            order: [[0, 'desc']], // 👈 Default: Sr No DESC
            columnDefs: [
                { targets: 0, orderable: true },   // Sr No orderable
                { targets: '_all', orderable: true }
            ],
            ajax: {
                url: "{{ route('common.getEducatorPatientTable') }}",
                type: "POST",
                data: function (d) {
                    return $.extend({}, d, {
                        _token: $('input[name="_token"]').val(),
                        campId: $('#campId').val(),
                        doctorId: $('#doctor').val(),
                        fromDate: $('#from_date').val(),
                        toDate: $('#to_date').val()
                    });
                }
            },
            columns: [
                {
                    data: null,
                    name: 'Sr',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'date', name: 'date' },
                { data: 'patient_name', name: 'patient_name' },
                { data: 'mobile_number', name: 'mobile_number' },
                { data: 'gender', name: 'gender' },
                { data: 'blood_pressure', name: 'blood_pressure', defaultContent: '-' },
                { data: 'bmi', name: 'bmi', defaultContent: '-' },
                {
                    data: 'consent_form_file',
                    name: 'consent_form_file',
                    render: function (data) {
                        return data
                            ? `<a href="/private-file/${data}" target="_blank">View</a>`
                            : '-';
                    }
                },
                {
                    data: 'prescription_file',
                    name: 'prescription_file',
                    render: function (data) {
                        if (!data) return '-';
                        // If already an array, use it; else split by comma
                        let files = Array.isArray(data) ? data : data.split(',');
                        return files
                            .map(f => `<a href="/private-file/${f.trim()}" target="_blank">View</a>`)
                            .join(', ');
                    }
                },
                { data: 'educator_name', name: 'educator_name', defaultContent: '-' },
                { data: 'rm_name', name: 'rm_name', defaultContent: '-' },
                { data: 'city', name: 'city', defaultContent: '-' }
            ]
        });
        function loadPatientData() {
            patientTable.ajax.reload();
        }

        // Load Camps
        function loadCamps() {
            $.post("{{ route('common.getEducatorCamp') }}", {
                fromDate: $('#from_date').val(),
                toDate: $('#to_date').val(),
                _token: $('input[name="_token"]').val()
            }, function (data) {
                $('#campId').html(data);
                $('#doctor').html('<option value="">-- Select --</option>'); // Reset doctor
                loadPatientData();
            });
        }

        // On change of camp, load doctors and data
        $('#campId').on('change', function () {
            $.post("{{ route('common.getDoctorsByCamp') }}", {
                campId: $(this).val(),
                _token: $('input[name="_token"]').val()
            }, function (data) {
                $('#doctor').html(data);
                loadPatientData();
            });
        });

        // On change of doctor, reload data
        $('#submitbtn').on('click', loadPatientData);
        $('#doctor').on('change', loadPatientData);
        $("#from_date, #to_date").on('change', loadPatientData);

        loadCamps();
    });
    window.downloadExcelFile = function () {
        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();
        var campId = $('#campId').val();
        var hcpId = $('#doctor').val();

        var url = "{{ route('educator.patients.export') }}"
            + "?fromDate=" + encodeURIComponent(fromDate)
            + "&toDate=" + encodeURIComponent(toDate)
            + "&campId=" + encodeURIComponent(campId)
            + "&hcp=" + encodeURIComponent(hcpId);

        window.location.href = url; // This will trigger the Excel download
    }
</script>
