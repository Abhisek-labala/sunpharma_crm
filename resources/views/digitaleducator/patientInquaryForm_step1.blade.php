@include('digitaleducator.head')

<div class="main-wrapper">
    @include('digitaleducator.header')
    @include('digitaleducator.Sidebar')

    <script src="{{asset('js/jquery.min.js')}}"></script>
    <style>
        .mandatory {
            color: red;
            font-weight: bold;
        }
    </style>

    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            @include('digitaleducator.breadcum')

            <form id="step1Form">
                @csrf
                <input type="hidden" name="patient_uuid" id="patient_uuid" value="{{ $uuid ?? '' }}">

                <!-- Step 1: HCP Details -->
                <div class="card mb-4">
                    <div class="card-header thembutton text-white">
                        <h5 class="mb-0">Doctor Details (Step 1/4)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Doctor Name <span class='mandatory'>*</span></label>
                                <select class="form-select form-control" name="hcp_name" id="hcp_name" required>
                                    <option selected="selected" value="">--Select--</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Doctor Code <span class='mandatory'>*</span></label>
                                <input type="text" class="form-control" name="msl_code" id="msl_code" required readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">State <span class='mandatory'>*</span></label>
                                <select class="form-select form-control" name="state" id="state" required>
                                    <option value="">--Select--</option>
                                    <!-- Populate via JS -->
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">City <span class='mandatory'>*</span></label>
                                <select class="form-select form-control" name="city" id="city" required>
                                    <option value="">--Select--</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Speciality <span class='mandatory'>*</span></label>
                                <select class="form-select form-control" name="speciality" id="speciality" required>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="button" class="btn btn-primary" onclick="saveStep1()">Next</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
         // Load HCP Names
        $.ajax({
            url: "{{ url('digitalcounsellor/getHCPNames') }}", // Reuse Educator route if shared, or create new
            type: "GET",
            success: function(response) {
                var html = '<option value="">-- Select --</option>';
                $.each(response.data, function(key, value) {
                    html += '<option value="' + value.id + '">' + value.name + '</option>';
                });
                $('#hcp_name').html(html);
                
                @if(isset($patient))
                    $('#hcp_name').val('{{ $patient->hcp_id }}').trigger('change');
                @endif
            }
        });

        // HCL Details on change
        $('#hcp_name').change(function() {
            var doctor_id = $(this).val();
            if(doctor_id) {
                $.ajax({
                    url: "{{ url('digitalcounsellor/getHCLDetails') }}", // Reuse or duplicate
                    type: "POST",
                    data: {
                        doctor_id: doctor_id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status == 'success' && response.data.length > 0) {
                            var data = response.data[0];
                            $('#msl_code').val(data.msl_code);
                            
                            var stateHtml = '<option value="'+data.state+'" selected>'+data.state+'</option>';
                            $('#state').html(stateHtml);
                            
                            var cityHtml = '<option value="'+data.city+'" selected>'+data.city+'</option>';
                            $('#city').html(cityHtml);

                            var specialityHtml = '<option value="'+data.speciality+'" selected>'+data.speciality+'</option>';
                            $('#speciality').html(specialityHtml);
                        }
                    }
                });
            }
        });
    });

    function saveStep1() {
        var formData = $('#step1Form').serialize();
        $.ajax({
            url: "{{ route('digital.patient.save.step1') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                if(response.success) {
                    window.location.href = "{{ url('digitalcounsellor/patient-inquiry/step-2') }}/" + response.uuid;
                } else {
                    alert('Error saving data');
                }
            },
            error: function(xhr) {
               alert('Error: ' + xhr.responseText);
            }
        });
    }
</script>
