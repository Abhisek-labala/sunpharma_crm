@include('rm.head')
@include('rm.header')

@section('content')
<div class="main-wrapper">

    {{-- Sidebar --}}
    @include('rm.Sidebar')

    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">

            @include('rm.breadcum')

            <div class="card">
                <div class="card-body">
                    <table id="patientTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Weight</th>
                                <th>Height</th>
                                <th>Doctor Name</th>
                                <th>Brand Prescribed</th>
                                <th>Camp</th>
                                <th>Date</th>
                                <th>Consent Form</th>
                                <th>Prescription Files</th>
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

@include('rm.footer')
<script>
    let patientTable; // Declare globally

    function loadPatientTable() {
        $.ajax({
            url: "{{ route('rm.patientdata') }}",
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                const data = response.data.map((item, index) => {
                    let actionButtons = '';

                    if (item.approved_status === 'Pending') {
                        actionButtons = `
                            <button class="btn btn-success" onclick="approve(${item.id})">Approve</button>
                            <button class="btn btn-danger" onclick="reject(${item.id})">Reject</button>
                        `;
                    } else {
                        const colorClass = item.approved_status === 'Approved' ? 'text-success' : 'text-danger';
                        actionButtons = `<span class="${colorClass} fw-bold">${item.approved_status}</span>`;
                    }

                    return {
                        sr: index + 1,
                        patient_name: item.patient_name,
                        gender: item.gender,
                        age: item.age,
                        weight: item.weight ?? '-',
                        height: item.height ?? '-',
                        doctor_name: item.doctor_name,
                        cipla_brand_prescribed: item.cipla_brand_prescribed,
                        camp_id: 'Camp ' + item.camp_id,
                        date: item.date,
                        consent_form_file: item.consent_form_file ?? null,
                        prescription_file: item.prescription_file ?? null,
                        actions: actionButtons
                    };
                });

                patientTable.clear().rows.add(data).draw();
            },
            error: function () {
                toastr.error("Failed to load patient data.");
            }
        });
    }

    $(document).ready(function () {
        patientTable = $('#patientTable').DataTable({
            // responsive: true,
            scrollX: true,
            scrollY: '500px',
            sorting: false,
            searching: true,
            paging: true,
            lengthChange: true,
            pageLength: 10,
            info: true,
            autoWidth: false,
            data: [],
            columns: [
                { data: 'sr' },
                { data: 'patient_name' },
                { data: 'gender' },
                { data: 'age' },
                { data: 'weight' },
                { data: 'height' },
                { data: 'doctor_name' },
                { data: 'cipla_brand_prescribed' },
                { data: 'camp_id' },
                { data: 'date' },
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
                { data: 'actions' },
            ]
        });

        // Initial load
        loadPatientTable();
    });

    function approve(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to approve this patient?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, approve',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('rm.approve-patient') }}",
                    method: 'POST',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        toastr.success("Patient approved successfully.");
                        let row = patientTable.rows().nodes().to$().filter(function () {
                        return $(this).find('button').filter(function () {
                            return this.onclick?.toString().includes(`approve(${id})`);
                        }).length > 0;
                    });

                    // Update the last cell (actions)
                    const approvedHTML = `<span class="text-success fw-bold">Approved</span>`;
                    patientTable.row(row).data().actions = approvedHTML;
                    patientTable.row(row).invalidate().draw(false); // Redraw only that row
                    },
                    error: function (xhr) {
                        toastr.error("Failed to approve patient.");
                    }
                });
            }
        });
    }

    function reject(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to reject this patient?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, reject',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('rm.reject-patient') }}",
                    method: 'POST',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        toastr.success("Patient rejected.");
                        let row = patientTable.rows().nodes().to$().filter(function () {
                        return $(this).find('button').filter(function () {
                            return this.onclick?.toString().includes(`reject(${id})`);
                        }).length > 0;
                    });

                    const rejectedHTML = `<span class="text-danger fw-bold">Rejected</span>`;
                    patientTable.row(row).data().actions = rejectedHTML;
                    patientTable.row(row).invalidate().draw(false); // Redraw only that row
                    },
                    error: function (xhr) {
                        toastr.error("Failed to reject patient.");
                    }
                });
            }
        });
    }
</script>

