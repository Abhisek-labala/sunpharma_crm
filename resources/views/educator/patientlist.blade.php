@include('educator/head')
@include('educator/header')
@section('content')
<div class="main-wrapper">
    {{-- Sidebar --}}
    @include('educator.Sidebar')
    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            @include('educator/breadcum')
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
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="uploadForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="patient_id" id="uploadPatientId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Documents</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label for="consent_form" class="form-label">Consent Form</label>
                        <input type="file" name="consent_form" class="form-control" accept="image/*,application/pdf">
                    </div>
                    <div class="col-md-6">
                        <label for="purchase_bill" class="form-label">Purchase Bill</label>
                        <input type="file" name="purchase_bill" class="form-control" accept="image/*,application/pdf">
                    </div>
                    <div class="col-md-12">
                        <label for="prescription_file" class="form-label">Prescription Files (multiple)</label>
                        <input type="file" name="prescription_file[]" class="form-control" multiple
                            accept="image/*,application/pdf">
                    </div>
                </div>
                <div class="modal-footer mt-3">
                    <div id="uploadLoader" class="spinner-border text-primary me-3" role="status" style="display: none;">
        <span class="visually-hidden">Uploading...</span>
    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

@include('educator/footer')
<script>
$(document).ready(function () {
    // Initialize DataTable with server-side processing
    const table = $('#patientTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('educator.patientslist') }}",
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
                render: function (data, type, row) {
                    return `
                        <div class="d-flex gap-2">
                            <button class="btn btn-success btn-sm" onclick="openForm(${data})">View Form</button>
                            ${row.approved_status === 'Rejected' ? `
                                <button class="btn btn-warning btn-sm" onclick="openUploadModal(${row.id}, '${row.patient_name}')">ReUpload</button>
                            ` : ''}
                        </div>
                    `;
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
        window.location.href = '/educator/educator-follow-up-form?patient_id=' + patientId;
    };
    window.openUploadModal = function (patientId, patientName) {
            $('#uploadPatientId').val(patientId);
            $('#uploadForm')[0].reset(); // Clear previous files
            if ($('#patientNameInput').length === 0) {
        $('#uploadForm .modal-body').prepend(`
            <div class="col-md-12">
                <label for="patient_name" class="form-label">Patient Name</label>
                <input type="text" name="patient_name" id="patientNameInput" class="form-control" value="${patientName}">
            </div>
        `);
        } else {
            $('#patientNameInput').val(patientName);
        }
            $('#uploadModal').modal('show');
        };
        $('#uploadForm').on('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
             $('#uploadLoader').show();
    $('#uploadBtn').prop('disabled', true).text('Uploading...');

            $.ajax({
                url: "{{ route('educator.uploadDocuments') }}", // Define this route in your controller
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (res) {
                    toastr.success('Documents uploaded successfully.');
                    $('#uploadModal').modal('hide');
            $('#patientTable').DataTable().ajax.reload(null, false);
                },
                error: function (err) {
                    toastr.error('Upload failed. Please try again.');
                },
                 complete: function () {
            // Hide loader & enable button again
            $('#uploadLoader').hide();
            $('#uploadBtn').prop('disabled', false).text('Upload');
        }
            });
        });
});
</script>
