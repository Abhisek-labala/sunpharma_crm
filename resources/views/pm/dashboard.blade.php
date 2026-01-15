@include('pm.header');
@section('content')
<div class="main-wrapper">
    @include('pm.Sidebar');

    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            @include('pm.breadcum')

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="pmdashboard">
                                @csrf
                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label class="col-form-label">From Date</label>
                                        <input class="form-control" type="date" id="from_date" name="from_date" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label">To Date</label>
                                        <input class="form-control" type="date" id="to_date" name="to_date" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-2">Zone</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="zone" id="zone">
                                            <option value=""> -- Select -- </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-2">Rc</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="rm" id="rm">
                                            <option value=""> -- Select -- </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-2">Counsellor</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="educator" id="educator">
                                            <option value=""> -- Select -- </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-2">Camp</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="campId" id="campId">
                                            <option value=""> -- Select -- </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-2">Doctor Name</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="doctor" id="doctor">
                                            <option value=""> -- Select -- </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-2"> </label>
                                    <div class="col-md-10">
                                      <button type="button" name="submit" id="submitbtn" class="btn btn-primary"
                                            >Submit</button>
                                        <button type="button" class="btn btn-secondary"
                                            onclick="downloadpmPatientExcel();">Patient Report</button>
                                        <button type="button" class="btn btn-success"
                                            onclick="downloadDailyReport();">Daily Report</button>
                                    </div>
                                </div>
                            </form>

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
                                <th>Counsellor Name</th>
                                <th>Rc Name</th>
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
            </div>

        </div>
    </div>
</div>
@include('pm.footer');
<script>
    $(document).ready(function () {
        loadZones();

        function checkEducatorAndLoad() {
            if ($('#educator').val()) {
                loadCamps();
            }
        }

        let patientTable = $('#patientTable').DataTable({
            processing: true,
            serverSide: true,
            // responsive: true,
            scrollX: true,
            order: [[0, 'desc']], // 👈 Default: Sr No DESC
            columnDefs: [
                { targets: 0, orderable: true },   // Sr No orderable
                { targets: '_all', orderable: true }
            ],
            ajax: {
                url: "{{ route('common.getpmPatientTable') }}",
                type: "POST",
                data: function (d) {
                    return $.extend({}, d, {
                        _token: $('input[name="_token"]').val(),
                        campId: $('#campId').val(),
                        doctorId: $('#doctor').val(),
                        fromDate: $('#from_date').val(),
                        toDate: $('#to_date').val(),
                        zone: $('#zone').val(),
                        rm: $('#rm').val(),
                        educator: $('#educator').val()
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

        function loadCamps() {
            $.post("{{ route('common.getCampbyeducator') }}", {
                educatorId: $('#educator').val(),
                fromDate: $('#from_date').val(),
                toDate: $('#to_date').val(),
                _token: $('input[name="_token"]').val()
            }, function (data) {
                $('#campId').html(data);
                $('#doctor').html('<option value="">-- Select --</option>');
                loadPatientData();
            });
        }

        function loadZones() {
            $.post("{{ route('common.getZones') }}", {
                _token: $('input[name="_token"]').val()
            }, function (data) {
                $('#zone').html(data);
                $('#rm').html('<option value="">-- Select --</option>');
                loadPatientData();
            });
        }

        $('#zone').on('change', function () {
            $.post("{{ route('common.getrmsbyzone') }}", {
                zone: $(this).val(),
                _token: $('input[name="_token"]').val()
            }, function (data) {
                $('#rm').html(data);
                loadPatientData();
            });
        });

        $('#rm').on('change', function () {
            $.post("{{ route('common.getEducatorbyzoneandRm') }}", {
                rm: $(this).val(),
                zone: $('#zone').val(),
                _token: $('input[name="_token"]').val()
            }, function (data) {
                $('#educator').html(data);
                loadPatientData();
            });
        });

        $('#educator').on('change', function () {
            loadCamps();
        });

        $('#campId').on('change', function () {
            $.post("{{ route('common.getDoctorsByEdu') }}", {
                educatorId: $('#educator').val(),
                _token: $('input[name="_token"]').val()
            }, function (data) {
                $('#doctor').html(data);
                loadPatientData();
            });
        });

        $('#doctor').on('change', loadPatientData);

        $('#submitbtn').on('click', loadPatientData);

        // ✅ Updated: Handle native input type="date" changes
        $('#from_date, #to_date').on('input', function () {
            checkEducatorAndLoad();
            loadPatientData();
        });

        loadCamps();
    });

    window.downloadpmPatientExcel = function () {
        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();
        var educator = $('#educator').val();
        var zone = $('#zone').val();
        var rm = $('#rm').val();
        var campId = $('#campId').val();
        var hcpId = $('#doctor').val();

        var url = "{{ route('pm.patients.export') }}"
            + "?fromDate=" + encodeURIComponent(fromDate)
            + "&toDate=" + encodeURIComponent(toDate)
            + "&campId=" + encodeURIComponent(campId)
            + "&hcp=" + encodeURIComponent(hcpId)
            + "&educator=" + encodeURIComponent(educator)
            + "&rm=" + encodeURIComponent(rm)
            + "&zone=" + encodeURIComponent(zone);

        window.location.href = url;
    }
     window.downloadDailyReport = function () {
    var fromDate = $('#from_date').val();
    var toDate = $('#to_date').val();

    var url = "{{ route('pmdaily.report.export') }}"
        + "?fromDate=" + encodeURIComponent(fromDate)
        + "&toDate=" + encodeURIComponent(toDate);

    window.location.href = url;
}
</script>

