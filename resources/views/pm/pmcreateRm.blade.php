
@include('pm.header');

<!-- Main Wrapper -->
<div class="main-wrapper">

	<!-- Sidebar -->

	@include('pm.Sidebar');;

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
							<h4 class="card-title">RC Management</h4>
							<button type="button" class="btn btn-primary float-right" data-toggle="modal"
								data-target="#rmModal" onclick="resetForm()">
								<i class="fa fa-plus"></i> Add RC
							</button>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="rmsTable" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>ID</th>
											<th>Emp Id</th>
											<th>Name</th>
											<th>Username</th>
											<th>Password</th>
											<th>Zone</th>
											<th>Zone Name</th>
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

<!-- Rm Modal -->
<div class="modal fade" id="rmModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle">Add RC</h5>
			</div>
			<div class="modal-body">
				<form action="nc-Create-Rm-Post" name="createRm" id="createRm" method="post"
					enctype="multipart/form-data">
					<input type="hidden" name="rm_id" id="rm_id">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>EMP ID <span class="text-danger">*</span></label>
								<input type="text" maxlength="50" class="form-control" name="emp_id"
									id="emp_id">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Full Name <span class="text-danger">*</span></label>
								<input type="text" maxlength="50" class="form-control" name="name"
									id="name">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Password <span class="text-danger">*</span></label>
								<input type="text" maxlength="12" class="form-control" name="password"
									id="password">
								<small class="text-muted">Min 5 chars with at least 1 uppercase letter</small>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Zone <span class="text-danger">*</span></label>
								<select class="form-control" name="zone_id" id="zone_id">
									<option value=""> -- Select -- </option>

								</select>
							</div>
						</div>
					</div>

					<div class="text-center">
						<button type="submit" name="submit" id="submitBtn" class="btn btn-primary">Submit</button>
						<button type="button" class="btn btn-secondary" onclick="closemodal();" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /Rm Modal -->

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Confirm Delete</h5>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to delete this rc?</p>
				<input type="hidden" id="delete_id">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closemodaldelete()">Cancel</button>
				<button type="button" class="btn btn-danger" onclick="deleteRm()">Delete</button>
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
			$('#rmsTable').DataTable({
				screenX: true,
				processing: true,
				serverSide: true,
				ajax: {
					url: 'nc-Get-Rm',
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
					{ data: 'user_name' },
					{ data: 'password' },
					{ data: 'zone', visible: false }, // Hide zone ID column
					{ data: 'zone_name' },
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
					$('#rmsTable').DataTable().clear().draw();
				}
			});
		});


	function loadZones(selectedZoneId = null) {
    $.post("{{ route('common.getZones') }}", {
        _token: $('input[name="_token"]').val()
    }, function (data) {
        $('#zone_id').html(data);

        // After dropdown is filled, set selected if provided
        if (selectedZoneId) {
			console.log(selectedZoneId);
            $('#zone_id').val(selectedZoneId);
        }
    });
}

	// Reset form and modal - improved version
	function resetForm() {
		$('#rmModal').modal('show');
		$('#modalTitle').text('Add Rm');
		$('#createRm')[0].reset();
		$('#rm_id').val('');
		$('#emp_id').val('');
		$('#password').val('').removeAttr('placeholder');
		$('#submitBtn').text('Submit');
		$('#submitBtn').prop('disabled', false);
		$('#zone_id').html('<option value="">Loading...</option>');
		loadZones();

		$('.is-invalid').removeClass('is-invalid');
		$('.invalid-feedback').remove();
	}
	function closemodaldelete()
	{
		$('#deleteModal').modal('hide');
	}
	function closemodal()
	{
		$('#rmModal').modal('hide');
	}
	function confirmDelete(id) {
		$('#delete_id').val(id);
		$('#deleteModal').modal('show');
	}

	// Delete rm
	function deleteRm() {
    var id = $('#delete_id').val();

    $.ajax({
        url: 'nc-Delete-Rm/' + id,
        type: 'POST',
        dataType: 'json',
        data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
        success: function(response) {
            if (response.status) {
                $('#rmsTable').DataTable().ajax.reload(null, false); // false to maintain paging
                $('#deleteModal').modal('hide');
                toastr.success('deleted', response.message);
            } else {
                toastr.error('error', response.message);
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

	function editRecord(id) {
    var table = $('#rmsTable').DataTable(); // Adjust table ID if different
    var rowData = table.rows().data().toArray().find(r => r.id == id);

    if (!rowData) {
        toastr.error("RC not found");
        return;
    }

    // Change modal title
    $('#modalTitle').text("Edit RC");
$('#rm_id').val(rowData.id);
$('#submitBtn').prop('disabled', false);
    // Populate form fields
    $('#emp_id').val(rowData.emp_id);
    $('#name').val(rowData.full_name);

    // For security: keep password blank
    $('#password')
        .val(rowData.password)

    loadZones(rowData.zone);

    // Change submit button
    $('#submitBtn').text('Update');

    // Show modal
    $('#rmModal').modal('show');
}

	// Form validation and submission
	$('#createRm').submit(function(e) {
    e.preventDefault();

    // Disable submit button to prevent duplicate submissions
    var $submitBtn = $('#submitBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

    if (validateRmForm()) {
        var formData = new FormData(this);
        var url = $('#rm_id').val() ? 'nc-Update-Rm-Post' : 'nc-Create-Rm-Post';
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#rmsTable').DataTable().ajax.reload();
                    $('#rmModal').modal('hide');
                     toastr.success(response.message, 'Success');
                } else {
					toastr.error(response.message, 'Error');
					// Handle validation errors


					// Show validation errors
                   if (response.errors) {
                        $.each(response.errors, function(field, message) {
                            $('#' + field).addClass('is-invalid');
                            $('#' + field).after('<div class="invalid-feedback">' + message + '</div>');
                        });
                    }
                }
            },
            error: function(xhr) {
              toastr.error(response.message, 'Error');
                console.error(xhr.responseText);
            },
            complete: function() {
                $submitBtn.prop('disabled', false).html('Submit');
            }
        });
    } else {
        $submitBtn.prop('disabled', false).html('Submit');
    }
		});

	// Form validation
	function validateRmForm() {
		var isValid = true;
		var messages = [];

		const firstName = $('#name').val().trim();
		const password = $('#password').val();
		const zone=$('#zone_id').val();
		// Clear previous errors
		$('.is-invalid').removeClass('is-invalid');
		$('.invalid-feedback').remove();

		if (isEmpty(firstName)) {
			$('#first_name').addClass('is-invalid').after('<div class="invalid-feedback">First name is required</div>');
			isValid = false;
		}


		// Only validate password if it's a new rm or password field is not empty
		if ( !isEmpty(password)) {
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

	// Utility validation functions
	function isEmpty(value) {
		return value.trim() === "";
	}



	function isValidPassword(password) {
		const pattern = /^(?=.*[A-Z]).{5,}$/;
		return pattern.test(password);
	}
</script>
