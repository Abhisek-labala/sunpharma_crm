@include('educator.head');

<!-- Main Wrapper -->
<div class="main-wrapper">
    @include('educator.header');
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <style>
        .select2-container { z-index: 1051 !important; }
        .select2-search__field { width: 100% !important; }
        .select2-container--default .select2-selection--multiple { min-height: 38px; padding: 5px; }

        .form-label { font-weight: 500; color: #333; }
        .mandatory { color: red; margin-left: 2px; }
        
        .btn-next { float: right; font-weight: bold; }
        .btn-prev { float: left; font-weight: bold; }
    </style>

    @include('educator.Sidebar');

    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/chosen.jquery.min.js')}}"></script>
    <link href="{{asset('css/chosen.min.css')}}" rel="stylesheet" />

    <!-- Page Wrapper -->
    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            <!-- Page Header -->
            @include('educator.breadcum')
            <!-- /Page Header -->

            <form action="{{ url('counsellor/Patient-Inquiry-Post') }}" name="createPatientInquiry" id="createPatientInquiry" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name='campId' id='campId' value='{{ $campId ?? "" }}'>
                <input type="hidden" name="patient_uuid" id="patient_uuid">

                <!-- Step 1: HCP Details -->
                <div class="wizard-step active" id="step1">
                    <div class="card mb-4">
                        <div class="card-header thembutton text-white">
                            <h5 class="mb-0">HCP Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">HCP Name <span class='mandatory'>*</span></label>
                                    <select class="form-select form-control" name="hcp_name" id="hcp_name" required>
                                        <option selected="selected" value="">--Select--</option>
                                        <!-- Options populated dynamically -->
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
                                        <option value="">--Select--</option>
                                        <option value="Obesity">Obesity</option>
                                        <option value="Heart">Heart</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mt-4 clearfix">
                                <button type="button" class="btn btn-primary btn-next" onclick="nextStep(1)">Next <i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Patient Details -->
                <div class="wizard-step" id="step2">
                    <div class="card mb-4">
                        <div class="card-header thembutton text-white">
                            <h5 class="mb-0">Patient Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Patient Name <span class='mandatory'>*</span></label>
                                    <input type="text" class="form-control" name="patient_name" id="patient_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mobile Number <span class='mandatory'>*</span></label>
                                    <input type="text" class="form-control" name="mobile_number" id="mobile_number" maxlength="10" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">City <span class='mandatory'>*</span></label>
                                    <select class="form-select form-control" name="patient_city" id="patient_city" required>
                                        <option value="">--Select--</option>
                                        <!-- City options -->
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Age <span class='mandatory'>*</span></label>
                                    <select class="form-select form-control" name="age" id="age" required>
                                        <option value="">--Select--</option>
                                        @for($i=1; $i<=100; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                        <option value="100+">100+</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Gender <span class='mandatory'>*</span></label>
                                    <select class="form-select form-control" name="gender" id="gender" required>
                                        <option value="">--Select--</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-4 clearfix">
                                <button type="button" class="btn btn-secondary btn-prev" onclick="prevStep(2)"><i class="fa fa-arrow-left"></i> Back</button>
                                <button type="button" class="btn btn-primary btn-next" onclick="nextStep(2)">Next <i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Obesity Details -->
                <div class="wizard-step" id="step3">
                    <div class="card mb-4">
                        <div class="card-header thembutton text-white">
                            <h5 class="mb-0">Obesity Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Weight <span class='mandatory'>*</span></label>
                                    <input type="number" step="0.01" class="form-control" name="weight" id="weight" placeholder="--Weight in Kg--" required oninput="calculateBMI()">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Height <span class='mandatory'>*</span></label>
                                    <input type="number" step="0.01" class="form-control" name="height" id="height" placeholder="--Height in cm--" required oninput="calculateBMI(); calculateWHtR();">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Waist Circumference <span class='mandatory'>*</span></label>
                                    <input type="number" step="0.01" class="form-control" name="waist_circumference" id="waist_circumference" placeholder="--Waist Circumference in cm--" required oninput="calculateWHtR()">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">BMI <span class='mandatory'>*</span></label>
                                    <select class="form-select form-control" name="bmi_display" id="bmi_display" disabled>
                                        <option value="">--Calculated automatically--</option>
                                    </select>
                                    <input type="hidden" name="bmi" id="bmi">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">W-HtR <span class='mandatory'>*</span></label>
                                    <select class="form-select form-control" name="w_htr_display" id="w_htr_display" disabled>
                                        <option value="">--Calculated automatically--</option>
                                    </select>
                                    <input type="hidden" name="w_htr" id="w_htr">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Metabolic Age <span class='mandatory'>*</span></label>
                                    <select class="form-select form-control" name="metabolic_age_display" id="metabolic_age_display" disabled>
                                        <option value="">--Calculated automatically--</option>
                                    </select>
                                    <input type="hidden" name="metabolic_age" id="metabolic_age" value="N/A"> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Co-morbidities if any <span class='mandatory'>*</span></label>
                                    <input type="text" class="form-control" name="co_morbidities" id="co_morbidities" placeholder="--Mention--">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <textarea class="form-control" name="additional_notes" rows="4" placeholder="--Mention Additional Notes--"></textarea>
                                </div>
                            </div>

                            <div class="mt-4 clearfix">
                                <button type="button" class="btn btn-secondary btn-prev" onclick="prevStep(3)"><i class="fa fa-arrow-left"></i> Back</button>
                                <button type="button" class="btn btn-primary btn-next" onclick="nextStep(3)">Next <i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Brand Details -->
                <div class="wizard-step" id="step4">
                    <div class="card mb-4">
                        <div class="card-header thembutton text-white">
                            <h5 class="mb-0">Brand Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label d-block">Any SunPharma brand has been Prescribed? <span class='mandatory'>*</span></label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sunpharma_prescribed" id="sp_yes" value="Yes" required>
                                        <label class="form-check-label" for="sp_yes">YES</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sunpharma_prescribed" id="sp_no" value="No">
                                        <label class="form-check-label" for="sp_no">NO</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Brand Prescribed <span class='mandatory'>*</span></label>
                                    <select class="form-select form-control" name="brand_prescribed" id="brand_prescribed" required>
                                        <option value="">--Select--</option>
                                        <!-- Populate list -->
                                        <option value="Brand A">Brand A</option>
                                        <option value="Brand B">Brand B</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Competitor Brand Prescribed <span class='mandatory'>*</span></label>
                                    <select class="form-select form-control" name="competitor_brand" id="competitor_brand" required>
                                        <option value="">--Select--</option>
                                        <option value="Competitor A">Competitor A</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">If the Prescription is available. Please Upload. <span class='mandatory'>*</span></label>
                                    <div class="d-flex align-items-center">
                                        <input type="file" class="form-control" name="prescription_file" id="prescription_file" accept="image/*,application/pdf">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Upload Patient Consent Form <span class='mandatory'>*</span></label>
                                    <div class="d-flex align-items-center">
                                        <input type="file" class="form-control" name="consent_form" id="consent_form" accept="image/*,application/pdf" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 clearfix">
                                <button type="button" class="btn btn-secondary btn-prev" onclick="prevStep(4)"><i class="fa fa-arrow-left"></i> Back</button>
                                <button type="submit" class="btn btn-primary btn-next" id="submitBtn">Submit <i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    async function nextStep(currentStep) {
        const btn = document.querySelector(`#step${currentStep} .btn-next`);
        const originalText = btn.innerHTML;

        if(validateStep(currentStep)) {
            // Show loading state
            btn.disabled = true;
            btn.innerHTML = 'Saving... <i class="fa fa-spinner fa-spin"></i>';

            const saved = await savePhaseData(currentStep);

            // Restore button state
            btn.disabled = false;
            btn.innerHTML = originalText;

            if (saved) {
                document.getElementById('step' + currentStep).classList.remove('active');
                document.getElementById('step' + (currentStep + 1)).classList.add('active');
            }
        }
    }

    function prevStep(currentStep) {
        document.getElementById('step' + currentStep).classList.remove('active');
        document.getElementById('step' + (currentStep - 1)).classList.add('active');
    }

    function validateStep(step) {
        let valid = true;
        const stepDiv = document.getElementById('step' + step);
        const inputs = stepDiv.querySelectorAll('input[required], select[required], textarea[required]');
        
        inputs.forEach(input => {
            if (!input.value) {
                valid = false;
                input.style.border = '1px solid red';
            } else {
                input.style.border = '';
            }
        });

        if (!valid) {
            alert('Please fill all mandatory fields to proceed.');
        }
        return valid;
    }

    async function savePhaseData(step) {
        const formData = new FormData(document.getElementById('createPatientInquiry'));
        const csrfToken = document.querySelector('input[name="_token"]').value;
        
        let url = '';
        if (step === 1) url = '{{ url("counsellor/patient-inquiry/save-step-1") }}';
        if (step === 2) url = '{{ url("counsellor/patient-inquiry/save-step-2") }}';
        if (step === 3) url = '{{ url("counsellor/patient-inquiry/save-step-3") }}';

        if (!url) return true; // Should ideally not happen for steps 1-3

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();
            if (result.success) {
                if (result.uuid) {
                    document.getElementById('patient_uuid').value = result.uuid;
                }
                return true;
            } else {
                alert('Error saving data: ' + result.message);
                return false;
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while saving.');
            return false;
        }
    }

    function calculateBMI() {
        const weight = parseFloat(document.getElementById('weight').value);
        const heightCm = parseFloat(document.getElementById('height').value);
        
        if (weight > 0 && heightCm > 0) {
            const heightM = heightCm / 100;
            const bmi = (weight / (heightM * heightM)).toFixed(2);
            document.getElementById('bmi').value = bmi;
            document.getElementById('bmi_display').innerHTML = `<option>${bmi}</option>`;
        }
    }

    function calculateWHtR() {
        const waist = parseFloat(document.getElementById('waist_circumference').value);
        const height = parseFloat(document.getElementById('height').value);

        if (waist > 0 && height > 0) {
            const whtr = (waist / height).toFixed(2);
            document.getElementById('w_htr').value = whtr;
            document.getElementById('w_htr_display').innerHTML = `<option>${whtr}</option>`;
        }
    }
</script>
