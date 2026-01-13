<style>
    #feedbackalert-message {
        color: red;
        font-weight: bold;
        padding: 2px 5px;
        border-radius: 3px;
    }
</style>
{{-- Include Header --}}
@include('pm.header')

<div class="main-wrapper">
    {{-- Sidebar --}}
    @include('pm.Sidebar');

    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            {{-- Page Header --}}
            @include('pm.breadcum')

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- Filter Section --}}
                            <div class="row mb-3">
                                <p id="feedbackalert-message"><span style="color:red">* </span>For a smooth data download, it's recommended that you use a filter.</p>
                                <div class="col-md-3">
                                    <label for="fromDate" class="form-label">From Date</label>
                                    <input type="date" class="form-control" id="fromDate" value="{{ now()->format('Y-m-d') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="toDate" class="form-label">To Date</label>
                                    <input type="date" class="form-control" id="toDate" value="{{ now()->format('Y-m-d') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="educatorFilter" class="form-label">Educator</label>
                                    <select class="form-control" id="educatorFilter"></select>
                                </div>
                                <div class="col-md-3">
                                    <label for="digitalEducatorFilter" class="form-label">Digital Educator</label>
                                    <select class="form-control" id="digitalEducatorFilter"></select>
                                </div>
                                <div class="col-md-12 mt-3 text-end">
                                    <button class="btn btn-primary" id="filterBtn">Filter</button>
                                    <button class="btn btn-secondary" id="resetBtn">Reset</button>
                                    <button type="button" class="btn btn-success" onclick="downloadFeedbackReport();">
                                        Feedback Report
                                    </button>
                                </div>
                            </div>

                            <table id="feedbackTable" class="display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Patient ID</th>
                                        <th>Patient Name</th>
                                        <th>Mobile Number</th>
                                        <th>Doctor Name</th>
                                        <th>Educator Name</th>
                                        <th>Digital Educator Name</th>
                                        <th>Created At</th>
                                        <th>Day 3 planned Date</th>
                                        <th>Day 3 Actual Date</th>
                                        <th>Day 3 Remark</th>
                                        <th>Day 3 Details Remark</th>
                                        <th>Day 3 AE Report</th>
                                        <th>Day 7 planned Date</th>
                                        <th>Day 7 Actual Date</th>
                                        <th>Day 7 Remark</th>
                                        <th>Day 7 Details Remark</th>
                                        <th>Day 7 AE Report</th>
                                        <th>Day 15 planned Date</th>
                                        <th>Day 15 Actual Date</th>
                                        <th>Day 15 Remark</th>
                                        <th>Day 15 Details Remark</th>
                                        <th>Day 15 AE Report</th>
                                        <th>Day 30 planned Date</th>
                                        <th>Day 30 Actual Date</th>
                                        <th>Day 30 Remark</th>
                                        <th>Day 30 Details Remark</th>
                                        <th>Day 30 AE Report</th>
                                        <th>Day 45 planned Date</th>
                                        <th>Day 45 Actual Date</th>
                                        <th>Day 45 Remark</th>
                                        <th>Day 45 Details Remark</th>
                                        <th>Day 45 AE Report</th>
                                        <th>Day 60 planned Date</th>
                                        <th>Day 60 Actual Date</th>
                                        <th>Day 60 Remark</th>
                                        <th>Day 60 Details Remark</th>
                                        <th>Day 60 AE Report</th>
                                        <th>Day 90 planned Date</th>
                                        <th>Day 90 Actual Date</th>
                                        <th>Day 90 Remark</th>
                                        <th>Day 90 Details Remark</th>
                                        <th>Day 90 AE Report</th>
                                        <th>Day 120 planned Date</th>
                                        <th>Day 120 Actual Date</th>
                                        <th>Day 120 Remark</th>
                                        <th>Day 120 Details Remark</th>
                                        <th>Day 120 AE Report</th>
                                        <th>Day 150 planned Date</th>
                                        <th>Day 150 Actual Date</th>
                                        <th>Day 150 Remark</th>
                                        <th>Day 150 Details Remark</th>
                                        <th>Day 150 AE Report</th>
                                        <th>Day 180 planned Date</th>
                                        <th>Day 180 Actual Date</th>
                                        <th>Day 180 Remark</th>
                                        <th>Day 180 Details Remark</th>
                                        <th>Day 180 AE Report</th>
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

@include('pm.footer')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Populate educator and digital educator dropdowns
    function populateFilters() {
        $.getJSON('{{ route("get.educators.name") }}', function(data) {
            let educatorOptions = '<option value="">All Educators</option>';
            data.forEach(item => {
                educatorOptions += `<option value="${item.id}">${item.full_name}</option>`;
            });
            $('#educatorFilter').html(educatorOptions);
        });

        $.getJSON('{{ route("get.digi.educators.name") }}', function(data) {
            let digitalEducatorOptions = '<option value="">All Digital Educators</option>';
            data.forEach(item => {
                digitalEducatorOptions += `<option value="${item.id}">${item.full_name}</option>`;
            });
            $('#digitalEducatorFilter').html(digitalEducatorOptions);
        });
    }

    $(document).ready(function () {
        populateFilters();

        const table = $('#feedbackTable').DataTable({
            scrollX: true,
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            columnDefs: [
                { targets: 0, orderable: true },
                { targets: '_all', orderable: true }
            ],
            ajax: {
                url: '{{ url("PM-Feedback-Details") }}',
                type: 'POST',
                data: function (d) {
                    d.fromDate = $('#fromDate').val();
                    d.toDate = $('#toDate').val();
                    d.educatorId = $('#educatorFilter').val();
                    d.digitalEducatorId = $('#digitalEducatorFilter').val();
                    return JSON.stringify(d);
                },
                dataType: 'json',
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
                { data: 'patient_id' },
                { data: 'patient_name' },
                { data: 'mobile_number' },
                { data: 'doctor_name' },
                { data: 'educator_name' },
                { data: 'digital_educator_name' },
                { data: 'created_at' },
                { data: 'day3_planned_date' },
                { data: 'day3_actual_date' },
                { data: 'day_3_remark' },
                { data: 'day_3_details_remark' },
                { data: 'ae_report' },
                { data: 'day7_planned_date' },
                { data: 'day7_actual_date' },
                { data: 'day_7_remark' },
                { data: 'day_7_details_remark' },
                { data: 'day7_ae_report' },
                { data: 'day15_planned_date' },
                { data: 'day15_actual_date' },
                { data: 'day_15_remark' },
                { data: 'day_15_details_remark' },
                { data: 'day15_ae_report' },
                { data: 'day30_planned_date' },
                { data: 'day30_actual_date' },
                { data: 'day_30_remark' },
                { data: 'day_30_details_remark' },
                { data: 'day30_ae_report' },
                { data: 'day45_planned_date' },
                { data: 'day45_actual_date' },
                { data: 'day_45_remark' },
                { data: 'day_45_details_remark' },
                { data: 'day45_ae_report' },
                { data: 'day60_planned_date' },
                { data: 'day60_actual_date' },
                { data: 'day_60_remark' },
                { data: 'day_60_details_remark' },
                { data: 'day60_ae_report' },
                { data: 'day90_planned_date' },
                { data: 'day90_actual_date' },
                { data: 'day_90_remark' },
                { data: 'day_90_details_remark' },
                { data: 'day90_ae_report' },
                { data: 'day120_planned_date' },
                { data: 'day120_actual_date' },
                { data: 'day_120_remark' },
                { data: 'day_120_details_remark' },
                { data: 'day120_ae_report' },
                { data: 'day150_planned_date' },
                { data: 'day150_actual_date' },
                { data: 'day_150_remark' },
                { data: 'day_150_details_remark' },
                { data: 'day150_ae_report' },
                { data: 'day180_planned_date' },
                { data: 'day180_actual_date' },
                { data: 'day_180_remark' },
                { data: 'day_180_details_remark' },
                { data: 'day180_ae_report' }
            ],
            error: function (xhr, error, thrown) {
                console.error('DataTables error:', error, thrown);
                $('#feedbackTable').DataTable().clear().draw();
            }
        });

        $('#filterBtn').on('click', function() {
            table.ajax.reload();
        });

        $('#resetBtn').on('click', function() {
            $('#fromDate').val('');
            $('#toDate').val('');
            $('#educatorFilter').val('');
            $('#digitalEducatorFilter').val('');
            table.ajax.reload();
        });
    });

    function downloadFeedbackReport() {
        // Collect filter values
        const fromDate = $('#fromDate').val();
        const toDate = $('#toDate').val();
        const educatorId = $('#educatorFilter').val();
        const digitalEducatorId = $('#digitalEducatorFilter').val();

        // Construct URL with query parameters
        const url = '{{ route("pm-feedback-report-excel") }}' +
                    `?fromDate=${fromDate}&toDate=${toDate}&educatorId=${educatorId}&digitalEducatorId=${digitalEducatorId}`;

        window.location.href = url;
    }
</script>
