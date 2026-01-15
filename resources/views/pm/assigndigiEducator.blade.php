
@include('pm.header')

<div class="main-wrapper">
    @include('pm.Sidebar')

    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            @include('pm.breadcum')


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
                                    <div class="col-md-10 offset-md-2">
                                        <button type="submit" class="btn btn-primary">Assign Digital Counsellor</button>
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
    loaddigiEducators();
    loadRegionalManagers();
    // Load educators and RMs dynamically
    function loaddigiEducators() {
    $.ajax({
        url: "getdigiEducatorsname",
        method: 'GET',
        dataType: 'json', // ensures JSON parsing
        success: function(data) {
            let educatorSelect = $('#educator_id');
            educatorSelect.empty();
            educatorSelect.append('<option value="">-- Select Counsellor --</option>');

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

        const formData = {
            educator_id: $('#educator_id').val(),
            rm_id: $('#rm_id').val()

        };

        if (!formData.educator_id || formData.rm_id === '') {
            $('#responseMessage').addClass('alert alert-danger').html('Please select both counsellor and RC');
            return;
        }

        $('button[type="submit"]').prop('disabled', true).html('Processing...');

        $.ajax({
            url: "{{ url('pm-Assign-DigitalEducator-Post') }}",
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
                $('button[type="submit"]').prop('disabled', false).html('Assign Digital Educator');
            }
        });
    });
});
</script>

