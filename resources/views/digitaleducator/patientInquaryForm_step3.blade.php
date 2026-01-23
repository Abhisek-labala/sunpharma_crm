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

            <form id="step3Form">
                @csrf
                <input type="hidden" name="patient_uuid" value="{{ $uuid }}">
                <input type="hidden" id="patient_age" value="{{ $patient->age ?? 30 }}"> <!-- Default to 30 if missing -->
                <input type="hidden" id="patient_gender" value="{{ $patient->gender ?? 'Male' }}">

                <!-- Step 3: Obesity Details -->
                <div class="card mb-4">
                    <div class="card-header thembutton text-white">
                        <h5 class="mb-0">Obesity Details (Step 3/4)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Weight <span class='mandatory'>*</span></label>
                                <input type="number" step="0.01" class="form-control" name="weight" id="weight" placeholder="--Weight in Kg--" required oninput="calculateBMI()" value="{{ $medication->weight ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Height <span class='mandatory'>*</span></label>
                                <input type="number" step="0.01" class="form-control" name="height" id="height" placeholder="--Height in cm--" required oninput="calculateBMI(); calculateWHtR();" value="{{ $medication->height ?? '' }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Waist Circumference <span class='mandatory'>*</span></label>
                                <input type="number" step="0.01" class="form-control" name="waist_circumference" id="waist_circumference" placeholder="--Waist Circumference in cm--" required oninput="calculateWHtR()" value="{{ $medication->waist_circumference ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">BMI <span class='mandatory'>*</span></label>
                                <input type="text" class="form-control" name="bmi" id="bmi" readonly value="{{ $medication->bmi ?? '' }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">W-HtR <span class='mandatory'>*</span></label>
                                <input type="text" class="form-control" name="w_htr" id="w_htr" readonly value="{{ $medication->waist_to_height_ratio ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Metabolic Age <span class='mandatory'>*</span></label>
                                <input type="text" class="form-control" name="metabolic_age" id="metabolic_age" readonly value="{{ $medication->metabolic_age ?? '' }}"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Co-morbidities if any <span class='mandatory'>*</span></label>
                                <input type="text" class="form-control" name="co_morbidities" id="co_morbidities" placeholder="--Mention--" value="{{ $medication->co_morbidities ?? '' }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <textarea class="form-control" name="additional_notes" rows="4" placeholder="--Mention Additional Notes--">{{ $medication->remark ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ route('digital.patient.step2', ['uuid' => $uuid]) }}" class="btn btn-secondary">Previous</a>
                    <button type="button" class="btn btn-primary" onclick="saveStep3()">Next</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function calculateBMI() {
        const weight = parseFloat(document.getElementById('weight').value);
        const heightCm = parseFloat(document.getElementById('height').value);
        
        if (weight > 0 && heightCm > 0) {
            const heightM = heightCm / 100;
            const bmi = (weight / (heightM * heightM)).toFixed(2);
            document.getElementById('bmi').value = bmi;
            calculateMetabolicAge(bmi);
        }
    }

    function calculateMetabolicAge(bmi) {
        const age = parseFloat(document.getElementById('patient_age').value) || 30;
        const bmiVal = parseFloat(bmi);
        
        const diff = bmiVal - 22;
        
        // Exact match with Educator form logic
        let metabolicAge = age + (diff * 0.8);
        
        if(metabolicAge < 12) metabolicAge = 12;
        
        document.getElementById('metabolic_age').value = Math.round(metabolicAge);
    }

    function calculateWHtR() {
        const waist = parseFloat(document.getElementById('waist_circumference').value);
        const height = parseFloat(document.getElementById('height').value);

        if (waist > 0 && height > 0) {
            const whtr = (waist / height).toFixed(2);
            document.getElementById('w_htr').value = whtr;
        }
    }

    function saveStep3() {
        var formData = $('#step3Form').serialize();
        $.ajax({
            url: "{{ route('digital.patient.save.step3') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                if(response.success) {
                    window.location.href = "{{ url('digitalcounsellor/patient-inquiry/step-4') }}/" + response.uuid;
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
