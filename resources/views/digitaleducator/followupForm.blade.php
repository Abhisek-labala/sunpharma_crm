@include('digitaleducator/header')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
    }

    .form-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 30px;
    }

    .form-title {
        color: #2c3e50;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 2px solid #3498db;
    }

    .form-section {
        margin-bottom: 30px;
        padding: 20px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
    }

    .section-title {
        font-size: 1.2rem;
        color: #3498db;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .form-label {
        font-weight: 500;
        margin-top: 10px;
        color: #495057;
    }

    .checkbox-group {
        margin-left: 20px;
    }

    .checkbox-item {
        margin-right: 15px;
    }

    .form-text-input {
        max-width: 300px;
    }

    .required-field::after {
        content: " *";
        color: red;
    }

    .support-number {
        font-weight: bold;
        color: #e74c3c;
    }

    /* Tab styling */
    .nav-tabs {
        border-bottom: 2px solid #dee2e6;
        margin-bottom: 20px;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #495057;
        font-weight: 500;
        padding: 10px 20px;
    }

    .nav-tabs .nav-link.active {
        color: #3498db;
        border-bottom: 3px solid #3498db;
        background-color: transparent;
    }

    .tab-content {
        padding: 15px 0;
    }
</style>
</head>

<body>
    <div class="main-wrapper">

        @include('digitaleducator/Sidebar')
        <div class="page-wrapper">
            <div class="content container-fluid">
                @include('digitaleducator/breadcum')
                <div class="form-container">
                    <h1 class="form-title">✅ Patient Follow-up Form</h1>
                    <ul class="nav nav-tabs" id="followUpTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="day3-tab" data-bs-toggle="tab" data-bs-target="#day3"
                                type="button" role="tab">Day 3</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="day7-tab" data-bs-toggle="tab" data-bs-target="#day7"
                                type="button" role="tab">Day 7</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="day15-tab" data-bs-toggle="tab" data-bs-target="#day15"
                                type="button" role="tab">Day 15</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="day30-tab" data-bs-toggle="tab" data-bs-target="#day30"
                                type="button" role="tab">Day 30</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="day45-tab" data-bs-toggle="tab" data-bs-target="#day45"
                                type="button" role="tab">Day 45</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="day60-tab" data-bs-toggle="tab" data-bs-target="#day60"
                                type="button" role="tab">Day 60</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="day90-tab" data-bs-toggle="tab" data-bs-target="#day90"
                                type="button" role="tab">Day 90</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="day120-tab" data-bs-toggle="tab" data-bs-target="#day120"
                                type="button" role="tab">Day 120</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="day150-tab" data-bs-toggle="tab" data-bs-target="#day150"
                                type="button" role="tab">Day 150</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="day180-tab" data-bs-toggle="tab" data-bs-target="#day180"
                                type="button" role="tab">Day 180</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="followUpTabsContent">
                        <div class="tab-pane fade show active" id="day3" role="tabpanel" aria-labelledby="day3-tab">
                            <form id="day3form">
                                <div class="form-section">
                                    <h2 class="section-title">📞 Day 3 Follow-up</h2>

                                    <input type="hidden" name="day" value="3">
                                    <input type="hidden" name="patient_id" id="day3_patient_id">
                                    <input type="hidden" name="id">

                                    <!-- Q1: Medicines -->
                                    <div class="mb-3">
                                        <label class="form-label">1. Are you taking your prescribed medicines regularly
                                            and on time?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day3_meds"
                                                id="day3_meds_yes" value="Yes">
                                            <label class="form-check-label" for="day3_meds_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day3_meds"
                                                id="day3_meds_no" value="No">
                                            <label class="form-check-label" for="day3_meds_no">No</label>
                                        </div>
                                        <span id="day3_meds_reason" style="display:none;">
                                            → Reason: <input type="text" name="day3_meds_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- Q2: Monitoring -->
                                    <div class="mb-3">
                                        <label class="form-label">2. Are you monitoring the following as
                                            advised?</label>
                                        <div class="checkbox-group">

                                            <!-- Sugar -->
                                            <div class="mb-2">
                                                <span>Daily sugar levels:</span>
                                                <div class="form-check form-check-inline checkbox-item">
                                                    <input class="form-check-input" type="radio" name="day3_sugar"
                                                        id="day3_sugar_yes" value="Yes">
                                                    <label class="form-check-label" for="day3_sugar_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline checkbox-item">
                                                    <input class="form-check-input" type="radio" name="day3_sugar"
                                                        id="day3_sugar_no" value="No">
                                                    <label class="form-check-label" for="day3_sugar_no">No</label>
                                                </div>
                                                <span id="day3_sugar_reason" style="display:none;">
                                                    → Reason: <input type="text" name="day3_sugar_reason"
                                                        class="form-control form-control-sm d-inline form-text-input">
                                                </span>
                                            </div>

                                            <!-- Blood Pressure -->
                                            <div class="mb-2">
                                                <span>Blood pressure:</span>
                                                <div class="form-check form-check-inline checkbox-item">
                                                    <input class="form-check-input" type="radio" name="day3_bp"
                                                        id="day3_bp_yes" value="Yes">
                                                    <label class="form-check-label" for="day3_bp_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline checkbox-item">
                                                    <input class="form-check-input" type="radio" name="day3_bp"
                                                        id="day3_bp_no" value="No">
                                                    <label class="form-check-label" for="day3_bp_no">No</label>
                                                </div>
                                                <span id="day3_bp_reason" style="display:none;">
                                                    → Reason: <input type="text" name="day3_bp_reason"
                                                        class="form-control form-control-sm d-inline form-text-input">
                                                </span>
                                            </div>

                                            <!-- Fluid & Salt -->
                                            <div class="mb-2">
                                                <span>Fluid and salt intake:</span>
                                                <div class="form-check form-check-inline checkbox-item">
                                                    <input class="form-check-input" type="radio" name="day3_fluid"
                                                        id="day3_fluid_yes" value="Yes">
                                                    <label class="form-check-label" for="day3_fluid_yes">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline checkbox-item">
                                                    <input class="form-check-input" type="radio" name="day3_fluid"
                                                        id="day3_fluid_no" value="No">
                                                    <label class="form-check-label" for="day3_fluid_no">No</label>
                                                </div>
                                                <span id="day3_fluid_reason" style="display:none;">
                                                    → Reason: <input type="text" name="day3_fluid_reason"
                                                        class="form-control form-control-sm d-inline form-text-input">
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Q3: Support -->
                                    <div class="mb-3">
                                        <label class="form-label">3. Would you like us to arrange a yoga, physiotherapy,
                                            or dietitian call for support?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="checkbox" name="day3_support[]"
                                                id="day3_support_yoga" value="Yoga">
                                            <label class="form-check-label" for="day3_support_yoga">Yoga</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="checkbox" name="day3_support[]"
                                                id="day3_support_physio" value="Physiotherapy">
                                            <label class="form-check-label"
                                                for="day3_support_physio">Physiotherapy</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="checkbox" name="day3_support[]"
                                                id="day3_support_diet" value="Dietitian">
                                            <label class="form-check-label" for="day3_support_diet">Dietitian</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="checkbox" name="day3_support[]"
                                                id="day3_support_none" value="No">
                                            <label class="form-check-label" for="day3_support_none">No</label>
                                        </div>
                                    </div>

                                    <!-- AE Report -->
                                    <div class="mb-3">
                                        <label class="form-label">4. AE REPORT?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="ae_report"
                                                id="ae_report_yes" value="Yes">
                                            <label class="form-check-label" for="ae_report_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="ae_report"
                                                id="ae_report_no" value="No">
                                            <label class="form-check-label" for="ae_report_no">No</label>
                                        </div>
                                    </div>

                                    <!-- Call Remark & Subremarks -->
                                    <div class="mb-3">
                                        <label class="form-label">Call Remark</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="callremark_3"
                                                id="callremark_call_3" value="Call Connect">
                                            <label class="form-check-label" for="callremark_call_3">Call Connect</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="callremark_3"
                                                id="callremark_no_3" value="No Response">
                                            <label class="form-check-label" for="callremark_no_3">No Response</label>
                                        </div>

                                        <!-- Subremarks -->
                                        <div id="callremark_subremarks_3" style="display:none; margin-top:10px;">
                                            <div id="callconnect_subremarks_3" style="display:none;">
                                                <select class="form-select form-select-sm"
                                                    name="callconnect_subremark_3">
                                                    <option value="">Select remark</option>
                                                    <option value="DND the Patient">DND the Patient
                                                    </option>
                                                    <option value="Journey Completed">Journey Completed</option>
                                                    <option value="Call Rescheduled by the Patient">Call Rescheduled by
                                                        the Patient</option>
                                                    <option value="Wrong Number – DND the Patient">Wrong Number – DND
                                                        the Patient</option>
                                                    <option value="Language Barrier">Language Barrier</option>
                                                    <option value="Call Completed">Call Completed</option>
                                                    <option value="Call Disconnected by the Patient">Call Disconnected
                                                        by the Patient</option>
                                                    <option value="Dropout">Dropout</option>
                                                </select>
                                            </div>
                                            <div id="noresponse_subremarks_3" style="display:none;">
                                                <select class="form-select form-select-sm"
                                                    name="noresponse_subremark_3">
                                                    <option value="">Select remark</option>
                                                    <option value="Ringing">Ringing</option>
                                                    <option value="Call Busy">Call Busy</option>
                                                    <option value="Invalid Number">Invalid Number</option>
                                                    <option value="Out of Service">Out of Service</option>
                                                    <option value="Switched Off">Switched Off</option>
                                                    <option value="Drop out">Drop out</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center mt-4">
                                        <button type="submit" id="day3_submit" class="btn btn-primary">Submit Day 3
                                            Follow-up</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="day7" role="tabpanel" aria-labelledby="day7-tab">
                            <div class="form-section">
                                <h2 class="section-title">🧘 Day 7 Follow-up</h2>

                                <form id="day7form">
                                    <input type="hidden" name="day" value="7">
                                    <input type="hidden" name="patient_id" value="">
                                    <input type="hidden" name="id">

                                    <!-- Q1: Medicines -->
                                    <div class="mb-3">
                                        <label class="form-label">1. Are you taking your prescribed medicines
                                            regularly?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day7_meds"
                                                id="day7_meds_yes" value="Yes">
                                            <label class="form-check-label" for="day7_meds_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day7_meds"
                                                id="day7_meds_no" value="No">
                                            <label class="form-check-label" for="day7_meds_no">No</label>
                                        </div>
                                        <span id="day7_meds_reason" style="display: none;">
                                            → Reason: <input type="text" name="day7_meds_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- Q2: Doctor Visit -->
                                    <div class="mb-3">
                                        <label class="form-label">2. Have you visited your doctor recently for a
                                            follow-up?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day7_doctor"
                                                id="day7_doctor_yes" value="Yes">
                                            <label class="form-check-label" for="day7_doctor_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day7_doctor"
                                                id="day7_doctor_no" value="No">
                                            <label class="form-check-label" for="day7_doctor_no">No</label>
                                        </div>
                                        <span id="day7_doctor_reason" style="display: none;">
                                            → Reason: <input type="text" name="day7_doctor_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- Q3: Blood Pressure -->
                                    <div class="mb-3">
                                        <label class="form-label">3. What was your latest blood pressure
                                            reading:</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day7_bp" id="day7_bp_yes"
                                                value="Yes">
                                            <label class="form-check-label" for="day7_bp_yes">Yes</label>
                                        </div>
                                        <span id="day7_bp_value" style="display: none;">
                                            → BP: <input type="text" name="day7_bp_value"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day7_bp" id="day7_bp_no"
                                                value="No">
                                            <label class="form-check-label" for="day7_bp_no">No</label>
                                        </div>
                                        <span id="day7_bp_remarks" style="display: none;">
                                            → Remarks: <input type="text" name="day7_bp_remarks"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- Q4: Weight -->
                                    <div class="mb-3">
                                        <label class="form-label">4. Do you know your current weight:</label>
                                        <input type="text" name="day7_weight"
                                            class="form-control form-control-sm d-inline form-text-input"> kg
                                    </div>

                                    <!-- Q5: Breathlessness -->
                                    <div class="mb-3">
                                        <label class="form-label">5. Do you feel breathless?</label>
                                        <div class="checkbox-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day7_breathless"
                                                    id="day7_breathless_none" value="No breathlessness">
                                                <label class="form-check-label" for="day7_breathless_none">No
                                                    breathlessness</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day7_breathless"
                                                    id="day7_breathless_stairs" value="While climbing stairs">
                                                <label class="form-check-label" for="day7_breathless_stairs">While
                                                    climbing stairs</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day7_breathless"
                                                    id="day7_breathless_sitting" value="While sitting">
                                                <label class="form-check-label" for="day7_breathless_sitting">While
                                                    sitting</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day7_breathless"
                                                    id="day7_breathless_clothes" value="While changing clothes">
                                                <label class="form-check-label" for="day7_breathless_clothes">While
                                                    changing clothes</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day7_breathless"
                                                    id="day7_breathless_lie" value="Cannot lie down flat">
                                                <label class="form-check-label" for="day7_breathless_lie">Cannot lie
                                                    down flat</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Q6: Yoga Schedule -->
                                    <div class="mb-3">
                                        <label class="form-label">6. Would you like to schedule a yoga session as part
                                            of your care plan?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day7_yoga_schedule"
                                                id="day7_yoga_schedule_yes" value="Yes">
                                            <label class="form-check-label" for="day7_yoga_schedule_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day7_yoga_schedule"
                                                id="day7_yoga_schedule_no" value="No">
                                            <label class="form-check-label" for="day7_yoga_schedule_no">No</label>
                                        </div>
                                        <span id="day7_yoga_schedule_reason" style="display: none;">
                                            → Reason: <input type="text" name="day7_yoga_schedule_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- Q7: Yoga Tried Earlier -->
                                    <div class="mb-3">
                                        <label class="form-label">7. Have you tried any yoga or breathing exercises
                                            earlier?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day7_yoga_tried"
                                                id="day7_yoga_tried_yes" value="Yes">
                                            <label class="form-check-label" for="day7_yoga_tried_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day7_yoga_tried"
                                                id="day7_yoga_tried_no" value="No">
                                            <label class="form-check-label" for="day7_yoga_tried_no">No</label>
                                        </div>

                                        <span id="day7_yoga_tried_difficult" style="display: none;">
                                            <div class="form-check form-check-inline checkbox-item">
                                                <input class="form-check-input" type="radio" name="day7_yoga_difficult"
                                                    id="day7_yoga_difficult_yes" value="Yes">
                                                <label class="form-check-label"
                                                    for="day7_yoga_difficult_yes">Difficulties?</label>
                                            </div>
                                            <span id="day7_yoga_difficult_reason" style="display: none;">
                                                → Reason: <input type="text" name="day7_yoga_difficult_reason"
                                                    class="form-control form-control-sm d-inline form-text-input">
                                            </span>
                                        </span>
                                    </div>

                                    <!-- Q8: Yoga Session Required -->
                                    <div class="mb-3">
                                        <label class="form-label">8. Yoga Session Required?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day7_yoga_required"
                                                id="day7_yoga_required_yes" value="Yes">
                                            <label class="form-check-label" for="day7_yoga_required_yes">Yes</label>
                                        </div>
                                        <span id="day7_yoga_planned_date" style="display: none;">
                                            → Planned date: <input type="text" placeholder="YYYY-MM-DD"
                                                name="day7_yoga_planned_date"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day7_yoga_required"
                                                id="day7_yoga_required_no" value="No">
                                            <label class="form-check-label" for="day7_yoga_required_no">No</label>
                                        </div>
                                        <span id="day7_yoga_required_reason" style="display: none;">
                                            → Reason: <input type="text" name="day7_yoga_required_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">9. AE REPORT?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day7_ae_report"
                                                id="day7_ae_report_yes" value="Yes">
                                            <label class="form-check-label" for="day7_ae_report_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day7_ae_report"
                                                id="day7_ae_report_no" value="No">
                                            <label class="form-check-label" for="day7_ae_report_no">No</label>
                                        </div>
                                    </div>

                                    <!-- Call Remark + Subremarks -->
                                    <div class="mb-3">
                                        <label class="form-label">Call Remark</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="callremark_7"
                                                id="callremark_call_7" value="Call Connect">
                                            <label class="form-check-label" for="callremark_call_7">Call Connect</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="callremark_7"
                                                id="callremark_no_7" value="No Response">
                                            <label class="form-check-label" for="callremark_no_7">No Response</label>
                                        </div>

                                        <div id="callremark_subremarks_7" style="display: none;">
                                            <div class="mt-2">
                                                <label class="form-label">Remarks:</label>
                                                <div id="callconnect_subremarks_7" style="display: none;">
                                                    <select class="form-select form-select-sm"
                                                        name="callconnect_subremark_7">
                                                        <option value="">Select remark</option>
                                                        <option value="DND the Patient">DND the
                                                            Patient</option>
                                                        <option value="Journey Completed">Journey Completed</option>
                                                        <option value="Call Rescheduled by the Patient">Call Rescheduled
                                                            by the Patient</option>
                                                        <option value="Wrong Number – DND the Patient">Wrong Number –
                                                            DND the Patient</option>
                                                        <option value="Language Barrier">Language Barrier</option>
                                                        <option value="Call Completed">Call Completed</option>
                                                        <option value="Call Disconnected by the Patient">Call
                                                            Disconnected by the Patient</option>
                                                        <option value="Dropout">Dropout</option>
                                                    </select>
                                                </div>
                                                <div id="noresponse_subremarks_7" style="display: none;">
                                                    <select class="form-select form-select-sm"
                                                        name="noresponse_subremark_7">
                                                        <option value="">Select remark</option>
                                                        <option value="Ringing">Ringing</option>
                                                        <option value="Call Busy">Call Busy</option>
                                                        <option value="Invalid Number">Invalid Number</option>
                                                        <option value="Out of Service">Out of Service</option>
                                                        <option value="Switched Off">Switched Off</option>
                                                        <option value="Drop out">Drop out</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="text-center mt-4">
                                        <button type="submit" id="day7_submit" class="btn btn-primary">Submit Day 7
                                            Follow-up</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="day15" role="tabpanel" aria-labelledby="day15-tab">
                            <div class="form-section">
                                <h2 class="section-title">🗓️ Day 15 Follow-up</h2>
                                <form id="day15form">
                                    <input type="hidden" name="day" value="15">
                                    <input type="hidden" name="patient_id" value="">
                                    <input type="hidden" name="id">
                                    <!-- Q1: Medicines -->
                                    <div class="mb-3">
                                        <label class="form-label">1. Are you taking your medicines regularly as advised
                                            by your doctor?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_meds"
                                                id="day15_meds_yes" value="Yes">
                                            <label class="form-check-label" for="day15_meds_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_meds"
                                                id="day15_meds_no" value="No">
                                            <label class="form-check-label" for="day15_meds_no">No</label>
                                        </div>
                                        <span id="day15_meds_reason" style="display:none;">
                                            → Reason: <input type="text" name="day15_meds_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- Q2: Medicine Stock -->
                                    <div class="mb-3">
                                        <label class="form-label">2. Do you have enough stock of medicines?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_stock"
                                                id="day15_stock_yes" value="Yes">
                                            <label class="form-check-label" for="day15_stock_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_stock"
                                                id="day15_stock_no" value="No">
                                            <label class="form-check-label" for="day15_stock_no">No</label>
                                        </div>
                                        <span id="day15_meds_stock" style="display:none;">
                                            → Please get a refill or consult your doctor.
                                        </span>
                                    </div>

                                    <!-- Q3: Medication Change -->
                                    <div class="mb-3">
                                        <label class="form-label">3. Has your doctor added or changed any medication
                                            recently?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_changes"
                                                id="day15_changes_yes" value="Yes">
                                            <label class="form-check-label" for="day15_changes_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_changes"
                                                id="day15_changes_no" value="No">
                                            <label class="form-check-label" for="day15_changes_no">No</label>
                                        </div>
                                    </div>

                                    <!-- Q4: BP Reading -->
                                    <div class="mb-3">
                                        <label class="form-label">4. Recent BP Reading:</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_bp"
                                                id="day15_bp_yes" value="Yes">
                                            <label class="form-check-label" for="day15_bp_yes">Yes→ BP:</label>
                                        </div>
                                        <span id="day15_bp_value" style="display:none;">
                                            <input type="text" name="day15_bp_value"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_bp"
                                                id="day15_bp_no" value="No">
                                            <label class="form-check-label" for="day15_bp_no">No</label>
                                        </div>
                                    </div>

                                    <!-- Q5: Weight -->
                                    <div class="mb-3">
                                        <label class="form-label">5. Current weight:</label>
                                        <input type="text" name="day15_weight"
                                            class="form-control form-control-sm d-inline form-text-input"> kg
                                    </div>

                                    <!-- Q6: Blood Sugar -->
                                    <div class="mb-3">
                                        <label class="form-label">6. Have you checked your blood sugar level (RBS)
                                            recently?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_rbs"
                                                id="day15_rbs_yes" value="Yes">
                                            <label class="form-check-label" for="day15_rbs_yes">Yes</label>
                                        </div>
                                        <span id="day15_rbs_value" style="display:none;">
                                            → <input type="text" name="day15_rbs_value"
                                                class="form-control form-control-sm d-inline form-text-input"> mg/dL
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_rbs"
                                                id="day15_rbs_no" value="No">
                                            <label class="form-check-label" for="day15_rbs_no">No</label>
                                        </div>
                                        <span id="day15_rbs_reason" style="display:none;">
                                            → Reason: <input type="text" name="day15_rbs_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- Q7: Fluid & Urine -->
                                    <div class="mb-3">
                                        <label class="form-label">7. Can you tell me about your water/fluid intake and
                                            urine output over the past few days?</label>
                                        <br>
                                        <label class="form-label">Fluid Intake:</label><br>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_fluid"
                                                id="day15_fluid_adequate" value="Adequate">
                                            <label class="form-check-label" for="day15_fluid_adequate">Adequate</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_fluid"
                                                id="day15_fluid_increased" value="Increased">
                                            <label class="form-check-label"
                                                for="day15_fluid_increased">Increased</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_fluid"
                                                id="day15_fluid_decreased" value="Decreased">
                                            <label class="form-check-label"
                                                for="day15_fluid_decreased">Decreased</label>
                                        </div>
                                        <br>
                                        <label class="form-label">Urine Output:</label><br>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_urine"
                                                id="day15_urine_normal" value="Normal">
                                            <label class="form-check-label" for="day15_urine_normal">Normal</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_urine"
                                                id="day15_urine_increased" value="Increased">
                                            <label class="form-check-label"
                                                for="day15_urine_increased">Increased</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_urine"
                                                id="day15_urine_reduced" value="Reduced">
                                            <label class="form-check-label" for="day15_urine_reduced">Reduced</label>
                                        </div>
                                    </div>

                                    <!-- Q8: Breathing -->
                                    <div class="mb-3">
                                        <label class="form-label">8. How is your breathing (NYHA
                                            Classification)?</label>
                                        <div class="checkbox-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day15_breathless"
                                                    id="day15_breathless_none" value="No breathlessness">
                                                <label class="form-check-label" for="day15_breathless_none">No
                                                    breathlessness</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day15_breathless"
                                                    id="day15_breathless_stairs" value="While climbing stairs">
                                                <label class="form-check-label" for="day15_breathless_stairs">While
                                                    climbing stairs</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day15_breathless"
                                                    id="day15_breathless_sitting" value="While sitting">
                                                <label class="form-check-label" for="day15_breathless_sitting">While
                                                    sitting</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day15_breathless"
                                                    id="day15_breathless_clothes" value="While changing clothes">
                                                <label class="form-check-label" for="day15_breathless_clothes">While
                                                    changing clothes</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day15_breathless"
                                                    id="day15_breathless_lie" value="Cannot lie down flat">
                                                <label class="form-check-label" for="day15_breathless_lie">Cannot lie
                                                    down flat</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Q9: Yoga -->
                                    <div class="mb-3">
                                        <label class="form-label">9. Have you attended any yoga sessions yet?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_yoga"
                                                id="day15_yoga_yes" value="Yes">
                                            <label class="form-check-label" for="day15_yoga_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_yoga"
                                                id="day15_yoga_no" value="No">
                                            <label class="form-check-label" for="day15_yoga_no">No</label>
                                        </div>
                                        <span id="day15_yoga_reason" style="display:none;">
                                            → Reason: <input type="text" name="day15_yoga_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">10. AE REPORT?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_ae_report"
                                                id="day15_ae_report_yes" value="Yes">
                                            <label class="form-check-label" for="day15_ae_report_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day15_ae_report"
                                                id="day15_ae_report_no" value="No">
                                            <label class="form-check-label" for="day15_ae_report_no">No</label>
                                        </div>
                                    </div>
                                    <!-- Call Remark -->
                                    <div class="mb-3">
                                        <label class="form-label">Call Remark</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="callremark_15"
                                                id="callremark_call_15" value="Call Connect">
                                            <label class="form-check-label" for="callremark_call_15">Call
                                                Connect</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="callremark_15"
                                                id="callremark_no_15" value="No Response">
                                            <label class="form-check-label" for="callremark_no_15">No Response</label>
                                        </div>

                                        <div id="callremark_subremarks_15" style="display: none;">
                                            <div class="mt-2">
                                                <label class="form-label">Remarks:</label>
                                                <div id="callconnect_subremarks_15" style="display: none;">
                                                    <select class="form-select form-select-sm"
                                                        name="callconnect_subremark_15">
                                                        <option value="">Select remark</option>
                                                        <option value="DND the Patient">DND the
                                                            Patient</option>
                                                        <option value="Journey Completed">Journey Completed</option>
                                                        <option value="Call Rescheduled by the Patient">Call Rescheduled
                                                            by the Patient</option>
                                                        <option value="Wrong Number – DND the Patient">Wrong Number –
                                                            DND the Patient</option>
                                                        <option value="Language Barrier">Language Barrier</option>
                                                        <option value="Call Completed">Call Completed</option>
                                                        <option value="Call Disconnected by the Patient">Call
                                                            Disconnected by the Patient</option>
                                                        <option value="Dropout">Dropout</option>
                                                    </select>
                                                </div>
                                                <div id="noresponse_subremarks_15" style="display: none;">
                                                    <select class="form-select form-select-sm"
                                                        name="noresponse_subremark_15">
                                                        <option value="">Select remark</option>
                                                        <option value="Ringing">Ringing</option>
                                                        <option value="Call Busy">Call Busy</option>
                                                        <option value="Invalid Number">Invalid Number</option>
                                                        <option value="Out of Service">Out of Service</option>
                                                        <option value="Switched Off">Switched Off</option>
                                                        <option value="Drop out">Drop out</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="text-center mt-4">
                                        <button type="submit" id='day15_submit' class="btn btn-primary">Submit Day 15
                                            Follow-up</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="day30" role="tabpanel" aria-labelledby="day30-tab">
                            <div class="form-section">
                                <h2 class="section-title">🗓️ Day 30 Follow-up</h2>
                                <form id="day30form">
                                    <input type="hidden" name="day" value="30">
                                    <input type="hidden" name="patient_id" value="">
                                    <input type="hidden" name="id">
                                    <!-- 1. Medicines Regularity -->
                                    <div class="mb-3">
                                        <label class="form-label">1. Are you taking your medicines regularly as advised
                                            by your doctor?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_meds"
                                                id="day30_meds_yes" value="Yes">
                                            <label class="form-check-label" for="day30_meds_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_meds"
                                                id="day30_meds_no" value="No">
                                            <label class="form-check-label" for="day30_meds_no">No</label>
                                        </div>
                                        <span id="day30_meds_reason" style="display: none;">
                                            → Reason: <input type="text" name="day30_meds_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- 2. Medicines Stock -->
                                    <div class="mb-3">
                                        <label class="form-label">2. Do you have enough stock of medicines?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_stock"
                                                id="day30_stock_yes" value="Yes">
                                            <label class="form-check-label" for="day30_stock_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_stock"
                                                id="day30_stock_no" value="No">
                                            <label class="form-check-label" for="day30_stock_no">No</label>
                                        </div>
                                        <span id="day30_meds_stock" style="display: none;">
                                            → Please get a refill or consult your doctor.
                                        </span>
                                    </div>

                                    <!-- 3. Medication Changes -->
                                    <div class="mb-3">
                                        <label class="form-label">3. Has your doctor added or changed any medication
                                            recently?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_changes"
                                                id="day30_changes_yes" value="Yes">
                                            <label class="form-check-label" for="day30_changes_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_changes"
                                                id="day30_changes_no" value="No">
                                            <label class="form-check-label" for="day30_changes_no">No</label>
                                        </div>
                                    </div>

                                    <!-- 4. Recent BP -->
                                    <div class="mb-3">
                                        <label class="form-label">4. Recent BP Reading:</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_bp"
                                                id="day30_bp_yes" value="Yes">
                                            <label class="form-check-label" for="day30_bp_yes">Yes → BP:</label>
                                        </div>
                                        <span id="day30_bp_value" style="display: none;">
                                            <input type="text" name="day30_bp_value"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_bp"
                                                id="day30_bp_no" value="No">
                                            <label class="form-check-label" for="day30_bp_no">No</label>
                                        </div>
                                    </div>

                                    <!-- 5. Weight -->
                                    <div class="mb-3">
                                        <label class="form-label">5. Current weight:</label>
                                        <input type="text" name="day30_weight"
                                            class="form-control form-control-sm d-inline form-text-input"> kg
                                    </div>

                                    <!-- 6. Blood Sugar -->
                                    <div class="mb-3">
                                        <label class="form-label">6. Have you checked your blood sugar level (RBS)
                                            recently</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_rbs"
                                                id="day30_rbs_yes" value="Yes">
                                            <label class="form-check-label" for="day30_rbs_yes">Yes</label>
                                        </div>
                                        <span id="day30_rbs_value" style="display: none;">
                                            → <input type="text" name="day30_rbs_value"
                                                class="form-control form-control-sm d-inline form-text-input"> mg/dL
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_rbs"
                                                id="day30_rbs_no" value="No">
                                            <label class="form-check-label" for="day30_rbs_no">No</label>
                                        </div>
                                        <span id="day30_rbs_reason" style="display: none;">
                                            → Reason: <input type="text" name="day30_rbs_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- 7. Fluid Intake & Urine Output -->
                                    <div class="mb-3">
                                        <label class="form-label">7. Can you tell me about your water/fluid intake and
                                            urine output over the past few days?</label><br>
                                        <label class="form-label">Fluid Intake:</label><br>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_fluid"
                                                id="day30_fluid_adequate" value="Adequate">
                                            <label class="form-check-label" for="day30_fluid_adequate">Adequate</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_fluid"
                                                id="day30_fluid_increased" value="Increased">
                                            <label class="form-check-label"
                                                for="day30_fluid_increased">Increased</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_fluid"
                                                id="day30_fluid_decreased" value="Decreased">
                                            <label class="form-check-label"
                                                for="day30_fluid_decreased">Decreased</label>
                                        </div><br>
                                        <label class="form-label">Urine Output:</label><br>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_urine"
                                                id="day30_urine_normal" value="Normal">
                                            <label class="form-check-label" for="day30_urine_normal">Normal</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_urine"
                                                id="day30_urine_increased" value="Increased">
                                            <label class="form-check-label"
                                                for="day30_urine_increased">Increased</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_urine"
                                                id="day30_urine_reduced" value="Reduced">
                                            <label class="form-check-label" for="day30_urine_reduced">Reduced</label>
                                        </div>
                                    </div>

                                    <!-- 8. Breathing -->
                                    <div class="mb-3">
                                        <label class="form-label">8. How is your breathing (NYHA
                                            Classification)?</label>
                                        <div class="checkbox-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day30_breathless"
                                                    id="day30_breathless_no_breathlessness" value="No breathlessness">
                                                <label class="form-check-label"
                                                    for="day30_breathless_no_breathlessness">No breathlessness</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day30_breathless"
                                                    id="day30_breathless_while_climbing_stairs"
                                                    value="While climbing stairs">
                                                <label class="form-check-label"
                                                    for="day30_breathless_while_climbing_stairs">While climbing
                                                    stairs</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day30_breathless"
                                                    id="day30_breathless_while_sitting" value="While sitting">
                                                <label class="form-check-label"
                                                    for="day30_breathless_while_sitting">While sitting</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day30_breathless"
                                                    id="day30_breathless_while_changing_clothes"
                                                    value="While changing clothes">
                                                <label class="form-check-label"
                                                    for="day30_breathless_while_changing_clothes">While changing
                                                    clothes</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day30_breathless"
                                                    id="day30_breathless_cannot_lie_down_flat"
                                                    value="Cannot lie down flat">
                                                <label class="form-check-label"
                                                    for="day30_breathless_cannot_lie_down_flat">Cannot lie down
                                                    flat</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 9. Yoga -->
                                    <div class="mb-3">
                                        <label class="form-label">9. Have you attended any yoga sessions yet</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_yoga"
                                                id="day30_yoga_yes" value="Yes">
                                            <label class="form-check-label" for="day30_yoga_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_yoga"
                                                id="day30_yoga_no" value="No">
                                            <label class="form-check-label" for="day30_yoga_no">No</label>
                                        </div>
                                        <span id="day30_yoga_reason" style="display: none;">
                                            → Reason: <input type="text" name="day30_yoga_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">10. AE REPORT?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_ae_report"
                                                id="day30_ae_report_yes" value="Yes">
                                            <label class="form-check-label" for="day30_ae_report_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day30_ae_report"
                                                id="day30_ae_report_no" value="No">
                                            <label class="form-check-label" for="day30_ae_report_no">No</label>
                                        </div>
                                    </div>
                                    <!-- Call Remark -->
                                    <div class="mb-3">
                                        <label class="form-label">Call Remark</label>
                                        <div class="mb-3">
                                            <div class="form-check form-check-inline checkbox-item">
                                                <input class="form-check-input" type="radio" name="callremark_30"
                                                    id="callremark_call_30" value="Call Connect">
                                                <label class="form-check-label" for="callremark_call_30">Call
                                                    Connect</label>
                                            </div>
                                            <div class="form-check form-check-inline checkbox-item">
                                                <input class="form-check-input" type="radio" name="callremark_30"
                                                    id="callremark_no_30" value="No Response">
                                                <label class="form-check-label" for="callremark_no_30">No
                                                    Response</label>
                                            </div>

                                            <div id="callremark_subremarks_30" style="display: none;">
                                                <div class="mt-2">
                                                    <label class="form-label">Remarks:</label>
                                                    <div id="callconnect_subremarks_30" style="display: none;">
                                                        <select class="form-select form-select-sm"
                                                            name="callconnect_subremark_30">
                                                            <option value="">Select remark</option>
                                                            <option value="DND the Patient">DND the
                                                                Patient</option>
                                                            <option value="Journey Completed">Journey Completed</option>
                                                            <option value="Call Rescheduled by the Patient">Call
                                                                Rescheduled by the Patient</option>
                                                            <option value="Wrong Number – DND the Patient">Wrong Number
                                                                – DND the Patient</option>
                                                            <option value="Language Barrier">Language Barrier</option>
                                                            <option value="Call Completed">Call Completed</option>
                                                            <option value="Call Disconnected by the Patient">Call
                                                                Disconnected by the Patient</option>
                                                            <option value="Dropout">Dropout</option>
                                                        </select>
                                                    </div>
                                                    <div id="noresponse_subremarks_30" style="display: none;">
                                                        <select class="form-select form-select-sm"
                                                            name="noresponse_subremark_30">
                                                            <option value="">Select remark</option>
                                                            <option value="Ringing">Ringing</option>
                                                            <option value="Call Busy">Call Busy</option>
                                                            <option value="Invalid Number">Invalid Number</option>
                                                            <option value="Out of Service">Out of Service</option>
                                                            <option value="Switched Off">Switched Off</option>
                                                            <option value="Drop out">Drop out</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="text-center mt-4">
                                        <button type="submit" id='day30_submit' class="btn btn-primary">Submit Day 30
                                            Follow-up</button>
                                    </div>

                                </form>
                            </div>
                        </div>



                        <div class="tab-pane fade" id="day45" role="tabpanel" aria-labelledby="day45-tab">
                            <div class="form-section">
                                <h2 class="section-title">🗓️ Day 45 Follow-up</h2>
                                <form id="day45form">
                                    <input type="hidden" name="day" value="45">
                                    <input type="hidden" name="patient_id" value="">
                                    <input type="hidden" name="id">
                                    <!-- 1. Medicines -->
                                    <div class="mb-3">
                                        <label class="form-label">1. Are you taking your prescribed medicines
                                            regularly?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day45_meds"
                                                id="day45_meds_yes" value="Yes">
                                            <label class="form-check-label" for="day45_meds_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day45_meds"
                                                id="day45_meds_no" value="No">
                                            <label class="form-check-label" for="day45_meds_no">No</label>
                                        </div>
                                        <span id="day45_meds_reason" style="display: none;">
                                            → Reason: <input type="text" name="day45_meds_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- 2. Doctor Follow-up -->
                                    <div class="mb-3">
                                        <label class="form-label">2. Have you visited your doctor recently for a
                                            follow-up?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day45_doctor"
                                                id="day45_doctor_yes" value="Yes">
                                            <label class="form-check-label" for="day45_doctor_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day45_doctor"
                                                id="day45_doctor_no" value="No">
                                            <label class="form-check-label" for="day45_doctor_no">No</label>
                                        </div>
                                        <span id="day45_doctor_reason" style="display: none;">
                                            → Reason: <input type="text" name="day45_doctor_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- 3. Blood Pressure -->
                                    <div class="mb-3">
                                        <label class="form-label">3. What was your latest blood pressure
                                            reading:</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day45_bp"
                                                id="day45_bp_yes" value="Yes">
                                            <label class="form-check-label" for="day45_bp_yes">Yes</label>
                                        </div>
                                        <span id="day45_bp_value" style="display: none;">
                                            → BP: <input type="text" name="day45_bp_value"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day45_bp"
                                                id="day45_bp_no" value="No">
                                            <label class="form-check-label" for="day45_bp_no">No</label>
                                        </div>
                                        <span id="day45_bp_remarks" style="display: none;">
                                            → Remarks: <input type="text" name="day45_bp_remarks"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- 4. Weight -->
                                    <div class="mb-3">
                                        <label class="form-label">4. Do you know your current weight:</label>
                                        <input type="text" name="day45_weight"
                                            class="form-control form-control-sm d-inline form-text-input"> kg
                                    </div>

                                    <!-- 5. Breathlessness -->
                                    <div class="mb-3">
                                        <label class="form-label">5. Do you feel breathless?</label>
                                        <div class="checkbox-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day45_breathless"
                                                    id="day45_breathless_none" value="No breathlessness">
                                                <label class="form-check-label" for="day45_breathless_none">No
                                                    breathlessness</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day45_breathless"
                                                    id="day45_breathless_stairs" value="While climbing stairs">
                                                <label class="form-check-label" for="day45_breathless_stairs">While
                                                    climbing stairs</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day45_breathless"
                                                    id="day45_breathless_sitting" value="While sitting">
                                                <label class="form-check-label" for="day45_breathless_sitting">While
                                                    sitting</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day45_breathless"
                                                    id="day45_breathless_clothes" value="While changing clothes">
                                                <label class="form-check-label" for="day45_breathless_clothes">While
                                                    changing clothes</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day45_breathless"
                                                    id="day45_breathless_lie" value="Cannot lie down flat">
                                                <label class="form-check-label" for="day45_breathless_lie">Cannot lie
                                                    down flat</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 6. Yoga Schedule -->
                                    <div class="mb-3">
                                        <label class="form-label">6. Would you like to schedule a yoga session as part
                                            of your care plan?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day45_yoga_schedule"
                                                id="day45_yoga_schedule_yes" value="Yes">
                                            <label class="form-check-label" for="day45_yoga_schedule_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day45_yoga_schedule"
                                                id="day45_yoga_schedule_no" value="No">
                                            <label class="form-check-label" for="day45_yoga_schedule_no">No</label>
                                        </div>
                                        <span id="day45_yoga_schedule_reason" style="display: none;">
                                            → Reason: <input type="text" name="day45_yoga_schedule_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- 7. Yoga Tried Earlier -->
                                    <div class="mb-3">
                                        <label class="form-label">7. Have you tried any yoga or breathing exercises
                                            earlier?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day45_yoga_tried"
                                                id="day45_yoga_tried_yes" value="Yes">
                                            <label class="form-check-label" for="day45_yoga_tried_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day45_yoga_tried"
                                                id="day45_yoga_tried_no" value="No">
                                            <label class="form-check-label" for="day45_yoga_tried_no">No</label>
                                        </div>
                                        <span id="day45_yoga_tried_difficult" style="display: none;">
                                            <div class="form-check form-check-inline checkbox-item">
                                                <input class="form-check-input" type="radio" name="day45_yoga_difficult"
                                                    id="day45_yoga_difficult_yes" value="Yes">
                                                <label class="form-check-label"
                                                    for="day45_yoga_difficult_yes">Difficulties?</label>
                                            </div>
                                            <span id="day45_yoga_difficult_reason" style="display: none;">
                                                → Reason: <input type="text" name="day45_yoga_difficult_reason"
                                                    class="form-control form-control-sm d-inline form-text-input">
                                            </span>
                                        </span>
                                    </div>

                                    <!-- 8. Yoga Session Required -->
                                    <div class="mb-3">
                                        <label class="form-label">8. Yoga Session Required?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day45_yoga_required"
                                                id="day45_yoga_required_yes" value="Yes">
                                            <label class="form-check-label" for="day45_yoga_required_yes">Yes</label>
                                        </div>
                                        <span id="day45_yoga_planned_date" style="display: none;">
                                            → Planned date: <input type="text" placeholder="YYYY-MM-DD"
                                                name="day45_yoga_planned_date"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day45_yoga_required"
                                                id="day45_yoga_required_no" value="No">
                                            <label class="form-check-label" for="day45_yoga_required_no">No</label>
                                        </div>
                                        <span id="day45_yoga_required_reason" style="display: none;">
                                            → Reason: <input type="text" name="day45_yoga_required_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">9. AE REPORT?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day45_ae_report"
                                                id="day45_ae_report_yes" value="Yes">
                                            <label class="form-check-label" for="day45_ae_report_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day45_ae_report"
                                                id="day45_ae_report_no" value="No">
                                            <label class="form-check-label" for="day45_ae_report_no">No</label>
                                        </div>
                                    </div>
                                    <!-- 9. Call Remark -->
                                    <div class="mb-3">
                                        <label class="form-label">Call Remark</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="callremark_45"
                                                id="callremark_call_45" value="Call Connect">
                                            <label class="form-check-label" for="callremark_call_45">Call
                                                Connect</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="callremark_45"
                                                id="callremark_no_45" value="No Response">
                                            <label class="form-check-label" for="callremark_no_45">No Response</label>
                                        </div>

                                        <div id="callremark_subremarks_45" style="display: none;">
                                            <div class="mt-2">
                                                <label class="form-label">Remarks:</label>
                                                <div id="callconnect_subremarks_45" style="display: none;">
                                                    <select class="form-select form-select-sm"
                                                        name="callconnect_subremark_45">
                                                        <option value="">Select remark</option>
                                                        <option value="DND the Patient">DND the
                                                            Patient</option>
                                                        <option value="Journey Completed">Journey Completed</option>
                                                        <option value="Call Rescheduled by the Patient">Call Rescheduled
                                                            by the Patient</option>
                                                        <option value="Wrong Number – DND the Patient">Wrong Number –
                                                            DND the Patient</option>
                                                        <option value="Language Barrier">Language Barrier</option>
                                                        <option value="Call Completed">Call Completed</option>
                                                        <option value="Call Disconnected by the Patient">Call
                                                            Disconnected by the Patient</option>
                                                        <option value="Dropout">Dropout</option>
                                                    </select>
                                                </div>
                                                <div id="noresponse_subremarks_45" style="display: none;">
                                                    <select class="form-select form-select-sm"
                                                        name="noresponse_subremark_45">
                                                        <option value="">Select remark</option>
                                                        <option value="Ringing">Ringing</option>
                                                        <option value="Call Busy">Call Busy</option>
                                                        <option value="Invalid Number">Invalid Number</option>
                                                        <option value="Out of Service">Out of Service</option>
                                                        <option value="Switched Off">Switched Off</option>
                                                        <option value="Drop out">Drop out</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="text-center mt-4">
                                        <button type="submit" id='day45_submit' class="btn btn-primary">Submit Day 45
                                            Follow-up</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="day60" role="tabpanel" aria-labelledby="day60-tab">
                            <div class="form-section">
                                <h2 class="section-title">🗓️ Day 60 Follow-up</h2>
                                <form id="day60form">
                                    <input type="hidden" name="day" value="60">
                                    <input type="hidden" name="patient_id" value="">
                                    <input type="hidden" name="id">
                                    <!-- 1. Medicines Regularity -->
                                    <div class="mb-3">
                                        <label class="form-label">1. Are you taking your medicines regularly and on
                                            time?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_meds"
                                                id="day60_meds_yes" value="Yes">
                                            <label class="form-check-label" for="day60_meds_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_meds"
                                                id="day60_meds_no" value="No">
                                            <label class="form-check-label" for="day60_meds_no">No</label>
                                        </div>
                                        <span id="day60_meds_reason" style="display:none;">
                                            → Reason: <input type="text" name="day60_meds_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- 2. Blood Pressure -->
                                    <div class="mb-3">
                                        <label class="form-label">2. Recent blood pressure (BP) reading:</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_bp"
                                                id="day60_bp_yes" value="Yes">
                                            <label class="form-check-label" for="day60_bp_yes">Yes</label>
                                        </div>
                                        <span id="day60_bp_value" style="display:none;">
                                            → <input type="text" name="day60_bp_value"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_bp"
                                                id="day60_bp_no" value="No">
                                            <label class="form-check-label" for="day60_bp_no">No</label>
                                        </div>
                                    </div>

                                    <!-- 3. Blood Sugar -->
                                    <div class="mb-3">
                                        <label class="form-label">3. Recent blood sugar level (RBS) reading:</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_rbs"
                                                id="day60_rbs_yes" value="Yes">
                                            <label class="form-check-label" for="day60_rbs_yes">Yes</label>
                                        </div>
                                        <span id="day60_rbs_value" style="display:none;">
                                            → <input type="text" name="day60_rbs_value"
                                                class="form-control form-control-sm d-inline form-text-input"> mg/dL
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_rbs"
                                                id="day60_rbs_no" value="No">
                                            <label class="form-check-label" for="day60_rbs_no">No</label>
                                        </div>
                                    </div>

                                    <!-- 4. Weight -->
                                    <div class="mb-3">
                                        <label class="form-label">4. Current weight:</label>
                                        <input type="text" name="day60_weight"
                                            class="form-control form-control-sm d-inline form-text-input"> kg
                                    </div>

                                    <!-- 5. HbA1c -->
                                    <div class="mb-3">
                                        <label class="form-label">5. Do you know your last HbA1c value?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_hba1c"
                                                id="day60_hba1c_yes" value="Yes">
                                            <label class="form-check-label" for="day60_hba1c_yes">Yes</label>
                                        </div>
                                        <span id="day60_hba1c_value" style="display:none;">
                                            → <input type="text" name="day60_hba1c_value"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_hba1c"
                                                id="day60_hba1c_no" value="No">
                                            <label class="form-check-label" for="day60_hba1c_no">No</label>
                                        </div>
                                        <span id="day60_hba1c_last" style="display:none;">
                                            → Last checked: <input type="text" name="day60_hba1c_last"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- 6. Diet Challenges -->
                                    <div class="mb-3">
                                        <label class="form-label">6. Are you facing challenges in following the diet
                                            plan?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_challenges"
                                                id="day60_challenges_yes" value="Yes">
                                            <label class="form-check-label" for="day60_challenges_yes">Yes</label>
                                        </div>
                                        <span id="day60_challenges_reason" style="display:none;">
                                            → Reason: <input type="text" name="day60_challenges_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_challenges"
                                                id="day60_challenges_no" value="No">
                                            <label class="form-check-label" for="day60_challenges_no">No</label>
                                        </div>
                                    </div>

                                    <!-- 7. Fluid Monitoring -->
                                    <div class="mb-3">
                                        <label class="form-label">7. Are you monitoring your daily fluid intake?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_monitor"
                                                id="day60_monitor_yes" value="Yes">
                                            <label class="form-check-label" for="day60_monitor_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_monitor"
                                                id="day60_monitor_no" value="No">
                                            <label class="form-check-label" for="day60_monitor_no">No</label>
                                        </div>
                                        <span id="day60_monitor_reason" style="display:none;">
                                            → Reason: <input type="text" name="day60_monitor_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- 8. Fluid & Urine Output -->
                                    <div class="mb-3">
                                        <label class="form-label">8. Can you tell me about your water/fluid intake and
                                            urine output over the past few days?</label><br>
                                        <label class="form-label">Water Intake:</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_water"
                                                id="day60_water_adequate" value="Adequate">
                                            <label class="form-check-label" for="day60_water_adequate">Adequate</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_water"
                                                id="day60_water_increased" value="Increased">
                                            <label class="form-check-label"
                                                for="day60_water_increased">Increased</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_water"
                                                id="day60_water_decreased" value="Decreased">
                                            <label class="form-check-label"
                                                for="day60_water_decreased">Decreased</label>
                                        </div>
                                        <br>
                                        <label class="form-label">Urine Output:</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_urine"
                                                id="day60_urine_normal" value="Normal">
                                            <label class="form-check-label" for="day60_urine_normal">Normal</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_urine"
                                                id="day60_urine_increased" value="Increased">
                                            <label class="form-check-label"
                                                for="day60_urine_increased">Increased</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_urine"
                                                id="day60_urine_reduced" value="Reduced">
                                            <label class="form-check-label" for="day60_urine_reduced">Reduced</label>
                                        </div>
                                    </div>

                                    <!-- 9. Diet/Lifestyle Questions -->
                                    <div class="mb-3">
                                        <label class="form-label">9. Any question related to diet or lifestyle
                                            changes?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_questions"
                                                id="day60_questions_yes" value="Yes">
                                            <label class="form-check-label" for="day60_questions_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_questions"
                                                id="day60_questions_no" value="No">
                                            <label class="form-check-label" for="day60_questions_no">No</label>
                                        </div>
                                    </div>

                                    <!-- 10. Meal Planning Help -->
                                    <div class="mb-3">
                                        <label class="form-label">10. Would you like more help with meal planning or
                                            salt restriction?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_help"
                                                id="day60_help_yes" value="Yes">
                                            <label class="form-check-label" for="day60_help_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_help"
                                                id="day60_help_no" value="No">
                                            <label class="form-check-label" for="day60_help_no">No</label>
                                        </div>
                                    </div>

                                    <!-- 11. Doctor Follow-up -->
                                    <div class="mb-3">
                                        <label class="form-label">11. Was there any follow-up with the doctor
                                            recently?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_doctor"
                                                id="day60_doctor_yes" value="Yes">
                                            <label class="form-check-label" for="day60_doctor_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_doctor"
                                                id="day60_doctor_no" value="No">
                                            <label class="form-check-label" for="day60_doctor_no">No</label>
                                        </div>
                                        <span id="day60_doctor_reason" style="display:none;">
                                            → Reason: <input type="text" name="day60_doctor_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- 12. Yoga Remark -->
                                    <div class="mb-3">
                                        <label class="form-label">12. How are you feeling now? Do you need more yoga
                                            sessions?</label>
                                        <div class="form-group">
                                            <label>Remark:</label>
                                            <textarea name="day60_yoga_remark" class="form-control" rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">13. AE REPORT?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_ae_report"
                                                id="day60_ae_report_yes" value="Yes">
                                            <label class="form-check-label" for="day60_ae_report_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day60_ae_report"
                                                id="day60_ae_report_no" value="No">
                                            <label class="form-check-label" for="day60_ae_report_no">No</label>
                                        </div>
                                    </div>
                                    <!-- Call Remark -->
                                    <div class="mb-3">
                                        <label class="form-label">Call Remark</label>
                                        <div class="mb-3">
                                            <div class="form-check form-check-inline checkbox-item">
                                                <input class="form-check-input" type="radio" name="callremark_60"
                                                    id="callremark_call_60" value="Call Connect">
                                                <label class="form-check-label" for="callremark_call_60">Call
                                                    Connect</label>
                                            </div>
                                            <div class="form-check form-check-inline checkbox-item">
                                                <input class="form-check-input" type="radio" name="callremark_60"
                                                    id="callremark_no_60" value="No Response">
                                                <label class="form-check-label" for="callremark_no_60">No
                                                    Response</label>
                                            </div>
                                        </div>

                                        <div id="callremark_subremarks_60" style="display:none;">
                                            <div class="mt-2">
                                                <label class="form-label">Remarks:</label>
                                                <div id="callconnect_subremarks_60" style="display:none;">
                                                    <select class="form-select form-select-sm"
                                                        name="callconnect_subremark_60">
                                                        <option value="">Select remark</option>
                                                        <option value="DND the Patient">DND the
                                                            Patient</option>
                                                        <option value="Journey Completed">Journey Completed</option>
                                                        <option value="Call Rescheduled by the Patient">Call Rescheduled
                                                            by the Patient</option>
                                                        <option value="Wrong Number – DND the Patient">Wrong Number –
                                                            DND the Patient</option>
                                                        <option value="Language Barrier">Language Barrier</option>
                                                        <option value="Call Completed">Call Completed</option>
                                                        <option value="Call Disconnected by the Patient">Call
                                                            Disconnected by the Patient</option>
                                                        <option value="Dropout">Dropout</option>
                                                    </select>
                                                </div>
                                                <div id="noresponse_subremarks_60" style="display:none;">
                                                    <select class="form-select form-select-sm"
                                                        name="noresponse_subremark_60">
                                                        <option value="">Select remark</option>
                                                        <option value="Ringing">Ringing</option>
                                                        <option value="Call Busy">Call Busy</option>
                                                        <option value="Invalid Number">Invalid Number</option>
                                                        <option value="Out of Service">Out of Service</option>
                                                        <option value="Switched Off">Switched Off</option>
                                                        <option value="Drop out">Drop out</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="text-center mt-4">
                                        <button type="submit" id='day60_submit' class="btn btn-primary">
                                            Submit Day 60 Follow-up
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="day90" role="tabpanel" aria-labelledby="day90-tab">
                            <div class="form-section">
                                <h2 class="section-title">🗓️ Day 90 Follow-up</h2>
                                <form id="day90form">
                                    <input type="hidden" name="day" value="90">
                                    <input type="hidden" name="patient_id" value="">
                                    <input type="hidden" name="id">
                                    <!-- 1. Medicines -->
                                    <div class="mb-3">
                                        <label class="form-label">1. Are you taking your prescribed medicines
                                            regularly?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day90_meds"
                                                id="day90_meds_yes" value="Yes">
                                            <label class="form-check-label" for="day90_meds_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day90_meds"
                                                id="day90_meds_no" value="No">
                                            <label class="form-check-label" for="day90_meds_no">No</label>
                                        </div>
                                        <span id="day90_meds_reason" style="display:none;">
                                            → Reason: <input type="text" name="day90_meds_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- 2. Doctor Follow-up -->
                                    <div class="mb-3">
                                        <label class="form-label">2. Have you visited your doctor recently for a
                                            follow-up?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day90_doctor"
                                                id="day90_doctor_yes" value="Yes">
                                            <label class="form-check-label" for="day90_doctor_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day90_doctor"
                                                id="day90_doctor_no" value="No">
                                            <label class="form-check-label" for="day90_doctor_no">No</label>
                                        </div>
                                        <span id="day90_doctor_reason" style="display:none;">
                                            → Reason: <input type="text" name="day90_doctor_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- 3. Blood Pressure -->
                                    <div class="mb-3">
                                        <label class="form-label">3. What was your latest blood pressure
                                            reading:</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day90_bp"
                                                id="day90_bp_yes" value="Yes">
                                            <label class="form-check-label" for="day90_bp_yes">Yes</label>
                                        </div>
                                        <span id="day90_bp_value" style="display:none;">
                                            → BP: <input type="text" name="day90_bp_value"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day90_bp"
                                                id="day90_bp_no" value="No">
                                            <label class="form-check-label" for="day90_bp_no">No</label>
                                        </div>
                                        <span id="day90_bp_remarks" style="display:none;">
                                            → Remarks: <input type="text" name="day90_bp_remarks"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- 4. Weight -->
                                    <div class="mb-3">
                                        <label class="form-label">4. Do you know your current weight:</label>
                                        <input type="text" name="day90_weight"
                                            class="form-control form-control-sm d-inline form-text-input"> kg
                                    </div>

                                    <!-- 5. Breathlessness -->
                                    <div class="mb-3">
                                        <label class="form-label">5. Do you feel breathless?</label>
                                        <div class="checkbox-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day90_breathless"
                                                    id="day90_breathless_none" value="No breathlessness">
                                                <label class="form-check-label" for="day90_breathless_none">No
                                                    breathlessness</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day90_breathless"
                                                    id="day90_breathless_stairs" value="While climbing stairs">
                                                <label class="form-check-label" for="day90_breathless_stairs">While
                                                    climbing stairs</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day90_breathless"
                                                    id="day90_breathless_sitting" value="While sitting">
                                                <label class="form-check-label" for="day90_breathless_sitting">While
                                                    sitting</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day90_breathless"
                                                    id="day90_breathless_clothes" value="While changing clothes">
                                                <label class="form-check-label" for="day90_breathless_clothes">While
                                                    changing clothes</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day90_breathless"
                                                    id="day90_breathless_lie" value="Cannot lie down flat">
                                                <label class="form-check-label" for="day90_breathless_lie">Cannot lie
                                                    down flat</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 6. Yoga Schedule -->
                                    <div class="mb-3">
                                        <label class="form-label">6. Would you like to schedule a yoga session as part
                                            of your care plan?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day90_yoga_schedule"
                                                id="day90_yoga_schedule_yes" value="Yes">
                                            <label class="form-check-label" for="day90_yoga_schedule_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day90_yoga_schedule"
                                                id="day90_yoga_schedule_no" value="No">
                                            <label class="form-check-label" for="day90_yoga_schedule_no">No</label>
                                        </div>
                                        <span id="day90_yoga_schedule_reason" style="display:none;">
                                            → Reason: <input type="text" name="day90_yoga_schedule_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- 7. Yoga Tried Earlier -->
                                    <div class="mb-3">
                                        <label class="form-label">7. Have you tried any yoga or breathing exercises
                                            earlier?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day90_yoga_tried"
                                                id="day90_yoga_tried_yes" value="Yes">
                                            <label class="form-check-label" for="day90_yoga_tried_yes">Yes</label>
                                        </div>
                                        <span id="day90_yoga_tried_difficult" style="display:none;">
                                            <div class="form-check form-check-inline checkbox-item">
                                                <input class="form-check-input" type="radio" name="day90_yoga_difficult"
                                                    id="day90_yoga_difficult_yes" value="Yes">
                                                <label class="form-check-label"
                                                    for="day90_yoga_difficult_yes">Difficulties?</label>
                                            </div>
                                        </span>
                                        <span id="day90_yoga_difficult_reason" style="display:none;">
                                            → Reason: <input type="text" name="day90_yoga_difficult_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day90_yoga_tried"
                                                id="day90_yoga_tried_no" value="No">
                                            <label class="form-check-label" for="day90_yoga_tried_no">No</label>
                                        </div>
                                    </div>

                                    <!-- 8. Yoga Session Required -->
                                    <div class="mb-3">
                                        <label class="form-label">8. Yoga Session Required?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day90_yoga_required"
                                                id="day90_yoga_required_yes" value="Yes">
                                            <label class="form-check-label" for="day90_yoga_required_yes">Yes</label>
                                        </div>
                                        <span id="day90_yoga_planned_date" style="display:none;">
                                            → Planned date: <input type="text" placeholder="YYYY-MM-DD"
                                                name="day90_yoga_planned_date"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day90_yoga_required"
                                                id="day90_yoga_required_no" value="No">
                                            <label class="form-check-label" for="day90_yoga_required_no">No</label>
                                        </div>
                                        <span id="day90_yoga_required_reason" style="display:none;">
                                            → Reason: <input type="text" name="day90_yoga_required_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">9. AE REPORT?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day90_ae_report"
                                                id="day90_ae_report_yes" value="Yes">
                                            <label class="form-check-label" for="day90_ae_report_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day90_ae_report"
                                                id="day90_ae_report_no" value="No">
                                            <label class="form-check-label" for="day90_ae_report_no">No</label>
                                        </div>
                                    </div>
                                    <!-- 9. Call Remark -->
                                    <div class="mb-3">
                                        <label class="form-label">Call Remark</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="callremark_90"
                                                id="callremark_call_90" value="Call Connect">
                                            <label class="form-check-label" for="callremark_call_90">Call
                                                Connect</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="callremark_90"
                                                id="callremark_no_90" value="No Response">
                                            <label class="form-check-label" for="callremark_no_90">No Response</label>
                                        </div>
                                        <div id="callremark_subremarks_90" style="display:none;">
                                            <div class="mt-2">
                                                <label class="form-label">Remarks:</label>
                                                <div id="callconnect_subremarks_90" style="display:none;">
                                                    <select class="form-select form-select-sm"
                                                        name="callconnect_subremark_90">
                                                        <option value="">Select remark</option>
                                                        <option value="DND the Patient">DND the
                                                            Patient</option>
                                                        <option value="Journey Completed">Journey Completed</option>
                                                        <option value="Call Rescheduled by the Patient">Call Rescheduled
                                                            by the Patient</option>
                                                        <option value="Wrong Number – DND the Patient">Wrong Number –
                                                            DND the Patient</option>
                                                        <option value="Language Barrier">Language Barrier</option>
                                                        <option value="Call Completed">Call Completed</option>
                                                        <option value="Call Disconnected by the Patient">Call
                                                            Disconnected by the Patient</option>
                                                        <option value="Dropout">Dropout</option>
                                                    </select>
                                                </div>
                                                <div id="noresponse_subremarks_90" style="display:none;">
                                                    <select class="form-select form-select-sm"
                                                        name="noresponse_subremark_90">
                                                        <option value="">Select remark</option>
                                                        <option value="Ringing">Ringing</option>
                                                        <option value="Call Busy">Call Busy</option>
                                                        <option value="Invalid Number">Invalid Number</option>
                                                        <option value="Out of Service">Out of Service</option>
                                                        <option value="Switched Off">Switched Off</option>
                                                        <option value="Drop out">Drop out</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="text-center mt-4">
                                        <button type="submit" id='day90_submit' class="btn btn-primary">Submit Day 90
                                            Follow-up</button>
                                    </div>
                                </form>
                            </div>
                        </div>



                        <div class="tab-pane fade" id="day120" role="tabpanel" aria-labelledby="day120-tab">
                            <div class="form-section">
                                <h2 class="section-title">🗓️ Day 120 Follow-up</h2>
                                <form id="day120form">
                                    <input type="hidden" name="day" value="120">
                                    <input type="hidden" name="patient_id" value="">
                                    <input type="hidden" name="id">
                                    <div class="mb-3">
                                        <label class="form-label">1. Are you taking your medicines regularly and on
                                            time?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_meds"
                                                id="day120_meds_yes" value="Yes">
                                            <label class="form-check-label" for="day120_meds_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_meds"
                                                id="day120_meds_no" value="No">
                                            <label class="form-check-label" for="day120_meds_no">No</label>
                                        </div>
                                        <span id="day120_meds_reason" style="display: none;">
                                            → Reason: <input type="text" name="day120_meds_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">2. Recent blood pressure (BP) reading:</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_bp"
                                                id="day120_bp_yes" value="Yes">
                                            <label class="form-check-label" for="day120_bp_yes">Yes</label>
                                        </div>
                                        <span id="day120_bp_value" style="display: none;">
                                            → <input type="text" name="day120_bp_value"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_bp"
                                                id="day120_bp_no" value="No">
                                            <label class="form-check-label" for="day120_bp_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">3. Recent blood sugar level (RBS) reading:</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_rbs"
                                                id="day120_rbs_yes" value="Yes">
                                            <label class="form-check-label" for="day120_rbs_yes">Yes</label>
                                        </div>
                                        <span id="day120_rbs_value" style="display: none;">
                                            → <input type="text" name="day120_rbs_value"
                                                class="form-control form-control-sm d-inline form-text-input"> mg/dL
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_rbs"
                                                id="day120_rbs_no" value="No">
                                            <label class="form-check-label" for="day120_rbs_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">4. Current weight:</label>
                                        <input type="text" name="day120_weight"
                                            class="form-control form-control-sm d-inline form-text-input"> kg
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">5. Do you know your last HbA1c value?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_hba1c"
                                                id="day120_hba1c_yes" value="Yes">
                                            <label class="form-check-label" for="day120_hba1c_yes">Yes</label>
                                        </div>
                                        <span id="day120_hba1c_value" style="display: none;">
                                            → <input type="text" name="day120_hba1c_value"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_hba1c"
                                                id="day120_hba1c_no" value="No">
                                            <label class="form-check-label" for="day120_hba1c_no">No</label>
                                        </div>
                                        <span id="day120_hba1c_last" style="display: none;">
                                            → Last checked: <input type="text" name="day120_hba1c_last"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">6. Are you facing challenges in following the diet
                                            plan?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_challenges"
                                                id="day120_challenges_yes" value="Yes">
                                            <label class="form-check-label" for="day120_challenges_yes">Yes</label>
                                        </div>
                                        <span id="day120_challenges_reason" style="display: none;">
                                            → Reason: <input type="text" name="day120_challenges_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_challenges"
                                                id="day120_challenges_no" value="No">
                                            <label class="form-check-label" for="day120_challenges_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">7. Are you monitoring your daily fluid intake?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_monitor"
                                                id="day120_monitor_yes" value="Yes">
                                            <label class="form-check-label" for="day120_monitor_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_monitor"
                                                id="day120_monitor_no" value="No">
                                            <label class="form-check-label" for="day120_monitor_no">No</label>
                                        </div>
                                        <span id="day120_monitor_reason" style="display: none;">
                                            → Reason: <input type="text" name="day120_monitor_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">8. Can you tell me about your water/fluid intake and
                                            urine output over the past few days?</label>
                                        <br>
                                        <label class="form-label">Water Intake:</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_water"
                                                id="day120_water_adequate" value="Adequate">
                                            <label class="form-check-label" for="day120_water_adequate">Adequate</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_water"
                                                id="day120_water_increased" value="Increased">
                                            <label class="form-check-label"
                                                for="day120_water_increased">Increased</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_water"
                                                id="day120_water_decreased" value="Decreased">
                                            <label class="form-check-label"
                                                for="day120_water_decreased">Decreased</label>
                                        </div>
                                        <br>
                                        <label class="form-label">Urine Output:</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_urine"
                                                id="day120_urine_normal" value="Normal">
                                            <label class="form-check-label" for="day120_urine_normal">Normal</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_urine"
                                                id="day120_urine_increased" value="Increased">
                                            <label class="form-check-label"
                                                for="day120_urine_increased">Increased</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_urine"
                                                id="day120_urine_reduced" value="Reduced">
                                            <label class="form-check-label" for="day120_urine_reduced">Reduced</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">9. Any question related to diet or lifestyle
                                            changes?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_questions"
                                                id="day120_questions_yes" value="Yes">
                                            <label class="form-check-label" for="day120_questions_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_questions"
                                                id="day120_questions_no" value="No">
                                            <label class="form-check-label" for="day120_questions_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">10. Would you like more help with meal planning or
                                            salt restriction?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_help"
                                                id="day120_help_yes" value="Yes">
                                            <label class="form-check-label" for="day120_help_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_help"
                                                id="day120_help_no" value="No">
                                            <label class="form-check-label" for="day120_help_no">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">11. Was there any follow-up with the doctor
                                            recently?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_doctor"
                                                id="day120_doctor_yes" value="Yes">
                                            <label class="form-check-label" for="day120_doctor_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_doctor"
                                                id="day120_doctor_no" value="No">
                                            <label class="form-check-label" for="day120_doctor_no">No</label>
                                        </div>
                                        <span id="day120_doctor_reason" style="display: none;">
                                            → Reason: <input type="text" name="day120_doctor_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">12. How are you feeling now? Do you need more yoga
                                            sessions?</label>
                                        <div class="form-group">
                                            <label>Remark:</label>
                                            <textarea name="day120_yoga_remark" class="form-control"
                                                rows="2"></textarea>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">13. AE REPORT?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_ae_report"
                                                id="day120_ae_report_yes" value="Yes">
                                            <label class="form-check-label" for="day120_ae_report_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day120_ae_report"
                                                id="day120_ae_report_no" value="No">
                                            <label class="form-check-label" for="day120_ae_report_no">No</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Call Remark</label>
                                        <div class="mb-3">
                                            <div class="form-check form-check-inline checkbox-item">
                                                <input class="form-check-input" type="radio" name="callremark_120"
                                                    id="callremark_call_120" value="Call Connect">
                                                <label class="form-check-label" for="callremark_call_120">Call
                                                    Connect</label>
                                            </div>
                                            <div class="form-check form-check-inline checkbox-item">
                                                <input class="form-check-input" type="radio" name="callremark_120"
                                                    id="callremark_no_120" value="No Response">
                                                <label class="form-check-label" for="callremark_no_120">No
                                                    Response</label>
                                            </div>
                                        </div>

                                        <div id="callremark_subremarks_120" style="display:none;">
                                            <div class="mt-2">
                                                <label class="form-label">Remarks:</label>
                                                <div id="callconnect_subremarks_120" style="display:none;">
                                                    <select class="form-select form-select-sm"
                                                        name="callconnect_subremark_120">
                                                        <option value="">Select remark</option>
                                                        <option value="DND the Patient">DND the
                                                            Patient</option>
                                                        <option value="Journey Completed">Journey Completed</option>
                                                        <option value="Call Rescheduled by the Patient">Call Rescheduled
                                                            by the Patient</option>
                                                        <option value="Wrong Number – DND the Patient">Wrong Number –
                                                            DND the Patient</option>
                                                        <option value="Language Barrier">Language Barrier</option>
                                                        <option value="Call Completed">Call Completed</option>
                                                        <option value="Call Disconnected by the Patient">Call
                                                            Disconnected by the Patient</option>
                                                        <option value="Dropout">Dropout</option>
                                                    </select>
                                                </div>
                                                <div id="noresponse_subremarks_120" style="display:none;">
                                                    <select class="form-select form-select-sm"
                                                        name="noresponse_subremark_120">
                                                        <option value="">Select remark</option>
                                                        <option value="Ringing">Ringing</option>
                                                        <option value="Call Busy">Call Busy</option>
                                                        <option value="Invalid Number">Invalid Number</option>
                                                        <option value="Out of Service">Out of Service</option>
                                                        <option value="Switched Off">Switched Off</option>
                                                        <option value="Drop out">Drop out</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center mt-4">
                                        <button type="submit" id='day120_submit' class="btn btn-primary">Submit Day 120
                                            Follow-up</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="day150" role="tabpanel" aria-labelledby="day150-tab">
                            <div class="form-section">
                                <h2 class="section-title">🗓️ Day 150 Follow-up</h2>
                                <form id="day150form">
                                    <input type="hidden" name="day" value="150">
                                    <input type="hidden" name="patient_id" value="">
                                    <input type="hidden" name="id">
                                    <!-- 1. Medicines -->
                                    <div class="mb-3">
                                        <label class="form-label">1. Are you taking your medicines regularly as advised
                                            by your doctor?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_meds"
                                                id="day150_meds_yes" value="Yes">
                                            <label class="form-check-label" for="day150_meds_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_meds"
                                                id="day150_meds_no" value="No">
                                            <label class="form-check-label" for="day150_meds_no">No</label>
                                        </div>
                                        <span id="day150_meds_reason" style="display:none;">
                                            → Reason: <input type="text" name="day150_meds_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- 2. Medicine Stock -->
                                    <div class="mb-3">
                                        <label class="form-label">2. Do you have enough stock of medicines?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_stock"
                                                id="day150_stock_yes" value="Yes">
                                            <label class="form-check-label" for="day150_stock_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_stock"
                                                id="day150_stock_no" value="No">
                                            <label class="form-check-label" for="day150_stock_no">No</label>
                                        </div>
                                        <span id="day150_meds_stock" style="display:none;">
                                            → Please get a refill or consult your doctor.
                                        </span>
                                    </div>

                                    <!-- 3. Medication Changes -->
                                    <div class="mb-3">
                                        <label class="form-label">3. Has your doctor added or changed any medication
                                            recently?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_changes"
                                                id="day150_changes_yes" value="Yes">
                                            <label class="form-check-label" for="day150_changes_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_changes"
                                                id="day150_changes_no" value="No">
                                            <label class="form-check-label" for="day150_changes_no">No</label>
                                        </div>
                                    </div>

                                    <!-- 4. BP -->
                                    <div class="mb-3">
                                        <label class="form-label">4. Recent BP Reading:</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_bp"
                                                id="day150_bp_yes" value="Yes">
                                            <label class="form-check-label" for="day150_bp_yes">Yes → BP:</label>
                                        </div>
                                        <span id="day150_bp_value" style="display:none;">
                                            <input type="text" name="day150_bp_value"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_bp"
                                                id="day150_bp_no" value="No">
                                            <label class="form-check-label" for="day150_bp_no">No</label>
                                        </div>
                                    </div>

                                    <!-- 5. Weight -->
                                    <div class="mb-3">
                                        <label class="form-label">5. Current weight:</label>
                                        <input type="text" name="day150_weight"
                                            class="form-control form-control-sm d-inline form-text-input"> kg
                                    </div>

                                    <!-- 6. RBS -->
                                    <div class="mb-3">
                                        <label class="form-label">6. Have you checked your blood sugar level (RBS)
                                            recently?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_rbs"
                                                id="day150_rbs_yes" value="Yes">
                                            <label class="form-check-label" for="day150_rbs_yes">Yes</label>
                                        </div>
                                        <span id="day150_rbs_value" style="display:none;">
                                            → <input type="text" name="day150_rbs_value"
                                                class="form-control form-control-sm d-inline form-text-input"> mg/dL
                                        </span>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_rbs"
                                                id="day150_rbs_no" value="No">
                                            <label class="form-check-label" for="day150_rbs_no">No</label>
                                        </div>
                                        <span id="day150_rbs_reason" style="display:none;">
                                            → Reason: <input type="text" name="day150_rbs_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>

                                    <!-- 7. Fluid & Urine -->
                                    <div class="mb-3">
                                        <label class="form-label">7. Can you tell me about your water/fluid intake and
                                            urine output over the past few days?</label>
                                        <br>
                                        <label class="form-label">Fluid Intake:</label><br>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_fluid"
                                                id="day150_fluid_adequate" value="Adequate">
                                            <label class="form-check-label" for="day150_fluid_adequate">Adequate</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_fluid"
                                                id="day150_fluid_increased" value="Increased">
                                            <label class="form-check-label"
                                                for="day150_fluid_increased">Increased</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_fluid"
                                                id="day150_fluid_decreased" value="Decreased">
                                            <label class="form-check-label"
                                                for="day150_fluid_decreased">Decreased</label>
                                        </div>
                                        <br>
                                        <label class="form-label">Urine Output:</label><br>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_urine"
                                                id="day150_urine_normal" value="Normal">
                                            <label class="form-check-label" for="day150_urine_normal">Normal</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_urine"
                                                id="day150_urine_increased" value="Increased">
                                            <label class="form-check-label"
                                                for="day150_urine_increased">Increased</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_urine"
                                                id="day150_urine_reduced" value="Reduced">
                                            <label class="form-check-label" for="day150_urine_reduced">Reduced</label>
                                        </div>
                                    </div>

                                    <!-- 8. Breathing -->
                                    <div class="mb-3">
                                        <label class="form-label">8. How is your breathing (NYHA
                                            Classification)?</label>
                                        <div class="checkbox-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day150_breathless"
                                                    id="day150_breathless_none" value="No breathlessness">
                                                <label class="form-check-label" for="day150_breathless_none">No
                                                    breathlessness</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day150_breathless"
                                                    id="day150_breathless_stairs" value="While climbing stairs">
                                                <label class="form-check-label" for="day150_breathless_stairs">While
                                                    climbing stairs</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day150_breathless"
                                                    id="day150_breathless_sitting" value="While sitting">
                                                <label class="form-check-label" for="day150_breathless_sitting">While
                                                    sitting</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day150_breathless"
                                                    id="day150_breathless_clothes" value="While changing clothes">
                                                <label class="form-check-label" for="day150_breathless_clothes">While
                                                    changing clothes</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="day150_breathless"
                                                    id="day150_breathless_lie" value="Cannot lie down flat">
                                                <label class="form-check-label" for="day150_breathless_lie">Cannot lie
                                                    down flat</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 9. Yoga -->
                                    <div class="mb-3">
                                        <label class="form-label">9. Have you attended any yoga sessions yet?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_yoga"
                                                id="day150_yoga_yes" value="Yes">
                                            <label class="form-check-label" for="day150_yoga_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_yoga"
                                                id="day150_yoga_no" value="No">
                                            <label class="form-check-label" for="day150_yoga_no">No</label>
                                        </div>
                                        <span id="day150_yoga_reason" style="display:none;">
                                            → Reason: <input type="text" name="day150_yoga_reason"
                                                class="form-control form-control-sm d-inline form-text-input">
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">10. AE REPORT?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_ae_report"
                                                id="day150_ae_report_yes" value="Yes">
                                            <label class="form-check-label" for="day150_ae_report_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day150_ae_report"
                                                id="day150_ae_report_no" value="No">
                                            <label class="form-check-label" for="day150_ae_report_no">No</label>
                                        </div>
                                    </div>

                                    <!-- 10. Call Remark -->
                                    <div class="mb-3">
                                        <label class="form-label">Call Remark</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="callremark_150"
                                                id="callremark_call_150" value="Call Connect">
                                            <label class="form-check-label" for="callremark_call_150">Call
                                                Connect</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="callremark_150"
                                                id="callremark_no_150" value="No Response">
                                            <label class="form-check-label" for="callremark_no_150">No Response</label>
                                        </div>
                                        <div id="callremark_subremarks_150" style="display:none;">
                                            <div class="mt-2">
                                                <label class="form-label">Remarks:</label>
                                                <div id="callconnect_subremarks_150" style="display:none;">
                                                    <select class="form-select form-select-sm"
                                                        name="callconnect_subremark_150">
                                                        <option value="">Select remark</option>
                                                        <option value="DND the Patient">DND the
                                                            Patient</option>
                                                        <option value="Journey Completed">Journey Completed</option>
                                                        <option value="Call Rescheduled by the Patient">Call Rescheduled
                                                            by the Patient</option>
                                                        <option value="Wrong Number – DND the Patient">Wrong Number –
                                                            DND the Patient</option>
                                                        <option value="Language Barrier">Language Barrier</option>
                                                        <option value="Call Completed">Call Completed</option>
                                                        <option value="Call Disconnected by the Patient">Call
                                                            Disconnected by the Patient</option>
                                                        <option value="Dropout">Dropout</option>
                                                    </select>
                                                </div>
                                                <div id="noresponse_subremarks_150" style="display:none;">
                                                    <select class="form-select form-select-sm"
                                                        name="noresponse_subremark_150">
                                                        <option value="">Select remark</option>
                                                        <option value="Ringing">Ringing</option>
                                                        <option value="Call Busy">Call Busy</option>
                                                        <option value="Invalid Number">Invalid Number</option>
                                                        <option value="Out of Service">Out of Service</option>
                                                        <option value="Switched Off">Switched Off</option>
                                                        <option value="Drop out">Drop out</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="text-center mt-4">
                                        <button type="submit" id='day150_submit' class="btn btn-primary">Submit Day 150
                                            Follow-up</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="day180" role="tabpanel" aria-labelledby="day180-tab">
                            <div class="form-section">
                                <h2 class="section-title">🗓️ Day 180 Follow-up</h2>
                                <form id="day180form">
                                    <input type="hidden" name="day" value="180">
                                    <input type="hidden" name="patient_id" value="">
                                    <input type="hidden" name="id">
                                    <!-- Q1 -->
                                    <div class="mb-3">
                                        <label class="form-label">1. How are you feeling now compared to 6 months
                                            ago?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="feeling_now"
                                                id="feeling_much_better" value="Much better">
                                            <label class="form-check-label" for="feeling_much_better">Much better – I
                                                feel healthier and more energetic</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="feeling_now"
                                                id="feeling_slightly_better" value="Slightly better">
                                            <label class="form-check-label" for="feeling_slightly_better">Slightly
                                                better – Some improvements, but still facing a few challenges</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="feeling_now"
                                                id="feeling_same" value="About the same">
                                            <label class="form-check-label" for="feeling_same">About the same – No major
                                                changes noticed</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="feeling_now"
                                                id="feeling_not_better" value="Not feeling better">
                                            <label class="form-check-label" for="feeling_not_better">Not feeling better
                                                – I’m still struggling with my health</label>
                                        </div>
                                    </div>

                                    <!-- Q2 -->
                                    <div class="mb-3">
                                        <label class="form-label">2. Have the yoga sessions been helpful in managing
                                            your health condition (HF/HTN/Diabetes)?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="yoga_helpful"
                                                id="yoga_helpful_yes" value="Yes">
                                            <label class="form-check-label" for="yoga_helpful_yes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="yoga_helpful"
                                                id="yoga_helpful_no" value="No">
                                            <label class="form-check-label" for="yoga_helpful_no">No</label>
                                        </div>
                                        <div class="mt-2" id="yoga_feedback_container" style="display:none;">
                                            <label>→ If No, please share your feedback:</label>
                                            <input type="text" name="yoga_feedback"
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>

                                    <!-- Q3 -->
                                    <div class="mb-3">
                                        <label class="form-label">3. Were the yoga and diet instructors supportive and
                                            knowledgeable?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="instructor_support"
                                                id="instructor_yes" value="Yes">
                                            <label class="form-check-label" for="instructor_yes">Yes – They explained
                                                things clearly and were easy to approach</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="instructor_support"
                                                id="instructor_somewhat" value="Somewhat">
                                            <label class="form-check-label" for="instructor_somewhat">Somewhat – They
                                                helped, but I had some unanswered questions</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="instructor_support"
                                                id="instructor_no" value="No">
                                            <label class="form-check-label" for="instructor_no">No – I didn’t find the
                                                sessions helpful</label>
                                        </div>
                                        <div class="mt-2">
                                            <label>→ Feedback:</label>
                                            <input type="text" name="instructor_feedback"
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>

                                    <!-- Q4 -->
                                    <div class="mb-3">
                                        <label class="form-label">4. Have the diet plans contributed to improvements in
                                            your health?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="diet_impact"
                                                id="diet_yes" value="Yes">
                                            <label class="form-check-label" for="diet_yes">Yes – I’ve seen clear health
                                                benefits</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="diet_impact"
                                                id="diet_somewhat" value="Somewhat">
                                            <label class="form-check-label" for="diet_somewhat">Somewhat – Minor
                                                changes, but not significant</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="diet_impact" id="diet_no"
                                                value="No">
                                            <label class="form-check-label" for="diet_no">No – Didn’t see any
                                                impact</label>
                                        </div>
                                        <div class="mt-2">
                                            <label>→ Feedback:</label>
                                            <input type="text" name="diet_feedback"
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>

                                    <!-- Q5 -->
                                    <div class="mb-3">
                                        <label class="form-label">5. Was the dietician/nutritionist accessible for
                                            follow-ups or questions?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="dietician_access"
                                                id="dietician_yes" value="Yes">
                                            <label class="form-check-label" for="dietician_yes">Yes – I was able to
                                                connect whenever I needed support</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="dietician_access"
                                                id="dietician_sometimes" value="Sometimes">
                                            <label class="form-check-label" for="dietician_sometimes">Sometimes – Faced
                                                delays in getting responses</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="dietician_access"
                                                id="dietician_no" value="No">
                                            <label class="form-check-label" for="dietician_no">No – It was difficult to
                                                reach them</label>
                                        </div>
                                        <div class="mt-2">
                                            <label>→ Feedback:</label>
                                            <input type="text" name="dietician_feedback"
                                                class="form-control form-control-sm">
                                        </div>
                                    </div>

                                    <!-- Q6 -->
                                    <div class="mb-3">
                                        <label class="form-label">6. How would you describe your overall experience
                                            during the 6-month program?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="overall_experience"
                                                id="experience_excellent" value="Excellent">
                                            <label class="form-check-label" for="experience_excellent">Excellent – Very
                                                supportive and effective</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="overall_experience"
                                                id="experience_satisfactory" value="Satisfactory">
                                            <label class="form-check-label" for="experience_satisfactory">Satisfactory –
                                                Helpful, but with more improvement</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="overall_experience"
                                                id="experience_needs" value="Needs Improvement">
                                            <label class="form-check-label" for="experience_needs">Needs Improvement – I
                                                expected better results and support</label>
                                        </div>
                                        <div class="mt-2">
                                            <label>Remarks:</label>
                                            <textarea name="experience_remarks" class="form-control"
                                                rows="2"></textarea>
                                        </div>
                                    </div>

                                    <!-- Q7 -->
                                    <div class="mb-3">
                                        <label class="form-label">7. Do you have any final feedback or suggestions for
                                            us?</label>
                                        <textarea name="final_feedback" class="form-control" rows="2"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">8. AE REPORT?</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day180_ae_report"
                                                id="day180_ae_report_yes" value="Yes">
                                            <label class="form-check-label" for="day180_ae_report_yes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="day180_ae_report"
                                                id="day180_ae_report_no" value="No">
                                            <label class="form-check-label" for="day180_ae_report_no">No</label>
                                        </div>
                                    </div>

                                    <!-- Call Remark -->
                                    <div class="mb-3">
                                        <label class="form-label">Call Remark</label>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="callremark_180"
                                                id="callremark_call_180" value="Call Connect">
                                            <label class="form-check-label" for="callremark_call_180">Call
                                                Connect</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox-item">
                                            <input class="form-check-input" type="radio" name="callremark_180"
                                                id="callremark_no_180" value="No Response">
                                            <label class="form-check-label" for="callremark_no_180">No Response</label>
                                        </div>

                                        <div id="callremark_subremarks_180" style="display:none;">
                                            <div class="mt-2">
                                                <label class="form-label">Remarks:</label>
                                                <div id="callconnect_subremarks_180" style="display:none;">
                                                    <select class="form-select form-select-sm"
                                                        name="callconnect_subremark_180">
                                                        <option value="">Select remark</option>
                                                        <option value="DND the Patient">DND the
                                                            Patient</option>
                                                        <option value="Journey Completed">Journey Completed</option>
                                                        <option value="Call Rescheduled by the Patient">Call Rescheduled
                                                            by the Patient</option>
                                                        <option value="Wrong Number – DND the Patient">Wrong Number –
                                                            DND the Patient</option>
                                                        <option value="Language Barrier">Language Barrier</option>
                                                        <option value="Call Completed">Call Completed</option>
                                                        <option value="Call Disconnected by the Patient">Call
                                                            Disconnected by the Patient</option>
                                                        <option value="Dropout">Dropout</option>
                                                    </select>
                                                </div>
                                                <div id="noresponse_subremarks_180" style="display:none;">
                                                    <select class="form-select form-select-sm"
                                                        name="noresponse_subremark_180">
                                                        <option value="">Select remark</option>
                                                        <option value="Ringing">Ringing</option>
                                                        <option value="Call Busy">Call Busy</option>
                                                        <option value="Invalid Number">Invalid Number</option>
                                                        <option value="Out of Service">Out of Service</option>
                                                        <option value="Switched Off">Switched Off</option>
                                                        <option value="Drop out">Drop out</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="text-center mt-4">
                                        <button type="submit" id='day180_submit' class="btn btn-primary">Submit Day 180
                                            Follow-up</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @include('digitaleducator/footer')
        {{--
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script> --}}
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            document.addEventListener('DOMContentLoaded', function () {
                // Function to set up listeners for a specific day
                function setupCallRemarkListeners(day) {
                    const callConnectRadio = document.getElementById(`callremark_call_${day}`);
                    const noResponseRadio = document.getElementById(`callremark_no_${day}`);
                    const subRemarksContainer = document.getElementById(`callremark_subremarks_${day}`);
                    const callConnectDropdown = document.getElementById(`callconnect_subremarks_${day}`);
                    const noResponseDropdown = document.getElementById(`noresponse_subremarks_${day}`);

                    if (callConnectRadio) {
                        callConnectRadio.addEventListener('change', function () {
                            if (this.checked) {
                                subRemarksContainer.style.display = 'block';
                                callConnectDropdown.style.display = 'block';
                                noResponseDropdown.style.display = 'none';
                                // Reset the value of the other dropdown when hiding
                                noResponseDropdown.querySelector('select').value = '';
                            }
                        });
                    }

                    if (noResponseRadio) {
                        noResponseRadio.addEventListener('change', function () {
                            if (this.checked) {
                                subRemarksContainer.style.display = 'block';
                                callConnectDropdown.style.display = 'none';
                                noResponseDropdown.style.display = 'block';
                                // Reset the value of the other dropdown when hiding
                                callConnectDropdown.querySelector('select').value = '';
                            } else {

                            }
                        });
                    }

                    // Initial state check in case of pre-selected values (e.g., from editing)
                    if (callConnectRadio && callConnectRadio.checked) {
                        subRemarksContainer.style.display = 'block';
                        callConnectDropdown.style.display = 'block';
                        noResponseDropdown.style.display = 'none';
                    } else if (noResponseRadio && noResponseRadio.checked) {
                        subRemarksContainer.style.display = 'block';
                        callConnectDropdown.style.display = 'none';
                        noResponseDropdown.style.display = 'block';
                    } else {
                        subRemarksContainer.style.display = 'none';
                        callConnectDropdown.style.display = 'none';
                        noResponseDropdown.style.display = 'none';
                    }
                }

                // Call the setup function for each day that has call remark fields
                setupCallRemarkListeners(3);
                setupCallRemarkListeners(7);
                setupCallRemarkListeners(15);
                setupCallRemarkListeners(30);
                setupCallRemarkListeners(45);
                setupCallRemarkListeners(60);
                setupCallRemarkListeners(90);
                setupCallRemarkListeners(120);
                setupCallRemarkListeners(150);
                setupCallRemarkListeners(180);

                // --- Other existing JavaScript for Day 3 and Day 7 questions ---

                // Day 3 Medication Adherence
                const day3MedsYes = document.getElementById('day3_meds_yes');
                const day3MedsNo = document.getElementById('day3_meds_no');
                const day3MedsReason = document.getElementById('day3_meds_reason');

                if (day3MedsNo) {
                    day3MedsNo.addEventListener('change', function () {
                        if (this.checked) {
                            day3MedsReason.style.display = 'inline';
                        }
                    });
                }
                if (day3MedsYes) {
                    day3MedsYes.addEventListener('change', function () {
                        if (this.checked) {
                            day3MedsReason.style.display = 'none';
                            day3MedsReason.querySelector('input').value = ''; // Clear reason when 'Yes' is selected
                        }
                    });
                }
                // Initial check for day3_meds
                if (day3MedsNo && day3MedsNo.checked) {
                    day3MedsReason.style.display = 'inline';
                } else if (day3MedsYes && day3MedsYes.checked) {
                    day3MedsReason.style.display = 'none';
                }

                // Day 3 Sugar Monitoring
                const day3SugarYes = document.getElementById('day3_sugar_yes');
                const day3SugarNo = document.getElementById('day3_sugar_no');
                const day3SugarReason = document.getElementById('day3_sugar_reason');

                if (day3SugarNo) {
                    day3SugarNo.addEventListener('change', function () {
                        if (this.checked) {
                            day3SugarReason.style.display = 'inline';
                        }
                    });
                }
                if (day3SugarYes) {
                    day3SugarYes.addEventListener('change', function () {
                        if (this.checked) {
                            day3SugarReason.style.display = 'none';
                            day3SugarReason.querySelector('input').value = '';
                        }
                    });
                }
                // Initial check for day3_sugar
                if (day3SugarNo && day3SugarNo.checked) {
                    day3SugarReason.style.display = 'inline';
                } else if (day3SugarYes && day3SugarYes.checked) {
                    day3SugarReason.style.display = 'none';
                }

                // Day 3 BP Monitoring
                const day3BpYes = document.getElementById('day3_bp_yes');
                const day3BpNo = document.getElementById('day3_bp_no');
                const day3BpReason = document.getElementById('day3_bp_reason');

                if (day3BpNo) {
                    day3BpNo.addEventListener('change', function () {
                        if (this.checked) {
                            day3BpReason.style.display = 'inline';
                        }
                    });
                }
                if (day3BpYes) {
                    day3BpYes.addEventListener('change', function () {
                        if (this.checked) {
                            day3BpReason.style.display = 'none';
                            day3BpReason.querySelector('input').value = '';
                        }
                    });
                }
                // Initial check for day3_bp
                if (day3BpNo && day3BpNo.checked) {
                    day3BpReason.style.display = 'inline';
                } else if (day3BpYes && day3BpYes.checked) {
                    day3BpReason.style.display = 'none';
                }

                // Day 3 Fluid Monitoring
                const day3FluidYes = document.getElementById('day3_fluid_yes');
                const day3FluidNo = document.getElementById('day3_fluid_no');
                const day3FluidReason = document.getElementById('day3_fluid_reason');

                if (day3FluidNo) {
                    day3FluidNo.addEventListener('change', function () {
                        if (this.checked) {
                            day3FluidReason.style.display = 'inline';
                        }
                    });
                }
                if (day3FluidYes) {
                    day3FluidYes.addEventListener('change', function () {
                        if (this.checked) {
                            day3FluidReason.style.display = 'none';
                            day3FluidReason.querySelector('input').value = '';
                        }
                    });
                }
                // Initial check for day3_fluid
                if (day3FluidNo && day3FluidNo.checked) {
                    day3FluidReason.style.display = 'inline';
                } else if (day3FluidYes && day3FluidYes.checked) {
                    day3FluidReason.style.display = 'none';
                }


                // Day 7 Doctor Visit
                const day7DoctorYes = document.getElementById('day7_doctor_yes');
                const day7DoctorNo = document.getElementById('day7_doctor_no');
                const day7DoctorReason = document.getElementById('day7_doctor_reason');

                if (day7DoctorNo) {
                    day7DoctorNo.addEventListener('change', function () {
                        if (this.checked) {
                            day7DoctorReason.style.display = 'inline';
                        }
                    });
                }
                if (day7DoctorYes) {
                    day7DoctorYes.addEventListener('change', function () {
                        if (this.checked) {
                            day7DoctorReason.style.display = 'none';
                            day7DoctorReason.querySelector('input').value = '';
                        }
                    });
                }
                // Initial check for day7_doctor
                if (day7DoctorNo && day7DoctorNo.checked) {
                    day7DoctorReason.style.display = 'inline';
                } else if (day7DoctorYes && day7DoctorYes.checked) {
                    day7DoctorReason.style.display = 'none';
                }

                // Day 7 Medication Adherence
                const day7MedsYes = document.getElementById('day7_meds_yes');
                const day7MedsNo = document.getElementById('day7_meds_no');
                const day7MedsReason = document.getElementById('day7_meds_reason');

                if (day7MedsNo) {
                    day7MedsNo.addEventListener('change', function () {
                        if (this.checked) {
                            day7MedsReason.style.display = 'inline';
                        }
                    });
                }
                if (day7MedsYes) {
                    day7MedsYes.addEventListener('change', function () {
                        if (this.checked) {
                            day7MedsReason.style.display = 'none';
                            day7MedsReason.querySelector('input').value = '';
                        }
                    });
                }
                // Initial check for day7_meds
                if (day7MedsNo && day7MedsNo.checked) {
                    day7MedsReason.style.display = 'inline';
                } else if (day7MedsYes && day7MedsYes.checked) {
                    day7MedsReason.style.display = 'none';
                }


                // Day 7 BP Reading
                const day7BpValYes = document.getElementById('day7_bp_yes');
                const day7BpValNo = document.getElementById('day7_bp_no');
                const day7BpValue = document.getElementById('day7_bp_value');
                const day7BpRemarks = document.getElementById('day7_bp_remarks');

                if (day7BpValYes) {
                    day7BpValYes.addEventListener('change', function () {
                        if (this.checked) {
                            day7BpValue.style.display = 'inline';
                            day7BpRemarks.style.display = 'none';
                            day7BpRemarks.querySelector('input').value = '';
                        }
                    });
                }
                if (day7BpValNo) {
                    day7BpValNo.addEventListener('change', function () {
                        if (this.checked) {
                            day7BpValue.style.display = 'none';
                            day7BpValue.querySelector('input').value = '';
                            day7BpRemarks.style.display = 'inline';
                        }
                    });
                }
                // Initial check for day7_bp
                if (day7BpValYes && day7BpValYes.checked) {
                    day7BpValue.style.display = 'inline';
                    day7BpRemarks.style.display = 'none';
                } else if (day7BpValNo && day7BpValNo.checked) {
                    day7BpValue.style.display = 'none';
                    day7BpRemarks.style.display = 'inline';
                }


                // Day 7 Yoga Schedule
                const day7YogaScheduleYes = document.getElementById('day7_yoga_schedule_yes');
                const day7YogaScheduleNo = document.getElementById('day7_yoga_schedule_no');
                const day7YogaScheduleReason = document.getElementById('day7_yoga_schedule_reason');

                if (day7YogaScheduleNo) {
                    day7YogaScheduleNo.addEventListener('change', function () {
                        if (this.checked) {
                            day7YogaScheduleReason.style.display = 'inline';
                        }
                    });
                }
                if (day7YogaScheduleYes) {
                    day7YogaScheduleYes.addEventListener('change', function () {
                        if (this.checked) {
                            day7YogaScheduleReason.style.display = 'none';
                            day7YogaScheduleReason.querySelector('input').value = '';
                        }
                    });
                }
                // Initial check for day7_yoga_schedule
                if (day7YogaScheduleNo && day7YogaScheduleNo.checked) {
                    day7YogaScheduleReason.style.display = 'inline';
                } else if (day7YogaScheduleYes && day7YogaScheduleYes.checked) {
                    day7YogaScheduleReason.style.display = 'none';
                }

                // Day 7 Yoga Tried & Difficulties
                const day7YogaTriedYes = document.getElementById('day7_yoga_tried_yes');
                const day7YogaTriedNo = document.getElementById('day7_yoga_tried_no');
                const day7YogaTriedDifficult = document.getElementById('day7_yoga_tried_difficult');
                const day7YogaDifficultYes = document.getElementById('day7_yoga_difficult_yes');
                const day7YogaDifficultReason = document.getElementById('day7_yoga_difficult_reason');


                if (day7YogaTriedYes) {
                    day7YogaTriedYes.addEventListener('change', function () {
                        if (this.checked) {
                            day7YogaTriedDifficult.style.display = 'inline';
                        }
                    });
                }
                if (day7YogaTriedNo) {
                    day7YogaTriedNo.addEventListener('change', function () {
                        if (this.checked) {
                            day7YogaTriedDifficult.style.display = 'none';
                            day7YogaDifficultYes.checked = false; // Uncheck difficulties
                            day7YogaDifficultReason.style.display = 'none';
                            day7YogaDifficultReason.querySelector('input').value = '';
                        }
                    });
                }
                if (day7YogaDifficultYes) {
                    day7YogaDifficultYes.addEventListener('change', function () {
                        if (this.checked) {
                            day7YogaDifficultReason.style.display = 'inline';
                        } else {
                            day7YogaDifficultReason.style.display = 'none';
                            day7YogaDifficultReason.querySelector('input').value = '';
                        }
                    });
                }

                // Initial check for day7_yoga_tried
                if (day7YogaTriedYes && day7YogaTriedYes.checked) {
                    day7YogaTriedDifficult.style.display = 'inline';
                    if (day7YogaDifficultYes && day7YogaDifficultYes.checked) {
                        day7YogaDifficultReason.style.display = 'inline';
                    }
                } else if (day7YogaTriedNo && day7YogaTriedNo.checked) {
                    day7YogaTriedDifficult.style.display = 'none';
                }
                const yesRadio = document.getElementById("day7_yoga_required_yes");
                const noRadio = document.getElementById("day7_yoga_required_no");
                const plannedDateSpan = document.getElementById("day7_yoga_planned_date");
                const reasonSpan = document.getElementById("day7_yoga_required_reason");

                function toggleYogaFields() {
                    if (yesRadio.checked) {
                        plannedDateSpan.style.display = "inline";
                        reasonSpan.style.display = "none";
                    } else if (noRadio.checked) {
                        plannedDateSpan.style.display = "none";
                        reasonSpan.style.display = "inline";
                    } else {
                        plannedDateSpan.style.display = "none";
                        reasonSpan.style.display = "none";
                    }
                }

                // Initialize on page load
                toggleYogaFields();

                // Attach event listeners
                yesRadio.addEventListener("change", toggleYogaFields);
                noRadio.addEventListener("change", toggleYogaFields);
                // 1. Medicines taken - show reason if No
                const medsYes = document.getElementById("day15_meds_yes");
                const medsNo = document.getElementById("day15_meds_no");
                const medsReason = document.getElementById("day15_meds_reason");

                medsYes.addEventListener("change", () => medsReason.style.display = "none");
                medsNo.addEventListener("change", () => medsReason.style.display = "inline");

                const stockYes = document.getElementById("day15_stock_yes");
                const stockNo = document.getElementById("day15_stock_no");
                const stockMeds = document.getElementById("day15_meds_stock");

                stockYes.addEventListener("change", () => {
                    if (stockYes.checked) {
                        stockMeds.style.display = "none";
                    }
                });

                stockNo.addEventListener("change", () => {
                    if (stockNo.checked) {
                        stockMeds.style.display = "inline";
                    }
                });


                // 2. BP Reading - show BP input only if Yes is selected
                const bpYes = document.getElementById("day15_bp_yes");
                const bpNo = document.getElementById("day15_bp_no");
                const bpValue = document.getElementById("day15_bp_value");

                bpYes.addEventListener("change", () => bpValue.style.display = "inline");
                bpNo.addEventListener("change", () => bpValue.style.display = "none");

                // 3. RBS - show value if Yes, reason if No
                const rbsYes = document.getElementById("day15_rbs_yes");
                const rbsNo = document.getElementById("day15_rbs_no");
                const rbsValue = document.getElementById("day15_rbs_value");
                const rbsReason = document.getElementById("day15_rbs_reason");

                rbsYes.addEventListener("change", () => {
                    rbsValue.style.display = "inline";
                    rbsReason.style.display = "none";
                });

                rbsNo.addEventListener("change", () => {
                    rbsValue.style.display = "none";
                    rbsReason.style.display = "inline";
                });

                // 4. Yoga attended - show reason if No
                const yogaYes = document.getElementById("day15_yoga_yes");
                const yogaNo = document.getElementById("day15_yoga_no");
                const yogaReason = document.getElementById("day15_yoga_reason");

                yogaYes.addEventListener("change", () => yogaReason.style.display = "none");
                yogaNo.addEventListener("change", () => yogaReason.style.display = "inline");

                // 5. Call Remark - handle sub-options visibility
                const callConnect = document.getElementById("callremark_call_15");
                const noResponse = document.getElementById("callremark_no_15");
                const callRemarkContainer = document.getElementById("callremark_subremarks_15");
                const callConnectSub = document.getElementById("callconnect_subremarks_15");
                const noResponseSub = document.getElementById("noresponse_subremarks_15");

                callConnect.addEventListener("change", () => {
                    callRemarkContainer.style.display = "block";
                    callConnectSub.style.display = "block";
                    noResponseSub.style.display = "none";
                });

                noResponse.addEventListener("change", () => {
                    callRemarkContainer.style.display = "block";
                    callConnectSub.style.display = "none";
                    noResponseSub.style.display = "block";
                });
                // 1. Medicines taken - show reason if No
                const medsYes1 = document.getElementById("day30_meds_yes");
                const medsNo1 = document.getElementById("day30_meds_no");
                const medsReason1 = document.getElementById("day30_meds_reason");

                medsYes1.addEventListener("change", () => medsReason1.style.display = "none");
                medsNo1.addEventListener("change", () => medsReason1.style.display = "inline");

                const stockYes1 = document.getElementById("day30_stock_yes");
                const stockNo1 = document.getElementById("day30_stock_no");
                const stockMeds1 = document.getElementById("day30_meds_stock");

                stockYes1.addEventListener("change", () => {
                    if (stockYes1.checked) {
                        stockMeds1.style.display = "none";
                    }
                });

                stockNo1.addEventListener("change", () => {
                    if (stockNo1.checked) {
                        stockMeds1.style.display = "inline";
                    }
                });


                // 2. BP Reading - show BP input only if Yes is selected
                const bpYes1 = document.getElementById("day30_bp_yes");
                const bpNo1 = document.getElementById("day30_bp_no");
                const bpValue1 = document.getElementById("day30_bp_value");

                bpYes1.addEventListener("change", () => bpValue1.style.display = "inline");
                bpNo1.addEventListener("change", () => bpValue1.style.display = "none");

                // 3. RBS - show value if Yes, reason if No
                const rbsYes1 = document.getElementById("day30_rbs_yes");
                const rbsNo1 = document.getElementById("day30_rbs_no");
                const rbsValue1 = document.getElementById("day30_rbs_value");
                const rbsReason1 = document.getElementById("day30_rbs_reason");

                rbsYes1.addEventListener("change", () => {
                    rbsValue1.style.display = "inline";
                    rbsReason1.style.display = "none";
                });

                rbsNo1.addEventListener("change", () => {
                    rbsValue1.style.display = "none";
                    rbsReason1.style.display = "inline";
                });

                // 4. Yoga attended - show reason if No
                const yogaYes1 = document.getElementById("day30_yoga_yes");
                const yogaNo1 = document.getElementById("day30_yoga_no");
                const yogaReason1 = document.getElementById("day30_yoga_reason");

                yogaYes1.addEventListener("change", () => yogaReason1.style.display = "none");
                yogaNo1.addEventListener("change", () => yogaReason.style.display = "inline");

                // 5. Call Remark - handle sub-options visibility
                const callConnect1 = document.getElementById("callremark_call_30");
                const noResponse1 = document.getElementById("callremark_no_30");
                const callRemarkContainer1 = document.getElementById("callremark_subremarks_30");
                const callConnectSub1 = document.getElementById("callconnect_subremarks_30");
                const noResponseSub1 = document.getElementById("noresponse_subremarks_30");

                callConnect1.addEventListener("change", () => {
                    callRemarkContainer1.style.display = "block";
                    callConnectSub1.style.display = "block";
                    noResponseSub1.style.display = "none";
                });

                noResponse1.addEventListener("change", () => {
                    callRemarkContainer1.style.display = "block";
                    callConnectSub1.style.display = "none";
                    noResponseSub1.style.display = "block";
                });
                // day45

                // Day 45 Doctor Visit
                const day45DoctorYes = document.getElementById('day45_doctor_yes');
                const day45DoctorNo = document.getElementById('day45_doctor_no');
                const day45DoctorReason = document.getElementById('day45_doctor_reason');

                if (day45DoctorNo) {
                    day45DoctorNo.addEventListener('change', function () {
                        if (this.checked) {
                            day45DoctorReason.style.display = 'inline';
                        }
                    });
                }
                if (day45DoctorYes) {
                    day45DoctorYes.addEventListener('change', function () {
                        if (this.checked) {
                            day45DoctorReason.style.display = 'none';
                            day45DoctorReason.querySelector('input').value = '';
                        }
                    });
                }
                // Initial check for day45_doctor
                if (day45DoctorNo && day45DoctorNo.checked) {
                    day45DoctorReason.style.display = 'inline';
                } else if (day45DoctorYes && day45DoctorYes.checked) {
                    day45DoctorReason.style.display = 'none';
                }

                // Day 45 Medication Adherence
                const day45MedsYes = document.getElementById('day45_meds_yes');
                const day45MedsNo = document.getElementById('day45_meds_no');
                const day45MedsReason = document.getElementById('day45_meds_reason');

                if (day45MedsNo) {
                    day45MedsNo.addEventListener('change', function () {
                        if (this.checked) {
                            day45MedsReason.style.display = 'inline';
                        }
                    });
                }
                if (day45MedsYes) {
                    day45MedsYes.addEventListener('change', function () {
                        if (this.checked) {
                            day45MedsReason.style.display = 'none';
                            day45MedsReason.querySelector('input').value = '';
                        }
                    });
                }
                // Initial check for day45_meds
                if (day45MedsNo && day45MedsNo.checked) {
                    day45MedsReason.style.display = 'inline';
                } else if (day45MedsYes && day45MedsYes.checked) {
                    day45MedsReason.style.display = 'none';
                }


                // Day 45 BP Reading
                const day45BpValYes = document.getElementById('day45_bp_yes');
                const day45BpValNo = document.getElementById('day45_bp_no');
                const day45BpValue = document.getElementById('day45_bp_value');
                const day45BpRemarks = document.getElementById('day45_bp_remarks');

                if (day45BpValYes) {
                    day45BpValYes.addEventListener('change', function () {
                        if (this.checked) {
                            day45BpValue.style.display = 'inline';
                            day45BpRemarks.style.display = 'none';
                            day45BpRemarks.querySelector('input').value = '';
                        }
                    });
                }
                if (day45BpValNo) {
                    day45BpValNo.addEventListener('change', function () {
                        if (this.checked) {
                            day45BpValue.style.display = 'none';
                            day45BpValue.querySelector('input').value = '';
                            day45BpRemarks.style.display = 'inline';
                        }
                    });
                }
                // Initial check for day45_bp
                if (day45BpValYes && day45BpValYes.checked) {
                    day45BpValue.style.display = 'inline';
                    day45BpRemarks.style.display = 'none';
                } else if (day45BpValNo && day45BpValNo.checked) {
                    day45BpValue.style.display = 'none';
                    day45BpRemarks.style.display = 'inline';
                }


                // Day 45 Yoga Schedule
                const day45YogaScheduleYes = document.getElementById('day45_yoga_schedule_yes');
                const day45YogaScheduleNo = document.getElementById('day45_yoga_schedule_no');
                const day45YogaScheduleReason = document.getElementById('day45_yoga_schedule_reason');

                if (day45YogaScheduleNo) {
                    day45YogaScheduleNo.addEventListener('change', function () {
                        if (this.checked) {
                            day45YogaScheduleReason.style.display = 'inline';
                        }
                    });
                }
                if (day45YogaScheduleYes) {
                    day45YogaScheduleYes.addEventListener('change', function () {
                        if (this.checked) {
                            day45YogaScheduleReason.style.display = 'none';
                            day45YogaScheduleReason.querySelector('input').value = '';
                        }
                    });
                }
                // Initial check for day45_yoga_schedule
                if (day45YogaScheduleNo && day45YogaScheduleNo.checked) {
                    day45YogaScheduleReason.style.display = 'inline';
                } else if (day45YogaScheduleYes && day45YogaScheduleYes.checked) {
                    day45YogaScheduleReason.style.display = 'none';
                }

                // Day 45 Yoga Tried & Difficulties
                const day45YogaTriedYes = document.getElementById('day45_yoga_tried_yes');
                const day45YogaTriedNo = document.getElementById('day45_yoga_tried_no');
                const day45YogaTriedDifficult = document.getElementById('day45_yoga_tried_difficult');
                const day45YogaDifficultYes = document.getElementById('day45_yoga_difficult_yes');
                const day45YogaDifficultReason = document.getElementById('day45_yoga_difficult_reason');


                if (day45YogaTriedYes) {
                    day45YogaTriedYes.addEventListener('change', function () {
                        if (this.checked) {
                            day45YogaTriedDifficult.style.display = 'inline';
                        }
                    });
                }
                if (day45YogaTriedNo) {
                    day45YogaTriedNo.addEventListener('change', function () {
                        if (this.checked) {
                            day45YogaTriedDifficult.style.display = 'none';
                            day45YogaDifficultYes.checked = false; // Uncheck difficulties
                            day45YogaDifficultReason.style.display = 'none';
                            day45YogaDifficultReason.querySelector('input').value = '';
                        }
                    });
                }
                if (day45YogaDifficultYes) {
                    day45YogaDifficultYes.addEventListener('change', function () {
                        if (this.checked) {
                            day45YogaDifficultReason.style.display = 'inline';
                        } else {
                            day45YogaDifficultReason.style.display = 'none';
                            day45YogaDifficultReason.querySelector('input').value = '';
                        }
                    });
                }

                // Initial check for day45_yoga_tried
                if (day45YogaTriedYes && day45YogaTriedYes.checked) {
                    day45YogaTriedDifficult.style.display = 'inline';
                    if (day45YogaDifficultYes && day45YogaDifficultYes.checked) {
                        day45YogaDifficultReason.style.display = 'inline';
                    }
                } else if (day45YogaTriedNo && day45YogaTriedNo.checked) {
                    day45YogaTriedDifficult.style.display = 'none';
                }
                const yesRadio45 = document.getElementById("day45_yoga_required_yes");
                const noRadio45 = document.getElementById("day45_yoga_required_no");
                const plannedDateSpan45 = document.getElementById("day45_yoga_planned_date");
                const reasonSpan45 = document.getElementById("day45_yoga_required_reason");

                function toggleYogaFields45() {
                    if (yesRadio45.checked) {
                        plannedDateSpan45.style.display = "inline";
                        reasonSpan45.style.display = "none";
                    } else if (noRadio45.checked) {
                        plannedDateSpan45.style.display = "none";
                        reasonSpan45.style.display = "inline";
                    } else {
                        plannedDateSpan45.style.display = "none";
                        reasonSpan45.style.display = "none";
                    }
                }

                // Initialize on page load
                toggleYogaFields45();

                // Attach event listeners
                yesRadio45.addEventListener("change", toggleYogaFields45);
                noRadio45.addEventListener("change", toggleYogaFields45);

                const day60_meds_yes = document.getElementById('day60_meds_yes');
                const day60_meds_no = document.getElementById('day60_meds_no');
                const day60_meds_reason = document.getElementById('day60_meds_reason');

                function toggleYogaFields60() {
                    if (day60_meds_no.checked) {
                        day60_meds_reason.style.display = "inline";
                    } else {
                        day60_meds_reason.style.display = "none";
                    }
                }

                // Initialize on page load
                toggleYogaFields60();

                // Attach event listeners
                day60_meds_yes.addEventListener("change", toggleYogaFields60);
                day60_meds_no.addEventListener("change", toggleYogaFields60);

                const day60_bp_yes = document.getElementById('day60_bp_yes');
                const day60_bp_no = document.getElementById('day60_bp_no');
                const day60_bp_value = document.getElementById('day60_bp_value');

                function toggleBPField60() {
                    if (day60_bp_yes.checked) {
                        day60_bp_value.style.display = "inline";
                    } else {
                        day60_bp_value.style.display = "none";
                    }
                }

                // Initialize on page load
                window.addEventListener('DOMContentLoaded', toggleBPField60);

                // Attach event listeners
                day60_bp_yes.addEventListener("change", toggleBPField60);
                day60_bp_no.addEventListener("change", toggleBPField60);
            });

            const day60_rbs_yes = document.getElementById('day60_rbs_yes');
            const day60_rbs_no = document.getElementById('day60_rbs_no');
            const day60_rbs_value = document.getElementById('day60_rbs_value');

            function toggleRBSField60() {
                if (day60_rbs_yes.checked) {
                    day60_rbs_value.style.display = "inline";
                } else {
                    day60_rbs_value.style.display = "none";
                }
            }

            // Initialize on page load
            window.addEventListener('DOMContentLoaded', toggleRBSField60);

            // Attach event listeners
            day60_rbs_yes.addEventListener("change", toggleRBSField60);
            day60_rbs_no.addEventListener("change", toggleRBSField60);

            const day60_hba1c_yes = document.getElementById('day60_hba1c_yes');
            const day60_hba1c_no = document.getElementById('day60_hba1c_no');
            const day60_hba1c_value = document.getElementById('day60_hba1c_value');
            const day60_hba1c_last = document.getElementById('day60_hba1c_last');

            function toggleHbA1cFields60() {
                if (day60_hba1c_yes.checked) {
                    day60_hba1c_value.style.display = "inline";
                    day60_hba1c_last.style.display = "none";
                } else if (day60_hba1c_no.checked) {
                    day60_hba1c_value.style.display = "none";
                    day60_hba1c_last.style.display = "inline";
                } else {
                    day60_hba1c_value.style.display = "none";
                    day60_hba1c_last.style.display = "none";
                }
            }

            // Initialize on page load
            window.addEventListener('DOMContentLoaded', toggleHbA1cFields60);

            // Attach event listeners
            day60_hba1c_yes.addEventListener("change", toggleHbA1cFields60);
            day60_hba1c_no.addEventListener("change", toggleHbA1cFields60);

            const day60_challenges_yes = document.getElementById('day60_challenges_yes');
            const day60_challenges_no = document.getElementById('day60_challenges_no');
            const day60_challenges_reason = document.getElementById('day60_challenges_reason');

            function toggleDietChallengeField60() {
                if (day60_challenges_yes.checked) {
                    day60_challenges_reason.style.display = "inline";
                } else {
                    day60_challenges_reason.style.display = "none";
                }
            }

            // Initialize on page load
            window.addEventListener('DOMContentLoaded', toggleDietChallengeField60);

            // Attach event listeners
            day60_challenges_yes.addEventListener("change", toggleDietChallengeField60);
            day60_challenges_no.addEventListener("change", toggleDietChallengeField60);

            const day60_monitor_yes = document.getElementById('day60_monitor_yes');
            const day60_monitor_no = document.getElementById('day60_monitor_no');
            const day60_monitor_reason = document.getElementById('day60_monitor_reason');

            function toggleFluidMonitorField60() {
                if (day60_monitor_no.checked) {
                    day60_monitor_reason.style.display = "inline";
                } else {
                    day60_monitor_reason.style.display = "none";
                }
            }

            // Initialize on page load
            window.addEventListener('DOMContentLoaded', toggleFluidMonitorField60);

            // Attach event listeners
            day60_monitor_yes.addEventListener("change", toggleFluidMonitorField60);
            day60_monitor_no.addEventListener("change", toggleFluidMonitorField60);

            const day60_doctor_yes = document.getElementById('day60_doctor_yes');
            const day60_doctor_no = document.getElementById('day60_doctor_no');
            const day60_doctor_reason = document.getElementById('day60_doctor_reason');

            function toggleDoctorFollowupField60() {
                if (day60_doctor_no.checked) {
                    day60_doctor_reason.style.display = "inline";
                } else {
                    day60_doctor_reason.style.display = "none";
                }
            }

            // Initialize on page load
            window.addEventListener('DOMContentLoaded', toggleDoctorFollowupField60);

            // Attach event listeners
            day60_doctor_yes.addEventListener("change", toggleDoctorFollowupField60);
            day60_doctor_no.addEventListener("change", toggleDoctorFollowupField60);

            const day90DoctorYes = document.getElementById('day90_doctor_yes');
            const day90DoctorNo = document.getElementById('day90_doctor_no');
            const day90DoctorReason = document.getElementById('day90_doctor_reason');

            if (day90DoctorNo) {
                day90DoctorNo.addEventListener('change', function () {
                    if (this.checked) {
                        day90DoctorReason.style.display = 'inline';
                    }
                });
            }
            if (day90DoctorYes) {
                day90DoctorYes.addEventListener('change', function () {
                    if (this.checked) {
                        day90DoctorReason.style.display = 'none';
                        day90DoctorReason.querySelector('input').value = '';
                    }
                });
            }
            // Initial check for day90_doctor
            if (day90DoctorNo && day90DoctorNo.checked) {
                day90DoctorReason.style.display = 'inline';
            } else if (day90DoctorYes && day90DoctorYes.checked) {
                day90DoctorReason.style.display = 'none';
            }

            // Day 90 Medication Adherence
            const day90MedsYes = document.getElementById('day90_meds_yes');
            const day90MedsNo = document.getElementById('day90_meds_no');
            const day90MedsReason = document.getElementById('day90_meds_reason');

            if (day90MedsNo) {
                day90MedsNo.addEventListener('change', function () {
                    if (this.checked) {
                        day90MedsReason.style.display = 'inline';
                    }
                });
            }
            if (day90MedsYes) {
                day90MedsYes.addEventListener('change', function () {
                    if (this.checked) {
                        day90MedsReason.style.display = 'none';
                        day90MedsReason.querySelector('input').value = '';
                    }
                });
            }
            // Initial check for day90_meds
            if (day90MedsNo && day90MedsNo.checked) {
                day90MedsReason.style.display = 'inline';
            } else if (day90MedsYes && day90MedsYes.checked) {
                day90MedsReason.style.display = 'none';
            }


            // Day 90 BP Reading
            const day90BpValYes = document.getElementById('day90_bp_yes');
            const day90BpValNo = document.getElementById('day90_bp_no');
            const day90BpValue = document.getElementById('day90_bp_value');
            const day90BpRemarks = document.getElementById('day90_bp_remarks');

            if (day90BpValYes) {
                day90BpValYes.addEventListener('change', function () {
                    if (this.checked) {
                        day90BpValue.style.display = 'inline';
                        day90BpRemarks.style.display = 'none';
                        day90BpRemarks.querySelector('input').value = '';
                    }
                });
            }
            if (day90BpValNo) {
                day90BpValNo.addEventListener('change', function () {
                    if (this.checked) {
                        day90BpValue.style.display = 'none';
                        day90BpValue.querySelector('input').value = '';
                        day90BpRemarks.style.display = 'inline';
                    }
                });
            }
            // Initial check for day90_bp
            if (day90BpValYes && day90BpValYes.checked) {
                day90BpValue.style.display = 'inline';
                day90BpRemarks.style.display = 'none';
            } else if (day90BpValNo && day90BpValNo.checked) {
                day90BpValue.style.display = 'none';
                day90BpRemarks.style.display = 'inline';
            }


            // Day 90 Yoga Schedule
            const day90YogaScheduleYes = document.getElementById('day90_yoga_schedule_yes');
            const day90YogaScheduleNo = document.getElementById('day90_yoga_schedule_no');
            const day90YogaScheduleReason = document.getElementById('day90_yoga_schedule_reason');

            if (day90YogaScheduleNo) {
                day90YogaScheduleNo.addEventListener('change', function () {
                    if (this.checked) {
                        day90YogaScheduleReason.style.display = 'inline';
                    }
                });
            }
            if (day90YogaScheduleYes) {
                day90YogaScheduleYes.addEventListener('change', function () {
                    if (this.checked) {
                        day90YogaScheduleReason.style.display = 'none';
                        day90YogaScheduleReason.querySelector('input').value = '';
                    }
                });
            }
            // Initial check for day90_yoga_schedule
            if (day90YogaScheduleNo && day90YogaScheduleNo.checked) {
                day90YogaScheduleReason.style.display = 'inline';
            } else if (day90YogaScheduleYes && day90YogaScheduleYes.checked) {
                day90YogaScheduleReason.style.display = 'none';
            }

            // Day 90 Yoga Tried & Difficulties
            const day90YogaTriedYes = document.getElementById('day90_yoga_tried_yes');
            const day90YogaTriedNo = document.getElementById('day90_yoga_tried_no');
            const day90YogaTriedDifficult = document.getElementById('day90_yoga_tried_difficult');
            const day90YogaDifficultYes = document.getElementById('day90_yoga_difficult_yes');
            const day90YogaDifficultReason = document.getElementById('day90_yoga_difficult_reason');


            if (day90YogaTriedYes) {
                day90YogaTriedYes.addEventListener('change', function () {
                    if (this.checked) {
                        day90YogaTriedDifficult.style.display = 'inline';
                    }
                });
            }
            if (day90YogaTriedNo) {
                day90YogaTriedNo.addEventListener('change', function () {
                    if (this.checked) {
                        day90YogaTriedDifficult.style.display = 'none';
                        day90YogaDifficultYes.checked = false; // Uncheck difficulties
                        day90YogaDifficultReason.style.display = 'none';
                        day90YogaDifficultReason.querySelector('input').value = '';
                    }
                });
            }
            if (day90YogaDifficultYes) {
                day90YogaDifficultYes.addEventListener('change', function () {
                    if (this.checked) {
                        day90YogaDifficultReason.style.display = 'inline';
                    } else {
                        day90YogaDifficultReason.style.display = 'none';
                        day90YogaDifficultReason.querySelector('input').value = '';
                    }
                });
            }

            // Initial check for day90_yoga_tried
            if (day90YogaTriedYes && day90YogaTriedYes.checked) {
                day90YogaTriedDifficult.style.display = 'inline';
                if (day90YogaDifficultYes && day90YogaDifficultYes.checked) {
                    day90YogaDifficultReason.style.display = 'inline';
                }
            } else if (day90YogaTriedNo && day90YogaTriedNo.checked) {
                day90YogaTriedDifficult.style.display = 'none';
            }
            const yesRadio90 = document.getElementById("day90_yoga_required_yes");
            const noRadio90 = document.getElementById("day90_yoga_required_no");
            const plannedDateSpan90 = document.getElementById("day90_yoga_planned_date");
            const reasonSpan90 = document.getElementById("day90_yoga_required_reason");

            function toggleYogaFields90() {
                if (yesRadio90.checked) {
                    plannedDateSpan90.style.display = "inline";
                    reasonSpan90.style.display = "none";
                } else if (noRadio90.checked) {
                    plannedDateSpan90.style.display = "none";
                    reasonSpan90.style.display = "inline";
                } else {
                    plannedDateSpan90.style.display = "none";
                    reasonSpan90.style.display = "none";
                }
            }

            // Initialize on page load
            toggleYogaFields90();

            // Attach event listeners
            yesRadio90.addEventListener("change", toggleYogaFields90);
            noRadio90.addEventListener("change", toggleYogaFields90);

            const day120_meds_yes = document.getElementById('day120_meds_yes');
            const day120_meds_no = document.getElementById('day120_meds_no');
            const day120_meds_reason = document.getElementById('day120_meds_reason');

            function toggleYogaFields120() {
                if (day120_meds_no.checked) {
                    day120_meds_reason.style.display = "inline";
                } else {
                    day120_meds_reason.style.display = "none";
                }
            }

            // Initialize on page load
            toggleYogaFields120();

            // Attach event listeners
            day120_meds_yes.addEventListener("change", toggleYogaFields120);
            day120_meds_no.addEventListener("change", toggleYogaFields120);

            const day120_bp_yes = document.getElementById('day120_bp_yes');
            const day120_bp_no = document.getElementById('day120_bp_no');
            const day120_bp_value = document.getElementById('day120_bp_value');

            function toggleBPField120() {
                if (day120_bp_yes.checked) {
                    day120_bp_value.style.display = "inline";
                } else {
                    day120_bp_value.style.display = "none";
                }
            }

            // Initialize on page load
            window.addEventListener('DOMContentLoaded', toggleBPField120);

            // Attach event listeners
            day120_bp_yes.addEventListener("change", toggleBPField120);
            day120_bp_no.addEventListener("change", toggleBPField120);

            const day120_rbs_yes = document.getElementById('day120_rbs_yes');
            const day120_rbs_no = document.getElementById('day120_rbs_no');
            const day120_rbs_value = document.getElementById('day120_rbs_value');

            function toggleRBSField120() {
                if (day120_rbs_yes.checked) {
                    day120_rbs_value.style.display = "inline";
                } else {
                    day120_rbs_value.style.display = "none";
                }
            }

            // Initialize on page load
            window.addEventListener('DOMContentLoaded', toggleRBSField120);

            // Attach event listeners
            day120_rbs_yes.addEventListener("change", toggleRBSField120);
            day120_rbs_no.addEventListener("change", toggleRBSField120);

            const day120_hba1c_yes = document.getElementById('day120_hba1c_yes');
            const day120_hba1c_no = document.getElementById('day120_hba1c_no');
            const day120_hba1c_value = document.getElementById('day120_hba1c_value');
            const day120_hba1c_last = document.getElementById('day120_hba1c_last');

            function toggleHbA1cFields120() {
                if (day120_hba1c_yes.checked) {
                    day120_hba1c_value.style.display = "inline";
                    day120_hba1c_last.style.display = "none";
                } else if (day120_hba1c_no.checked) {
                    day120_hba1c_value.style.display = "none";
                    day120_hba1c_last.style.display = "inline";
                } else {
                    day120_hba1c_value.style.display = "none";
                    day120_hba1c_last.style.display = "none";
                }
            }

            // Initialize on page load
            window.addEventListener('DOMContentLoaded', toggleHbA1cFields120);

            // Attach event listeners
            day120_hba1c_yes.addEventListener("change", toggleHbA1cFields120);
            day120_hba1c_no.addEventListener("change", toggleHbA1cFields120);

            const day120_challenges_yes = document.getElementById('day120_challenges_yes');
            const day120_challenges_no = document.getElementById('day120_challenges_no');
            const day120_challenges_reason = document.getElementById('day120_challenges_reason');

            function toggleDietChallengeField120() {
                if (day120_challenges_yes.checked) {
                    day120_challenges_reason.style.display = "inline";
                } else {
                    day120_challenges_reason.style.display = "none";
                }
            }

            // Initialize on page load
            window.addEventListener('DOMContentLoaded', toggleDietChallengeField120);

            // Attach event listeners
            day120_challenges_yes.addEventListener("change", toggleDietChallengeField120);
            day120_challenges_no.addEventListener("change", toggleDietChallengeField120);

            const day120_monitor_yes = document.getElementById('day120_monitor_yes');
            const day120_monitor_no = document.getElementById('day120_monitor_no');
            const day120_monitor_reason = document.getElementById('day120_monitor_reason');

            function toggleFluidMonitorField120() {
                if (day120_monitor_no.checked) {
                    day120_monitor_reason.style.display = "inline";
                } else {
                    day120_monitor_reason.style.display = "none";
                }
            }

            // Initialize on page load
            window.addEventListener('DOMContentLoaded', toggleFluidMonitorField120);

            // Attach event listeners
            day120_monitor_yes.addEventListener("change", toggleFluidMonitorField120);
            day120_monitor_no.addEventListener("change", toggleFluidMonitorField120);

            const day120_doctor_yes = document.getElementById('day120_doctor_yes');
            const day120_doctor_no = document.getElementById('day120_doctor_no');
            const day120_doctor_reason = document.getElementById('day120_doctor_reason');

            function toggleDoctorFollowupField120() {
                if (day120_doctor_no.checked) {
                    day120_doctor_reason.style.display = "inline";
                } else {
                    day120_doctor_reason.style.display = "none";
                }
            }

            // Initialize on page load
            window.addEventListener('DOMContentLoaded', toggleDoctorFollowupField120);

            // Attach event listeners
            day120_doctor_yes.addEventListener("change", toggleDoctorFollowupField120);
            day120_doctor_no.addEventListener("change", toggleDoctorFollowupField120);

            const medsYes2 = document.getElementById("day150_meds_yes");
            const medsNo2 = document.getElementById("day150_meds_no");
            const medsReason2 = document.getElementById("day150_meds_reason");

            medsYes2.addEventListener("change", () => medsReason2.style.display = "none");
            medsNo2.addEventListener("change", () => medsReason2.style.display = "inline");

            const stockYes2 = document.getElementById("day150_stock_yes");
            const stockNo2 = document.getElementById("day150_stock_no");
            const stockMeds2 = document.getElementById("day150_meds_stock");

            stockYes2.addEventListener("change", () => {
                if (stockYes2.checked) {
                    stockMeds2.style.display = "none";
                }
            });

            stockNo2.addEventListener("change", () => {
                if (stockNo2.checked) {
                    stockMeds2.style.display = "inline";
                }
            });


            // 2. BP Reading - show BP input only if Yes is selected
            const bpYes2 = document.getElementById("day150_bp_yes");
            const bpNo2 = document.getElementById("day150_bp_no");
            const bpValue2 = document.getElementById("day150_bp_value");

            bpYes2.addEventListener("change", () => bpValue2.style.display = "inline");
            bpNo2.addEventListener("change", () => bpValue2.style.display = "none");

            // 3. RBS - show value if Yes, reason if No
            const rbsYes2 = document.getElementById("day150_rbs_yes");
            const rbsNo2 = document.getElementById("day150_rbs_no");
            const rbsValue2 = document.getElementById("day150_rbs_value");
            const rbsReason2 = document.getElementById("day150_rbs_reason");

            rbsYes2.addEventListener("change", () => {
                rbsValue2.style.display = "inline";
                rbsReason2.style.display = "none";
            });

            rbsNo2.addEventListener("change", () => {
                rbsValue2.style.display = "none";
                rbsReason2.style.display = "inline";
            });

            // 4. Yoga attended - show reason if No
            const yogaYes2 = document.getElementById("day150_yoga_yes");
            const yogaNo2 = document.getElementById("day150_yoga_no");
            const yogaReason2 = document.getElementById("day150_yoga_reason");

            yogaYes2.addEventListener("change", () => yogaReason2.style.display = "none");
            yogaNo2.addEventListener("change", () => yogaReason.style.display = "inline");

            // 5. Call Remark - handle sub-options visibility
            const callConnect2 = document.getElementById("callremark_call_150");
            const noResponse2 = document.getElementById("callremark_no_150");
            const callRemarkContainer2 = document.getElementById("callremark_subremarks_150");
            const callConnectSub2 = document.getElementById("callconnect_subremarks_150");
            const noResponseSub2 = document.getElementById("noresponse_subremarks_150");

            callConnect2.addEventListener("change", () => {
                callRemarkContainer2.style.display = "block";
                callConnectSub2.style.display = "block";
                noResponseSub2.style.display = "none";
            });

            noResponse2.addEventListener("change", () => {
                callRemarkContainer2.style.display = "block";
                callConnectSub2.style.display = "none";
                noResponseSub2.style.display = "block";
            });

            const callConnect180 = document.getElementById("callremark_call_180");
            const noResponse180 = document.getElementById("callremark_no_180");
            const callRemarkContainer180 = document.getElementById("callremark_subremarks_180");
            const callConnectSub180 = document.getElementById("callconnect_subremarks_180");
            const noResponseSub180 = document.getElementById("noresponse_subremarks_180");

            callConnect180.addEventListener("change", () => {
                callRemarkContainer180.style.display = "block";
                callConnectSub180.style.display = "block";
                noResponseSub180.style.display = "none";
            });

            noResponse180.addEventListener("change", () => {
                callRemarkContainer180.style.display = "block";
                callConnectSub180.style.display = "none";
                noResponseSub180.style.display = "block";
            });
            document.addEventListener("DOMContentLoaded", function () {
                const yogaYes = document.getElementById("yoga_helpful_yes");
                const yogaNo = document.getElementById("yoga_helpful_no");
                const feedbackContainer = document.getElementById("yoga_feedback_container");

                function toggleFeedbackField() {
                    if (yogaNo.checked) {
                        feedbackContainer.style.display = "block";
                    } else {
                        feedbackContainer.style.display = "none";
                    }
                }

                // Add event listeners
                yogaYes.addEventListener("change", toggleFeedbackField);
                yogaNo.addEventListener("change", toggleFeedbackField);

                // Optional: trigger on page load if one is preselected
                toggleFeedbackField();
            });
            function getQueryParam(param) {
                let urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }

            // Get patient_id from URL
            let patientId = getQueryParam('patient_id');


            function submitFollowUpForm(formSelector, createUrl, updateUrl) {
                var $form = $(formSelector);
                var $submitBtn = $form.find('button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
                var formData = new FormData($form[0]);
                formData.set('patient_id', patientId);

                // Check for edit
                var recordId = $form.find('[name="id"]').val();
                var url = recordId ? updateUrl : createUrl;

                $.ajax({
                    url: url,
                    type: 'POST', // Use POST for both, or PUT for update if your backend expects it
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message, 'Success');
                            $submitBtn.prop('disabled', false).html('Edit');
                            enableNextTab(patientId);
                        } else {
                            toastr.error(response.message, 'Error');
                            $submitBtn.prop('disabled', false).html('Submit');
                        }
                    },
                    error: function () {
                        toastr.error("Something went wrong", 'Error');
                        $submitBtn.prop('disabled', false).html('Submit');
                    }
                });
            }

            $(document).ready(function () {
                var forms = [
                    { id: '#day3form', createUrl: 'day3-Followup-Create', updateUrl: 'day3-Followup-Update' },
                    { id: '#day7form', createUrl: 'day7-Followup-Create', updateUrl: 'day7-Followup-Update' },
                    { id: '#day15form', createUrl: 'day15-Followup-Create', updateUrl: 'day15-Followup-Update' },
                    { id: '#day30form', createUrl: 'day30-Followup-Create', updateUrl: 'day30-Followup-Update' },
                    { id: '#day45form', createUrl: 'day45-Followup-Create', updateUrl: 'day45-Followup-Update' },
                    { id: '#day60form', createUrl: 'day60-Followup-Create', updateUrl: 'day60-Followup-Update' },
                    { id: '#day90form', createUrl: 'day90-Followup-Create', updateUrl: 'day90-Followup-Update' },
                    { id: '#day120form', createUrl: 'day120-Followup-Create', updateUrl: 'day120-Followup-Update' },
                    { id: '#day150form', createUrl: 'day150-Followup-Create', updateUrl: 'day150-Followup-Update' },
                    { id: '#day180form', createUrl: 'day180-Followup-Create', updateUrl: 'day180-Followup-Update' }
                ];

                forms.forEach(function (f) {
                    if ($(f.id).length) {
                        $(f.id).submit(function (e) {
                            e.preventDefault();
                            submitFollowUpForm(f.id, f.createUrl, f.updateUrl);
                        });
                    }
                });
                day3dataget();
            });
            function enableNextTab(patientId) {
                $.ajax({
                    url: 'max-day/' + patientId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (res) {
                        let maxDay = res.max_day || 0;

                        // Detect if ANY disable flag is present
                        let disableFlag = null;
                        Object.keys(res).forEach(key => {
                            if (key.startsWith('disableDay') && res[key] === 'YES') {
                                disableFlag = key; // e.g., "disableDay7"
                            }
                        });

                        // Define day order
                        let days = [3, 7, 15, 30, 45, 60, 90, 120, 150, 180];

                        // Disable all tabs initially
                        $('#followUpTabs button').addClass('disabled').prop('disabled', true);

                        if (disableFlag) {
                            // Extract the day number from the disable flag
                            let dayNum = parseInt(disableFlag.replace('disableDay', ''), 10);

                            // Enable only tabs up to that day
                            days.forEach(d => {
                                if (d <= dayNum) {
                                    $('#day' + d + '-tab').removeClass('disabled').prop('disabled', false);
                                    $('#day' + d + '_submit').prop('disabled', false).html('Edit');
                                }
                            });

                            // Mark the disabled day explicitly
                            $('#day' + dayNum + '_submit').prop('disabled', true).html('Follow-up Stopped');
                        } else {
                            // Normal flow (no disable, just follow maxDay)
                            let idx = days.indexOf(maxDay);

                            // Enable tabs up to current maxDay
                            for (let i = 0; i <= idx; i++) {
                                $('#day' + days[i] + '-tab')
                                    .removeClass('disabled')
                                    .prop('disabled', false);
                                $('#day' + days[i] + '_submit').prop('disabled', false).html('Edit');
                            }

                            // Also enable the next day tab if available
                            if (idx + 1 < days.length) {
                                $('#day' + days[idx + 1] + '-tab')
                                    .removeClass('disabled')
                                    .prop('disabled', false);
                            }
                        }

                        // Ensure Day 3 tab is always visible
                        $('#day3-tab').removeClass('disabled').prop('disabled', false);
                    }
                });
            }
            enableNextTab(patientId);

            function day3dataget() {
                $.ajax({
                    url: 'day3-Followup-get/' + patientId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (res) {
                        if (res.success && res.data) {
                            let d = res.data;

                            // Hidden inputs
                            $('#day3_patient_id').val(patientId);
                            $('#day3form [name="id"]').val(d.id || '');
                            // Q1 Medicines
                            if (d.day3_meds) {
                                $('input[name="day3_meds"][value="' + d.day3_meds + '"]').prop('checked', true);
                                if (d.day3_meds === 'No') {
                                    $('#day3_meds_reason').show()
                                        .find('input').val(d.day3_meds_reason || '');
                                }
                            }

                            // Q2 Monitoring
                            if (d.day3_sugar) {
                                $('input[name="day3_sugar"][value="' + d.day3_sugar + '"]').prop('checked', true);
                                if (d.day3_sugar === 'No') {
                                    $('#day3_sugar_reason').show()
                                        .find('input').val(d.day3_sugar_reason || '');
                                }
                            }
                            if (d.day3_bp) {
                                $('input[name="day3_bp"][value="' + d.day3_bp + '"]').prop('checked', true);
                                if (d.day3_bp === 'No') {
                                    $('#day3_bp_reason').show()
                                        .find('input').val(d.day3_bp_reason || '');
                                }
                            }
                            if (d.day3_fluid) {
                                $('input[name="day3_fluid"][value="' + d.day3_fluid + '"]').prop('checked', true);
                                if (d.day3_fluid === 'No') {
                                    $('#day3_fluid_reason').show()
                                        .find('input').val(d.day3_fluid_reason || '');
                                }
                            }

                            // Q3 Support (checkboxes)
                            if (d.day3_support) {
                                let supportArr = d.day3_support.split(','); // assuming CSV stored
                                supportArr.forEach(val => {
                                    $('input[name="day3_support[]"][value="' + val + '"]').prop('checked', true);
                                });
                            }

                            // AE Report
                            if (d.ae_report) {
                                $('input[name="ae_report"][value="' + d.ae_report + '"]').prop('checked', true);
                            }

                            // Call Remark
                            if (d.callremark_3) {
                                $('input[name="callremark_3"][value="' + d.callremark_3 + '"]').prop('checked', true);

                                $('#callremark_subremarks_3').show();

                                if (d.callremark_3 === 'Call Connect') {
                                    $('#callconnect_subremarks_3').show();
                                    $('#callconnect_subremarks_3 select').val(d.callconnect_subremark_3);
                                } else if (d.callremark_3 === 'No Response') {
                                    $('#noresponse_subremarks_3').show();
                                    $('#noresponse_subremarks_3 select').val(d.noresponse_subremark_3);
                                }
                            }
                        }
                    },
                    error: function () {
                        toastr.error('Unable to load Day 3 data', 'Error');
                    }
                });
            }
            $('#day7-tab').on('click', function () {
                $.ajax({
                    url: 'day7-Followup-get/' + patientId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success && response.data) {
                            let data = response.data;

                            // Bind data to form fields
                            $('#day7form [name="patient_id"]').val(patientId);
                            $('#day7form [name="id"]').val(data.id || '');

                            // Medicines - using your pattern
                            $('#day7form [name="day7_meds"][value="' + data.day7_meds + '"]').prop('checked', true);
                            if (data.day7_meds === 'No') {
                                $('#day7_meds_reason').show()
                                    .find('input').val(data.day7_meds_reason || '');
                            }

                            // Doctor visit - using your pattern
                            $('#day7form [name="day7_doctor"][value="' + data.day7_doctor + '"]').prop('checked', true);
                            if (data.day7_doctor === 'No') {
                                $('#day7_doctor_reason').show()
                                    .find('input').val(data.day7_doctor_reason || '');
                            }

                            // BP monitoring - using your pattern
                            $('#day7form [name="day7_bp"][value="' + data.day7_bp + '"]').prop('checked', true);
                            if (data.day7_bp === 'Yes') {
                                $('#day7_bp_fields').show()
                                    .find('[name="day7_bp_value"]').val(data.day7_bp_value || '');
                            }
                            if (data.day7_bp === 'No') {
                                $('#day7_bp_remarks').show()
                                    .find('[name="day7_bp_remarks"]').val(data.day7_bp_remarks || '');
                            }

                            // Other fields
                            $('#day7form [name="day7_weight"]').val(data.day7_weight || '');
                            $('#day7form [name="day7_breathless"][value="' + data.day7_breathless + '"]').prop('checked', true);

                            // Yoga schedule - using your pattern
                            $('#day7form [name="day7_yoga_schedule"][value="' + data.day7_yoga_schedule + '"]').prop('checked', true);
                            if (data.day7_yoga_schedule === 'No') {
                                $('#day7_yoga_schedule_reason').show()
                                    .find('input').val(data.day7_yoga_schedule_reason || '');
                            }

                            // Yoga tried
                            $('#day7form [name="day7_yoga_tried"][value="' + data.day7_yoga_tried + '"]').prop('checked', true);

                            // Yoga difficult - using your pattern
                            $('#day7form [name="day7_yoga_difficult"][value="' + data.day7_yoga_difficult + '"]').prop('checked', true);
                            if (data.day7_yoga_difficult === 'Yes') {
                                $('#day7_yoga_difficult_reason').show()
                                    .find('input').val(data.day7_yoga_difficult_reason || '');
                            }

                            // Yoga required - using your pattern
                            $('#day7form [name="day7_yoga_required"][value="' + data.day7_yoga_required + '"]').prop('checked', true);
                            if (data.day7_yoga_required === 'Yes') {
                                $('#day7_yoga_planned_date_field').show()
                                    .find('input').val(data.day7_yoga_planned_date || '');
                            } else {
                                $('#day7_yoga_required_reason').show()
                                    .find('input').val(data.day7_yoga_required_reason || '');
                            }

                            if (data.day7_ae_report) {
                                $('#day7form [name="day7_ae_report"][value="' + data.day7_ae_report + '"]').prop('checked', true);
                            }

                            // Call remarks - using your pattern
                            $('#day7form [name="callremark_7"][value="' + data.callremark_7 + '"]').prop('checked', true);
                            $('#callremark_subremarks_7').show();
                            if (data.callremark_7 === 'Call Connect') {
                                $('#callconnect_subremarks_7').show()
                                    .find('select').val(data.callconnect_subremark_7 || '');
                                $('#noresponse_subremarks_7').hide();
                            } else if (data.callremark_7 === 'No Response') {
                                $('#noresponse_subremarks_7').show()
                                    .find('select').val(data.noresponse_subremark_7 || '');
                                $('#callconnect_subremarks_7').hide();
                            }
                        } else {
                            console.log("No saved data for Day 7.");
                        }
                    },
                    error: function () {
                        toastr.error("Failed to load Day 7 data", "Error");
                    }
                });
            });
            $('#day15-tab').on('click', function () {
                $.ajax({
                    url: 'day15-Followup-get/' + patientId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success && response.data) {
                            let data = response.data;

                            // Bind patient id
                            $('#day15form [name="id"]').val(data.id || '');
                            $('#day15form [name="patient_id"]').val(patientId);

                            // Q1 Medicines
                            $('#day15form [name="day15_meds"][value="' + data.day15_meds + '"]').prop('checked', true);
                            if (data.day15_meds === 'No') {
                                $('#day15_meds_reason').show()
                                    .find('input').val(data.day15_meds_reason || '');
                            }


                            // Q2 Stock
                            $('#day15form [name="day15_stock"][value="' + data.day15_stock + '"]').prop('checked', true);

                            // Q3 Changes
                            $('#day15form [name="day15_changes"][value="' + data.day15_changes + '"]').prop('checked', true);

                            // Q4 BP
                            $('#day15form [name="day15_bp"][value="' + data.day15_bp + '"]').prop('checked', true);
                            if (data.day15_bp === 'Yes') {
                                $('#day15_bp_value').show()
                                    .find('input').val(data.day15_bp_value || '');
                            }

                            // Q5 Weight
                            $('#day15form [name="day15_weight"]').val(data.day15_weight);

                            // Q6 RBS
                            $('#day15form [name="day15_rbs"][value="' + data.day15_rbs + '"]').prop('checked', true);
                            if (data.day15_rbs === 'Yes') {
                                $('#day15_rbs_value').show()
                                    .find('input').val(data.day15_rbs_value || '');
                            }
                            if (data.day15_rbs === 'No') {
                                $('#day15_rbs_reason').show()
                                    .find('input').val(data.day15_rbs_reason || '');
                            }


                            // Q7 Fluids & Urine
                            $('#day15form [name="day15_fluid"][value="' + data.day15_fluid + '"]').prop('checked', true);
                            $('#day15form [name="day15_urine"][value="' + data.day15_urine + '"]').prop('checked', true);

                            // Q8 Breathing
                            $('#day15form [name="day15_breathless"][value="' + data.day15_breathless + '"]').prop('checked', true);

                            // Q9 Yoga
                            $('#day15form [name="day15_yoga"][value="' + data.day15_yoga + '"]').prop('checked', true);
                            if (data.day15_rbs === 'No') {
                                $('#day15_yoga_reason').show()
                                    .find('input').val(data.day15_yoga_reason || '');
                            }
                            // Add this line inside the Day 15 success function
                            if (data.day15_ae_report) {
                                $('#day15form [name="day15_ae_report"][value="' + data.day15_ae_report + '"]').prop('checked', true);
                            }
                            // Call Remarks
                            $('#day15form [name="callremark_15"][value="' + data.callremark_15 + '"]').prop('checked', true);
                            $('#callremark_subremarks_15').show();
                            if (data.callremark_15 === 'Call Connect') {
                                $('#callconnect_subremarks_15').show()
                                    .find('select').val(data.callconnect_subremark_15 || '');
                                $('#noresponse_subremarks_15').hide();
                            } else if (data.callremark_15 === 'No Response') {
                                $('#noresponse_subremarks_15').show()
                                    .find('select').val(data.noresponse_subremark_15 || '');
                                $('#callconnect_subremarks_15').hide();
                            }
                        } else {
                            console.log("No saved data for Day 15.");
                        }
                    },
                    error: function () {
                        toastr.error("Failed to load Day 15 data", "Error");
                    }
                });
            });
            $('#day30-tab').on('click', function () {
                $.ajax({
                    url: 'day30-Followup-get/' + patientId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success && response.data) {
                            let data = response.data;
                            $('#day30form [name="id"]').val(data.id || '');
                            // bind patient id
                            $('#day30form [name="patient_id"]').val(patientId);

                            // Q1 Medicines
                            $('#day30form [name="day30_meds"][value="' + data.day30_meds + '"]').prop('checked', true);
                            if (data.day30_meds === 'No') {
                                $('#day30_meds_reason').show()
                                    .find('input').val(data.day30_meds_reason || '');
                            }

                            // Q2 Stock
                            $('#day30form [name="day30_stock"][value="' + data.day30_stock + '"]').prop('checked', true);

                            // Q3 Changes
                            $('#day30form [name="day30_changes"][value="' + data.day30_changes + '"]').prop('checked', true);

                            // Q4 BP
                            $('#day30form [name="day30_bp"][value="' + data.day30_bp + '"]').prop('checked', true);
                            if (data.day30_bp === 'Yes') {
                                $('#day30_bp_value').show()
                                    .find('input').val(data.day30_bp_value || '');
                            }


                            // Q5 Weight
                            $('#day30form [name="day30_weight"]').val(data.day30_weight);

                            // Q6 RBS
                            $('#day30form [name="day30_rbs"][value="' + data.day30_rbs + '"]').prop('checked', true);
                            if (data.day30_rbs === 'Yes') {
                                $('#day30_rbs_value').show()
                                    .find('input').val(data.day30_rbs_value || '');
                            }
                            if (data.day30_rbs === 'No') {
                                $('#day30_rbs_reason').show()
                                    .find('input').val(data.day30_rbs_reason || '');
                            }

                            // Q7 Fluid + Urine
                            $('#day30form [name="day30_fluid"][value="' + data.day30_fluid + '"]').prop('checked', true);
                            $('#day30form [name="day30_urine"][value="' + data.day30_urine + '"]').prop('checked', true);

                            // Q8 Breathing
                            $('#day30form [name="day30_breathless"][value="' + data.day30_breathless + '"]').prop('checked', true);

                            // Q9 Yoga
                            $('#day30form [name="day30_yoga"][value="' + data.day30_yoga + '"]').prop('checked', true);
                            if (data.day30_yoga === 'No') {
                                $('#day30_yoga_reason').show()
                                    .find('input').val(data.day30_yoga_reason || '');
                            }
                            // Add this line inside the Day 30 success function
                            if (data.day30_ae_report) {
                                $('#day30form [name="day30_ae_report"][value="' + data.day30_ae_report + '"]').prop('checked', true);
                            }

                            // Call Remark
                            $('#day30form [name="callremark_30"][value="' + data.callremark_30 + '"]').prop('checked', true);
                            $('#callremark_subremarks_30').show();
                            if (data.callremark_30 === 'Call Connect') {
                                $('#callconnect_subremarks_30').show()
                                    .find('select').val(data.callconnect_subremark_30 || '');
                                $('#noresponse_subremarks_30').hide();
                            } else if (data.callremark_30 === 'No Response') {
                                $('#noresponse_subremarks_30').show()
                                    .find('select').val(data.noresponse_subremark_30 || '');
                                $('#callconnect_subremarks_30').hide();
                            }
                        } else {
                            console.log("No saved data for Day 30.");
                        }
                    },
                    error: function () {
                        toastr.error("Failed to load Day 30 data", "Error");
                    }
                });
            });
            $('#day45-tab').on('click', function () {
                $.ajax({
                    url: 'day45-Followup-get/' + patientId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success && response.data) {
                            let data = response.data;
                            $('#day45form [name="id"]').val(data.id || '');
                            // set patient_id
                            $('#day45form [name="patient_id"]').val(patientId);

                            // 1. Medicines
                            $('#day45form [name="day45_meds"][value="' + data.day45_meds + '"]').prop('checked', true);
                            if (data.day45_meds === 'No') {
                                $('#day45_meds_reason').show()
                                    .find('input').val(data.day45_meds_reason || '');
                            }


                            // 2. Doctor follow-up
                            $('#day45form [name="day45_doctor"][value="' + data.day45_doctor + '"]').prop('checked', true);
                            if (data.day45_doctor === 'No') {
                                $('#day45_doctor_reason').show()
                                    .find('input').val(data.day45_doctor_reason || '');
                            }

                            // 3. Blood Pressure
                            $('#day45form [name="day45_bp"][value="' + data.day45_bp + '"]').prop('checked', true);
                            if (data.day45_bp === 'Yes') {
                                $('#day45_bp_value').show()
                                    .find('input').val(data.day45_bp_value || '');
                            }
                            if (data.day45_bp === 'No') {
                                $('#day45_bp_remarks').show()
                                    .find('input').val(data.day45_bp_remarks || '');
                            }


                            // 4. Weight
                            $('#day45form [name="day45_weight"]').val(data.day45_weight);

                            // 5. Breathlessness
                            $('#day45form [name="day45_breathless"][value="' + data.day45_breathless + '"]').prop('checked', true);

                            // 6. Yoga Schedule
                            $('#day45form [name="day45_yoga_schedule"][value="' + data.day45_yoga_schedule + '"]').prop('checked', true);
                            if (data.day45_yoga_schedule === 'No') {
                                $('#day45_yoga_schedule_reason').show()
                                    .find('input').val(data.day45_yoga_schedule_reason || '');
                            }

                            // 7. Yoga Tried Earlier
                            $('#day45form [name="day45_yoga_tried"][value="' + data.day45_yoga_tried + '"]').prop('checked', true);
                            if (data.day45_yoga_tried === 'Yes') {
                                $('#day45_yoga_difficult').show()
                                    .find('input').val(data.day45_yoga_difficult || '');
                                if (data.day45_yoga_difficult == 'Difficulties') {
                                    $('#day45_yoga_difficult_reason').show()
                                        .find('input').val(data.day45_yoga_difficult_reason || '');
                                }
                            }


                            // 8. Yoga Session Required
                            $('#day45form [name="day45_yoga_required"][value="' + data.day45_yoga_required + '"]').prop('checked', true);
                            if (data.day45_yoga_required === 'Yes') {
                                $('#day45_yoga_planned_date').show()
                                    .find('input').val(data.day45_yoga_planned_date || '');
                            } if (data.day45_yoga_required === 'No') {
                                $('#day45_yoga_required_reason').show()
                                    .find('input').val(data.day45_yoga_required_reason || '');
                            }
                            // Add this line inside the Day 30 success function
                            if (data.day45_ae_report) {
                                $('#day45form [name="day45_ae_report"][value="' + data.day45_ae_report + '"]').prop('checked', true);
                            }
                            // 9. Call Remark
                            $('#day45form [name="callremark_45"][value="' + data.callremark_45 + '"]').prop('checked', true);
                            $('#callremark_subremarks_45').show();
                            if (data.callremark_45 === 'Call Connect') {
                                $('#callconnect_subremarks_45').show()
                                    .find('select').val(data.callconnect_subremark_45 || '');
                                $('#noresponse_subremarks_45').hide();
                            } else if (data.callremark_45 === 'No Response') {
                                $('#noresponse_subremarks_45').show()
                                    .find('select').val(data.noresponse_subremark_45 || '');
                                $('#callconnect_subremarks_45').hide();
                            }
                        } else {
                            console.log("No saved data for Day45.");
                        }
                    },
                    error: function () {
                        toastr.error("Failed to load Day45 data", "Error");
                    }
                });
            });
            $('#day60-tab').on('click', function () {
                $.ajax({
                    url: 'day60-Followup-get/' + patientId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success && response.data) {
                            let data = response.data;
                            $('#day60form [name="id"]').val(data.id || '');
                            // set patient_id
                            $('#day60form [name="patient_id"]').val(patientId);

                            // Medicines
                            $('#day60form [name="day60_meds"][value="' + data.day60_meds + '"]').prop('checked', true);
                            if (data.day60_meds === 'No') {
                                $('#day60_meds_reason').show()
                                    .find('input').val(data.day60_meds_reason || '');
                            }


                            // BP
                            $('#day60form [name="day60_bp"][value="' + data.day60_bp + '"]').prop('checked', true);
                            if (data.day60_bp === 'Yes') {
                                $('#day60_bp_value').show()
                                    .find('input').val(data.day60_bp_value || '');
                            }

                            // RBS
                            $('#day60form [name="day60_rbs"][value="' + data.day60_rbs + '"]').prop('checked', true);
                            if (data.day60_rbs === 'Yes') {
                                $('#day60_rbs_reason').show()
                                    .find('input').val(data.day60_rbs_reason || '');
                            }


                            // Weight
                            $('#day60form [name="day60_weight"]').val(data.day60_weight);

                            // HbA1c
                            $('#day60form [name="day60_hba1c"][value="' + data.day60_hba1c + '"]').prop('checked', true);
                            if (data.day60_hba1c === 'Yes') {
                                $('#day60_hba1c_value').show()
                                    .find('input').val(data.day60_hba1c_value || '');
                            }
                            if (data.day60_hba1c === 'No') {
                                $('#day60_hba1c_last').show()
                                    .find('input').val(data.day60_hba1c_last || '');
                            }

                            // Diet Challenges
                            $('#day60form [name="day60_challenges"][value="' + data.day60_challenges + '"]').prop('checked', true);
                            if (data.day60_challenges === 'Yes') {
                                $('#day60_challenges_reason').show()
                                    .find('input').val(data.day60_challenges_reason || '');
                            }

                            // Fluid Monitoring
                            $('#day60form [name="day60_monitor"][value="' + data.day60_monitor + '"]').prop('checked', true);
                            if (data.day60_monitor === 'No') {
                                $('#day60_monitor_reason').show()
                                    .find('input').val(data.day60_monitor_reason || '');
                            }

                            // Fluid & Urine
                            $('#day60form [name="day60_water"][value="' + data.day60_water + '"]').prop('checked', true);
                            $('#day60form [name="day60_urine"][value="' + data.day60_urine + '"]').prop('checked', true);

                            // Questions
                            $('#day60form [name="day60_questions"][value="' + data.day60_questions + '"]').prop('checked', true);

                            // Meal Planning Help
                            $('#day60form [name="day60_help"][value="' + data.day60_help + '"]').prop('checked', true);

                            // Doctor Follow-up
                            $('#day60form [name="day60_doctor"][value="' + data.day60_doctor + '"]').prop('checked', true);
                            if (data.day60_doctor === 'No') {
                                $('#day60_doctor_reason').show()
                                    .find('input').val(data.day60_doctor_reason || '');
                            }

                            // Yoga Remark
                            $('#day60form [name="day60_yoga_remark"]').val(data.day60_yoga_remark);
                            // Add this line inside the Day 30 success function
                            if (data.day60_ae_report) {
                                $('#day60form [name="day60_ae_report"][value="' + data.day60_ae_report + '"]').prop('checked', true);
                            }
                            // Call Remark
                            $('#day60form [name="callremark_60"][value="' + data.callremark_60 + '"]').prop('checked', true);
                            $('#callremark_subremarks_60').show();
                            if (data.callremark_60 === 'Call Connect') {
                                $('#callconnect_subremarks_60').show()
                                    .find('select').val(data.callconnect_subremark_60 || '');
                                $('#noresponse_subremarks_60').hide();
                            } else if (data.callremark_60 === 'No Response') {
                                $('#noresponse_subremarks_60').show()
                                    .find('select').val(data.noresponse_subremark_60 || '');
                                $('#callconnect_subremarks_60').hide();
                            }

                        } else {
                            console.log("No saved data for Day60");
                        }
                    },
                    error: function () {
                        toastr.error("Failed to load Day60 follow-up", "Error");
                    }
                });
            });
            $('#day90-tab').on('click', function () {
                $.ajax({
                    url: 'day90-Followup-get/' + patientId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success && response.data) {
                            let data = response.data;
                            $('#day90form [name="id"]').val(data.id || '');
                            // hidden fields
                            $('#day90form [name="patient_id"]').val(patientId);

                            // Medicines
                            $('#day90form [name="day90_meds"][value="' + data.day90_meds + '"]').prop('checked', true);
                            if (data.day90_meds === 'No') {
                                $('#day90_meds_reason').show()
                                    .find('input').val(data.day90_meds_reason || '');
                            }

                            // Doctor
                            $('#day90form [name="day90_doctor"][value="' + data.day90_doctor + '"]').prop('checked', true);
                            if (data.day90_doctor === 'No') {
                                $('#day90_doctor_reason').show()
                                    .find('input').val(data.day90_doctor_reason || '');
                            }
                            // BP
                            $('#day90form [name="day90_bp"][value="' + data.day90_bp + '"]').prop('checked', true);
                            if (data.day90_bp === 'Yes') {
                                $('#day90_bp_value').show()
                                    .find('input').val(data.day90_bp_value || '');
                            }
                            if (data.day90_bp === 'No') {
                                $('#day90_bp_remarks').show()
                                    .find('input').val(data.day90_bp_remarks || '');
                            }


                            // Weight
                            $('#day90form [name="day90_weight"]').val(data.day90_weight);

                            // Breathlessness
                            $('#day90form [name="day90_breathless"][value="' + data.day90_breathless + '"]').prop('checked', true);

                            // Yoga schedule
                            $('#day90form [name="day90_yoga_schedule"][value="' + data.day90_yoga_schedule + '"]').prop('checked', true);
                            if (data.day90_yoga_schedule === 'No') {
                                $('#day90_yoga_schedule_reason').show()
                                    .find('input').val(data.day90_yoga_schedule_reason || '');
                            }

                            // Yoga tried
                            $('#day90form [name="day90_yoga_tried"][value="' + data.day90_yoga_tried + '"]').prop('checked', true);
                            if (data.day90_yoga_tried === 'Yes') {
                                $('#day90_yoga_difficult').show()
                                    .find('input').val(data.day90_yoga_difficult || '');
                                if (data.day90_yoga_difficult == 'Difficulties') {
                                    $('#day90_yoga_difficult_reason').show()
                                        .find('input').val(data.day90_yoga_difficult_reason || '');
                                }
                            }

                            // Yoga required
                            $('#day90form [name="day90_yoga_required"][value="' + data.day90_yoga_required + '"]').prop('checked', true);
                            if (data.day90_yoga_required === 'Yes') {
                                $('#day90_yoga_planned_date').show()
                                    .find('input').val(data.day90_yoga_planned_date || '');
                            } if (data.day90_yoga_required === 'No') {
                                $('#day90_yoga_required_reason').show()
                                    .find('input').val(data.day90_yoga_required_reason || '');
                            }
                            // Add this line inside the Day 30 success function
                            if (data.day90_ae_report) {
                                $('#day90form [name="day90_ae_report"][value="' + data.day90_ae_report + '"]').prop('checked', true);
                            }
                            // Call remarks
                            $('#day90form [name="callremark_90"][value="' + data.callremark_90 + '"]').prop('checked', true);
                            $('#callremark_subremarks_90').show();
                            if (data.callremark_90 === 'Call Connect') {
                                $('#callconnect_subremarks_90').show()
                                    .find('select').val(data.callconnect_subremark_90 || '');
                                $('#noresponse_subremarks_90').hide();
                            } else if (data.callremark_90 === 'No Response') {
                                $('#noresponse_subremarks_90').show()
                                    .find('select').val(data.noresponse_subremark_90 || '');
                                $('#callconnect_subremarks_90').hide();
                            }

                        } else {
                            console.log("No Day90 data found");
                        }
                    },
                    error: function () {
                        toastr.error("Failed to load Day 90 follow-up", "Error");
                    }
                });
            });
            $('#day120-tab').on('click', function () {
                $.ajax({
                    url: 'day120-Followup-get/' + patientId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success && response.data) {
                            let data = response.data;
                            $('#day120form [name="id"]').val(data.id || '');
                            // hidden fields
                            $('#day120form [name="patient_id"]').val(patientId);

                            // Medicines
                            $('#day120form [name="day120_meds"][value="' + data.day120_meds + '"]').prop('checked', true);
                            if (data.day120_meds === 'No') {
                                $('#day120_meds_reason').show()
                                    .find('input').val(data.day120_meds_reason || '');
                            }

                            // Blood Pressure
                            $('#day120form [name="day120_bp"][value="' + data.day120_bp + '"]').prop('checked', true);
                            if (data.day120_bp === 'Yes') {
                                $('#day120_bp_value').show()
                                    .find('input').val(data.day120_bp_value || '');
                            }

                            // Blood Sugar
                            $('#day120form [name="day120_rbs"][value="' + data.day120_rbs + '"]').prop('checked', true);
                            if (data.day120_rbs === 'Yes') {
                                $('#day120_rbs_reason').show()
                                    .find('input').val(data.day120_rbs_reason || '');
                            }

                            // Weight
                            $('#day120form [name="day120_weight"]').val(data.day120_weight);

                            // HbA1c
                            $('#day120form [name="day120_hba1c"][value="' + data.day120_hba1c + '"]').prop('checked', true);
                            if (data.day120_hba1c === 'Yes') {
                                $('#day120_hba1c_value').show()
                                    .find('input').val(data.day120_hba1c_value || '');
                            }
                            if (data.day120_hba1c === 'No') {
                                $('#day120_hba1c_last').show()
                                    .find('input').val(data.day120_hba1c_last || '');
                            }


                            // Diet Challenges
                            $('#day120form [name="day120_challenges"][value="' + data.day120_challenges + '"]').prop('checked', true);
                            if (data.day120_challenges === 'Yes') {
                                $('#day120_challenges_reason').show()
                                    .find('input').val(data.day120_challenges_reason || '');
                            }

                            // Fluid monitoring
                            $('#day120form [name="day120_monitor"][value="' + data.day120_monitor + '"]').prop('checked', true);
                            if (data.day120_monitor === 'No') {
                                $('#day120_monitor_reason').show()
                                    .find('input').val(data.day120_monitor_reason || '');
                            }

                            // Water & Urine
                            $('#day120form [name="day120_water"][value="' + data.day120_water + '"]').prop('checked', true);
                            $('#day120form [name="day120_urine"][value="' + data.day120_urine + '"]').prop('checked', true);

                            // Questions & Help
                            $('#day120form [name="day120_questions"][value="' + data.day120_questions + '"]').prop('checked', true);
                            $('#day120form [name="day120_help"][value="' + data.day120_help + '"]').prop('checked', true);

                            // Doctor follow-up
                            $('#day120form [name="day120_doctor"][value="' + data.day120_doctor + '"]').prop('checked', true);
                            if (data.day120_doctor === 'No') {
                                $('#day120_doctor_reason').show()
                                    .find('input').val(data.day120_doctor_reason || '');
                            }

                            // Yoga Remark
                            $('#day120form [name="day120_yoga_remark"]').val(data.day120_yoga_remark);
                            // Add this line inside the Day 30 success function
                            if (data.day120_ae_report) {
                                $('#day120form [name="day120_ae_report"][value="' + data.day120_ae_report + '"]').prop('checked', true);
                            }
                            // Call Remark
                            $('#day120form [name="callremark_120"][value="' + data.callremark_120 + '"]').prop('checked', true);
                            $('#callremark_subremarks_120').show();
                            if (data.callremark_120 === 'Call Connect') {
                                $('#callconnect_subremarks_120').show()
                                    .find('select').val(data.callconnect_subremark_120 || '');
                                $('#noresponse_subremarks_120').hide();
                            } else if (data.callremark_120 === 'No Response') {
                                $('#noresponse_subremarks_120').show()
                                    .find('select').val(data.noresponse_subremark_120 || '');
                                $('#callconnect_subremarks_120').hide();
                            }

                        } else {
                            console.log("No Day120 data found");
                        }
                    },
                    error: function () {
                        toastr.error("Failed to load Day 120 follow-up", "Error");
                    }
                });
            });
            $('#day150-tab').on('click', function () {
                $.ajax({
                    url: 'day150-Followup-get/' + patientId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success && response.data) {
                            let data = response.data;
                            $('#day150form [name="id"]').val(data.id || '');
                            // hidden fields
                            $('#day150form [name="patient_id"]').val(patientId);

                            // Medicines
                            $('#day150form [name="day150_meds"][value="' + data.day150_meds + '"]').prop('checked', true);
                            if (data.day150_meds === 'No') {
                                $('#day150_meds_reason').show()
                                    .find('input').val(data.day150_meds_reason || '');
                            }

                            // Stock
                            $('#day150form [name="day150_stock"][value="' + data.day150_stock + '"]').prop('checked', true);

                            // Medication Changes
                            $('#day150form [name="day150_changes"][value="' + data.day150_changes + '"]').prop('checked', true);

                            // BP
                            $('#day150form [name="day150_bp"][value="' + data.day150_bp + '"]').prop('checked', true);
                            if (data.day150_bp === 'Yes') {
                                $('#day150_bp_value').show()
                                    .find('input').val(data.day150_bp_value || '');
                            }


                            // Weight
                            $('#day150form [name="day150_weight"]').val(data.day150_weight);

                            // RBS
                            $('#day150form [name="day150_rbs"][value="' + data.day150_rbs + '"]').prop('checked', true);
                            if (data.day150_rbs === 'Yes') {
                                $('#day150_rbs_value').show()
                                    .find('input').val(data.day150_rbs_value || '');
                            }
                            if (data.day150_rbs === 'No') {
                                $('#day150_rbs_reason').show()
                                    .find('input').val(data.day150_rbs_reason || '');
                            }

                            // Fluid & Urine
                            $('#day150form [name="day150_fluid"][value="' + data.day150_fluid + '"]').prop('checked', true);
                            $('#day150form [name="day150_urine"][value="' + data.day150_urine + '"]').prop('checked', true);

                            // Breathing
                            $('#day150form [name="day150_breathless"][value="' + data.day150_breathless + '"]').prop('checked', true);

                            // Yoga
                            $('#day150form [name="day150_yoga"][value="' + data.day150_yoga + '"]').prop('checked', true);
                            if (data.day150_yoga === 'No') {
                                $('#day150_yoga_reason').show()
                                    .find('input').val(data.day150_yoga_reason || '');
                            }
                            // Add this line inside the Day 30 success function
                            if (data.day150_ae_report) {
                                $('#day150form [name="day150_ae_report"][value="' + data.day150_ae_report + '"]').prop('checked', true);
                            }

                            // Call Remark
                            $('#day150form [name="callremark_150"][value="' + data.callremark_150 + '"]').prop('checked', true);
                            $('#callremark_subremarks_150').show();
                            if (data.callremark_150 === 'Call Connect') {
                                $('#callconnect_subremarks_150').show()
                                    .find('select').val(data.callconnect_subremark_150 || '');
                                $('#noresponse_subremarks_150').hide();
                            } else if (data.callremark_150 === 'No Response') {
                                $('#noresponse_subremarks_150').show()
                                    .find('select').val(data.noresponse_subremark_150 || '');
                                $('#callconnect_subremarks_150').hide();
                            }

                        } else {
                            console.log("No Day150 data found");
                        }
                    },
                    error: function () {
                        toastr.error("Failed to load Day 150 follow-up", "Error");
                    }
                });
            });
            $('#day180-tab').on('click', function () {
                $.ajax({
                    url: 'day180-Followup-get/' + patientId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success && response.data) {
                            let data = response.data;
                            $('#day180form [name="id"]').val(data.id || '');
                            // hidden fields
                            $('#day180form [name="patient_id"]').val(patientId);

                            // Q1: Feeling Now
                            $('#day180form [name="feeling_now"][value="' + data.feeling_now + '"]').prop('checked', true);

                            // Q2: Yoga Helpful
                            $('#day180form [name="yoga_helpful"][value="' + data.yoga_helpful + '"]').prop('checked', true);
                            if (data.yoga_helpful === 'No') {
                                $('#yoga_feedback_section').show()
                                    .find('input').val(data.yoga_feedback || '');
                            }


                            // Q3: Instructor Support
                            $('#day180form [name="instructor_support"][value="' + data.instructor_support + '"]').prop('checked', true);
                            $('#day180form [name="instructor_feedback"]').val(data.instructor_feedback);

                            // Q4: Diet Impact
                            $('#day180form [name="diet_impact"][value="' + data.diet_impact + '"]').prop('checked', true);
                            $('#day180form [name="diet_feedback"]').val(data.diet_feedback);

                            // Q5: Dietician Access
                            $('#day180form [name="dietician_access"][value="' + data.dietician_access + '"]').prop('checked', true);
                            $('#day180form [name="dietician_feedback"]').val(data.dietician_feedback);

                            // Q6: Overall Experience
                            $('#day180form [name="overall_experience"][value="' + data.overall_experience + '"]').prop('checked', true);
                            $('#day180form [name="experience_remarks"]').val(data.experience_remarks);

                            // Q7: Final Feedback
                            $('#day180form [name="final_feedback"]').val(data.final_feedback);
                            // Add this line inside the Day 30 success function
                            if (data.day180_ae_report) {
                                $('#day180form [name="day180_ae_report"][value="' + data.day180_ae_report + '"]').prop('checked', true);
                            }
                            // Call Remark
                            $('#day180form [name="callremark_180"][value="' + data.callremark_180 + '"]').prop('checked', true);
                            $('#callremark_subremarks_180').show();
                            if (data.callremark_180 === 'Call Connect') {
                                $('#callconnect_subremarks_180').show()
                                    .find('select').val(data.callconnect_subremark_180 || '');
                                $('#noresponse_subremarks_180').hide();
                            } else if (data.callremark_180 === 'No Response') {
                                $('#noresponse_subremarks_180').show()
                                    .find('select').val(data.noresponse_subremark_180 || '');
                                $('#callconnect_subremarks_180').hide();
                            }


                        } else {
                            console.log("No Day180 data found");
                        }
                    },
                    error: function () {
                        toastr.error("Failed to load Day 180 follow-up", "Error");
                    }
                });
            });
        </script>
