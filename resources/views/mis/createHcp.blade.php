
@include('mis.header');

<!-- Main Wrapper -->
<div class="main-wrapper">

	<!-- Sidebar -->

	@include('mis.Sidebar');

	<!-- /Sidebar -->


	<!-- Page Wrapper -->
	<div class="page-wrapper" style="min-height: 653px;">
		<div class="content container-fluid">

			<!-- Page Header -->
			  @include('mis.breadcum')
			<!-- /Page Header -->





			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">HCP Management</h4>
							<button type="button" class="btn btn-primary float-right" data-toggle="modal"
								data-target="#doctorModal" onclick="resetForm()">
								<i class="fa fa-plus"></i> Add HCP
							</button>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="doctorsTable" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>ID</th>
											<th>Doctor CODE</th>
											<th>Name</th>
											<th>City</th>
											<th>State</th>
											<th>Zone</th>
											<th>Speciality</th>
											<th>First Visit</th>
											<th>Counsellor Name</th>
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

<!-- Doctor Modal -->
<div class="modal fade" id="doctorModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle">Add DOCTOR</h5>
			</div>
			<div class="modal-body">
				<form action="admin-Create-Doctor-Post" name="createDoctor" id="createDoctor" method="post"
					enctype="multipart/form-data">
					<input type="hidden" name="doctor_id" id="doctor_id">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>DOCTOR CODE <span class="text-danger">*</span></label>
								<input type="text" maxlength="50" class="form-control" name="msl_code" id="msl_code">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Name <span class="text-danger">*</span></label>
								<input type="text" maxlength="50" class="form-control" name="name" id="name">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>State <span class="text-danger">*</span></label>
								<select class="form-control" name="state" id="state">
									<option value=""> -- Select -- </option>



								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>City <span class="text-danger">*</span></label>
								<select class="form-control" name="city" id="city">
									<option value=""> -- Select -- </option>

								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Zone <span class="text-danger">*</span></label>
								<select class="form-control" name="zone" id="zone">
									<option value=""> -- Select -- </option>

								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Speciality <span class="text-danger">*</span></label>
								<input type="text" id="speciality" name="speciality" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>First Visit <span class="text-danger">*</span></label>
									<input type="date" id="first_vist" name="first_vist" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
							<div class="form-group">
								<label>Doctor Consent<span class="text-danger">*</span></label>
								<input class="form-control" type="file" name="consent_image" id="consent_image">
								<div id="doctor_image_preview" class="mt-2"></div>
							</div>
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
<!-- /Doctor Modal -->

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Confirm Delete</h5>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to delete this doctor?</p>
				<input type="hidden" id="delete_id">
			</div>
			<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closemodaldelete()">Cancel</button>
						<button type="button" class="btn btn-danger" onclick="deleteDoctor()">Delete</button>
			</div>
		</div>
	</div>
</div>
<!-- /Delete Confirmation Modal -->


@include('mis.footer')

<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$(document).ready(function () {
		$('#doctorsTable').DataTable({
                scrollX: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'admin-Get-Doctors',
                    type: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
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
                    { data: 'msl_code' },
                    { data: 'name' },
                    { data: 'city' },
                    { data: 'state' },
                    { data: 'zone' },
                    { data: 'speciality' },
                    { data: 'first_visit' },
                    { data: 'full_name' },
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
                    console.error('DataTables error:', error, thrown, xhr.responseText);
                    $('#doctorsTable').DataTable().clear().draw();
                }
            });
        });


		function loadZones(selectedZoneId = null) {
			$.post("{{ route('common.misgetZones') }}", {
				_token: $('input[name="_token"]').val()
			}, function (data) {
				$('#zone').html(data);

				// After dropdown is filled, set selected if provided
				if (selectedZoneId) {
					console.log(selectedZoneId);
					$('#zone').val(selectedZoneId);
				}
    });
	}
	async function loadState(selectedStateName = null) {
    try {
        let response = await $.post("{{ route('common.misgetState') }}", {
            _token: $('input[name="_token"]').val()
        });

        $('#state').html(response);

        if (selectedStateName) {
            let stateText = selectedStateName.trim().toLowerCase();
            let matched = false;

            $('#state option').each(function () {
                if ($(this).text().trim().toLowerCase() === stateText) {
                    let val = $(this).val();
                    $('#state').val(val);               // sets UI
                    $(this).prop('selected', true);     // sets attribute for Inspect
                    matched = true;
                    return false; // stop loop
                }
            });

            if (!matched) {
                console.warn("State not matched: " + selectedStateName);
            }
        }
    } catch (err) {
        console.error("Error loading states:", err);
    }
}

		$('#state').on('change', function () {
				loadCity();
				loadZones();
			});
		function loadCity(selectedCityName = null) {
			$.post("{{ route('common.misgetCity') }}", {
				state: $('#state').val(),
				_token: $('input[name="_token"]').val()
			}, function (data) {
        	$('#city').html(data);

        if (selectedCityName) {
            // Match by text, not value
            var cityText = selectedCityName.trim().toLowerCase();
            $('#city option').each(function () {
                if ($(this).text().trim().toLowerCase() === cityText) {
                    $('#city').val($(this).val());
                    return false; // stop loop once matched
                }
            });
        }
    });
	}

	function resetForm() {

		$('#modalTitle').text('Add Doctor');
		$('#createDoctor')[0].reset();
		$('#doctor_id').val('');
		$('#profile_image_preview').html('');
		$('#submitBtn').text('Submit');
		$('.is-invalid').removeClass('is-invalid');
		$('.invalid-feedback').remove();
		$('#submitBtn').prop('disabled', false);
		 loadState();

		 $('#doctorModal').modal('show');
	}
	function closemodal() {
		$('#doctorModal').modal('hide');
	}
	function confirmDelete(id) {
		$('#delete_id').val(id);
		$('#deleteModal').modal('show');
	}
	function closemodaldelete()
		{
			$('#deleteModal').modal('hide');
		}
	// Delete doctor
	function deleteDoctor() {
		var id = $('#delete_id').val();

		$.ajax({
			url: 'admin-Delete-Doctor/' + id,
			type: 'POST',
			dataType: 'json',
			data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
			success: function (response) {
				if (response.status) {
					$('#doctorsTable').DataTable().ajax.reload(null, false); // false to maintain paging
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



	$('#createDoctor').submit(function (e) {
    e.preventDefault();
    var $submitBtn = $('#submitBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

    if (validateDoctorForm()) {
        var formData = new FormData(this);
		var stateText = $('#state option:selected').text();
		var cityText = $('#city option:selected').text();
        formData.set('state', stateText);
        formData.set('city', cityText);
        var url = $('#doctor_id').val() ? 'admin-Update-Doctor-Post' : 'admin-Create-Doctor-Post';
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    $('#doctorsTable').DataTable().ajax.reload();
                    $('#doctorModal').modal('hide');
                     toastr.success(response.message, 'Success');
					$('#doctorModal').modal('hide');

                } else {
                    toastr.error(response.message, 'Error');
					$('#doctorModal').modal('hide');
                    if (response.errors) {
                        $.each(response.errors, function (field, message) {
                            $('#' + field).addClass('is-invalid').after('<div class="invalid-feedback">' + message + '</div>');
                        });
                    }
                }
            },
            error: function (xhr) {
                showAlert('error', 'An error occurred. Please try again.');
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

	// Show alert (replace with SweetAlert or Toastr if needed)
	function showAlert(type, message) {
		toastr.success(message); // simple alert; replace with toast if needed
	}

	// Form validation
	function validateDoctorForm() {
		var isValid = true;

		// Fetch values
		const name = $('#name').val().trim();
		const msl_code = $('#msl_code').val().trim();
		const state = $('#state option:selected').text();
		const city = $('#city option:selected').text();
		const consent_image = $('#consent_image').val();
		const zone = $('#zone').val().trim();
		const speciality = $('#speciality').val().trim();
		// const first_vist = $('#first_vist').val().trim();

		// Clear previous errors
		$('.is-invalid').removeClass('is-invalid');
		$('.invalid-feedback').remove();

		if (isEmpty(msl_code)) {
			$('#msl_code').addClass('is-invalid').after('<div class="invalid-feedback">MSL Code is required</div>');
			isValid = false;
		}
		if (isEmpty(name)) {
			$('#name').addClass('is-invalid').after('<div class="invalid-feedback">Name is required</div>');
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
		if (isEmpty(zone)) {
			$('#zone').addClass('is-invalid').after('<div class="invalid-feedback">Zone is required</div>');
			isValid = false;
		}
		if (isEmpty(speciality)) {
			$('#speciality').addClass('is-invalid').after('<div class="invalid-feedback">Speciality is required</div>');
			isValid = false;
		}
		if (!isValidImageFile(consent_image)) {
				$('#profile_image').addClass('is-invalid').after('<div class="invalid-feedback">Only JPG, JPEG, PNG files are allowed</div>');
				isValid = false;
			}

		return isValid;
	}

	// Utility validation
	function isEmpty(value) {
		return value === "";
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
function editRecord(id) {
    $('#doctorModal').modal('show');
    $('#modalTitle').text('Edit HCP');
    $('#createDoctor')[0].reset();
    $('#submitBtn').text('Update');
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    $.ajax({
        url: 'admin-Get-Doctor/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status && response.data) {
                const doc = response.data;

                $('#doctor_id').val(doc.id);
                $('#msl_code').val(doc.msl_code);
                $('#name').val(doc.name);
                $('#speciality').val(doc.speciality);

                if (doc.first_visit) {
                    const formattedDate = new Date(doc.first_visit).toISOString().split('T')[0];
                    $('#first_vist').val(formattedDate);
                }

                // Load state, then city, then zone in sequence
                loadState(doc.state).then(() => {
                    loadCity(doc.city); // call city loader with selected city
                });
                setTimeout(() => {
                    loadZones(doc.zone);
                }, 1500);
            } else {
                showAlert('error', 'Failed to fetch doctor details');
            }
        },
        error: function () {
            showAlert('error', 'An error occurred while fetching data');
        }
    });
}

</script>
