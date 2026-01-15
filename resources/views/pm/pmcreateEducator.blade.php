@include('pm.header')

<!-- Main Wrapper -->
<div class="main-wrapper">

    <!-- Sidebar -->

    @include('pm.Sidebar')

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
                            <h4 class="card-title">Educators Management</h4>
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                data-target="#educatorModal" onclick="resetForm()">
                                <i class="fa fa-plus"></i> Add Educator
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
                                            <th>Email</th>
                                            <th>Password</th>
                                            <th>Mobile</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Address</th>
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
                <h5 class="modal-title" id="modalTitle">Add Educator</h5>
            </div>
            <div class="modal-body">
                <form action="Pm-Create-Educator-Post" name="createEducator" id="createEducator" method="post"
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
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" maxlength="50" class="form-control" name="email" id="email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password <span class="text-danger">*</span></label>
                                <input type="text" maxlength="12" class="form-control" name="password" id="password">
                                <small class="text-muted">Min 5 chars with at least 1 uppercase letter</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mobile <span class="text-danger">*</span></label>
                                <input type="text" maxlength="10" class="form-control" name="mobile" id="mobile">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>State <span class="text-danger">*</span></label>
                                <select class="form-control" name="state" id="state">
                                    <option value=""> -- Select -- </option>



                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>City <span class="text-danger">*</span></label>
                                <input type="text" maxlength="50" class="form-control" name="city" id="city">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Profile Image</label>
                                <input class="form-control" type="file" name="profile_image" id="profile_image">
                                <div id="profile_image_preview" class="mt-2"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Address <span class="text-danger">*</span></label>
                        <textarea maxlength="200" rows="3" class="form-control" name="address" id="address"></textarea>
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
                <p>Are you sure you want to delete this educator?</p>
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
            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: 'nc-Get-Educators',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: function (d) {
                    d._token = '{{ csrf_token() }}';
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
                { data: 'email' },
                { data: 'password' },
                { data: 'mobile' },
                { data: 'city' },
                { data: 'state' },
                { data: 'address' },
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

    function loadState() {
        $.post("{{ route('common.getState') }}", {
            _token: $('input[name="_token"]').val()
        }, function (data) {
            $('#state').html(data);

        });
    }

    function closemodaldelete() {
        $('#deleteModal').modal('hide');
    }

    // Reset form and modal - improved version
    function resetForm() {
        $('#educatorModal').modal('show');
        $('#modalTitle').text('Add Educator');
        $('#createEducator')[0].reset();
        $('#educator_id').val('');
        $('#profile_image_preview').html('');
        $('#password').val('').removeAttr('placeholder');
        $('#submitBtn').text('Submit');
        $('#submitBtn').prop('disabled', false);
        loadState();
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

    // Delete educator
    function deleteEducator() {
        var id = $('#delete_id').val();

        $.ajax({
            url: 'nc-Delete-Educator/' + id,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    $('#educatorsTable').DataTable().ajax.reload(null, false);
                    $('#deleteModal').modal('hide');
                    toastr.success('Deleted: ' + response.message);
                } else {
                    toastr.error('Error: ' + response.message);
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

        var $submitBtn = $('#submitBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

        if (validateEducatorForm()) {
            var formData = new FormData(this);
            var url = $('#educator_id').val() ? 'nc-Update-Educator-Post' : 'nc-Create-Educator-Post';
            var stateText = $('#state option:selected').text();
            formData.set('state', stateText);

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
                        toastr.success(response.message, 'Success');
                    } else {
                        toastr.error(response.message || 'Something went wrong!', 'Error');
                        if (response.errors) {
                            $.each(response.errors, function (field, messages) {
                                let $field = $('#' + field);
                                $field.addClass('is-invalid');
                                // Remove old errors before appending new
                                $field.next('.invalid-feedback').remove();
                                $field.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                            });
                        }
                    }
                },
                error: function (xhr) {
                    let res = xhr.responseJSON;
                    if (res && res.errors) {
                        $.each(res.errors, function (field, messages) {
                            let $field = $('#' + field);
                            $field.addClass('is-invalid');
                            $field.next('.invalid-feedback').remove();
                            $field.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                        });
                        toastr.error('Please fix the highlighted errors.', 'Validation Error');
                    } else {
                        toastr.error(res?.message || 'Server error occurred.', 'Error');
                    }
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
    function editRecord(id) {
        // make sure state options are loaded before setting

        var table = $('#educatorsTable').DataTable();
        var rowData = table.rows().data().toArray().find(r => r.id == id);

        if (!rowData) {
            toastr.error("Educator not found");
            return;
        }

        // Change modal title
        $('#modalTitle').text("Edit Educator");
        $('#submitBtn').prop('disabled', false);
        // Populate form fields
        $('#educator_id').val(rowData.id);
        $('#emp_id').val(rowData.emp_id);
        $('#first_name').val(rowData.full_name);
        $('#email').val(rowData.email);
        $('#password')
            .val(rowData.password)
        $('#mobile').val(rowData.mobile);
        $('#address').val(rowData.address);

        loadState(rowData.state);


        $('#city').val(rowData.city);

        if (rowData.profile_image) {
            $('#profile_image_preview').html(
                '<img src="' + rowData.profile_image + '" class="img-thumbnail" width="80">'
            );
        } else {
            $('#profile_image_preview').html('');
        }

        $('#submitBtn').text('Update');

        // Show modal
        $('#educatorModal').modal('show');
    }
    function loadState(selectedStateName = null) {
        $.post("{{ route('common.getState') }}", {
            _token: $('input[name="_token"]').val()
        }, function (data) {
            $('#state').html(data);

            if (selectedStateName) {
                var stateText = selectedStateName.trim().toLowerCase();
                var matched = false;

                $('#state option').each(function () {
                    if ($(this).text().trim().toLowerCase() === stateText) {
                        $('#state').val($(this).val());
                        matched = true;
                        return false; // stop loop after match
                    }
                });

                if (!matched) {
                    console.warn("State not matched: " + selectedStateName);
                }
            }
        });
    }

    // Form validation
    function validateEducatorForm() {
        var isValid = true;
        var messages = [];

        const firstName = $('#first_name').val().trim();
        const emp_id = $('#emp_id').val().trim();
        const email = $('#email').val().trim();
        const password = $('#password').val();
        const mobile = $('#mobile').val().trim();
        const state = $('#state').val();
        const city = $('#city').val().trim();
        const address = $('#address').val().trim();
        const profileImage = $('#profile_image').val();
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

        if (!isValidEmail(email)) {
            $('#email').addClass('is-invalid').after('<div class="invalid-feedback">Invalid email address</div>');
            isValid = false;
        }

        // Only validate password if it's a new educator or password field is not empty
        if (!educatorId || (educatorId && !isEmpty(password))) {
            if (!isValidPassword(password)) {
                $('#password').addClass('is-invalid').after('<div class="invalid-feedback">Password must be at least 5 characters with at least one uppercase letter</div>');
                isValid = false;
            }
        }

        if (!isValidMobile(mobile)) {
            $('#mobile').addClass('is-invalid').after('<div class="invalid-feedback">Mobile must be 10 digits</div>');
            isValid = false;
        }

        if (isEmpty(state)) {
            $('#state').addClass('is-invalid').after('<div class="invalid-feedback">State is required</div>');
            isValid = false;
        }

        if (!isValidCity(city)) {
            $('#city').addClass('is-invalid').after('<div class="invalid-feedback">City must contain only letters</div>');
            isValid = false;
        }

        if (isEmpty(address)) {
            $('#address').addClass('is-invalid').after('<div class="invalid-feedback">Address is required</div>');
            isValid = false;
        }

        if (!isValidImageFile(profileImage)) {
            $('#profile_image').addClass('is-invalid').after('<div class="invalid-feedback">Only JPG, JPEG, PNG files are allowed</div>');
            isValid = false;
        }

        if (!isValid) {
            return false;
        }

        return true;
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
