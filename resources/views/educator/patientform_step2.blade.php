@include('educator.head')

<div class="main-wrapper">
    @include('educator.header')
    @include('educator.Sidebar')

    <script src="{{asset('js/jquery.min.js')}}"></script>
    <style>
        .mandatory {
            color: red;
            font-weight: bold;
        }
    </style>

    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            @include('educator.breadcum')

            <form id="step2Form">
                @csrf
                <input type="hidden" name="patient_uuid" value="{{ $uuid }}">

                <!-- Step 2: Patient Details -->
                <div class="card mb-4">
                    <div class="card-header thembutton text-white">
                        <h5 class="mb-0">Patient Details (Step 2/4)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Patient Name <span class='mandatory'>*</span></label>
                                <input type="text" class="form-control" name="patient_name" id="patient_name" value="{{ $patient->patient_name ?? '' }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mobile Number <span class='mandatory'>*</span></label>
                                <input type="text" class="form-control" name="mobile_number" id="mobile_number" maxlength="10" value="{{ $patient->mobile_number ?? '' }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">City <span class='mandatory'>*</span></label>
                                 <input type="text" class="form-control" name="patient_city" id="patient_city" value="{{ $patient->patient_city ?? '' }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Age <span class='mandatory'>*</span></label>
                                <select class="form-select form-control" name="age" id="age" required>
                                    <option value="">--Select--</option>
                                    @for($i=1; $i<=100; $i++)
                                        <option value="{{$i}}" {{ (isset($patient->age) && $patient->age == $i) ? 'selected' : '' }}>{{$i}}</option>
                                    @endfor
                                    <option value="100+" {{ (isset($patient->age) && $patient->age == '100+') ? 'selected' : '' }}>100+</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gender <span class='mandatory'>*</span></label>
                                <select class="form-select form-control" name="gender" id="gender" required>
                                    <option value="">--Select--</option>
                                    <option value="Male" {{ (isset($patient->gender) && $patient->gender == 'Male') ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ (isset($patient->gender) && $patient->gender == 'Female') ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ (isset($patient->gender) && $patient->gender == 'Other') ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 clearfix">
                            <a href="{{ route('educator.patient.step1', ['uuid' => $uuid]) }}" class="btn btn-secondary float-left"><i class="fa fa-arrow-left"></i> Back</a>
                            <button type="button" class="btn btn-primary float-right btn-next" onclick="saveAndNext()">Next <i class="fa fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    async function saveAndNext() {
        const name = $('#patient_name').val();
         // Basic Validation check
        if (!name) {
            alert('Please fill mandatory fields');
            return;
        }

        const btn = $('.btn-next');
        btn.prop('disabled', true).html('Saving... <i class="fa fa-spinner fa-spin"></i>');

        const formData = new FormData(document.getElementById('step2Form'));
        
        try {
            const response = await fetch("{{ url('counsellor/patient-inquiry/save-step-2') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            
            if (result.success) {
                window.location.href = "{{ url('counsellor/patient-inquiry/step-3') }}/" + "{{ $uuid }}";
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
