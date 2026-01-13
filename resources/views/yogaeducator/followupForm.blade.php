@include('yogaeducator/header')
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

        @include('yogaeducator/Sidebar')
        <div class="page-wrapper">
            <div class="content container-fluid">
                @include('yogaeducator/breadcum')
                <div class="form-container">
                    <h1 class="form-title">✅ Patient Follow-up Form</h1>
                    <ul class="nav nav-tabs" id="followUpTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="day7-tab" data-bs-toggle="tab" data-bs-target="#day7"
                                type="button" role="tab">Day 7</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="day45-tab" data-bs-toggle="tab" data-bs-target="#day45"
                                type="button" role="tab">Day 45</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="day90-tab" data-bs-toggle="tab" data-bs-target="#day90"
                                type="button" role="tab">Day 90</button>
                        </li>

                    </ul>
                    <div class="tab-content" id="followUpTabsContent">

                        <div class="tab-pane fade show active" id="day7" role="tabpanel" aria-labelledby="day7-tab">
                            <div class="form-section">
                                <h2 class="section-title">🧘 Day 7 Follow-up</h2>

                                <form id="day7form">
                                    <input type="hidden" name="day" value="7">
                                    <input type="hidden" name="patient_id" value="">

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
                                                        <option value="DND the Patient">DND the Patient</option>
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
                        <div class="tab-pane fade" id="day45" role="tabpanel" aria-labelledby="day45-tab">
                            <div class="form-section">
                                <h2 class="section-title">🗓️ Day 45 Follow-up</h2>
                                <form id="day45form">
                                    <input type="hidden" name="day" value="45">
                                    <input type="hidden" name="patient_id" value="">

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
                                                        <option value="DND the Patient">DND the Patient</option>
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
                        <div class="tab-pane fade" id="day90" role="tabpanel" aria-labelledby="day90-tab">
                            <div class="form-section">
                                <h2 class="section-title">🗓️ Day 90 Follow-up</h2>
                                <form id="day90form">
                                    <input type="hidden" name="day" value="90">
                                    <input type="hidden" name="patient_id" value="">

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
                                                        <option value="DND the Patient">DND the Patient</option>
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
                    </div>
                </div>
            </div>
        </div>
        @include('yogaeducator/footer')
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
                setupCallRemarkListeners(7);
                setupCallRemarkListeners(45);
                setupCallRemarkListeners(90);
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
            });
            function getQueryParam(param) {
                let urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }

            // Get patient_id from URL
            let patientId = getQueryParam('patient_id');


            function submitFollowUpForm(formSelector, url) {
                var $form = $(formSelector);

                // Disable submit button
                var $submitBtn = $form.find('button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

                // Prepare form data
                var formData = new FormData($form[0]);
                formData.set('patient_id', patientId); // add patient_id dynamically

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message, 'Success');

                            $submitBtn.prop('disabled', true).html('Already Submitted');
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

            // Attach submit handler for multiple forms
            $(document).ready(function () {

                var forms = [
                    { id: '#day7form', url: 'day7-Followup-Create' },
                    { id: '#day45form', url: 'day45-Followup-Create' },
                    { id: '#day90form', url: 'day90-Followup-Create' }
                ];

                forms.forEach(function (f) {
                    if ($(f.id).length) { // check if form exists
                        $(f.id).submit(function (e) {
                            e.preventDefault();
                            submitFollowUpForm(f.id, f.url);
                        });
                    }
                });
                day7dataget();
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
                                    $('#day' + d + '_submit').prop('disabled', true).html('Already Submitted');
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
                                $('#day' + days[i] + '_submit').prop('disabled', true).html('Already Submitted');
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
            function day7dataget() {
                $.ajax({
                    url: 'day7-Followup-get/' + patientId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success && response.data) {
                            let data = response.data;

                            // Bind data to form fields
                            $('#day7form [name="patient_id"]').val(patientId);

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

                            }
                        }else {
                                console.log("No saved data for Day 7.");
                            }
                        },
                        error: function () {
                            toastr.error("Failed to load Day 7 data", "Error");
                        }
                    });
            }
            $('#day45-tab').on('click', function () {
                $.ajax({
                    url: 'day45-Followup-get/' + patientId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success && response.data) {
                            let data = response.data;

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
            $('#day90-tab').on('click', function () {
                $.ajax({
                    url: 'day90-Followup-get/' + patientId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success && response.data) {
                            let data = response.data;

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
        </script>
