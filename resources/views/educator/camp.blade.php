@include('educator.head')
@include('educator.header')
@section('content')
<div class="main-wrapper">
    {{-- Sidebar --}}
    @include('educator.Sidebar')
    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            @include('educator.breadcum')
            <div class="card mb-4">
                <div class="card-header thembutton text-white">
                    <h5 class="mb-0">Ongoing Camp Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="doctor_dropdown">Select Doctor</label>
                            <select class="form-control" id="doctor_dropdown">
                                <option value="">Loading doctors...</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="campTable">
                            <thead>
                                <tr>
                                    <th>Sr</th>
                                    <th>Camp</th>
                                    <th>Date</th>
                                    <th>In Time</th>
                                    <th>Out Time</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                    <th>Execution Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        loadDoctors();
        loadCampData();

        function loadDoctors() {
            $.get('{{ url("/counsellor/get-doctors") }}', function (data) {
                let options = '<option value="">-- Select Doctor --</option>';
                $.each(data, function (i, doctor) {
                    options += `<option value="${doctor.id}">${doctor.name}</option>`;
                });
                $('#doctor_dropdown').html(options);
            });
        }

        function loadCampData() {
            $.get('{{ url("/counsellor/get-ongoing-camp") }}', function (camp) {
                let rows = '';
                for (let c = 1; c <= 3; c++) {
                    let in_time = '', out_time = '', remarks = '', camp_id = '', date = '';
                    if (camp && camp.camp_id == c) {
                        in_time = camp.in_time || '';
                        out_time = camp.out_time || '';
                        remarks = camp.remarks || '';
                        camp_id = camp.id;
                        date = camp.date || new Date().toISOString().split('T')[0];
                    }
                    else {
                        date = new Date().toLocaleString('en-GB', {
                            timeZone: 'Asia/Kolkata',
                            year: 'numeric',
                            month: '2-digit',
                            day: '2-digit'
                        }).split('/').reverse().join('-');
                        // Default to today if no camp data
                    }

                    rows += `
                        <tr>
                            <td>${c}</td>
                            <td>Camp ${c}</td>
                            <td>${date}</td>
                            <td>${in_time}</td>
                            <td>${out_time}</td>
                            <td>
                                <select class="form-control remarks-dropdown" data-camp-id="${camp_id || ''}">
                                    <option value="">Select Remark</option>
                                    <option value="Doctor on leave" ${remarks == 'Doctor on leave' ? 'selected' : ''}>Doctor on leave</option>
                                    <option value="Counsellor on leave" ${remarks == 'Counsellor on leave' ? 'selected' : ''}>Counsellor on leave</option>
                                </select>
                            </td>
                            <td>
                                ${camp_id
                            ? `<button class="btn btn-danger" onclick="stopCamp(${camp_id})">Stop</button>`
                            : `<button class="btn btn-primary" onclick="startCamp(${c})">Start</button>`}
                            </td>
                            <td>
                                <button class="btn btn-success" onclick="executed(${camp_id || 0})">Executed</button>
                                <button class="btn btn-danger" onclick="notexecuted(${camp_id || 0})">Not Executed</button>
                            </td>
                        </tr>
                    `;
                }
                $('#campTable tbody').html(rows);
            });
        }

        window.startCamp = function (campId) {
            const doctorId = $('#doctor_dropdown').val();
            const doctorName = $('#doctor_dropdown option:selected').text();

            if (!doctorId) {
                toastr.error('Please select a doctor first');
                return;
            }

            $.post('{{ url("/counsellor/start-camp") }}', {
                _token: '{{ csrf_token() }}',
                camp_id: campId,
                doctor_id: doctorId,
                doctor_name: doctorName
            }, function (res) {
                toastr.success(res.message);
                loadCampData();
            });
        };

        window.stopCamp = function (campId) {
            const remark = $(`.remarks-dropdown[data-camp-id="${campId}"]`).val();

            $.post('{{ url("/counsellor/stop-camp") }}', {
                _token: '{{ csrf_token() }}',
                camp_id: campId,
                remarks: remark
            }, function (res) {
                toastr.success(res.message);
                loadCampData();
            });
        };

        window.executed = function (campId) {
            $.post('{{ url("/counsellor/executed") }}', {
                _token: '{{ csrf_token() }}',
                camp_id: campId,
                execution_status: 'EXECUTED'
            }, function (res) {
                toastr.success(res.message);
                loadCampData();
            });
        };

        window.notexecuted = function (campId) {
            const remark = $(`.remarks-dropdown[data-camp-id="${campId}"]`).val();

            if (!remark) {
                toastr.error("Please select a remark first");
                return;
            }

            $.post('{{ url("/counsellor/not-executed") }}', {
                _token: '{{ csrf_token() }}',
                camp_id: campId,
                remarks: remark,
                execution_status: 'NOT EXECUTED'
            }, function (res) {
                toastr.success(res.message);
                loadCampData();
            });
        };
    });
</script>
@include('educator.footer')
