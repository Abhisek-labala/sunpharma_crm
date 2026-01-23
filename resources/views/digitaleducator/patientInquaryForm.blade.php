@include('digitaleducator.head');

<!-- Main Wrapper -->
<div class="main-wrapper">
    @include('digitaleducator.header');
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <style>
        .select2-container {
            z-index: 1051 !important;
        }

        .select2-search__field {
            width: 100% !important;
        }


        .select2-container--default .select2-selection--multiple {
            min-height: 38px;
            padding: 5px;
        }
    </style>


    @include('digitaleducator.Sidebar');

    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/chosen.jquery.min.js')}}"></script>
    <link href="{{asset('css/chosen.min.css')}}" rel="stylesheet" />

    <style>
        .error-border {
            border: 2px solid red !important;
        }
    </style>


    <style>
        .mandatory {
            color: red;
            font-size: 16px;
            font-weight: 500;
            margin-left: 2px;
        }
    </style>

    <!-- /Sidebar -->
    <!-- Page Wrapper -->
    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            <!-- Page Header -->
            @include('digitaleducator.breadcum')
            <!-- /Page Header -->
            <form action="{{ url('digitalcounsellor/Patient-Inquiry-Post') }}" name="createPatientInquiry"
                id="createPatientInquiry" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card mb-4">
                    <div class="card-header thembutton text-white">
                        <h5 class="mb-0">HCP Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-4" for="hcp_name">HCP Name <span
                                            class='mandatory'>*</span></label>
                                    <div class="col-md-8">
                                        <select class="form-select form-control" name="hcp_name" id="hcp_name" required>
                                            <option selected="selected" value="">-- Select --</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-4" for="msl_code">MSL Code<span
                                            class='mandatory'>*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" maxlength="50" class="form-control" name="msl_code"
                                            id="msl_code" value="" required readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-4" for="city">State <span
                                            class='mandatory'>*</span></label>
                                    <div class="col-md-8">
                                        <select class="form-select form-control" name="state" id="state" required>
                                            <option selected="selected" value="">-- Select --</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-4" for="city">City<span
                                            class='mandatory'>*</span></label>
                                    <div class="col-md-8">
                                        <select class="form-select form-control" name="city" id="city" required>
                                            <option selected="selected" value="">-- Select --</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3 row">
                                    <label class="col-form-label col-md-4" for="speciality">Speciality<span
                                            class='mandatory'>*</span></label>
                                    <div class="col-md-8">
                                        <select class="form-select form-control" name="speciality" id="speciality"
                                            required>
                                            <option value="">-- Select --</option>
                                            <option value="Obesity">Obesity</option>
                                            <option value="Heart">Heart</option>
                                        </select>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header thembutton text-white">
                            <h5 class="mb-0">Patient Details </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="mb-3 row">
                                        <label class="col-form-label col-md-4" for="patient_name">Patient Name<span
                                                class='mandatory'>*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" maxlength="50" class="form-control" name="patient_name"
                                                id="patient_name" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="mb-3 row">
                                        <label class="col-form-label col-md-4" for="age">Age<span
                                                class='mandatory'>*</span></label>
                                        <div class="col-md-8">
                                            <select class="form-select form-control" name="age" id="age" required>
                                                <option value="">-- Select --</option>

                                                <option value="100+">100+</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="mb-3 row">
                                        <label class="col-form-label col-md-4" for="mobile_number">Mobile Number<span
                                                class='mandatory'>*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" maxlength="10" class="form-control" name="mobile_number"
                                                id="mobile_number" value="" required inputmode="numeric">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="mb-3 row">
                                        <label class="col-form-label col-md-4" for="gender">Gender<span
                                                class='mandatory'>*</span></label>
                                        <div class="col-md-8">
                                            <select class="form-select form-control" name="gender" id="gender" required>
                                                <option value="">-- Select --</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-lg-6">
                                    <div class="mb-3 row">
                                        <label class="col-form-label col-md-4" for="gender">Cipla Brand Prescribed<span
                                                class='mandatory'>*</span></label>
                                        <div class="col-md-6">
                                            <span class="radio">
                                                <label><input type="radio" name="ciplaBrandPrescribed"
                                                        id="ciplaBrandPrescribed" value="Yes"> Yes</label>
                                            </span>
                                            <span class="radio">
                                                <label><input type="radio" name="ciplaBrandPrescribed"
                                                        id="ciplaBrandPrescribed" value="No"> No</label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6" id="prescriptionDiv">
                                    <div class="mb-3 row">
                                        <label class="col-form-label col-md-4" for="mobile_number">Upload
                                            Prescription<span class='mandatory'>*</span></label>
                                        <div class="col-md-8">
                                            <input type="file" accept="image/*" name="fileToUpload[]" id="fileToUpload"
                                                style="width:100%;" required="" multiple>
                                            <div id="prescriptionPreview" style="margin-top: 10px; display: none;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <!-- Removed Prescription Available, Purchase Bill, Patient Enrolled, Kit Enrolled -->
                            <div class="col-md-6 col-lg-6" id="medicinediv">
                                    <div class="mb-3 row">
                                        <label class="col-form-label col-md-4" for="medicine">Medicine<span
                                                class='mandatory'>*</span></label>
                                        <div class="col-md-8">
                                            <select class="form-control select2" name="medicine[]" id="medicine"
                                                multiple="multiple" required style="width: 100%;">
                                                <option value="">-- Select Medicine --</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6" id="consentFormDiv">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-4" for="mobile_number">Upload Consent
                                                Form<span class='mandatory'>*</span></label>
                                            <div class="col-md-8">
                                                <input type="file" accept="image/*" name="consentForm" id="consentForm"
                                                    style="width:100%;" required="" multiple="multiple">
                                                <div id="consentPreview" style="margin-top: 10px; display: none;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-4" for="Compititor">Competitor<span
                                                    class='mandatory'>*</span></label>
                                            <div class="col-md-8">
                                                <select class="form-control select2" name="Compititor[]" id="Compititor"
                                                    multiple="multiple" required style="width: 100%;">
                                                    <option value="">-- Select Competitor --</option>
                                                    <option value="N/A">N/A</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='h25'></div>
                    </div>
                    <!-- Cardio Start -->
                    <div id='ciplaBrandPrescribedDiv'>
                        <div class="card mb-4">
                            <div class="card-header thembutton text-white">
                                <h5 class="mb-0">Cardio</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 col-lg-4">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-6" for="date_of_discharge">Date of
                                                Discharge</label>
                                            <div class="col-md-6">
                                                <input type="text" maxlength="10" class="form-control datepicker"
                                                    name="date_of_discharge" id="date_of_discharge"
                                                    value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-5" for="blood_pressure">Blood
                                                Pressure<span class='mandatory'>*</span></label>
                                            <div class="col-md-7">
                                                <input type="text" placeholder="Systolic /Diastolic (mm Hg)"
                                                    maxlength="10" class="form-control" name="blood_pressure"
                                                    id="blood_pressure" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3" for="urea">Urea</label>
                                            <div class="col-md-9">
                                                <input type="text" placeholder="(mg/dL)" maxlength="10"
                                                    class="form-control" name="urea" id="urea" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3" for="lv_ef">LV EF</label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(%)" maxlength="10" class="form-control"
                                                    name="lv_ef" id="lv_ef">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3" for="heart_rate">Heart Rate<span
                                                    class='mandatory'>*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="bpm" maxlength="10" class="form-control"
                                                    name="heart_rate" id="heart_rate">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- 2 -->
                                <div class="row">
                                    <div class='col-md-6 col-lg-6'>
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">NT Pro BNP</label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(pg/mL)" maxlength="50"
                                                    class="form-control" name="nt_pro_bnp" id="nt_pro_bnp">
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-md-6 col-lg-6'>
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">EGFR</label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(mL/min/1.73m2)" maxlength="10"
                                                    class="form-control" name="egfr" id="egfr">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-6 col-lg-6'>
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">Potassium<span
                                                    class='mandatory'>*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(mmol/L)" maxlength="50"
                                                    class="form-control" name="potassium" id="potassium">
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-md-6 col-lg-6'>
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">Sodium<span
                                                    class='mandatory'>*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(mmol/L)" maxlength="10"
                                                    class="form-control" name="sodium" id="sodium">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-6 col-lg-6'>
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">Uric Acid</label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(mg/dL)" maxlength="50"
                                                    class="form-control" name="uric_acid" id="uric_acid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-md-6 col-lg-6'>
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">Creatinine</label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(mg/dL)" maxlength="10"
                                                    class="form-control" name="creatinine" id="creatinine">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-lg-4">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">CRP</label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(mg/L)" maxlength="10"
                                                    class="form-control" name="crp" id="crp">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">UACR</label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(mg/g)" maxlength="10"
                                                    class="form-control" name="uacr" id="uacr">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">Iron</label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(mcg/dL)" maxlength="10"
                                                    class="form-control" name="iron" id="iron">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-lg-4">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">HB</label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(g/dL)" maxlength="10"
                                                    class="form-control" name="hb" id="hb">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">LDL</label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(mg/dL)" maxlength="10"
                                                    class="form-control" name="ldl" id="ldl">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">HDL</label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(mg/dL)" maxlength="10"
                                                    class="form-control" name="hdl" id="hdl">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">Triglycerides<span
                                                    class='mandatory'>*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(mg/dL)" maxlength="10"
                                                    class="form-control" name="triglycerid" id="triglycerid" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-4">Total Cholesterol<span
                                                    class='mandatory'>*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(mg/dL)" maxlength="10"
                                                    class="form-control" name="total_cholesterol" id="total_cholesterol"
                                                    value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">HBA1c<span
                                                    class='mandatory'>*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(%)" maxlength="10" class="form-control"
                                                    name="hba1c" id="hba1c" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">SGOT</label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(U/L)" maxlength="10"
                                                    class="form-control" name="sgot" id="sgot" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">SGPT</label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(U/L)" maxlength="10"
                                                    class="form-control" name="sgpt" id="sgpt" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">VIT D</label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(ng/mL)" maxlength="10"
                                                    class="form-control" name="vit_d" id="vit_d" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">T3</label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(ng/mL)" maxlength="10"
                                                    class="form-control" name="t3" id="t3" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">T4</label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="(ng/mL)" maxlength="10"
                                                    class="form-control" name="t4" id="t4" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3"
                                                for="hypertension_angina_ckd">Hypertension,
                                                Angina, CKD<span class='mandatory'>*</span></label>
                                            <div class="col-md-8">
                                                <select class="form-select form-control" name="hypertension_angina_ckd"
                                                    id="hypertension_angina_ckd">
                                                    <option value="">-- Select--</option>
                                                    <option value="Vericiguat">Vericiguat</option>
                                                    <option value="CCBs">CCBs</option>
                                                    <option value="Diuretics">Diuretics</option>
                                                    <option value="Nitrates">Nitrates</option>
                                                    <option value="Trimetazidine">Trimetazidine</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3" for="anti_diabetic_therapy">Anti
                                                Diabetic
                                                Therapy (Optional)</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="anti_diabetic_therapy"
                                                    id="anti_diabetic_therapy">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="h25"></div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header thembutton text-white">
                                <h5 class="mb-0">Medication</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- ARNI Section -->
                                    <div class="col-md-4 col-lg-4">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">ARNI</label>
                                            <div class="col-md-8">
                                                <select class="form-select form-control" name="arni" id="arni"
                                                    onchange="toggleArniRemark();">
                                                    <option value="">-- Select--</option>
                                                    <option value="sacubitrilOrvalsartan">Sacubitril/Valsartan</option>
                                                    <option value="remark">Remark</option>
                                                </select>
                                                <div id='arni_remark_div' style='display:none;'>
                                                    <input type="text" maxlength="50" placeholder="ARNI Remark"
                                                        class="form-control mt-2" name="arni_remark" id="arni_remark">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- B Blockers Section -->
                                    <div class="col-md-4 col-lg-4">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-4">B Blockers</label>
                                            <div class="col-md-8">
                                                <select class="form-select form-control" name="b_blockers"
                                                    id="b_blockers" onchange='toggleBlockersRemark()'>
                                                    <option value="">-- Select--</option>
                                                    <option value="metoprolol">Metoprolol</option>
                                                    <option value="bisoprolol">Bisoprolol</option>
                                                    <option value="remark">Remark</option>
                                                </select>
                                                <div id='blockers_remark_div' style='display:none;'>
                                                    <input type="text" maxlength="50" placeholder="B Blockers Remark"
                                                        class="form-control mt-2" name="b_blockers_remark"
                                                        id="b_blockers_remark">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- MRA Section -->
                                    <div class="col-md-4 col-lg-4">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">MRA</label>
                                            <div class="col-md-8">
                                                <select class="form-select form-control" name="mra" id="mra"
                                                    onchange='toggleMraRemark()'>
                                                    <option value="">-- Select--</option>
                                                    <option value="torsemideAndeplerenone">Torsemide + Eplerenone
                                                    </option>
                                                    <option value="torsemideAndspironolactone">Torsemide +
                                                        Spironolactone</option>
                                                    <option value="eplerenone">Eplerenone</option>
                                                    <option value="remark">Remark</option>
                                                </select>
                                                <div id='mra_remark_div' style='display:none;'>
                                                    <input type="text" maxlength="50" placeholder="MRA Remark"
                                                        class="form-control mt-2" name="mra_remark" id="mra_remark">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- 3 -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="mb-3 row">
                                        <label class="col-form-label col-md-3" for="sglt2_inhibitors">SGLT2
                                            Inhibitors</label>
                                        <div class="col-md-8">
                                            <select class="form-select form-control" name="sglt2_inhibitors"
                                                id="sglt2_inhibitors">
                                                <option value="">-- Select--</option>
                                                <option value="Empagliflozin">Empagliflozin</option>
                                                <option value="Dapagliflozin">Dapagliflozin</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- 4 -->
                                <div class="row">
                                    <!-- Vaccination -->
                                    <div class="col-md-12 col-lg-12">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">Vaccination</label>
                                            <div class="col-md-8">
                                                <span class="radio">
                                                    <label><input type="radio" name="vaccination" value="Yes">
                                                        Yes</label>
                                                </span>
                                                <span class="radio">
                                                    <label><input type="radio" name="vaccination" value="No"> No</label>
                                                </span>
                                                <span class="radio">
                                                    <label><input type="radio" name="vaccination" value="na"
                                                            checked="checked">
                                                        N/A</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Influenza -->
                                    <div class="col-md-12 col-lg-12">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">Influenza</label>
                                            <div class="col-md-8">
                                                <span class="radio">
                                                    <label><input type="radio" name="influenza" value="Yes"> Yes</label>
                                                </span>
                                                <span class="radio">
                                                    <label><input type="radio" name="influenza" value="No"> No</label>
                                                </span>
                                                <span class="radio">
                                                    <label><input type="radio" name="influenza" value="na"
                                                            checked="checked">
                                                        N/A</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Pneumococcal -->
                                    <div class="col-md-12 col-lg-12">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">Pneumococcal</label>
                                            <div class="col-md-8">
                                                <span class="radio">
                                                    <label><input type="radio" name="pneumococcal" value="Yes">
                                                        Yes</label>
                                                </span>
                                                <span class="radio">
                                                    <label><input type="radio" name="pneumococcal" value="No">
                                                        No</label>
                                                </span>
                                                <span class="radio">
                                                    <label><input type="radio" name="pneumococcal" value="na"
                                                            checked="checked">
                                                        N/A</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Suitable for Cardiac Rehab -->
                                    <div class="col-md-12 col-lg-12">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">Suitable for cardiac rehab</label>
                                            <div class="col-md-8">
                                                <span class="radio">
                                                    <label><input type="radio" name="cardiac_rehab" value="Yes">
                                                        Yes</label>
                                                </span>
                                                <span class="radio">
                                                    <label><input type="radio" name="cardiac_rehab" value="No">
                                                        No</label>
                                                </span>
                                                <span class="radio">
                                                    <label><input type="radio" name="cardiac_rehab" value="na"
                                                            checked="checked">
                                                        N/A</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Use of NSAIDs -->
                                    <div class="col-md-12 col-lg-12">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">Use of NSAIDs (elderly)</label>
                                            <div class="col-md-8">
                                                <span class="radio">
                                                    <label><input type="radio" name="nsaids_use" value="Yes">
                                                        Yes</label>
                                                </span>
                                                <span class="radio">
                                                    <label><input type="radio" name="nsaids_use" value="No"> No</label>
                                                </span>
                                                <span class="radio">
                                                    <label><input type="radio" name="nsaids_use" value="na"
                                                            checked="checked">
                                                        N/A</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Patient Kit Given -->
                                    <div class="col-md-12 col-lg-12">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">Patient kit given</label>
                                            <div class="col-md-8">
                                                <span class="radio">
                                                    <label><input type="radio" name="patient_kit_given" value="Yes">
                                                        Yes</label>
                                                </span>
                                                <span class="radio">
                                                    <label><input type="radio" name="patient_kit_given" value="No">
                                                        No</label>
                                                </span>
                                                <span class="radio">
                                                    <label><input type="radio" name="patient_kit_given" value="na"
                                                            checked="checked">
                                                        N/A</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Any Remark -->
                                    <div class="col-md-12 col-lg-12">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">Any remark</label>
                                            <div class="col-md-8">
                                                <input type="text" maxlength="100" class="form-control" name="remark"
                                                    id="remark" placeholder="Enter any remark">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class='h25'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">

                        <div class="card-body" id="optionaldiv">
                            <div>
                                <div class="row">
                                    <div class="col-md-3 col-lg-3">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-4">Weight <span
                                                    class='mandatory'>*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="Weight In Kg" class="form-control"
                                                    name="weight" id="weight" maxlength="10" onkeydown="calculateBMI()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-lg-3">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-4">Height <span
                                                    class='mandatory'>*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" placeholder="Height In Cm" class="form-control"
                                                    name="height" id="height" maxlength="10" onkeydown="calculateBMI()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-5">Waist Circumference:</label>
                                            <div class="col-md-7">
                                                <input type="text" placeholder="Waist circumference In Cm"
                                                    maxlength="10" class="form-control" onkeydown="calculateWHRatio()"
                                                    name="waist_circumference_remark" id="waist_circumference_remark">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">BMI <span class='mandatory'>*</span>
                                            </label>
                                            <div class="col-md-8">
                                                <input type="text" maxlength="10" class="form-control" name="bmi"
                                                    id="bmi" placeholder="BMI In kg/m2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-3">W-HtR</label>
                                            <div class="col-md-8">
                                                <input type="text" maxlength="10" class="form-control"
                                                    name="waist_to_height_ratio" id="waist_to_height_ratio">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class='h25'></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 col-lg-5" style="background-color: #f3f3f3;">
                                        <div class='row'>
                                            <div class="h25"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class='subheading'>Past History </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class="h25"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-lg-12">
                                                <div class="mb-3 row">
                                                    <label class="col-form-label col-md-6">Type 2 DM<span
                                                            class='mandatory'>*</span></label>
                                                    <div class="col-md-5">
                                                        <span class="radio">
                                                            <label><input type="radio" name="type_2_dm" value="Yes">
                                                                Yes</label>
                                                        </span>
                                                        <span class="radio">
                                                            <label><input type="radio" name="type_2_dm" value="No">
                                                                No</label>
                                                        </span>
                                                        <!-- <div class="checkbox">
                                             <label>
                                                <input type="checkbox" name="type_2_dm" value="Yes"> Yes
                                             </label>
                                             </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-12">
                                                <div class="mb-3 row">
                                                    <label class="col-form-label col-md-6">Hypertension<span
                                                            class='mandatory'>*</span></label>
                                                    <div class="col-md-5">
                                                        <span class="radio">
                                                            <label><input type="radio" name="hypertension" value="Yes">
                                                                Yes</label>
                                                        </span>
                                                        <span class="radio">
                                                            <label><input type="radio" name="hypertension" value="No">
                                                                No</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-12">
                                                <div class="mb-3 row">
                                                    <label class="col-form-label col-md-6">Dyslipidemia<span
                                                            class='mandatory'>*</span></label>
                                                    <div class="col-md-5">
                                                        <span class="radio">
                                                            <label><input type="radio" name="dyslipidemia" value="Yes">
                                                                Yes</label>
                                                        </span>
                                                        <span class="radio">
                                                            <label><input type="radio" name="dyslipidemia" value="No">
                                                                No</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-12">
                                                <div class="mb-3 row">
                                                    <label class="col-form-label col-md-6">PCO<span
                                                            class='mandatory'>*</span></label>
                                                    <div class="col-md-5">
                                                        <span class="radio">
                                                            <label><input type="radio" name="pco" value="Yes">
                                                                Yes</label>
                                                        </span>
                                                        <span class="radio">
                                                            <label><input type="radio" name="pco" value="No"> No</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-12">
                                                <div class="mb-3 row">
                                                    <label class="col-form-label col-md-6">Knee pain
                                                        (Osteoarthritis)<span class='mandatory'>*</span></label>
                                                    <div class="col-md-5">
                                                        <span class="radio">
                                                            <label><input type="radio" name="knee_pain" value="Yes">
                                                                Yes</label>
                                                        </span>
                                                        <span class="radio">
                                                            <label><input type="radio" name="knee_pain" value="No">
                                                                No</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-12">
                                                <div class="mb-3 row">
                                                    <label class="col-form-label col-md-6">Asthma<span
                                                            class='mandatory'>*</span></label>
                                                    <div class="col-md-5">
                                                        <span class="radio">
                                                            <label><input type="radio" name="asthma" value="Yes">
                                                                Yes</label>
                                                        </span>
                                                        <span class="radio">
                                                            <label><input type="radio" name="asthma" value="No">
                                                                No</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-lg-1">
                                    </div>
                                    <div class="col-md-5 col-lg-5" style="background-color: #f3f3f3;">
                                        <div class='row'>
                                            <div class="h25"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class='subheading'>Daily activity limitation</div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class="h25"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-lg-12">
                                                <div class="mb-3 row">
                                                    <label class="col-form-label col-md-6">Bathing<span
                                                            class='mandatory'>*</span></label>
                                                    <div class="col-md-5">
                                                        <span class="radio">
                                                            <label><input type="radio" name="adl_bathing" value="Yes">
                                                                Yes</label>
                                                        </span>
                                                        <span class="radio">
                                                            <label><input type="radio" name="adl_bathing" value="No">
                                                                No</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-12">
                                                <div class="mb-3 row">
                                                    <label class="col-form-label col-md-6">Dressing<span
                                                            class='mandatory'>*</span></label>
                                                    <div class="col-md-5">
                                                        <span class="radio">
                                                            <label><input type="radio" name="adl_dressing" value="Yes">
                                                                Yes</label>
                                                        </span>
                                                        <span class="radio">
                                                            <label><input type="radio" name="adl_dressing" value="No">
                                                                No</label>
                                                        </span>
                                                        <!-- <div class="checkbox">
                                             <label>
                                                <input type="checkbox" name="adl_dressing" value="Yes"> Yes
                                             </label>
                                             </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-12">
                                                <div class="mb-3 row">
                                                    <label class="col-form-label col-md-6">Walking<span
                                                            class='mandatory'>*</span></label>
                                                    <div class="col-md-5">
                                                        <span class="radio">
                                                            <label><input type="radio" name="adl_walking" value="Yes">
                                                                Yes</label>
                                                        </span>
                                                        <span class="radio">
                                                            <label><input type="radio" name="adl_walking" value="No">
                                                                No</label>
                                                        </span>
                                                        <!-- <div class="checkbox">
                                             <label>
                                                <input type="checkbox" name="adl_walking" value="Yes"> Yes
                                             </label>
                                             </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-12">
                                                <div class="mb-3 row">
                                                    <label class="col-form-label col-md-6">Toileting<span
                                                            class='mandatory'>*</span></label>
                                                    <div class="col-md-5">
                                                        <span class="radio">
                                                            <label><input type="radio" name="adl_toileting" value="Yes">
                                                                Yes</label>
                                                        </span>
                                                        <span class="radio">
                                                            <label><input type="radio" name="adl_toileting" value="No">
                                                                No</label>
                                                        </span>
                                                        <!-- <div class="checkbox">
                                             <label>
                                                <input type="checkbox" name="adl_toileting" value="Yes"> Yes
                                             </label>
                                             </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class="h25"></div>
                                </div>
                                <!-- 5 -->
                                <!-- 6 -->
                                <div class="row">
                                    <!-- Exercise -->
                                    <div class="col-md-6 col-lg-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-5">Exercise (30mins/day):</label>
                                            <div class="col-md-5">
                                                <span class="radio">
                                                    <label><input type="radio" name="exercise_30mins" value="YES">
                                                        YES</label>
                                                </span>
                                                <span class="radio">
                                                    <label><input type="radio" name="exercise_30mins" value="No">
                                                        No</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Having Breakfast -->
                                    <div class="col-md-6 col-lg-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-5">Having Breakfast/week:</label>
                                            <div class="col-md-5">
                                                <span class="radio">
                                                    <label><input type="radio" name="breakfast_days" value="≤4 days"> ≤4
                                                        days</label>
                                                </span>
                                                <span class="radio">
                                                    <label><input type="radio" name="breakfast_days" value=">4 days"> >4
                                                        days</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Food habits -->
                                    <div class="col-md-6 col-lg-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-5">Food habits:</label>
                                            <div class="col-md-7">
                                                <span class="radio">
                                                    <label><input type="radio" name="food_habits" value="Vegetarian">
                                                        Vegetarian</label>
                                                </span>
                                                <span class="radio">
                                                    <label><input type="radio" name="food_habits"
                                                            value="Non-vegetarian">
                                                        Non-vegetarian</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Sedentary Hours -->
                                    <div class="col-md-6 col-lg-6">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-md-5">Sedentary hours/day:</label>
                                            <div class="col-md-5">
                                                <span class="radio">
                                                    <label><input type="radio" name="sedentary_hours" value="≤8 hours">
                                                        ≤8
                                                        hours</label>
                                                </span>
                                                <span class="radio">
                                                    <label><input type="radio" name="sedentary_hours" value=">8 hours">
                                                        >8
                                                        hours</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-body mb-4">
                        <div class="mb-3 row">
                            <!-- <label class="col-form-label col-md-2"> </label> -->
                            <div class="col-md-12" style="text-align: center;">
                                <button type="submit" name="submit" id="submit"
                                    class="btn btn-primary thembutton">Submit</button>
                            </div>
                        </div>


            </form>

        </div>
    </div>
</div>
</div>
</div>
</div>


@include('digitaleducator.footer');
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Initialize select2 dropdowns
        $('#medicine').select2({
            placeholder: "Select medicines",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#medicine').parent()
        });

        $('#Compititor').select2({
            placeholder: "Select competitors",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#Compititor').parent()
        });
        loadHCPNames();
        loadAges();
        loadMedicines();
        loadCompetitors();
        // Event handlers
        $('#hcp_name').on('change', function () {
            var doctorId = $(this).val();
            if (doctorId) {
                getHCPDetails(doctorId);
            } else {
                $('#msl_code').val('');
            }
        });

        $('input[name="patientEnrolled"], input[name="ciplaBrandPrescribed"], input[name="prescription_available"]').change(function () {
            updateFormFields();
        });
        const prescribedSelect = document.getElementById("prescribedselect");
        const followupDiv = document.getElementById("followupdiv");

        // Initially hide the followup div
        followupDiv.style.display = "none";

        prescribedSelect.addEventListener("change", function () {
            if (this.value === "Purchase Bill Available") {
                followupDiv.style.display = "block";
            } else if (this.value === "Observed Only Cipla Brand") {
                followupDiv.style.display = "none";
            }
            else {
                followupDiv.style.display = "none";
            }
        });
    });
    $('input[name="ciplaBrandPrescribed"]:radio').change(function () {
        //toastr.error(this.value);
        var ciplaBrandPrescribedValue = this.value;
        if (ciplaBrandPrescribedValue == "Yes") {
            $("#ciplaBrandPrescribedDiv").css("display", "block");
        } else {
            $("#ciplaBrandPrescribedDiv").css("display", "none");
            $("#prescribeddatashow").css("display", "block");
        }
    });
    $('input[name="prescription_available"]:radio').change(function () {
        //toastr.error(this.value);
        var prescription_available = this.value;
        if (prescription_available == "Yes") {
            $("#ciplaBrandPrescribedDiv").css("display", "block");
            $("#prescribeddatashow").css("display", "none");
            $("#followupdiv").css("display", "none");
        } else {
            $("#ciplaBrandPrescribedDiv").css("display", "none");
            $("#prescribeddatashow").css("display", "block");
            $("#consentFormDiv").css("display", "none");
            $("#optionaldiv").css("display", "none");
            $("#prescriptionDiv").css("display", "none");
        }
    });
    $('input[name="patient_kit_enrolled"]:radio').change(function () {
        //toastr.error(this.value);
        var patient_kit_enrolled = this.value;
        if (patient_kit_enrolled == "Yes") {
            $("#prescriptionDiv").css("display", "block");
        } else {
            $("#prescriptionDiv").css("display", "none");
        }
        // Calculate BMI and WH ratio on input
        $('#height, #weight').on('input', calculateBMI);
        $('#height, #waist_circumference_remark').on('input', calculateWHRatio);

        // Form submission
        $('#createPatientInquiry').on('submit', function (e) {
            e.preventDefault();
            if (validateForm()) {
                submitForm();
            }
        });
    });

    function loadHCPNames() {
        $.ajax({
            url: '/digitalcounsellor/getHCPNames',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                var options = '<option value="">-- Select --</option>';
                $.each(response.data, function (key, value) {
                    options += '<option value="' + value.id + '">' + value.name + '</option>';
                });
                $('#hcp_name').html(options);
            },
            error: function () {
                toastr.error('Error loading HCP names');
            }
        });
    }

    function loadAges() {
        var options = '<option value="">-- Select --</option>';
        for (var i = 1; i <= 100; i++) {
            options += '<option value="' + i + '">' + i + '</option>';
        }
        options += '<option value="100+">100+</option>';
        $('#age').html(options);
    }


    function loadMedicines() {
        $.ajax({
            url: '/digitalcounsellor/getMedicines',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                var options = '<option value="">-- Select Medicine --</option>';
                if (response.data && Array.isArray(response.data)) {
                    $.each(response.data, function (key, value) {
                        options += '<option value="' + value.medicine_name + '">' + value.medicine_name + '</option>';
                    });
                }
                $('#medicine').html(options);
            },
            error: function () {
                toastr.error('Error loading medicines');
            }
        });
    }

    function loadCompetitors() {
        $.ajax({
            url: '/digitalcounsellor/getCompetitors',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                var options = '<option value="">-- Select Competitor --</option>';
                options += '<option value="N/A">N/A</option>';

                if (response.data && Array.isArray(response.data)) {
                    $.each(response.data, function (key, value) {
                        options += '<option value="' + value.compitetor_name + '">' + value.compitetor_name + '</option>';
                    });
                }

                $('#Compititor').html(options);
            },
            error: function () {
                toastr.error('Error loading competitors');
            }
        });
    }

    function getHCPDetails(doctorId) {
        $.ajax({
            url: '/digitalcounsellor/getHCLDetails',
            type: 'POST',
            data: {
                doctor_id: doctorId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success' && response.data.length > 0) {
                    const hcp = response.data[0]; // Get the first HCP

                    $('#msl_code').val(hcp.msl_code);
                    $('#city').html('<option value="' + hcp.city + '">' + hcp.city + '</option>');
                    $('#state').html('<option value="' + hcp.state + '">' + hcp.state + '</option>');
                    $('#speciality').html('<option value="' + hcp.speciality + '">' + hcp.speciality + '</option>');
                } else {
                    $('#msl_code').val('');
                    toastr.error('HCP details not found');
                }
            },
            error: function () {
                toastr.error('Error loading HCP details');
            }
        });
    }

    function updateFormFields() {
        var patientEnrolled = $('input[name="patientEnrolled"]:checked').val();
        var ciplaBrandPrescribed = $('input[name="ciplaBrandPrescribed"]:checked').val();
        var prescription_available = $('input[name="prescription_available"]:checked').val();
        // Condition 1: Both Yes - show everything
        if (patientEnrolled === 'Yes' && ciplaBrandPrescribed === 'Yes' && prescription_available === 'Yes') {
            $("#consentFormDiv").show();
            $("#prescriptionDiv").show();
            $("#patientKitDiv").hide();
            $("#ciplaBrandPrescribedDiv").show();
            $("#optionaldiv").show();
            $("#medicinediv").show();

            // Make required fields required
            $("#fileToUpload").prop('required', true);
            $("#consentForm").prop('required', false);
            $("input[name='patient_kit_enrolled']").prop('required', false);
        }
        else if (patientEnrolled === 'Yes' && ciplaBrandPrescribed === 'Yes' && prescription_available === 'No') {
            $("#consentFormDiv").hide();
            $("#prescriptionDiv").hide();
            $("#ciplaBrandPrescribedDiv").hide();
            $("#optionaldiv").hide();
            $("#fileToUpload").prop('required', false);
            $("#consentForm").prop('required', false);
        }
        // Condition 2: Patient No, Cipla Yes - remove consent, add kit enrolled
        else if (patientEnrolled === 'No' && ciplaBrandPrescribed === 'Yes' && prescription_available === 'No') {
            $("#consentFormDiv").hide();
            $("#prescriptionDiv").show();
            $("#patientKitDiv").show();
            $("#ciplaBrandPrescribedDiv").hide();
            $("#optionaldiv").hide();
            $("#medicinediv").show();

            // Make fields required/not required
            $("#fileToUpload").prop('required', false);
            $("#consentForm").prop('required', false);
            $("input[name='patient_kit_enrolled']").prop('required', true);
        }
        else if (patientEnrolled === 'No' && ciplaBrandPrescribed === 'Yes' && prescription_available === 'Yes') {
            $("#consentFormDiv").hide();
            $("#prescriptionDiv").show();
            $("#patientKitDiv").show();
            $("#ciplaBrandPrescribedDiv").show();
            $("#optionaldiv").show();
            $("#medicinediv").show();

            // Make fields required/not required
            $("#fileToUpload").prop('required', false);
            $("#consentForm").prop('required', false);
            $("input[name='patient_kit_enrolled']").prop('required', true);
        }
        // Condition 3: Both No - remove both uploads
        else if (patientEnrolled === 'No' && ciplaBrandPrescribed === 'No' && prescription_available === 'No') {
            $("#consentFormDiv").hide();
            $("#prescriptionDiv").hide();
            $("#patientKitDiv").hide();
            //   $("#ciplaBrandPrescribedDiv").hide();
            $("#medicinediv").hide();
            $("#medicine").removeAttr('required');
            $("#optionaldiv").show();
            $('#prescribeddatashow').hide();

            // Make fields not required
            $("#fileToUpload").prop('required', false);
            $("#consentForm").prop('required', false);
            $("input[name='patient_kit_enrolled']").prop('required', false);
        }
    }

    function calculateBMI() {
        var height = parseFloat($("#height").val());
        var weight = parseFloat($("#weight").val());

        if (height && weight && height > 0) {
            var heightM = height / 100;
            var bmi = weight / (heightM * heightM);
            $("#bmi").val(bmi.toFixed(2));
        } else {
            $("#bmi").val('');
        }
    }

    function calculateWHRatio() {
        var height = parseFloat($("#height").val());
        var waist = parseFloat($("#waist_circumference_remark").val());

        if (height && waist && height > 0) {
            var ratio = waist / height;
            $("#waist_to_height_ratio").val(ratio.toFixed(2));
        } else {
            $("#waist_to_height_ratio").val('');
        }
    }

    function validateForm() {
        var patientEnrolled = $('input[name="patientEnrolled"]:checked').val();
        var ciplaBrandPrescribed = $('input[name="ciplaBrandPrescribed"]:checked').val();
        var prescription_available = $('input[name="prescription_available"]:checked').val();
        // Alphanumeric Validations
        if (!validateAlphanumeric(document.getElementById("hcp_name").value, "HCP Name")) return false;
        if (!validateAlphanumeric(document.getElementById("msl_code").value, "MSL Code")) return false;
        if (!validateAlphanumeric(document.getElementById("state").value, "State ")) return false;
        if (!validateAlphanumeric(document.getElementById("city").value, "City")) return false;
        if (!validateMobileField(document.getElementById("mobile_number").value, "Mobile Number")) return false;
        if (!document.querySelector('input[name="patientEnrolled"]:checked')) {
            toastr.error("Please select an option for Patient Enrolled.");
            return false;
        }


        if (!validateAlphabetOnly(document.getElementById("patient_name").value, "Patient Name")) return false;
        if (!validateNumberField(document.getElementById("age").value, "Age")) return false;
        if (!validateAlphanumeric(document.getElementById("gender").value, "Gender")) return false;

        // File
        if (patientEnrolled === 'Yes' && ciplaBrandPrescribed === 'Yes' && prescription_available === 'Yes') {
            if (!validateFileInput(document.getElementById("fileToUpload").value, "Prescription File")) return false;
            if (!validateFileInput(document.getElementById("consentForm").value, "Consent File")) return false;
            // Validate cardio section
            // if (!validateCardioSection()) return false;
            // if (!validateAlphabetOnly(document.getElementById("medicine").value, "Medicine")) return false;
        }
        if (patientEnrolled === 'Yes' && ciplaBrandPrescribed === 'Yes' && prescription_available === 'No') {
            // if (!validateAlphabetOnly(document.getElementById("medicine").value, "Medicine")) return false;
        }
        // Condition 2: Patient No, Cipla Yes - validate prescription only
        else if (patientEnrolled === 'No' && ciplaBrandPrescribed === 'Yes') {
            // if (!validateFileInput(document.getElementById("fileToUpload").value, "Prescription File")) return false;
            if (!document.querySelector('input[name="patient_kit_enrolled"]:checked')) {
                toastr.error("Please select an option for Patient Kit Enrolled.");
                return false;
            }
        }
        // Condition 3: Both No - no uploads required
        else if (patientEnrolled === 'No' && ciplaBrandPrescribed === 'No') {
            const prescriptionFile = document.getElementById("fileToUpload").files.length;
            const consentFile = document.getElementById("consentForm").files.length;

            if (prescriptionFile > 0 || consentFile > 0) {
                toastr.error("The uploaded file format is not supported. Please upload a valid image file (JPG, PNG, JPEG).");
                return false;
            }
        }
        if (prescription_available === 'No' && ciplaBrandPrescribed === 'Yes') {
            var prescribedSelectValue = $('#prescribedselect').val();
            if (!prescribedSelectValue) {
                toastr.error("Please select a reason for the prescribed Cipla brand since the prescription is not available.");
                return false;
            }
        }
        var ciplaBrandPrescribedStatus = 'No';

        if (!document.querySelector('input[name="ciplaBrandPrescribed"]:checked')) {
            toastr.error("Please select an option for Cipla Brand Prescribed.");
            return false;
        } else {
            var ciplaBrandPrescribedVal = $('input[name="ciplaBrandPrescribed"]:checked').val();
            if (ciplaBrandPrescribedVal == 'Yes') {
                var ciplaBrandPrescribedStatus = 'Yes';
            } else {
                var ciplaBrandPrescribedStatus = 'No';
            }
        }
        return true;
    }

    $('#submit').on('click', function (e) {
        e.preventDefault();

        if (!validateForm()) {
            return false;
        }

        // Show loading state
        $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...');

        var formData = new FormData($('#createPatientInquiry')[0]);

        $.ajax({
            url: $('#createPatientInquiry').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    // Show success message
                    toastr.success("Patient inquiry submitted successfully!", "Success");
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                } else {
                    // Show error message
                    toastr.error("Error: " + response.message, "Error");
                    $('#submit').prop('disabled', false).html('Submit');
                }
            },
            error: function (xhr) {
                let errorMessage = 'An error occurred while submitting the form. Please try again.';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.statusText) {
                    errorMessage += ' (' + xhr.statusText + ')';
                }

                toastr.error(errorMessage, "Error");
                $('#submit').prop('disabled', false).html('Submit');
            }
        });
    });

    function toggleArniRemark() {
        const selectElement = $('#arni option:selected').val();
        const remarkDiv = document.getElementById("arni_remark_div");
        const remarkInput = document.getElementById("arni_remark");


        if (selectElement === "remark") {
            remarkDiv.style.display = "block";
        } else {
            remarkDiv.style.display = "none";
            remarkInput.value = ""; // Clear input if hidden
        }
    }

    function toggleBlockersRemark() {
        const selectElement = $('#b_blockers option:selected').val();
        const remarkDiv = document.getElementById("blockers_remark_div");
        const remarkInput = document.getElementById("b_blockers_remark");

        if (selectElement === "remark") {
            remarkDiv.style.display = "block";
        } else {
            remarkDiv.style.display = "none";
            remarkInput.value = ""; // Clear input if hidden
        }
    }

    function toggleMraRemark() {
        const selectElement = $('#mra option:selected').val();
        const remarkDiv = document.getElementById("mra_remark_div");
        const remarkInput = document.getElementById("mra_remark");

        if (selectElement === "remark") {
            remarkDiv.style.display = "block";
        } else {
            remarkDiv.style.display = "none";
            remarkInput.value = ""; // Clear input if hidden
        }
    }

    function isAlphabetOnly(value) {
        return /^[a-zA-Z\s]+$/.test(value);  // Allows only letters and spaces
    }

    function validateAlphabetOnly(value, fieldName) {
        if (!value || value.trim() === '') {
            toastr.error(fieldName + " is required.");
            return false;
        }
        if (!isAlphabetOnly(value)) {
            toastr.error(fieldName + " must contain only alphabetic characters (A-Z or a-z).");
            return false;
        }
        return true;
    }

    function isNumber(value) {
        return /^-?\d+(\.\d+)?$/.test(value);  // Accepts integers and floats
    }

    function isAlphanumeric(value) {
        return /^[a-zA-Z0-9\s]+$/.test(value);  // Letters, numbers, and space
    }

    function validateField(value, fieldName) {
        if (!value || value.trim() === '') {
            toastr.error(fieldName + " is required.");
            return false;
        }
        return true;
    }

    function validateNumberField(value, fieldName) {
        if (!validateField(value, fieldName)) return false;
        if (!isNumber(value)) {
            toastr.error(fieldName + " must be a valid number.");
            return false;
        }
        return true;
    }

    function validateAlphanumeric(value, fieldName) {
        if (!validateField(value, fieldName)) return false;
        if (!isAlphanumeric(value)) {
            toastr.error(fieldName + " must be alphanumeric (letters and numbers only).");
            return false;
        }
        return true;
    }

    function validateMobileField(value, fieldName) {
        if (!value || value.trim() === '') {
            toastr.error(fieldName + " is required.");
            return false;
        }
        const mobileRegex = /^\d{10}$/;
        if (!mobileRegex.test(value)) {
            toastr.error(fieldName + " must be a valid 10-digit number.");
            return false;
        }
        return true;
    }
    function validateFileInput(filePath, fieldName) {
        if (filePath === "") {
            toastr.error("Please upload " + fieldName + ".");
            return false;
        }

        // Allowed file extensions
        const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.pdf)$/i;

        if (!allowedExtensions.exec(filePath)) {
            toastr.error("Invalid file format for " + fieldName + ". Allowed formats: JPG, JPEG, PNG, PDF.");
            return false;
        }

        return true;
    }

    function validateDateField(dateStr, fieldName) {
        if (dateStr.trim() === "") {
            toastr.error("Please enter " + fieldName + ".");
            return false;
        }

        // Check format: YYYY-MM-DD
        const regex = /^\d{4}-\d{2}-\d{2}$/;
        if (!regex.test(dateStr)) {
            toastr.error("Invalid date format for " + fieldName + ". Use YYYY-MM-DD.");
            return false;
        }

        const date = new Date(dateStr);
        const isValidDate = !isNaN(date.getTime());

        if (!isValidDate) {
            toastr.error("Invalid date entered for " + fieldName + ".");
            return false;
        }

        // Optional: prevent future date
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Ignore time part

        if (date <= today) {
            toastr.error(fieldName + " cannot be a future date.");
            return false;
        }

        return true;
    }
    function handleImagePreview(inputId, previewContainerId) {
        const input = document.getElementById(inputId);
        const previewContainer = document.getElementById(previewContainerId);

        input.addEventListener('change', function (event) {
            const files = event.target.files;
            previewContainer.innerHTML = ''; // Clear previous previews

            if (files.length === 0) {
                previewContainer.style.display = 'none';
                return;
            }

            let hasImage = false;

            Array.from(files).forEach(file => {
                if (!file.type.startsWith('image/')) return;

                hasImage = true;
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '100px';
                    img.style.margin = '5px';
                    img.style.border = '1px solid #ccc';
                    img.style.borderRadius = '4px';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });

            previewContainer.style.display = hasImage ? 'block' : 'none';
        });
    }

    // Apply preview to all 3 upload sections
    handleImagePreview('consentForm', 'consentPreview');
    handleImagePreview('fileToUpload', 'prescriptionPreview');
    handleImagePreview('purchasebill', 'purchasebillPreview');

</script>
