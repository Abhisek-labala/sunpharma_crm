<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Day90Followup;
use Auth;
use DB;
use Illuminate\Http\Request;

class yogaController extends Controller
{
    public function yogaPatientList()
    {
        return view('yogaeducator.yogaPatientList');
    }
      public function getPatientList(Request $request)
    {
        $draw = $request->get('draw');
    $start = $request->get('start');
    $length = $request->get('length');
    $search = $request->get('search');
    $searchValue = $search['value'];

    $order = $request->get('order');
    $orderColumn = $order[0]['column'];
    $orderDir = $order[0]['dir'];

    // Column mapping for ordering
    $columns = [
        'a.id',
        'a.patient_name',
        'a.mobile_number',
        'a.gender',
        'a.age',
        'c.weight',
        'c.height',
        'g.name',
        'a.cipla_brand_prescribed',
        'h.camp_id',
        'a.date',
        'a.approved_status'
    ];

    $orderColumnName = $columns[$orderColumn] ?? 'a.id';

    // Base query
    $query = DB::table('public.patient_details as a')
        ->leftJoin('public.patient_cardio_details as b', 'a.uuid', '=', 'b.uuid')
        ->leftJoin('public.patient_medication_details as c', 'a.uuid', '=', 'c.uuid')
        ->leftJoin('common.users as d', function ($join) {
            $join->on('a.digital_educator_id', '=', 'd.id');
        })
        ->leftJoin('common.rm_users as f', 'd.rm_pm_id', '=', 'f.id')
        ->leftJoin('public.doctor as g', DB::raw('CAST(a.hcp_id AS INTEGER)'), '=', 'g.id')
        ->leftJoin('public.camp as h', 'a.camp_id', '=', 'h.id')
        ->leftjoin('public.feedback_submitted as i',function ($join) {
            $join->on('a.id', '=', 'i.patient_id');
        })
        ->select(
            'a.id',
            'a.date',
            'a.patient_name',
            'a.mobile_number',
            'a.gender',
            'a.age',
            'c.height',
            'c.weight',
            'a.cipla_brand_prescribed',
            'h.camp_id',
            'g.name as doctor_name',
            'a.approved_status'
        )
        ->whereNotNull('a.patient_name')
        ->where('patient_enrolled', 'Yes')
        ->where('a.approved_status', 'Approved')
        ->where('i.day',  '3');

    // Get total records count
    $totalRecords = $query->count();

    // Apply search filter if provided
    if (!empty($searchValue)) {
        $query->where(function($q) use ($searchValue) {
            $q->where('a.patient_name', 'ilike', "%{$searchValue}%")
              ->orWhere('a.mobile_number', 'ilike', "%{$searchValue}%")
              ->orWhere('g.name', 'ilike', "%{$searchValue}%")
              ->orWhere('a.cipla_brand_prescribed', 'ilike', "%{$searchValue}%")
              ->orWhere('h.camp_id', 'ilike', "%{$searchValue}%")
              ->orWhere('a.gender', 'ilike', "%{$searchValue}%")
              ->orWhere('a.age', 'ilike', "%{$searchValue}%")
              ->orWhere('a.approved_status', 'ilike', "%{$searchValue}%");
        });
    }

    // Get filtered count
    $filteredRecords = $query->count();

    // Apply ordering and pagination
    $data = $query->orderBy($orderColumnName, $orderDir)
                  ->offset($start)
                  ->limit($length)
                  ->get();

    // Format the response for DataTables
    $response = [
        "draw" => intval($draw),
        "recordsTotal" => $totalRecords,
        "recordsFiltered" => $filteredRecords,
        "data" => $data
    ];

    return response()->json($response);
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
     public function day45followup(Request $request)
    {
        // Validation
        $request->validate([
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
            // Insert into day45_followup
            $day45 = DB::table('public.day45_followup')->insertGetId([
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
                'submitted_at' => now(),
                'created_at' => now(),
            ]);

            // Insert into feedback_submitted
            DB::table('public.feedback_submitted')->insert([
                'day' => 45,
                'patient_id' => $request->patient_id,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Day 45 follow-up submitted successfully',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to submit Day 45 follow-up',
                'error' => $e->getMessage(),
            ]);
        }
    }
    public function day7followup(Request $request)
    {

        $request->validate([
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
            'day7_ae_report' => 'nullable|string',
            'callremark_7' => 'nullable|string',
            'callconnect_subremark_7' => 'nullable|string',
            'noresponse_subremark_7' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Insert into day7_followup
            $day7 = DB::table('public.day7_followup')->insertGetId([
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
                'created_at' => now(),

            ]);

            // Insert into feedback_submitted
            DB::table('public.feedback_submitted')->insert([
                'day' => 7,
                'patient_id' => $request->patient_id,

            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Day 7 follow-up submitted successfully',

            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to submit Day 7 follow-up',
                'error' => $e->getMessage()
            ]);
        }
    }
    public function day90followup(Request $request)
    {
        // ✅ Validation rules
        $request->validate([
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
            // ✅ Insert into day90_followup using Eloquent model
            $day90 = Day90Followup::create([
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
                'submitted_at' => now(),
            ]);

            // ✅ Also mark in feedback_submitted
            DB::table('public.feedback_submitted')->insert([
                'day' => 90,
                'patient_id' => $request->patient_id,

            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Day 90 follow-up submitted successfully',

            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to submit Day 90 follow-up',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
