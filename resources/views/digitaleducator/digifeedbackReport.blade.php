<style>
    #feedbackalert-message {
        color: red;
        font-weight: bold;
        padding: 2px 5px;
        border-radius: 3px;
    }
</style>
{{-- Include Header --}}
@include('digitaleducator.header')

<div class="main-wrapper">
    {{-- Sidebar --}}
    @include('digitaleducator.Sidebar');

    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            {{-- Page Header --}}
            @include('digitaleducator.breadcum')

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- Filter Section --}}
                            <div class="row mb-3">
                                <p id="feedbackalert-message"><span style="color:red">* </span>For a smooth data
                                    download, it's recommended that you use a filter.</p>
                                <div class="col-md-3">
                                    <label for="fromDate" class="form-label">From Date</label>
                                    <input type="date" class="form-control" id="fromDate"
                                        value="">
                                </div>
                                <div class="col-md-3">
                                    <label for="toDate" class="form-label">To Date</label>
                                    <input type="date" class="form-control" id="toDate"
                                        value="">
                                </div>
                                <div class="col-md-3">
                                    <label for="educatorFilter" class="form-label">Educator</label>
                                    <select class="form-control" id="educatorFilter"></select>
                                </div>
                                <div class="col-md-3">
                                    <label for="dayFilter" class="form-label">Follow-up Day Due Today</label>
                                    <select class="form-control" id="dayFilter">
                                        <option value="">All Days</option>
                                        <option value="3">Day 3</option>
                                        <option value="7">Day 7</option>
                                        <option value="15">Day 15</option>
                                        <option value="30">Day 30</option>
                                        <option value="45">Day 45</option>
                                        <option value="60">Day 60</option>
                                        <option value="90">Day 90</option>
                                        <option value="120">Day 120</option>
                                        <option value="150">Day 150</option>
                                        <option value="180">Day 180</option>
                                    </select>
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

@include('digitaleducator.footer')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // This function populates the educator dropdown filter
    function populateFilters() {
        $.getJSON('{{ route("digitalget.educators.name") }}', function (data) {
            let educatorOptions = '<option value="">All Educators</option>';
            data.forEach(item => {
                educatorOptions += `<option value="${item.id}">${item.full_name}</option>`;
            });
            $('#educatorFilter').html(educatorOptions);
        });
    }

    // Main document ready function
    $(document).ready(function () {
        populateFilters();
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex, rowData, counter) {
                const selectedDay = $('#dayFilter').val();

                // If no day is selected in the filter, show all rows
                if (!selectedDay) {
                    return true;
                }

                // Get today's date in YYYY-MM-DD format
                const today = new Date();
                const yyyy = today.getFullYear();
                const mm = String(today.getMonth() + 1).padStart(2, '0');
                const dd = String(today.getDate()).padStart(2, '0');
                const todayStr = `${yyyy}-${mm}-${dd}`;

                // Dynamically get the planned date from the row's data
                const plannedDateColumnName = 'day' + selectedDay + '_planned_date';
                const plannedDate = rowData[plannedDateColumnName];

                // Show the row only if its planned date matches today's date
                return plannedDate === todayStr;
            }
        );
        // Initialize the DataTable in client-side mode
        const table = $('#feedbackTable').DataTable({
            scrollX: true, // Allows horizontal scrolling
            processing: true, // Shows the "Processing..." indicator
            serverSide: false, // ❗ Key change: Disables server-side processing
            columns: [
                { data: 'sr', title: 'Sr' },
                { data: 'patient_id', title: 'Patient ID' },
                { data: 'patient_name', title: 'Patient Name' },
                { data: 'mobile_number', title: 'Mobile Number' },
                { data: 'doctor_name', title: 'Doctor Name' },
                { data: 'educator_name', title: 'Educator Name' },
                { data: 'digital_educator_name', title: 'Digital Educator Name' },
                { data: 'created_at', title: 'Created At' },
                { data: 'day3_planned_date', title: 'Day 3 Planned Date' },
                { data: 'day3_actual_date', title: 'Day 3 Actual Date' },
                { data: 'day_3_remark', title: 'Day 3 Remark' },
                { data: 'day_3_details_remark', title: 'Day 3 Details Remark' },
                { data: 'ae_report', title: 'Day 3 AE Report' },
                { data: 'day7_planned_date', title: 'Day 7 Planned Date' },
                { data: 'day7_actual_date', title: 'Day 7 Actual Date' },
                { data: 'day_7_remark', title: 'Day 7 Remark' },
                { data: 'day_7_details_remark', title: 'Day 7 Details Remark' },
                { data: 'day7_ae_report', title: 'Day 7 AE Report' },
                { data: 'day15_planned_date', title: 'Day 15 Planned Date' },
                { data: 'day15_actual_date', title: 'Day 15 Actual Date' },
                { data: 'day_15_remark', title: 'Day 15 Remark' },
                { data: 'day_15_details_remark', title: 'Day 15 Details Remark' },
                { data: 'day15_ae_report', title: 'Day 15 AE Report' },
                { data: 'day30_planned_date', title: 'Day 30 Planned Date' },
                { data: 'day30_actual_date', title: 'Day 30 Actual Date' },
                { data: 'day_30_remark', title: 'Day 30 Remark' },
                { data: 'day_30_details_remark', title: 'Day 30 Details Remark' },
                { data: 'day30_ae_report', title: 'Day 30 AE Report' },
                { data: 'day45_planned_date', title: 'Day 45 Planned Date' },
                { data: 'day45_actual_date', title: 'Day 45 Actual Date' },
                { data: 'day_45_remark', title: 'Day 45 Remark' },
                { data: 'day_45_details_remark', title: 'Day 45 Details Remark' },
                { data: 'day45_ae_report', title: 'Day 45 AE Report' },
                { data: 'day60_planned_date', title: 'Day 60 Planned Date' },
                { data: 'day60_actual_date', title: 'Day 60 Actual Date' },
                { data: 'day_60_remark', title: 'Day 60 Remark' },
                { data: 'day_60_details_remark', title: 'Day 60 Details Remark' },
                { data: 'day60_ae_report', title: 'Day 60 AE Report' },
                { data: 'day90_planned_date', title: 'Day 90 Planned Date' },
                { data: 'day90_actual_date', title: 'Day 90 Actual Date' },
                { data: 'day_90_remark', title: 'Day 90 Remark' },
                { data: 'day_90_details_remark', title: 'Day 90 Details Remark' },
                { data: 'day90_ae_report', title: 'Day 90 AE Report' },
                { data: 'day120_planned_date', title: 'Day 120 Planned Date' },
                { data: 'day120_actual_date', title: 'Day 120 Actual Date' },
                { data: 'day_120_remark', title: 'Day 120 Remark' },
                { data: 'day_120_details_remark', title: 'Day 120 Details Remark' },
                { data: 'day120_ae_report', title: 'Day 120 AE Report' },
                { data: 'day150_planned_date', title: 'Day 150 Planned Date' },
                { data: 'day150_actual_date', title: 'Day 150 Actual Date' },
                { data: 'day_150_remark', title: 'Day 150 Remark' },
                { data: 'day_150_details_remark', title: 'Day 150 Details Remark' },
                { data: 'day150_ae_report', title: 'Day 150 AE Report' },
                { data: 'day180_planned_date', title: 'Day 180 Planned Date' },
                { data: 'day180_actual_date', title: 'Day 180 Actual Date' },
                { data: 'day_180_remark', title: 'Day 180 Remark' },
                { data: 'day_180_details_remark', title: 'Day 180 Details Remark' },
                { data: 'day180_ae_report', title: 'Day 180 AE Report' }
            ]
        });

        // Event listener for the filter button
        $('#filterBtn').on('click', function () {
            loadTableData();
        });

        // Event listener for the reset button
        $('#resetBtn').on('click', function () {
            $('#fromDate').val('');
            $('#toDate').val('');
            $('#educatorFilter').val('');
            loadTableData(); // Reload with reset filters
        });

        $('#dayFilter').on('change', function() {
            table.draw();
        });
        // Function to fetch data via AJAX and populate the DataTable
        function loadTableData() {
            const fromDate = $('#fromDate').val();
            const toDate = $('#toDate').val();
            const educatorId = $('#educatorFilter').val();

            $.ajax({
                url: '{{ url("Digital-Feedback-Details") }}',
                type: 'POST', // or 'GET' to match your route definition
                data: {
                    fromDate: fromDate,
                    toDate: toDate,
                    educatorId: educatorId,
                },
                success: function (json) {
                    // Clear the existing table data
                    table.clear();
                    // Add the new data returned from the server
                    table.rows.add(json.data || []).draw();
                    // Hide the loading indicator
                    table.processing(false);
                },
                error: function (xhr, error, thrown) {
                    console.error('AJAX error:', error, thrown);
                    toastr.error("Failed to load data from the server.", "Error");
                    // Hide the loading indicator on error
                    table.processing(false);
                }
            });
        }

        // Initial data load when the page is ready
        loadTableData();
    });

    // This function correctly builds the URL for the download
    function downloadFeedbackReport() {
        const fromDate = $('#fromDate').val();
        const toDate = $('#toDate').val();
        const educatorId = $('#educatorFilter').val();

        const url = '{{ route("digital-feedback-report-excel") }}' +
            `?fromDate=${fromDate}&toDate=${toDate}&educatorId=${educatorId}`;

        window.location.href = url;
    }
</script>
