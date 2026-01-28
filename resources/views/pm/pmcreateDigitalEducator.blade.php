@include('pm.header')

<!-- Main Wrapper -->
<div class="main-wrapper">

    <!-- Sidebar -->

    @include('pm.Sidebar');

    <!-- /Sidebar -->


    <!-- Page Wrapper -->
    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">

            <!-- Page Header -->
            @include('pm.breadcum')
            <!-- /Page Header -->





            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">DigitalCounsellor Management</h4>
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                data-target="#educatorModal" onclick="resetForm()">
                                <i class="fa fa-plus"></i> Add DigitalCounsellor
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="educatorsTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Emp Id</th>
                                            <th>Name</th>
                                            <th>Password</th>
                                            <th>RC Name</th>
                                            <th>Actions</th>
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
    </div>

</div>
<!-- /Main Wrapper -->

<!-- Educator Modal -->
<div class="modal fade" id="educatorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Digital Counsellor</h5>
            </div>
            <div class="modal-body">
                <form action="Pm-Create-DigiEducator-Post" name="createEducator" id="createEducator" method="post"
                    enctype="multipart/form-data">
                    <input type="hidden" name="educator_id" id="educator_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Employee Id <span class="text-danger">*</span></label>
                                <input type="text" maxlength="50" class="form-control" name="emp_id" id="emp_id">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Full Name <span class="text-danger">*</span></label>
                                <input type="text" maxlength="50" class="form-control" name="first_name"
                                    id="first_name">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password <span class="text-danger">*</span></label>
                                <input type="text" maxlength="12" class="form-control" name="password" id="password">
                                <small class="text-muted">Min 5 chars with at least 1 uppercase letter</small>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="submit" id="submitBtn" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" onclick="closemodal();"
                            data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Educator Modal -->

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this digital educator?</p>
                <input type="hidden" id="delete_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    onclick="closemodaldelete()">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="deleteEducator()">Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Confirmation Modal -->


@include('pm.footer')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function () {
        $('#educatorsTable').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            processing: true,
            serverSide: true,
            ajax: {
                url: 'nc-Get-DigiEducators',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: function (d) {
                    return JSON.stringify({
                        draw: d.draw,
                        start: d.start,
                        length: d.length,
                        search: {
                            value: d.search.value
                        },
                        order: d.order,
                        columns: d.columns
                    });
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
                { data: 'id' },
                { data: 'emp_id' },
                { data: 'full_name' },
                { data: 'password' },
                { data: 'rm' },
                {
                    data: null,
                    render: function (data, type, row) {
                        return '<div class="actions">' +
                            '<a href="javascript:void(0);" class="btn btn-sm bg-primary-light m-2" onclick="editRecord(' + row.id + ')">Edit</a>' +
                            '<a href="javascript:void(0);" class="btn btn-sm bg-danger-light m-2" onclick="confirmDelete(' + row.id + ')">Delete</a>' +
                            '</div>';
                    }
                }
            ],
            error: function (xhr, error, thrown) {
                console.error('DataTables error:', error, thrown);
                $('#educatorsTable').DataTable().clear().draw();
            }
        });
    });



    // Reset form and modal - improved version
    function resetForm() {
        $('#educatorModal').modal('show');
        $('#modalTitle').text('Add Counsellor');
        $('#createEducator')[0].reset();
        $('#educator_id').val('');
        $('#password').val('').removeAttr('placeholder');
        $('#submitBtn').text('Submit');
        $('#submitBtn').prop('disabled', false);

        // Clear validation errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    }

    function closemodal() {
        $('#educatorModal').modal('hide');
    }
    function confirmDelete(id) {
        $('#delete_id').val(id);
        $('#deleteModal').modal('show');
    }
    function closemodaldelete() {
        $('#deleteModal').modal('hide');
    }
    // Delete educator
    function deleteEducator() {
        var id = $('#delete_id').val();

        $.ajax({
            url: 'nc-Delete-DigiEducator/' + id,
            type: 'POST',
            dataType: 'json',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.status) {
                    $('#educatorsTable').DataTable().ajax.reload(null, false); // false to maintain paging
                    $('#deleteModal').modal('hide');
                    toastr.success(response.message, 'Success');
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function (xhr) {
                try {
                    var errResponse = JSON.parse(xhr.responseText);
                    toastr.error('Error: ' + (errResponse.message || 'Error deleting educator'));
                } catch (e) {
                    toastr.error('Error processing response');
                }
            }
        });
    }


    // Form validation and submission
    $('#createEducator').submit(function (e) {
        e.preventDefault();

        // Disable submit button to prevent duplicate submissions
        var $submitBtn = $('#submitBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

        if (validateEducatorForm()) {
            var formData = new FormData(this);
            var url = $('#educator_id').val() ? 'nc-Update-DigiEducator-Post' : 'nc-Create-DigiEducator-Post';

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        $('#educatorsTable').DataTable().ajax.reload();
                        $('#educatorModal').modal('hide');
                        // Show success message in a better way
                        toastr.success(response.message, 'Success');
                    } else {
                        toastr.error(response.message, 'Error');
                        // Highlight problematic fields if returned in response
                        if (response.errors) {
                            $.each(response.errors, function (field, message) {
                                $('#' + field).addClass('is-invalid');
                                $('#' + field).after('<div class="invalid-feedback">' + message + '</div>');
                            });
                        }
                    }
                },
                error: function (xhr) {
                    toastr.error(response.message, 'Error');
                    console.error(xhr.responseText);
                },
                complete: function () {
                    $submitBtn.prop('disabled', false).html('Submit');
                }
            });
        } else {
            $submitBtn.prop('disabled', false).html('Submit');
        }
    });

    // Form validation
    function validateEducatorForm() {
        var isValid = true;
        var messages = [];

        const firstName = $('#first_name').val().trim();
        const emp_id = $('#emp_id').val().trim();
        const password = $('#password').val();
        const educatorId = $('#educator_id').val();

        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        if (isEmpty(firstName)) {
            $('#first_name').addClass('is-invalid').after('<div class="invalid-feedback">First name is required</div>');
            isValid = false;
        }
        if (isEmpty(emp_id)) {
            $('#emp_id').addClass('is-invalid').after('<div class="invalid-feedback">Employee Id is required</div>');
            isValid = false;
        }


        // Only validate password if it's a new educator or password field is not empty
        if (!educatorId || (educatorId && !isEmpty(password))) {
            if (!isValidPassword(password)) {
                $('#password').addClass('is-invalid').after('<div class="invalid-feedback">Password must be at least 5 characters with at least one uppercase letter</div>');
                isValid = false;
            }
        }


        if (!isValid) {
            return false;
        }

        return true;
    }
    function editRecord(id) {
        var table = $('#educatorsTable').DataTable();
        var rowData = table.rows().data().toArray().find(r => r.id == id);

        if (!rowData) {
            toastr.error("Educator not found");
            return;
        }

        // Change modal title
        $('#modalTitle').text("Edit Digital Counsellor");
        $('#submitBtn').prop('disabled', false);
        // Populate form fields
        $('#educator_id').val(rowData.id);
        $('#emp_id').val(rowData.emp_id);
        $('#first_name').val(rowData.full_name);

        // For security reasons, don’t pre-fill password
        $('#password').val(rowData.password);

        // Change submit button text
        $('#submitBtn').text('Update');

        // Show modal
        $('#educatorModal').modal('show');
    }

    // Utility validation functions
    function isEmpty(value) {
        return value.trim() === "";
    }

    function isValidEmail(email) {
        const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return pattern.test(email);
    }

    function isValidPassword(password) {
        const pattern = /^(?=.*[A-Z]).{5,}$/;
        return pattern.test(password);
    }

    function isValidMobile(mobile) {
        const pattern = /^\d{10}$/;
        return pattern.test(mobile);
    }

    function isValidCity(city) {
        const pattern = /^[A-Za-z\s]+$/;
        return pattern.test(city);
    }

    function isValidImageFile(fileName) {
        if (fileName === "") return true; // Image is optional
        const pattern = /(\.jpg|\.jpeg|\.png)$/i;
        return pattern.test(fileName);
    }
</script>
