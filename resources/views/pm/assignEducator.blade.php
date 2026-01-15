@include('pm.header') {{-- Assuming you use a layout --}}


<div class="main-wrapper">
    @include('pm.Sidebar') {{-- side_bar.php --}}

    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">

             @include('pm.breadcum') {{-- breadcum.php --}}
             {{-- alerts.php --}}

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="assignEducatorForm" method="POST">
                                @csrf

                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-2">Select Counsellor</label>
                                    <div class="col-md-10">
                                        <select name="educator_id" id="educator_id" class="form-select form-control" required>
                                            <option value="">-- Select Counsellor --</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-2">Assign to RC</label>
                                    <div class="col-md-10">
                                        <select name="rm_id" id="rm_id" class="form-select form-control" required>
                                            <option value="">-- Select Regional Cordinator --</option>
                                            <option value="0">Unassign (No RC)</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-2"></label>
                                    <div class="col-md-10">
                                        <button type="submit" class="btn btn-primary">Assign Counsellor</button>
                                        <div id="responseMessage" class="mt-2"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include('pm.footer')



<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    loadEducators();
    loadRegionalManagers();
    // Load educators and RMs dynamically
    function loadEducators() {
    $.ajax({
        url: "getEducatorsname",
        method: 'GET',
        dataType: 'json', // ensures JSON parsing
        success: function(data) {
            let educatorSelect = $('#educator_id');
            educatorSelect.empty();
            educatorSelect.append('<option value="">-- Select Educator --</option>');

            data.forEach(function(educator) {
                educatorSelect.append('<option value="' + educator.id + '">' + educator.full_name + '</option>');
            });
        },
        error: function(xhr) {
            $('#responseMessage')
                .addClass('alert alert-danger')
                .html('Failed to load educators.');
        }
    });
}

    function loadRegionalManagers() {
        $.ajax({
            url: "getrmsname",
             method: 'GET',
            dataType: 'json',

            success: function(data) {
                let rmSelect = $('#rm_id');
                rmSelect.empty();
                rmSelect.append('<option value="">-- Select Regional Cordinator --</option>');
                rmSelect.append('<option value="0">Unassign (No RC)</option>');
                data.forEach(function(rm) {
                    rmSelect.append('<option value="' + rm.id + '">' + rm.full_name + '</option>');
                });
            },
            error: function(xhr) {
                $('#responseMessage')
                    .addClass('alert alert-danger')
                    .html('Failed to load Regional Managers.');
            }
        });
    }



    $('#assignEducatorForm').submit(function(e) {
        e.preventDefault();

        $('#responseMessage').removeClass('alert-success alert-danger').html('');

        let formData = {
            educator_id: $('#educator_id').val(),
            rm_id: $('#rm_id').val()
        };

        if (!formData.educator_id || formData.rm_id === '') {
            $('#responseMessage').addClass('alert alert-danger').html('Please select both educator and RM');
            return;
        }

        $('button[type="submit"]').prop('disabled', true).html('Processing...');

        $.ajax({
             url: "{{ url('nc-Assign-Educator-Post') }}",
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#responseMessage').addClass('alert alert-success').html(response.message);
                    $('#assignEducatorForm')[0].reset();
                } else {
                    $('#responseMessage').addClass('alert alert-danger').html(response.message);
                }
            },
            error: function(xhr) {
                $('#responseMessage').addClass('alert alert-danger').html('An error occurred.');
            },
            complete: function() {
                $('button[type="submit"]').prop('disabled', false).html('Assign Educator');
            }
        });
    });
});
</script>

