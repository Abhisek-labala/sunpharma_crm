@include('pm.header') {{-- Assuming you use a layout named "app" --}}

@section('content')
<div class="main-wrapper">
    @include('pm.Sidebar') {{-- Replaces side_bar.php --}}

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
                                    <label class="col-form-label col-md-2">Select HCP</label>
                                    <div class="col-md-10">
                                        <select name="hcp_id" id="hcp_id" class="form-select form-control" required>
                                            <option value="">-- Select HCP --</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-2">Assign to Educator</label>
                                    <div class="col-md-10">
                                        <select name="educator_id" id="educator_id" class="form-select form-control" required>
                                            <option value="">-- Select Educator --</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-2"></label>
                                    <div class="col-md-10">
                                        <button type="submit" class="btn btn-primary">Assign HCP</button>
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
    loadHCPs();
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
    function loadHCPs() {
        $.ajax({
            url: "getDoctorsname",
             method: 'GET',
            dataType: 'json',

            success: function(data) {
                let hcpSelect = $('#hcp_id');
                hcpSelect.empty();
                hcpSelect.append('<option value="">-- Select HCP --</option>');

                data.forEach(function(hcp) {
                    hcpSelect.append('<option value="' + hcp.id + '">' + hcp.name + '</option>');
                });
            },
            error: function(xhr) {
                $('#responseMessage')
                    .addClass('alert alert-danger')
                    .html('Failed to load HCPs.');
            }
        });
    }

    $('#assignEducatorForm').submit(function(e) {
        e.preventDefault();

        $('#responseMessage').removeClass('alert-success alert-danger').html('');

        var formData = {
            hcp_id: $('#hcp_id').val(),
            educator_id: $('#educator_id').val(),
            _token: '{{ csrf_token() }}'
        };

        if (!formData.educator_id || !formData.hcp_id) {
            $('#responseMessage').addClass('alert alert-danger').html('Please select both educator and HCP');
            return;
        }

        $('button[type="submit"]').prop('disabled', true).html('Processing...');

        $.ajax({
            url: "{{ url('pm-Assign-Hcp-Post') }}",
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
                $('button[type="submit"]').prop('disabled', false).html('Assign HCP');
            }
        });
    });
});
</script>

