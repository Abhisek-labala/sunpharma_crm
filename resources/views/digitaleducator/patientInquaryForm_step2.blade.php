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
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('digital.patient.step1', ['uuid' => $uuid]) }}" class="btn btn-secondary">Previous</a>
                    <button type="button" class="btn btn-primary" onclick="saveStep2()">Next</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function saveStep2() {
        var formData = $('#step2Form').serialize();
        $.ajax({
            url: "{{ route('digital.patient.save.step2') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                if(response.success) {
                    window.location.href = "{{ url('digitalcounsellor/patient-inquiry/step-3') }}/" + response.uuid;
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
