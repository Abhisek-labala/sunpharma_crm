@include('mis.header')
<div class="main-wrapper">
    @include('mis.Sidebar')

    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            <!-- Breadcrumb -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Attendance Report</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.mis') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Attendance Report</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Breadcrumb -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label>Start Date</label>
                                    <input type="date" id="startDate" class="form-control" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-3">
                                    <label>End Date</label>
                                    <input type="date" id="endDate" class="form-control" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Role</label>
                                    <select id="roleFilter" class="form-control">
                                        <option value="">All Roles</option>
                                        <option value="counsellor">Counsellor</option>
                                        <option value="digitalcounsellor">Digital Counsellor</option>
                                        <option value="rm">RC (Regional Coordinator)</option>
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button class="btn btn-primary me-2" id="filterBtn">Filter</button>
                                    <button class="btn btn-success" id="exportBtn">Export to Excel</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="attendanceTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Role</th>
                                            <th>Name</th>
                                            <th>In Time</th>
                                            <th>Out Time</th>
                                            <th>Location</th>
                                            <th>IP Address</th>
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

@include('mis.footer')

<script>
    $(document).ready(function() {
        var table = $('#attendanceTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('mis.attendance.data') }}",
                data: function(d) {
                    d.startDate = $('#startDate').val();
                    d.endDate = $('#endDate').val();
                    d.role = $('#roleFilter').val();
                }
            },
            columns: [
                { data: 'date', name: 'date' },
                { data: 'role', name: 'role' },
                { data: 'name', name: 'name', orderable: false }, // Sorting by computed name is hard server-side
                { data: 'in_time', name: 'in_time' },
                { data: 'out_time', name: 'out_time' },
                { data: 'location', name: 'location', orderable: false },
                { data: 'ip_address', name: 'ip_address' }
            ],
            order: [[0, 'desc']]
        });

        $('#filterBtn').click(function() {
            table.draw();
        });

        $('#exportBtn').click(function() {
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            var role = $('#roleFilter').val();
            var url = "{{ route('mis.attendance.export') }}?startDate=" + startDate + "&endDate=" + endDate + "&role=" + role;
            window.location.href = url;
        });
    });
</script>
