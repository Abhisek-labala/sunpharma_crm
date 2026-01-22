@include('educator.head')

<!-- Main Wrapper -->
<div class="main-wrapper">
    @include('educator.header')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <style>
        .select2-container { z-index: 1051 !important; }
        .select2-search__field { width: 100% !important; }
        .select2-container--default .select2-selection--multiple { min-height: 38px; padding: 5px; }

        .form-label { font-weight: 500; color: #333; }
        .mandatory { color: red; margin-left: 2px; }
        
        .btn-next { float: right; font-weight: bold; }
    </style>

    @include('educator.Sidebar')

    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/chosen.jquery.min.js')}}"></script>
    <link href="{{asset('css/chosen.min.css')}}" rel="stylesheet" />

    <!-- Page Wrapper -->
    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            <!-- Page Header -->
            @include('educator.breadcum')
            <!-- /Page Header -->

            <form id="step1Form">
                @csrf
                <input type="hidden" name='campId' id='campId' value=''>
                {{-- Handle editing existing patient if uuid is present --}}
                <input type="hidden" name="patient_uuid" id="patient_uuid" value="{{ $uuid ?? '' }}">

                <!-- Step 1: HCP Details -->
                <div class="card mb-4">
                    <div class="card-header thembutton text-white">
                        <h5 class="mb-0">HCP Details (Step 1/4)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">HCP Name <span class='mandatory'>*</span></label>
                                <select class="form-select form-control" name="hcp_name" id="hcp_name" required>
                                    <option selected="selected" value="">--Select--</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">HCP Code <span class='mandatory'>*</span></label>
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
                        
                        <div class="mt-4 clearfix">
                            <button type="button" class="btn btn-primary btn-next" onclick="saveAndNext()">Next <i class="fa fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        getCampId();
        getHcpNames();

        const existingUuid = "{{ $uuid ?? '' }}";
        if(existingUuid) {
        }
    });

    function getCampId() {
        $.ajax({
            url: "{{ url('counsellor/get-camp-id') }}",
            type: "GET",
            success: function(response) {
                if(response.campId) {
                    $('#campId').val(response.campId.camp_id);
                }
            }
        });
    }

    function getHcpNames() {
        $.ajax({
            url: "{{ url('counsellor/getHCPNames') }}",
            type: "GET",
            success: function(response) {
                let options = '<option value="">--Select--</option>';
                response.data.forEach(function(doctor) {
                    options += `<option value="${doctor.id}">${doctor.name}</option>`;
                });
                $('#hcp_name').html(options);
                
                @if(isset($patient) && $patient->hcp_id)
                    setTimeout(function() {
                        $('#hcp_name').val("{{ $patient->hcp_id }}");
                        if(typeof fetchHcpDetails === 'function') {
                            fetchHcpDetails("{{ $patient->hcp_id }}");
                        } else {
                            $('#hcp_name').trigger('change');
                        }
                    }, 500);
                @endif
            }
        });
    }
    
    function fetchHcpDetails(id) {
        if(id) {
            $.ajax({
                url: "{{ url('counsellor/getHCLDetails') }}",
                type: "POST",
                data: {
                    doctor_id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if(res.status === 'success' && res.data.length > 0) {
                        const doc = res.data[0];
                        $('#msl_code').val(doc.msl_code || '');
                        
                        // Populate State
                        if(doc.state) {
                            $('#state').html(`<option value="${doc.state}" selected>${doc.state}</option>`);
                        } else {
                            $('#state').html('<option value="">--Select--</option>');
                        }

                        // Populate City
                        if(doc.city) {
                             $('#city').html(`<option value="${doc.city}" selected>${doc.city}</option>`);
                        } else {
                            $('#city').html('<option value="">--Select--</option>');
                        }
                        
                        // Populate Speciality
                        if(doc.speciality) {
                             let exists = false;
                             $('#speciality option').each(function(){
                                 if (this.value == doc.speciality) {
                                     exists = true;
                                     return false;
                                 }
                             });
                             
                             if(!exists){
                                 $('#speciality').append(new Option(doc.speciality, doc.speciality));
                             }
                             $('#speciality').val(doc.speciality);
                        } else {
                            $('#speciality').val('');
                        }
                    }
                },
                error: function(err) {
                     console.error(err);
                }
            });
        }
    }

    $('#hcp_name').change(function() {
        const id = $(this).val();
        fetchHcpDetails(id);
    });



    async function saveAndNext() {
        const hcp = $('#hcp_name').val();
         // Basic Validation
        if (!hcp) {
            alert('Please select HCP Name');
            return;
        }

        const btn = $('.btn-next');
        btn.prop('disabled', true).html('Saving... <i class="fa fa-spinner fa-spin"></i>');

        const formData = new FormData(document.getElementById('step1Form'));
        
        try {
            const response = await fetch("{{ url('counsellor/patient-inquiry/save-step-1') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            
            if (result.success) {
                window.location.href = "{{ url('counsellor/patient-inquiry/step-2') }}/" + result.uuid;
            } else {
                alert('Error: ' + result.message);
                btn.prop('disabled', false).html('Next <i class="fa fa-arrow-right"></i>');
            }
        } catch (error) {
            console.error(error);
            alert('An error occurred.');
            btn.prop('disabled', false).html('Next <i class="fa fa-arrow-right"></i>');
        }
    }
</script>
@include('educator.footer')
