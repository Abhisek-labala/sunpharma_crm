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
                            <h4 class="card-title">Compitetor</h4>
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                data-target="#compitetorModal" onclick="resetForm()">
                                <i class="fa fa-plus"></i> Add Compitetor
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="compitetortable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Compitetor Name</th>
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

<!-- compitetor Modal -->
<div class="modal fade" id="compitetorModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Compitetor</h5>
            </div>
            <div class="modal-body">
                <form action="Pm-Create-Compitetor-Post" name="createCompitetor" id="createCompitetor" method="post"
                    enctype="multipart/form-data">
                    <input type="hidden" name="compitetor_id" id="compitetor_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Compitetor Name <span class="text-danger">*</span></label>
                                <input type="text" maxlength="50" class="form-control" name="compitetor_name"
                                    id="compitetor_name">
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
<!-- /compitetor Modal -->

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this compitetor?</p>
                <input type="hidden" id="delete_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    onclick="closemodaldelete()">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="deletecompitetor()">Delete</button>
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
        $('#compitetortable').DataTable({
            dom: 'Bfrtip',
            buttons: [],
            processing: true,
            serverSide: true,
            ajax: {
                url: 'Pm-Get-Compitetor',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: function (d) {
                    return JSON.stringify({
                        draw: d.draw,
                        start: d.start,
                        length: d.length,
                        search: { value: d.search.value },
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
                { data: 'compitetor_name' },
                {
                    data: null,
                    render: function (data, type, row) {
                        return `
                            <div class="actions">
                                <a href="javascript:void(0);" class="btn btn-sm bg-primary-light m-2" onclick="editRecord(${row.id})">Edit</a>
                                <a href="javascript:void(0);" class="btn btn-sm bg-danger-light m-2" onclick="confirmDelete(${row.id})">Delete</a>
                            </div>`;
                    }
                }
            ],
            error: function (xhr, error, thrown) {
                console.error('DataTables error:', error, thrown);
                $('#compitetortable').DataTable().clear().draw();
            }
        });
    });

    // Reset form and modal
    function resetForm() {
        $('#compitetorModal').modal('show');
        $('#modalTitle').text('Add compitetor');
        $('#createCompitetor')[0].reset();
        $('#compitetor_id').val('');
        $('#submitBtn').text('Submit').prop('disabled', false);

        // Clear validation errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    }

    function closemodal() {
        $('#compitetorModal').modal('hide');
    }

    function confirmDelete(id) {
        $('#delete_id').val(id);
        $('#deleteModal').modal('show');
    }

    function closemodaldelete() {
        $('#deleteModal').modal('hide');
    }

    // Delete compitetor
    function deletecompitetor() {
        var id = $('#delete_id').val();

        $.ajax({
            url: 'Pm-Delete-Compitetor/' + id,
            type: 'POST',
            dataType: 'json',
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function (response) {
                if (response.status) {
                    $('#compitetortable').DataTable().ajax.reload(null, false);
                    $('#deleteModal').modal('hide');
                    toastr.success(response.message || 'compitetor deleted successfully', 'Success');
                } else {
                    toastr.error(response.message || 'Failed to delete compitetor', 'Error');
                }
            },
            error: function (xhr) {
                toastr.error('Error processing response');
                console.error(xhr.responseText);
            }
        });
    }

    // Form submission
    $('#createCompitetor').submit(function (e) {
        e.preventDefault();

        var $submitBtn = $('#submitBtn')
            .prop('disabled', true)
            .html('<i class="fa fa-spinner fa-spin"></i> Processing...');

        if (validateCompitetorForm()) {
            var formData = new FormData(this);
            var url = $('#compitetor_id').val() ? 'Pm-Update-Compitetor-Post' : 'Pm-Create-Compitetor-Post';

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        $('#compitetortable').DataTable().ajax.reload();
                        $('#compitetorModal').modal('hide');
                        toastr.success(response.message || 'Saved successfully', 'Success');
                    } else {
                        toastr.error(response.message || 'Error saving compitetor', 'Error');
                        if (response.errors) {
                            $.each(response.errors, function (field, message) {
                                $('#' + field).addClass('is-invalid')
                                    .after('<div class="invalid-feedback">' + message + '</div>');
                            });
                        }
                    }
                },
                error: function (xhr) {
                    toastr.error('Unexpected error occurred', 'Error');
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

    // Validation
    function validateCompitetorForm() {
        var isValid = true;

        // Clear old errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        const compitetor_name = $('#compitetor_name').val().trim();
        if (isEmpty(compitetor_name)) {
            $('#compitetor_name').addClass('is-invalid')
                .after('<div class="invalid-feedback">compitetor name is required</div>');
            isValid = false;
        }
        return isValid;
    }

    function editRecord(id) {
        var table = $('#compitetortable').DataTable();
        var rowData = table.rows().data().toArray().find(r => r.id == id);

        if (!rowData) {
            toastr.error("compitetor not found");
            return;
        }

        $('#modalTitle').text("Edit compitetor");
        $('#submitBtn').prop('disabled', false).text('Update');

        $('#compitetor_id').val(rowData.id);
        $('#compitetor_name').val(rowData.compitetor_name);

        $('#compitetorModal').modal('show');
    }

    function isEmpty(value) {
        return !value || value.trim() === "";
    }
</script>
