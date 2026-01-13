@include('digitaleducator.head')
@include('digitaleducator.header')
@section('content')
<div class="main-wrapper">
    {{-- Sidebar --}}
    @include('digitaleducator.Sidebar')
    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            @include('digitaleducator.breadcum')
            <div class="card">
                <div class="card-body">
                    <table id="patientTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr</th>
                                <th>Educator Name</th>
                                <th>Name</th>
                                <th>Mobile Number</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Weight</th>
                                <th>Height</th>
                                <th>Doctor Name</th>
                                <th>Cipla Brand Prescribed</th>
                                <th>Camp</th>
                                <th>Consent Form</th>
                                <th>Prescription Form</th>
                                <th>Date</th>
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

@include('digitaleducator.footer')
<script>
    $(document).ready(function () {
        // Initialize DataTable first, with no data
        const table = $('#patientTable').DataTable({
            // responsive: true,
            scrollX: true,
            data: [], // will populate later via AJAX
            columns: [
                { data: 'sr' },
                { data: 'educator_name' },
                { data: 'patient_name' },
                { data: 'mobile_number' },
                { data: 'gender' },
                { data: 'age' },
                { data: 'weight' },
                { data: 'height' },
                { data: 'doctor_name' },
                { data: 'cipla_brand_prescribed' },
                { data: 'camp_id' },
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
                { data: 'date' },
                { data: 'actions' }
            ]
        });

        // Fetch data and populate the DataTable
        $.ajax({
            url: "{{ route('digitaleducator.patientslist') }}",
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                let data = [];

                response.data.forEach((item, index) => {
                    data.push({
                        sr: index + 1,
                        patient_name: item.patient_name,
                        educator_name: item.educator_name,
                        mobile_number: item.mobile_number,
                        gender: item.gender,
                        age: item.age,
                        weight: item.weight ?? '-',
                        height: item.height ?? '-',
                        doctor_name: item.doctor_name,
                        cipla_brand_prescribed: item.cipla_brand_prescribed,
                        camp_id: 'Camp ' + item.camp_id,
                        consent_form_file: item.consent_form_file ? item.consent_form_file : '',
                        prescription_file: item.prescription_file ? item.prescription_file : [],
                        date: item.date,
                        actions: `<button class="btn btn-success" onclick="openForm(${item.id})">View Form</button>`
                    });
                });

                table.clear().rows.add(data).draw();
            },
            error: function () {
                alert("Failed to load data.");
            }
        });

        // Define global function for form redirection
        window.openForm = function (patientId) {
    window.location.href = '/digitaleducator/educator-follow-up-form?patient_id=' + patientId;
};
    });
</script>
