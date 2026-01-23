<?php
namespace App\Http\Controllers;

use App\Exports\DigiFeedbackReportExport;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Day3Followup;
use App\Models\Day7Followup;
use App\Models\Day15Followup;
use App\Models\Day30Followup;
use App\Models\Day45Followup;
use App\Models\Day60FollowUp;
use App\Models\Day90Followup;
use App\Models\Day120FollowUp;
use App\Models\Day150Followup;
use App\Models\Day180Followup;
use Maatwebsite\Excel\Facades\Excel;


class digitalController extends Controller
{
    public function digitalEducatorDashboard()
    {
        return view('digitaleducator.dashboard');
    }
    public function digitsalPatientInquary()
    {
        return view('digitaleducator.patientInquaryForm');
    }
    public function digitalPatientList()
    {
        return view('digitaleducator.digitalPatientList');
    }
    public function getPatientList(Request $request)
    {
        $user_id = Auth::id();

        // Step 1: Define follow-up table mapping
        $followupTables = [
            3 => ['table' => 'day3_followup', 'call_col' => 'callconnect_subremark_3', 'noresp_col' => 'noresponse_subremark_3'],
            7 => ['table' => 'day7_followup', 'call_col' => 'callconnect_subremark_7', 'noresp_col' => 'noresponse_subremark_7'],
            15 => ['table' => 'day15_followup', 'call_col' => 'callconnect_subremark_15', 'noresp_col' => 'noresponse_subremark_15'],
            30 => ['table' => 'day30_followup', 'call_col' => 'callconnect_subremark_30', 'noresp_col' => 'noresponse_subremark_30'],
            45 => ['table' => 'day45_followup', 'call_col' => 'callconnect_subremark_45', 'noresp_col' => 'noresponse_subremark_45'],
            60 => ['table' => 'day60_followup', 'call_col' => 'callconnect_subremark_60', 'noresp_col' => 'noresponse_subremark_60'],
            90 => ['table' => 'day90_followup', 'call_col' => 'callconnect_subremark_90', 'noresp_col' => 'noresponse_subremark_90'],
            120 => ['table' => 'day120_followup', 'call_col' => 'callconnect_subremark_120', 'noresp_col' => 'noresponse_subremark_120'],
            150 => ['table' => 'day150_followup', 'call_col' => 'callconnect_subremark_150', 'noresp_col' => 'noresponse_subremark_150'],
            180 => ['table' => 'day180_followup', 'call_col' => 'callconnect_subremark_180', 'noresp_col' => 'noresponse_subremark_180'],
        ];

        $dndOrDropoutConditions = [
            'DND the Patient',
            'Wrong Number – DND the Patient',
            'Dropout',
        ];

        // Step 2: Get base patient list (without filtering yet)
        $patients = DB::table('public.patient_details as a')
            ->leftJoin('public.patient_medication_details as c', 'a.uuid', '=', 'c.uuid')
            ->leftJoin('common.users as d', function ($join) {
                $join->on('a.digital_educator_id', '=', 'd.id')
                    ->where('d.role', '=', 'digitalcounsellor');
            })
            ->leftJoin('common.users as e', function ($join) {
                $join->on('a.educator_id', '=', 'e.id')
                    ->where('e.role', '=', 'counsellor');
            })
            ->leftJoin('common.rm_users as f', 'd.rm_pm_id', '=', 'f.id')
            ->leftJoin('public.doctor as g', DB::raw('CAST(a.hcp_id AS INTEGER)'), '=', 'g.id')
            ->leftJoin('public.camp as h', 'a.camp_id', '=', 'h.id')
            ->select(
                'a.id',
                'a.date',
                'e.full_name AS educator_name',
                'a.patient_name',
                'a.mobile_number',
                'a.gender',
                'a.age',
                'c.height',
                'c.weight',
                'a.cipla_brand_prescribed',
                'h.camp_id',
                'g.name as doctor_name',
                'a.consent_form_file',
                'a.prescription_file'
            )
            ->where('a.digital_educator_id', $user_id)
            ->whereNotNull('a.patient_name')
            ->where('a.patient_enrolled', '=', 'Yes')
            ->whereNotNull('a.prescription_file')
            ->whereNotNull('a.consent_form_file')
            ->where('a.cipla_brand_prescribed', '=', 'Yes')
            ->where('a.approved_status', '=', 'Approved')
            ->orderByDesc('a.id')
            ->get();

        // Step 3: Filter out patients with DND/Dropout remarks
        $filteredPatients = $patients->filter(function ($patient) use ($followupTables, $dndOrDropoutConditions) {
            // Get latest day from feedback_submitted
            $maxDay = DB::table('public.feedback_submitted')
                ->where('patient_id', $patient->id)
                ->max(DB::raw('CAST(day AS INTEGER)'));

            if (!$maxDay || !isset($followupTables[$maxDay])) {
                return true; // Include patient (no valid feedback or followup found)
            }

            $tableInfo = $followupTables[$maxDay];

            $followup = DB::table("public.{$tableInfo['table']}")
                ->where('patient_id', $patient->id)
                ->first();

            if (!$followup) {
                return true; // Include patient (no followup record)
            }

            $callRemark = $followup->{$tableInfo['call_col']} ?? null;
            $norespRemark = $followup->{$tableInfo['noresp_col']} ?? null;

            // Exclude if DND / Dropout
            return !(
                in_array($callRemark, $dndOrDropoutConditions) ||
                $norespRemark === 'Drop out'
            );
        })->values(); // Reset keys

        return response()->json([
            'data' => $filteredPatients
        ]);
    }


    public function day3followup(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer',
            'patient_id' => 'required|integer',
            'day3_meds' => 'nullable|string',
            'day3_meds_reason' => 'nullable|string',
            'day3_sugar' => 'nullable|string',
            'day3_sugar_reason' => 'nullable|string',
            'day3_bp' => 'nullable|string',
            'day3_bp_reason' => 'nullable|string',
            'day3_fluid' => 'nullable|string',
            'day3_fluid_reason' => 'nullable|string',
            'day3_support' => 'nullable|array',
            'ae_report' => 'nullable|string',
            'callremark_3' => 'nullable|string',
            'callconnect_subremark_3' => 'nullable|string',
            'noresponse_subremark_3' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Convert support array to comma-separated string
            $day3_support = $request->has('day3_support')
                ? implode(',', $request->input('day3_support'))
                : null;
            $existing = Day3Followup::where('id', $request->id)->first();

            if ($existing) {
                // Update
                $existing->update([
                    'day3_meds' => $request->day3_meds,
                    'day3_meds_reason' => $request->day3_meds_reason,
                    'day3_sugar' => $request->day3_sugar,
                    'day3_sugar_reason' => $request->day3_sugar_reason,
                    'day3_bp' => $request->day3_bp,
                    'day3_bp_reason' => $request->day3_bp_reason,
                    'day3_fluid' => $request->day3_fluid,
                    'day3_fluid_reason' => $request->day3_fluid_reason,
                    'day3_support' => $day3_support,
                    'ae_report' => $request->ae_report,
                    'callremark_3' => $request->callremark_3,
                    'callconnect_subremark_3' => $request->callconnect_subremark_3,
                    'noresponse_subremark_3' => $request->noresponse_subremark_3,
                ]);
                $message = 'Day 3 follow-up updated successfully';
            } else {
                // Insert into day3_followup
                $day3 = Day3Followup::create([
                    'patient_id' => $request->patient_id,
                    'day3_meds' => $request->day3_meds,
                    'day3_meds_reason' => $request->day3_meds_reason,
                    'day3_sugar' => $request->day3_sugar,
                    'day3_sugar_reason' => $request->day3_sugar_reason,
                    'day3_bp' => $request->day3_bp,
                    'day3_bp_reason' => $request->day3_bp_reason,
                    'day3_fluid' => $request->day3_fluid,
                    'day3_fluid_reason' => $request->day3_fluid_reason,
                    'day3_support' => $day3_support,
                    'ae_report' => $request->ae_report,
                    'callremark_3' => $request->callremark_3,
                    'callconnect_subremark_3' => $request->callconnect_subremark_3,
                    'noresponse_subremark_3' => $request->noresponse_subremark_3,
                ]);

                // Insert into feedback_submitted
                DB::table('public.feedback_submitted')->insert([
                    'day' => 3,
                    'patient_id' => $request->patient_id,
                ]);
                $message = 'Day 3 follow-up submitted successfully';
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => $message,

            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to submit Day 3 follow-up',
                'error' => $e->getMessage()
            ]);
        }
    }
    public function day7followup(Request $request)
    {
        // Your validation rules are correct and remain the same.
        $request->validate([
            'id' => 'nullable|integer',
            'patient_id' => 'required|integer',
            'day7_meds' => 'nullable|string',
            'day7_meds_reason' => 'nullable|string',
            'day7_doctor' => 'nullable|string',
            'day7_doctor_reason' => 'nullable|string',
            'day7_bp' => 'nullable|string',
            'day7_bp_value' => 'nullable|string',
            'day7_bp_remarks' => 'nullable|string',
            'day7_weight' => 'nullable|string',
            'day7_breathless' => 'nullable|string',
            'day7_yoga_schedule' => 'nullable|string',
            'day7_yoga_schedule_reason' => 'nullable|string',
            'day7_yoga_tried' => 'nullable|string',
            'day7_yoga_difficult' => 'nullable|string',
            'day7_yoga_difficult_reason' => 'nullable|string',
            'day7_yoga_required' => 'nullable|string',
            'day7_yoga_planned_date' => 'nullable|string',
            'day7_yoga_required_reason' => 'nullable|string',
            'callremark_7' => 'nullable|string',
            'day7_ae_report' => 'nullable|string',
            'callconnect_subremark_7' => 'nullable|string',
            'noresponse_subremark_7' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $followUpData = [
                'patient_id' => $request->patient_id,
                'day7_meds' => $request->day7_meds,
                'day7_meds_reason' => $request->day7_meds_reason,
                'day7_doctor' => $request->day7_doctor,
                'day7_doctor_reason' => $request->day7_doctor_reason,
                'day7_bp' => $request->day7_bp,
                'day7_bp_value' => $request->day7_bp_value,
                'day7_bp_remarks' => $request->day7_bp_remarks,
                'day7_weight' => $request->day7_weight,
                'day7_breathless' => $request->day7_breathless,
                'day7_yoga_schedule' => $request->day7_yoga_schedule,
                'day7_yoga_schedule_reason' => $request->day7_yoga_schedule_reason,
                'day7_yoga_tried' => $request->day7_yoga_tried,
                'day7_yoga_difficult' => $request->day7_yoga_difficult,
                'day7_yoga_difficult_reason' => $request->day7_yoga_difficult_reason,
                'day7_yoga_required' => $request->day7_yoga_required,
                'day7_yoga_planned_date' => $request->day7_yoga_planned_date,
                'day7_yoga_required_reason' => $request->day7_yoga_required_reason,
                'day7_ae_report' => $request->day7_ae_report,
                'callremark_7' => $request->callremark_7,
                'callconnect_subremark_7' => $request->callconnect_subremark_7,
                'noresponse_subremark_7' => $request->noresponse_subremark_7,
                'updated_at' => now(), // Always set the updated timestamp
            ];

            if ($request->filled('id')) {
                // UPDATE existing record
                DB::table('public.day7_followup')
                    ->where('id', $request->id)
                    ->update($followUpData + ['updated_at' => now()]);
            } else {
                // INSERT new record
                DB::table('public.day7_followup')
                    ->insert($followUpData + ['created_at' => now(), 'updated_at' => now()]);
            }
            // Also use updateOrInsert for the feedback table to avoid duplicates.
            DB::table('public.feedback_submitted')->updateOrInsert(
                ['day' => 7, 'patient_id' => $request->patient_id]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Day 7 follow-up saved successfully',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to save Day 7 follow-up',
                'error' => $e->getMessage()
            ]);
        }
    }
    public function day15followup(Request $request)
    {
        // Validation: Added 'id' to allow for updates.
        $request->validate([
            'id' => 'nullable|integer',
            'patient_id' => 'required|integer',
            'day15_meds' => 'nullable|string',
            'day15_meds_reason' => 'nullable|string',
            'day15_stock' => 'nullable|string',
            'day15_changes' => 'nullable|string',
            'day15_bp' => 'nullable|string',
            'day15_bp_value' => 'nullable|string',
            'day15_weight' => 'nullable|string',
            'day15_rbs' => 'nullable|string',
            'day15_rbs_value' => 'nullable|string',
            'day15_rbs_reason' => 'nullable|string',
            'day15_fluid' => 'nullable|string',
            'day15_urine' => 'nullable|string',
            'day15_breathless' => 'nullable|string',
            'day15_yoga' => 'nullable|string',
            'day15_yoga_reason' => 'nullable|string',
            'day15_ae_report' => 'nullable|string',
            'callremark_15' => 'nullable|string',
            'callconnect_subremark_15' => 'nullable|string',
            'noresponse_subremark_15' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Prepare the data for insertion or update to keep the code DRY.
            $followUpData = [
                'patient_id' => $request->patient_id,
                'day15_meds' => $request->day15_meds,
                'day15_meds_reason' => $request->day15_meds_reason,
                'day15_stock' => $request->day15_stock,
                'day15_changes' => $request->day15_changes,
                'day15_bp' => $request->day15_bp,
                'day15_bp_value' => $request->day15_bp_value,
                'day15_weight' => $request->day15_weight,
                'day15_rbs' => $request->day15_rbs,
                'day15_rbs_value' => $request->day15_rbs_value,
                'day15_rbs_reason' => $request->day15_rbs_reason,
                'day15_fluid' => $request->day15_fluid,
                'day15_urine' => $request->day15_urine,
                'day15_breathless' => $request->day15_breathless,
                'day15_yoga' => $request->day15_yoga,
                'day15_yoga_reason' => $request->day15_yoga_reason,
                'day15_ae_report' => $request->day15_ae_report,
                'callremark_15' => $request->callremark_15,
                'callconnect_subremark_15' => $request->callconnect_subremark_15,
                'noresponse_subremark_15' => $request->noresponse_subremark_15,
                'updated_at' => now(), // Set the updated timestamp
            ];

            // Use updateOrInsert to create or update the record in one step.
            if ($request->filled('id')) {
                // UPDATE existing record
                DB::table('public.day15_followup')
                    ->where('id', $request->id)
                    ->update($followUpData + ['updated_at' => now()]);
            } else {
                // INSERT new record
                DB::table('public.day15_followup')
                    ->insert($followUpData + ['created_at' => now(), 'updated_at' => now()]);
            }

            // Use updateOrInsert for the feedback table to avoid duplicate entries.
            DB::table('public.feedback_submitted')->updateOrInsert(
                ['day' => 15, 'patient_id' => $request->patient_id]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Day 15 follow-up saved successfully',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to save Day 15 follow-up',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function day30followup(Request $request)
    {
        // Validation: Added 'id' to allow for updates.
        $request->validate([
            'id' => 'nullable|integer',
            'patient_id' => 'required|integer',
            'day30_meds' => 'nullable|string',
            'day30_meds_reason' => 'nullable|string',
            'day30_stock' => 'nullable|string',
            'day30_changes' => 'nullable|string',
            'day30_bp' => 'nullable|string',
            'day30_bp_value' => 'nullable|string',
            'day30_weight' => 'nullable|string',
            'day30_rbs' => 'nullable|string',
            'day30_rbs_value' => 'nullable|string',
            'day30_rbs_reason' => 'nullable|string',
            'day30_fluid' => 'nullable|string',
            'day30_urine' => 'nullable|string',
            'day30_breathless' => 'nullable|string',
            'day30_yoga' => 'nullable|string',
            'day30_yoga_reason' => 'nullable|string',
            'day30_ae_report' => 'nullable|string',
            'callremark_30' => 'nullable|string',
            'callconnect_subremark_30' => 'nullable|string',
            'noresponse_subremark_30' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Prepare the common data for both create and update.
            $followUpData = [
                'patient_id' => $request->patient_id,
                'day30_meds' => $request->day30_meds,
                'day30_meds_reason' => $request->day30_meds_reason,
                'day30_stock' => $request->day30_stock,
                'day30_changes' => $request->day30_changes,
                'day30_bp' => $request->day30_bp,
                'day30_bp_value' => $request->day30_bp_value,
                'day30_weight' => $request->day30_weight,
                'day30_rbs' => $request->day30_rbs,
                'day30_rbs_value' => $request->day30_rbs_value,
                'day30_rbs_reason' => $request->day30_rbs_reason,
                'day30_fluid' => $request->day30_fluid,
                'day30_urine' => $request->day30_urine,
                'day30_breathless' => $request->day30_breathless,
                'day30_yoga' => $request->day30_yoga,
                'day30_yoga_reason' => $request->day30_yoga_reason,
                'day30_ae_report' => $request->day30_ae_report,
                'callremark_30' => $request->callremark_30,
                'callconnect_subremark_30' => $request->callconnect_subremark_30,
                'noresponse_subremark_30' => $request->noresponse_subremark_30,
            ];

            // Check if an ID exists in the request to determine action.
            if ($request->filled('id')) {
                // If ID exists, UPDATE the existing record.
                DB::table('public.day30_followup')
                    ->where('id', $request->id)
                    ->update($followUpData + ['updated_at' => now()]);
            } else {
                // If no ID, INSERT a new record.
                DB::table('public.day30_followup')
                    ->insert($followUpData + ['created_at' => now(), 'updated_at' => now()]);
            }

            // Use updateOrInsert for the feedback table to prevent duplicates.
            DB::table('public.feedback_submitted')->updateOrInsert(
                ['day' => 30, 'patient_id' => $request->patient_id]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Day 30 follow-up saved successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to save Day 30 follow-up',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function day45followup(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer',
            'patient_id' => 'required|integer',
            'day45_meds' => 'nullable|string',
            'day45_meds_reason' => 'nullable|string',
            'day45_doctor' => 'nullable|string',
            'day45_doctor_reason' => 'nullable|string',
            'day45_bp' => 'nullable|string',
            'day45_bp_value' => 'nullable|string',
            'day45_bp_remarks' => 'nullable|string',
            'day45_weight' => 'nullable|string',
            'day45_breathless' => 'nullable|string',
            'day45_yoga_schedule' => 'nullable|string',
            'day45_yoga_schedule_reason' => 'nullable|string',
            'day45_yoga_tried' => 'nullable|string',
            'day45_yoga_difficult' => 'nullable|string',
            'day45_yoga_difficult_reason' => 'nullable|string',
            'day45_yoga_required' => 'nullable|string',
            'day45_yoga_planned_date' => 'nullable|string',
            'day45_yoga_required_reason' => 'nullable|string',
            'day45_ae_report' => 'nullable|string',
            'callremark_45' => 'nullable|string',
            'callconnect_subremark_45' => 'nullable|string',
            'noresponse_subremark_45' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $followUpData = [
                'patient_id' => $request->patient_id,
                'day45_meds' => $request->day45_meds,
                'day45_meds_reason' => $request->day45_meds_reason,
                'day45_doctor' => $request->day45_doctor,
                'day45_doctor_reason' => $request->day45_doctor_reason,
                'day45_bp' => $request->day45_bp,
                'day45_bp_value' => $request->day45_bp_value,
                'day45_bp_remarks' => $request->day45_bp_remarks,
                'day45_weight' => $request->day45_weight,
                'day45_breathless' => $request->day45_breathless,
                'day45_yoga_schedule' => $request->day45_yoga_schedule,
                'day45_yoga_schedule_reason' => $request->day45_yoga_schedule_reason,
                'day45_yoga_tried' => $request->day45_yoga_tried,
                'day45_yoga_difficult' => $request->day45_yoga_difficult,
                'day45_yoga_difficult_reason' => $request->day45_yoga_difficult_reason,
                'day45_yoga_required' => $request->day45_yoga_required,
                'day45_yoga_planned_date' => $request->day45_yoga_planned_date,
                'day45_yoga_required_reason' => $request->day45_yoga_required_reason,
                'day45_ae_report' => $request->day45_ae_report,
                'callremark_45' => $request->callremark_45,
                'callconnect_subremark_45' => $request->callconnect_subremark_45,
                'noresponse_subremark_45' => $request->noresponse_subremark_45,
            ];

            if ($request->filled('id')) {
                DB::table('public.day45_followup')
                    ->where('id', $request->id)
                    ->update($followUpData + ['updated_at' => now()]);
            } else {
                DB::table('public.day45_followup')
                    ->insert($followUpData + ['created_at' => now(), 'updated_at' => now()]);
            }

            DB::table('public.feedback_submitted')->updateOrInsert(
                ['day' => 45, 'patient_id' => $request->patient_id]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Day 45 follow-up saved successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to save Day 45 follow-up',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function day60followup(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer',
            'patient_id' => 'required|integer',
            'day60_meds' => 'nullable|string',
            'day60_meds_reason' => 'nullable|string',
            'day60_bp' => 'nullable|string',
            'day60_bp_value' => 'nullable|string',
            'day60_rbs' => 'nullable|string',
            'day60_rbs_value' => 'nullable|string',
            'day60_weight' => 'nullable|string',
            'day60_hba1c' => 'nullable|string',
            'day60_hba1c_value' => 'nullable|string',
            'day60_hba1c_last' => 'nullable|string',
            'day60_challenges' => 'nullable|string',
            'day60_challenges_reason' => 'nullable|string',
            'day60_monitor' => 'nullable|string',
            'day60_monitor_reason' => 'nullable|string',
            'day60_water' => 'nullable|string',
            'day60_urine' => 'nullable|string',
            'day60_questions' => 'nullable|string',
            'day60_help' => 'nullable|string',
            'day60_doctor' => 'nullable|string',
            'day60_doctor_reason' => 'nullable|string',
            'day60_yoga_remark' => 'nullable|string',
            'day60_ae_report' => 'nullable|string',
            'callremark_60' => 'nullable|string',
            'callconnect_subremark_60' => 'nullable|string',
            'noresponse_subremark_60' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $followUpData = [
                'patient_id' => $request->patient_id,
                'day60_meds' => $request->day60_meds,
                'day60_meds_reason' => $request->day60_meds_reason,
                'day60_bp' => $request->day60_bp,
                'day60_bp_value' => $request->day60_bp_value,
                'day60_rbs' => $request->day60_rbs,
                'day60_rbs_value' => $request->day60_rbs_value,
                'day60_weight' => $request->day60_weight,
                'day60_hba1c' => $request->day60_hba1c,
                'day60_hba1c_value' => $request->day60_hba1c_value,
                'day60_hba1c_last' => $request->day60_hba1c_last,
                'day60_challenges' => $request->day60_challenges,
                'day60_challenges_reason' => $request->day60_challenges_reason,
                'day60_monitor' => $request->day60_monitor,
                'day60_monitor_reason' => $request->day60_monitor_reason,
                'day60_water' => $request->day60_water,
                'day60_urine' => $request->day60_urine,
                'day60_questions' => $request->day60_questions,
                'day60_help' => $request->day60_help,
                'day60_doctor' => $request->day60_doctor,
                'day60_doctor_reason' => $request->day60_doctor_reason,
                'day60_yoga_remark' => $request->day60_yoga_remark,
                'day60_ae_report' => $request->day60_ae_report,
                'callremark_60' => $request->callremark_60,
                'callconnect_subremark_60' => $request->callconnect_subremark_60,
                'noresponse_subremark_60' => $request->noresponse_subremark_60,
            ];

            if ($request->filled('id')) {
                DB::table('public.day60_followup')
                    ->where('id', $request->id)
                    ->update($followUpData + ['updated_at' => now()]);
            } else {
                DB::table('public.day60_followup')
                    ->insert($followUpData + ['created_at' => now(), 'updated_at' => now()]);
            }

            DB::table('public.feedback_submitted')->updateOrInsert(
                ['day' => 60, 'patient_id' => $request->patient_id]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Day 60 follow-up saved successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to save Day 60 follow-up',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function day90followup(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer',
            'patient_id' => 'required|integer',
            'day90_meds' => 'nullable|string',
            'day90_meds_reason' => 'nullable|string',
            'day90_doctor' => 'nullable|string',
            'day90_doctor_reason' => 'nullable|string',
            'day90_bp' => 'nullable|string',
            'day90_bp_value' => 'nullable|string',
            'day90_bp_remarks' => 'nullable|string',
            'day90_weight' => 'nullable|string',
            'day90_breathless' => 'nullable|string',
            'day90_yoga_schedule' => 'nullable|string',
            'day90_yoga_schedule_reason' => 'nullable|string',
            'day90_yoga_tried' => 'nullable|string',
            'day90_yoga_difficult' => 'nullable|string',
            'day90_yoga_difficult_reason' => 'nullable|string',
            'day90_yoga_required' => 'nullable|string',
            'day90_yoga_planned_date' => 'nullable|string',
            'day90_yoga_required_reason' => 'nullable|string',
            'day90_ae_report' => 'nullable|string',
            'callremark_90' => 'nullable|string',
            'callconnect_subremark_90' => 'nullable|string',
            'noresponse_subremark_90' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $followUpData = [
                'patient_id' => $request->patient_id,
                'day90_meds' => $request->day90_meds,
                'day90_meds_reason' => $request->day90_meds_reason,
                'day90_doctor' => $request->day90_doctor,
                'day90_doctor_reason' => $request->day90_doctor_reason,
                'day90_bp' => $request->day90_bp,
                'day90_bp_value' => $request->day90_bp_value,
                'day90_bp_remarks' => $request->day90_bp_remarks,
                'day90_weight' => $request->day90_weight,
                'day90_breathless' => $request->day90_breathless,
                'day90_yoga_schedule' => $request->day90_yoga_schedule,
                'day90_yoga_schedule_reason' => $request->day90_yoga_schedule_reason,
                'day90_yoga_tried' => $request->day90_yoga_tried,
                'day90_yoga_difficult' => $request->day90_yoga_difficult,
                'day90_yoga_difficult_reason' => $request->day90_yoga_difficult_reason,
                'day90_yoga_required' => $request->day90_yoga_required,
                'day90_yoga_planned_date' => $request->day90_yoga_planned_date,
                'day90_yoga_required_reason' => $request->day90_yoga_required_reason,
                'day90_ae_report' => $request->day90_ae_report,
                'callremark_90' => $request->callremark_90,
                'callconnect_subremark_90' => $request->callconnect_subremark_90,
                'noresponse_subremark_90' => $request->noresponse_subremark_90,
            ];

            if ($request->filled('id')) {
                DB::table('public.day90_followup')
                    ->where('id', $request->id)
                    ->update($followUpData + ['updated_at' => now()]);
            } else {
                DB::table('public.day90_followup')
                    ->insert($followUpData + ['created_at' => now(), 'updated_at' => now()]);
            }

            DB::table('public.feedback_submitted')->updateOrInsert(
                ['day' => 90, 'patient_id' => $request->patient_id]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Day 90 follow-up saved successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to save Day 90 follow-up',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function day120followup(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer',
            'patient_id' => 'required|integer',
            'day120_meds' => 'nullable|string',
            'day120_meds_reason' => 'nullable|string',
            'day120_bp' => 'nullable|string',
            'day120_bp_value' => 'nullable|string',
            'day120_rbs' => 'nullable|string',
            'day120_rbs_value' => 'nullable|string',
            'day120_weight' => 'nullable|string',
            'day120_hba1c' => 'nullable|string',
            'day120_hba1c_value' => 'nullable|string',
            'day120_hba1c_last' => 'nullable|string',
            'day120_challenges' => 'nullable|string',
            'day120_challenges_reason' => 'nullable|string',
            'day120_monitor' => 'nullable|string',
            'day120_monitor_reason' => 'nullable|string',
            'day120_water' => 'nullable|string',
            'day120_urine' => 'nullable|string',
            'day120_questions' => 'nullable|string',
            'day120_help' => 'nullable|string',
            'day120_doctor' => 'nullable|string',
            'day120_doctor_reason' => 'nullable|string',
            'day120_yoga_remark' => 'nullable|string',
            'day120_ae_report' => 'nullable|string',
            'callremark_120' => 'nullable|string',
            'callconnect_subremark_120' => 'nullable|string',
            'noresponse_subremark_120' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $followUpData = [
                'patient_id' => $request->patient_id,
                'day120_meds' => $request->day120_meds,
                'day120_meds_reason' => $request->day120_meds_reason,
                'day120_bp' => $request->day120_bp,
                'day120_bp_value' => $request->day120_bp_value,
                'day120_rbs' => $request->day120_rbs,
                'day120_rbs_value' => $request->day120_rbs_value,
                'day120_weight' => $request->day120_weight,
                'day120_hba1c' => $request->day120_hba1c,
                'day120_hba1c_value' => $request->day120_hba1c_value,
                'day120_hba1c_last' => $request->day120_hba1c_last,
                'day120_challenges' => $request->day120_challenges,
                'day120_challenges_reason' => $request->day120_challenges_reason,
                'day120_monitor' => $request->day120_monitor,
                'day120_monitor_reason' => $request->day120_monitor_reason,
                'day120_water' => $request->day120_water,
                'day120_urine' => $request->day120_urine,
                'day120_questions' => $request->day120_questions,
                'day120_help' => $request->day120_help,
                'day120_doctor' => $request->day120_doctor,
                'day120_doctor_reason' => $request->day120_doctor_reason,
                'day120_yoga_remark' => $request->day120_yoga_remark,
                'day120_ae_report' => $request->day120_ae_report,
                'callremark_120' => $request->callremark_120,
                'callconnect_subremark_120' => $request->callconnect_subremark_120,
                'noresponse_subremark_120' => $request->noresponse_subremark_120,
            ];

            if ($request->filled('id')) {
                DB::table('public.day120_followup')
                    ->where('id', $request->id)
                    ->update($followUpData + ['updated_at' => now()]);
            } else {
                DB::table('public.day120_followup')
                    ->insert($followUpData + ['created_at' => now(), 'updated_at' => now()]);
            }

            DB::table('public.feedback_submitted')->updateOrInsert(
                ['day' => 120, 'patient_id' => $request->patient_id]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Day 120 follow-up saved successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to save Day 120 follow-up',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function day150followup(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer',
            'patient_id' => 'required|integer',
            'day150_meds' => 'nullable|string',
            'day150_meds_reason' => 'nullable|string',
            'day150_stock' => 'nullable|string',
            'day150_changes' => 'nullable|string',
            'day150_bp' => 'nullable|string',
            'day150_bp_value' => 'nullable|string',
            'day150_weight' => 'nullable|string',
            'day150_rbs' => 'nullable|string',
            'day150_rbs_value' => 'nullable|string',
            'day150_rbs_reason' => 'nullable|string',
            'day150_fluid' => 'nullable|string',
            'day150_urine' => 'nullable|string',
            'day150_breathless' => 'nullable|string',
            'day150_yoga' => 'nullable|string',
            'day150_yoga_reason' => 'nullable|string',
            'day150_ae_report' => 'nullable|string',
            'callremark_150' => 'nullable|string',
            'callconnect_subremark_150' => 'nullable|string',
            'noresponse_subremark_150' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $followUpData = [
                'patient_id' => $request->patient_id,
                'day150_meds' => $request->day150_meds,
                'day150_meds_reason' => $request->day150_meds_reason,
                'day150_stock' => $request->day150_stock,
                'day150_changes' => $request->day150_changes,
                'day150_bp' => $request->day150_bp,
                'day150_bp_value' => $request->day150_bp_value,
                'day150_weight' => $request->day150_weight,
                'day150_rbs' => $request->day150_rbs,
                'day150_rbs_value' => $request->day150_rbs_value,
                'day150_rbs_reason' => $request->day150_rbs_reason,
                'day150_fluid' => $request->day150_fluid,
                'day150_urine' => $request->day150_urine,
                'day150_breathless' => $request->day150_breathless,
                'day150_yoga' => $request->day150_yoga,
                'day150_yoga_reason' => $request->day150_yoga_reason,
                'day150_ae_report' => $request->day150_ae_report,
                'callremark_150' => $request->callremark_150,
                'callconnect_subremark_150' => $request->callconnect_subremark_150,
                'noresponse_subremark_150' => $request->noresponse_subremark_150,
            ];

            if ($request->filled('id')) {
                DB::table('public.day150_followup')
                    ->where('id', $request->id)
                    ->update($followUpData + ['updated_at' => now()]);
            } else {
                DB::table('public.day150_followup')
                    ->insert($followUpData + ['created_at' => now(), 'updated_at' => now()]);
            }

            DB::table('public.feedback_submitted')->updateOrInsert(
                ['day' => 150, 'patient_id' => $request->patient_id]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Day 150 follow-up saved successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to save Day 150 follow-up',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function day180followup(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer',
            'patient_id' => 'required|integer',
            'feeling_now' => 'nullable|string',
            'yoga_helpful' => 'nullable|string',
            'yoga_feedback' => 'nullable|string',
            'instructor_support' => 'nullable|string',
            'instructor_feedback' => 'nullable|string',
            'diet_impact' => 'nullable|string',
            'diet_feedback' => 'nullable|string',
            'dietician_access' => 'nullable|string',
            'dietician_feedback' => 'nullable|string',
            'overall_experience' => 'nullable|string',
            'experience_remarks' => 'nullable|string',
            'final_feedback' => 'nullable|string',
            'day180_ae_report' => 'nullable|string',
            'callremark_180' => 'nullable|string',
            'callconnect_subremark_180' => 'nullable|string',
            'noresponse_subremark_180' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $followUpData = [
                'patient_id' => $request->patient_id,
                'feeling_now' => $request->feeling_now,
                'yoga_helpful' => $request->yoga_helpful,
                'yoga_feedback' => $request->yoga_feedback,
                'instructor_support' => $request->instructor_support,
                'instructor_feedback' => $request->instructor_feedback,
                'diet_impact' => $request->diet_impact,
                'diet_feedback' => $request->diet_feedback,
                'dietician_access' => $request->dietician_access,
                'dietician_feedback' => $request->dietician_feedback,
                'overall_experience' => $request->overall_experience,
                'experience_remarks' => $request->experience_remarks,
                'final_feedback' => $request->final_feedback,
                'day180_ae_report' => $request->day180_ae_report,
                'callremark_180' => $request->callremark_180,
                'callconnect_subremark_180' => $request->callconnect_subremark_180,
                'noresponse_subremark_180' => $request->noresponse_subremark_180,
            ];

            if ($request->filled('id')) {
                DB::table('public.day180_followup')
                    ->where('id', $request->id)
                    ->update($followUpData + ['updated_at' => now()]);
            } else {
                DB::table('public.day180_followup')
                    ->insert($followUpData + ['created_at' => now(), 'updated_at' => now()]);
            }

            DB::table('public.feedback_submitted')->updateOrInsert(
                ['day' => 180, 'patient_id' => $request->patient_id]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Day 180 follow-up saved successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to save Day 180 follow-up',
                'error' => $e->getMessage(),
            ]);
        }
    }
    public function getMaxDay($patientId)
    {
        $maxDay = DB::table('public.feedback_submitted')
            ->where('patient_id', $patientId)
            ->max('day');

        // mapping of day => table and columns
        $followupTables = [
            3 => ['table' => 'day3_followup', 'call_col' => 'callconnect_subremark_3', 'noresp_col' => 'noresponse_subremark_3'],
            7 => ['table' => 'day7_followup', 'call_col' => 'callconnect_subremark_7', 'noresp_col' => 'noresponse_subremark_7'],
            15 => ['table' => 'day15_followup', 'call_col' => 'callconnect_subremark_15', 'noresp_col' => 'noresponse_subremark_15'],
            30 => ['table' => 'day30_followup', 'call_col' => 'callconnect_subremark_30', 'noresp_col' => 'noresponse_subremark_30'],
            45 => ['table' => 'day45_followup', 'call_col' => 'callconnect_subremark_45', 'noresp_col' => 'noresponse_subremark_45'],
            60 => ['table' => 'day60_followup', 'call_col' => 'callconnect_subremark_60', 'noresp_col' => 'noresponse_subremark_60'],
            90 => ['table' => 'day90_followup', 'call_col' => 'callconnect_subremark_90', 'noresp_col' => 'noresponse_subremark_90'],
            120 => ['table' => 'day120_followup', 'call_col' => 'callconnect_subremark_120', 'noresp_col' => 'noresponse_subremark_120'],
            150 => ['table' => 'day150_followup', 'call_col' => 'callconnect_subremark_150', 'noresp_col' => 'noresponse_subremark_150'],
            180 => ['table' => 'day180_followup', 'call_col' => 'callconnect_subremark_180', 'noresp_col' => 'noresponse_subremark_180'],
        ];

        // return if maxDay doesn't exist in mapping
        if (!isset($followupTables[$maxDay])) {
            return response()->json(['max_day' => $maxDay]);
        }

        $info = $followupTables[$maxDay];

        $data = DB::table($info['table'])
            ->where('patient_id', $patientId)
            ->first();

        if ($data) {
            $callconnectSubremark = $data->{$info['call_col']} ?? null;
            $noresponseSubremark = $data->{$info['noresp_col']} ?? null;

            $dndOrDropoutConditions = [
                'DND the Patient',
                'Wrong Number – DND the Patient',
                'Dropout',
            ];

            $disable = in_array($callconnectSubremark, $dndOrDropoutConditions)
                || $noresponseSubremark === 'Drop out';

            if ($disable) {
                return response()->json([
                    'max_day' => $maxDay,
                    "disableDay{$maxDay}" => 'YES'
                ]);
            }
        }

        return response()->json(['max_day' => $maxDay]);
    }


    public function day3followupget($patient_id)
    {
        $data = DB::table('day3_followup') // <-- replace with your actual table
            ->where('patient_id', $patient_id)
            ->first();

        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No record found'
        ]);
    }
    public function day7followupget($patient_id)
    {
        $data = DB::table('day7_followup') // <-- replace with your actual table
            ->where('patient_id', $patient_id)
            ->first();

        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No record found'
        ]);
    }
    public function day15followupget($patient_id)
    {
        $data = DB::table('day15_followup') // <-- replace with your actual table
            ->where('patient_id', $patient_id)
            ->first();

        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No record found'
        ]);
    }
    public function day30followupget($patient_id)
    {
        $data = DB::table('day30_followup') // <-- replace with your actual table
            ->where('patient_id', $patient_id)
            ->first();

        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No record found'
        ]);
    }
    public function day45followupget($patient_id)
    {
        $data = DB::table('day45_followup') // <-- replace with your actual table
            ->where('patient_id', $patient_id)
            ->first();

        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No record found'
        ]);
    }
    public function day60followupget($patient_id)
    {
        $data = DB::table('day60_followup') // <-- replace with your actual table
            ->where('patient_id', $patient_id)
            ->first();

        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No record found'
        ]);
    }
    public function day90followupget($patient_id)
    {
        $data = DB::table('day90_followup') // <-- replace with your actual table
            ->where('patient_id', $patient_id)
            ->first();

        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No record found'
        ]);
    }
    public function day120followupget($patient_id)
    {
        $data = DB::table('day120_followup') // <-- replace with your actual table
            ->where('patient_id', $patient_id)
            ->first();

        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No record found'
        ]);
    }
    public function day150followupget($patient_id)
    {
        $data = DB::table('day150_followup') // <-- replace with your actual table
            ->where('patient_id', $patient_id)
            ->first();

        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No record found'
        ]);
    }
    public function day180followupget($patient_id)
    {
        $data = DB::table('day180_followup') // <-- replace with your actual table
            ->where('patient_id', $patient_id)
            ->first();

        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No record found'
        ]);
    }
    public function digitalPatientReport(Request $request)
    {
        return view('digitaleducator.digifeedbackReport');
    }
     public function getEducatorsname(Request $request)
    {
        // Check session (replace with Laravel auth check if needed)
        if (!session()->has('emp_id')) {
            return response()->json(['error' => 'Session expired'], 401);
        }

        $digital_educator_id=Auth::user()->id;
        try {
            $educators = DB::table('common.users')
                ->where('role', 'educator')
                ->where('digital_educator_id',$digital_educator_id)
                ->select('id', 'full_name')
                ->get();

            return response()->json($educators);
        } catch (\Exception $e) {
            Log::error('Get Educators Name Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
      public function getFeedbackDetails(Request $request)
    {
        if (!session()->has('emp_id')) {
            return response()->json(['error' => 'Session expired'], 401);
        }

        try {
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $digitalEducatorId = Auth::user()->id;
            $educatorId = $request->input('educatorId');

            $query = DB::table('public.patient_details as a')
                ->leftJoin('public.doctor as b', DB::raw('a.hcp_id::int'), '=', 'b.id')
                ->leftJoin('common.users as c', function ($join) {
                    $join->on(DB::raw('c.id'), '=', DB::raw('a.educator_id::int'))->where('c.role', '=', 'educator');
                })
                ->leftJoin('common.users as d', function ($join) {
                    $join->on(DB::raw('d.id'), '=', DB::raw('a.digital_educator_id::int'))->where('d.role', '=', 'digitaleducator');
                })
                ->leftJoin('public.feedback_submitted as e', DB::raw('a.id'), '=', DB::raw('e.patient_id::int'))
                ->leftJoin('public.day3_followup as o', DB::raw('o.patient_id'), '=', DB::raw('e.patient_id::int'))
                ->leftJoin('public.day7_followup as f', DB::raw('f.patient_id'), '=', DB::raw('e.patient_id::int'))
                ->leftJoin('public.day15_followup as g', DB::raw('g.patient_id'), '=', DB::raw('e.patient_id::int'))
                ->leftJoin('public.day30_followup as h', DB::raw('h.patient_id'), '=', DB::raw('e.patient_id::int'))
                ->leftJoin('public.day45_followup as i', DB::raw('i.patient_id'), '=', DB::raw('e.patient_id::int'))
                ->leftJoin('public.day60_followup as j', DB::raw('j.patient_id'), '=', DB::raw('e.patient_id::int'))
                ->leftJoin('public.day90_followup as k', DB::raw('k.patient_id'), '=', DB::raw('e.patient_id::int'))
                ->leftJoin('public.day120_followup as l', DB::raw('l.patient_id'), '=', DB::raw('e.patient_id::int'))
                ->leftJoin('public.day150_followup as m', DB::raw('m.patient_id'), '=', DB::raw('e.patient_id::int'))
                ->leftJoin('public.day180_followup as n', DB::raw('n.patient_id'), '=', DB::raw('e.patient_id::int'))
                ->where('a.patient_enrolled', '=', 'Yes')
                ->where('a.approved_status', '=', 'Approved')
                ->where(function ($q) {
                    $q->whereNotNull('a.prescription_file')->orWhereNotNull('a.consent_form_file');
                });

            // Apply filters
            if (!empty($fromDate) && !empty($toDate)) {
                $query->where(function ($q) use ($fromDate, $toDate) {
                    $q->whereBetween('o.created_at', [$fromDate, $toDate])
                        ->orWhereBetween('f.created_at', [$fromDate, $toDate])
                        ->orWhereBetween('g.created_at', [$fromDate, $toDate])
                        ->orWhereBetween('h.created_at', [$fromDate, $toDate])
                        ->orWhereBetween('i.created_at', [$fromDate, $toDate])
                        ->orWhereBetween('j.created_at', [$fromDate, $toDate])
                        ->orWhereBetween('k.created_at', [$fromDate, $toDate])
                        ->orWhereBetween('l.created_at', [$fromDate, $toDate])
                        ->orWhereBetween('m.created_at', [$fromDate, $toDate])
                        ->orWhereBetween('n.created_at', [$fromDate, $toDate]);
                });
            }
            if (!empty($educatorId)) {
                $query->where('a.educator_id', $educatorId);
            }
            if (!empty($digitalEducatorId)) {
                $query->where('a.digital_educator_id', $digitalEducatorId);
            }

            // Select all necessary columns and group by them
            $results = $query->select(
                'a.id as patient_id', 'a.patient_name', 'a.mobile_number', 'b.name as doctor_name',
                'c.full_name as educator_name', 'd.full_name as digital_educator_name',
                DB::raw("CAST(a.created_at AS DATE) as created_at"),
                DB::raw("CAST((a.created_at + interval '3 days') AS DATE) AS day3_planned_date"),
                DB::raw("CAST(o.created_at AS DATE) as day3_actual_date"), 'o.callremark_3 as day_3_remark',
                DB::raw("CASE WHEN o.callremark_3 = 'Call Connect' THEN o.callconnect_subremark_3 WHEN o.callremark_3 = 'No Response' THEN o.noresponse_subremark_3 END AS day_3_details_remark"),
                'o.ae_report',
                DB::raw("CAST((a.created_at + interval '7 days') AS DATE) AS day7_planned_date"),
                DB::raw("CAST(f.created_at AS DATE) as day7_actual_date"), 'f.callremark_7 as day_7_remark',
                DB::raw("CASE WHEN f.callremark_7 = 'Call Connect' THEN f.callconnect_subremark_7 WHEN f.callremark_7 = 'No Response' THEN f.noresponse_subremark_7 END AS day_7_details_remark"),
                'f.day7_ae_report',
                DB::raw("CAST((a.created_at + interval '15 days') AS DATE) AS day15_planned_date"),
                DB::raw("CAST(g.created_at AS DATE) as day15_actual_date"), 'g.callremark_15 as day_15_remark',
                DB::raw("CASE WHEN g.callremark_15 = 'Call Connect' THEN g.callconnect_subremark_15 WHEN g.callremark_15 = 'No Response' THEN g.noresponse_subremark_15 END AS day_15_details_remark"),
                'g.day15_ae_report',
                DB::raw("CAST((a.created_at + interval '30 days') AS DATE) AS day30_planned_date"),
                DB::raw("CAST(h.created_at AS DATE) as day30_actual_date"), 'h.callremark_30 as day_30_remark',
                DB::raw("CASE WHEN h.callremark_30 = 'Call Connect' THEN h.callconnect_subremark_30 WHEN h.callremark_30 = 'No Response' THEN h.noresponse_subremark_30 END AS day_30_details_remark"),
                'h.day30_ae_report',
                DB::raw("CAST((a.created_at + interval '45 days') AS DATE) AS day45_planned_date"),
                DB::raw("CAST(i.created_at AS DATE) as day45_actual_date"), 'i.callremark_45 as day_45_remark',
                DB::raw("CASE WHEN i.callremark_45 = 'Call Connect' THEN i.callconnect_subremark_45 WHEN i.callremark_45 = 'No Response' THEN i.noresponse_subremark_45 END AS day_45_details_remark"),
                'i.day45_ae_report',
                DB::raw("CAST((a.created_at + interval '60 days') AS DATE) AS day60_planned_date"),
                DB::raw("CAST(j.created_at AS DATE) as day60_actual_date"), 'j.callremark_60 as day_60_remark',
                DB::raw("CASE WHEN j.callremark_60 = 'Call Connect' THEN j.callconnect_subremark_60 WHEN j.callremark_60 = 'No Response' THEN j.noresponse_subremark_60 END AS day_60_details_remark"),
                'j.day60_ae_report',
                DB::raw("CAST((a.created_at + interval '90 days') AS DATE) AS day90_planned_date"),
                DB::raw("CAST(k.created_at AS DATE) as day90_actual_date"), 'k.callremark_90 as day_90_remark',
                DB::raw("CASE WHEN k.callremark_90 = 'Call Connect' THEN k.callconnect_subremark_90 WHEN k.callremark_90 = 'No Response' THEN k.noresponse_subremark_90 END AS day_90_details_remark"),
                'k.day90_ae_report',
                DB::raw("CAST((a.created_at + interval '120 days') AS DATE) AS day120_planned_date"),
                DB::raw("CAST(l.created_at AS DATE) as day120_actual_date"), 'l.callremark_120 as day_120_remark',
                DB::raw("CASE WHEN l.callremark_120 = 'Call Connect' THEN l.callconnect_subremark_120 WHEN l.callremark_120 = 'No Response' THEN l.noresponse_subremark_120 END AS day_120_details_remark"),
                'l.day120_ae_report',
                DB::raw("CAST((a.created_at + interval '150 days') AS DATE) AS day150_planned_date"),
                DB::raw("CAST(m.created_at AS DATE) as day150_actual_date"), 'm.callremark_150 as day_150_remark',
                DB::raw("CASE WHEN m.callremark_150 = 'Call Connect' THEN m.callconnect_subremark_150 WHEN m.callremark_150 = 'No Response' THEN m.noresponse_subremark_150 END AS day_150_details_remark"),
                'm.day150_ae_report',
                DB::raw("CAST((a.created_at + interval '180 days') AS DATE) AS day180_planned_date"),
                DB::raw("CAST(n.created_at AS DATE) as day180_actual_date"), 'n.callremark_180 as day_180_remark',
                DB::raw("CASE WHEN n.callremark_180 = 'Call Connect' THEN n.callconnect_subremark_180 WHEN n.callremark_180 = 'No Response' THEN n.noresponse_subremark_180 END AS day_180_details_remark"),
                'n.day180_ae_report'
            )->groupBy(
                'a.id', 'b.name', 'c.full_name', 'd.full_name', 'a.created_at',
                'o.callremark_3', 'o.callconnect_subremark_3', 'o.noresponse_subremark_3', 'o.created_at', 'o.ae_report',
                'f.callremark_7', 'f.callconnect_subremark_7', 'f.noresponse_subremark_7', 'f.created_at', 'f.day7_ae_report',
                'g.callremark_15', 'g.callconnect_subremark_15', 'g.noresponse_subremark_15', 'g.created_at', 'g.day15_ae_report',
                'h.callremark_30', 'h.callconnect_subremark_30', 'h.noresponse_subremark_30', 'h.created_at', 'h.day30_ae_report',
                'i.callremark_45', 'i.callconnect_subremark_45', 'i.noresponse_subremark_45', 'i.created_at', 'i.day45_ae_report',
                'j.callremark_60', 'j.callconnect_subremark_60', 'j.noresponse_subremark_60', 'j.created_at', 'j.day60_ae_report',
                'k.callremark_90', 'k.callconnect_subremark_90', 'k.noresponse_subremark_90', 'k.created_at', 'k.day90_ae_report',
                'l.callremark_120', 'l.callconnect_subremark_120', 'l.noresponse_subremark_120', 'l.created_at', 'l.day120_ae_report',
                'm.callremark_150', 'm.callconnect_subremark_150', 'm.noresponse_subremark_150', 'm.created_at', 'm.day150_ae_report',
                'n.callremark_180', 'n.callconnect_subremark_180', 'n.noresponse_subremark_180', 'n.created_at', 'n.day180_ae_report'
            )->orderBy('a.id', 'desc')->get();

            $results->transform(function ($item, $index) {
                $item->sr = $index + 1;
                return $item;
            });

            return response()->json(['data' => $results]);

        } catch (\Exception $e) {
            Log::error('Get Feedback Details Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }     public function feedbackReportExcel(Request $request)
    {
        $fromDate = $request->query('fromDate');
        $toDate = $request->query('toDate');
        $educatorId = $request->query('educatorId');
        $digitalEducatorId = Auth::user()->id;

        return Excel::download(
            new DigiFeedbackReportExport($fromDate, $toDate, $educatorId, $digitalEducatorId),
            'FeedbackReport.csv'
        );
    }
}
