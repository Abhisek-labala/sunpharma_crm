<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\Patient;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class RmController extends Controller
{
    public function rmAnalytics()
    {
        return view('rm.analytics');
    }

    public function rmmonthlyCounseling()
    {
        $user_id =session()->get('id');

        $data = Patient::select(
            DB::raw("TO_CHAR(date, 'Month') as month"),
            DB::raw("EXTRACT(MONTH FROM date) as month_num"),
            DB::raw("COUNT(*) as count")
        )
            ->leftJoin('common.users as u', 'patient_details.educator_id', '=', 'u.id')
            ->leftJoin('common.rm_users as rm', 'u.rm_pm_id', '=', 'rm.id')
            ->where('date', '>=', Carbon::now()->subMonths(4))
            ->where('rm.id', $user_id)
            ->groupBy(DB::raw("TO_CHAR(date, 'Month')"), DB::raw("EXTRACT(MONTH FROM date)"))
            ->orderBy(DB::raw("EXTRACT(MONTH FROM date)"))
            ->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function rmcampDistribution()
    {
        $user_id = session()->get('id');

        $data = Camp::select('date', DB::raw('COUNT(*) as count'))
            ->leftJoin('common.users as u', 'camp.educator_id', '=', 'u.id')
            ->leftJoin('common.rm_users as rm', 'u.rm_pm_id', '=', 'rm.id')
            ->where('rm.id', $user_id)
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function rmbrandDistribution()
    {
        $user_id = session()->get('id');

        // Brand medicines
        $brandCount = DB::table('public.patient_details as pin')
            ->leftJoin('common.users as e', 'e.id', '=', 'pin.educator_id')
            ->leftJoin('common.rm_users as rm', 'rm.id', '=', 'e.rm_pm_id')
            ->where('rm.id', $user_id)
            ->whereNotNull('medicine')
            ->count();

        // Non-brand medicines
        $nonBrandCount = DB::table('public.patient_details as pin')
            ->leftJoin('common.users as e', 'e.id', '=', 'pin.educator_id')
            ->leftJoin('common.rm_users as rm', 'rm.id', '=', 'e.rm_pm_id')
            ->where('rm.id', $user_id)
            ->whereNotNull('compititor')
            ->count();

        $data = [
            ['type' => 'Brand', 'count' => $brandCount],
            ['type' => 'Non-brand', 'count' => $nonBrandCount]
        ];

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function rmdoctorNotMetrics(Request $request)
    {
        $user_id = session()->get('id');
        $days = $request->input('days', 5);

        $data = DB::table('public.patient_details as pin')
            ->leftJoin('public.doctor as h', DB::raw('CAST(pin.hcp_id AS INTEGER)'), '=', 'h.id')
            ->leftJoin('common.users as e', 'e.id', '=', 'pin.educator_id')
            ->leftJoin('common.rm_users as rm', 'e.rm_pm_id', '=', 'rm.id')
            ->whereNull('medicine')
            ->whereNotNull('compititor')
            ->where('rm.id', $user_id)
            ->where('pin.date', '>=', Carbon::now()->subDays($days))
            ->groupBy('h.name')
            ->select('h.name', DB::raw('COUNT(*) as count'))
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function rmtopeducators(Request $request)
    {
        $limit = $request->input('limit', 5);
        $user_id = session()->get('id');

        $data = DB::table('common.users as u')
            ->select('u.full_name as educator_name', DB::raw('COUNT(p.uuid) as session_count'))
            ->leftJoin('patient_details as p', 'u.id', '=', 'p.educator_id')
            ->leftJoin('common.rm_users as rm', 'u.rm_pm_id', '=', 'rm.id')
            ->where('u.role', 'educator')
            ->whereNotNull('p.medicine')
            ->where('rm.id', $user_id)
            ->groupBy('u.id', 'u.full_name')
            ->orderBy('session_count', 'desc')
            ->limit($limit)
            ->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function rmdocmetrics(Request $request)
    {
        $user_id = session()->get('id');
        $days = $request->input('days', 5);

        $data = DB::table('public.patient_details as pin')
            ->leftJoin('public.doctor as h', DB::raw('CAST(pin.hcp_id AS INTEGER)'), '=', 'h.id')
            ->leftJoin('common.users as e', 'e.id', '=', 'pin.educator_id')
            ->leftJoin('common.rm_users as rm', 'e.rm_pm_id', '=', 'rm.id')
            ->whereNotNull('medicine')
            ->where('rm.id', $user_id)
            ->where('pin.date', '>=', Carbon::now()->subDays($days))
            ->groupBy('h.name')
            ->select('h.name', DB::raw('COUNT(*) as count'))
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        return response()->json(['success' => true, 'data' => $data]);
    }
    public function getPatientpage()
    {
        return view('rm.patientlist');
    }
     public function getPatientdata(Request $request)
    {
        // echo 'g';die;
       $user_id = session()->get('id');
        $patients = DB::table('public.patient_details as a')
            ->leftJoin('public.patient_cardio_details as b', 'a.uuid', '=', 'b.uuid')
            ->leftJoin('public.patient_medication_details as c', 'a.uuid', '=', 'c.uuid')
            ->leftJoin('common.users as d', function ($join) {
                $join->on('a.educator_id', '=', 'd.id')
                    ->where('d.role', '=', 'educator');
            })
            ->leftJoin('common.rm_users as f', 'd.rm_pm_id', '=', 'f.id')
            ->leftJoin('public.doctor as g', DB::raw('CAST(a.hcp_id AS INTEGER)'), '=', 'g.id')
            ->leftJoin('public.camp as h', 'a.camp_id', '=', 'h.id')
            ->select(
                'a.id',
                'a.date',
                'a.patient_name',
                'a.mobile_number',
                'a.gender',
                'a.age',
                'a.approved_status',
                'a.prescription_file',
                'a.consent_form_file',
                'a.purchase_bill',
                'c.height',
                'c.weight',
                'a.cipla_brand_prescribed',
                'h.camp_id',
                'g.name as doctor_name',
            )
            ->where('d.rm_pm_id', $user_id)
            ->whereNotNull('a.patient_name')
            ->where(function ($q) {
                $q->whereNotNull('a.prescription_file')
                ->orWhereNotNull('a.consent_form_file')
                ->orWhereNotNull('a.purchase_bill');
            })
            ->orderBy('a.id', 'desc')
            ->get();

        return response()->json([
            'data' => $patients
        ]);
    }

    public function rejectPatient(Request $request)
    {
        $id = $request->input('id');
        $patient = Patient::find($id);
        if ($patient) {
            $patient->approved_status = 'Rejected';
            $patient->save();
            return response()->json(['success' => true, 'message' => 'Patient rejected successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Patient not found'], 404);
    }

    public function approvePatient(Request $request)
    {
        $id = $request->input('id');
        $patient = Patient::find($id);
        if ($patient) {
            $patient->approved_status = 'Approved';
            $patient->save();
            return response()->json(['success' => true, 'message' => 'Patient approved successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Patient not found'], 404);
    }
}
