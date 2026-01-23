<?php

namespace App\Http\Controllers;
use App\Exports\EducatorPatientExport;
use App\Exports\PmPatientExport;
use App\Exports\RmReportExport;
use App\Models\Camp;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use App\Models\Zone;
use App\Models\Rmuser;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function educator(Request $request)
    {
        $educatorId = Session::get('emp_id');

        $profileData = User::where('emp_id', $educatorId)->first();
        $profileImage = asset('uploads/logo/user_icon.jpg');

        if ($profileData && $profileData->profile_pic) {
            $profileImage = asset('uploads/' . $profileData->profile_pic);
        }

        return view('educator.dashboard', compact('profileData', 'profileImage'));
    }
    public function getZones()
    {

        $Zones = Zone::orderBy('zone_name')->get(['id', 'zone_name']); // Assuming camp_name exists

        $options = '<option value="">-- Select --</option>';
        foreach ($Zones as $Zone) {
            $options .= '<option value="' .  $Zone ->id . '">' . $Zone ->zone_name . '</option>';
        }

        return response()->json($options);
    }

    public function getrmsbyzone(Request $request)
    {
        $ZoneId = $request->input('zone');
        $RmDetails = Rmuser::where('zone_id',  $ZoneId )
           ->orderBy('full_name')
            ->get(['id', 'full_name']); // Assuming camp_name exists
        $options = '<option value="">-- Select --</option>';
        foreach ($RmDetails as $row) {
            $options .= '<option value="' .  $row ->id . '">' . $row ->full_name . '</option>';
        }

        return response()->json($options);
    }
    public function getEducatorbyzoneandRm(Request $request)
    {
        $ZoneId = $request->input('zone');
        $rmId = $request->input('rm');
        $eduDetails = User::leftJoin('common.rm_users as a', 'users.rm_pm_id', '=', 'a.id')
            ->where('a.zone_id', $ZoneId)
            ->where('users.rm_pm_id', $rmId)
            ->where('users.role', 'counsellor')
            ->orderBy('users.full_name')
            ->get(['users.id', 'users.full_name']);
            $options = '<option value="">-- Select --</option>';
            foreach ($eduDetails as $row) {
                $options .= '<option value="' .  $row ->id . '">' . $row ->full_name . '</option>';
            }

            return response()->json($options);
    }
    public function getEducatorbyRm(Request $request)
    {
        $rmId = session()->get('id');
        $eduDetails = User::leftJoin('common.rm_users as a', 'users.rm_pm_id', '=', 'a.id')
            ->where('users.rm_pm_id', $rmId)
            ->where('users.role', 'counsellor')
            ->orderBy('users.full_name')
            ->get(['users.id', 'users.full_name']);
            $options = '<option value="">-- Select --</option>';
            foreach ($eduDetails as $row) {
                $options .= '<option value="' .  $row ->id . '">' . $row ->full_name . '</option>';
            }

            return response()->json($options);
    }
     public function getEducatorCamp(Request $request)
    {
        $educatorId = Auth::id();
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $camps = Camp::where('educator_id', $educatorId)
            ->whereBetween('date', [$fromDate, $toDate])
            ->groupBy('camp_id')
            ->get(['camp_id']); // Assuming camp_name exists

        $options = '<option value="">-- Select --</option>';
        foreach ($camps as $camp) {
            $options .= '<option value="' . $camp->camp_id . '">' . "CAMP " . $camp->camp_id . '</option>';
        }

        return response()->json($options);
    }
    public function getCampbyeducator(Request $request)
    {
        $educatorId = $request->input('educatorId');
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $camps = Camp::where('educator_id', $educatorId)
            ->whereBetween('date', [$fromDate, $toDate])
            ->groupBy('camp_id')
            ->get(['camp_id']); // Assuming camp_name exists

        $options = '<option value="">-- Select --</option>';
        foreach ($camps as $camp) {
            $options .= '<option value="' . $camp->camp_id . '">' . "CAMP " . $camp->camp_id . '</option>';
        }

        return response()->json($options);
    }
    public function getDoctorsByCamp()
    {
        $user_id = Auth::id();
        $doctors = Doctor::where('educator_id', $user_id)->get();
        $html = '<option value="">Select Doctor</option>';
        foreach ($doctors as $doctor) {
            $html .= '<option value="' . $doctor->id . '">' . $doctor->name . '</option>';
        }

        return $html;
    }
     public function getDoctorsByEdu(Request $request)
    {
        $user_id = $request->input('educatorId');
        $doctors = Doctor::where('educator_id', $user_id)->get();
        $html = '<option value="">Select Doctor</option>';
        foreach ($doctors as $doctor) {
            $html .= '<option value="' . $doctor->id . '">' . $doctor->name . '</option>';
        }

        return $html;
    }
public function getEducatorPatientTable(Request $request)
{
    $user_id = Auth::id();
    $fromDate = $request->input('fromDate');
    $toDate = $request->input('toDate');
    $doctorId = $request->input('doctorId');
    $campId = $request->input('campId');
    $search = $request->input('search.value');

    // Build base query
    $query = DB::table('public.patient_details as a')
        ->leftJoin('public.patient_medication_details as c', 'a.uuid', '=', 'c.uuid')
        ->leftJoin('common.users as d', function ($join) {
            $join->on('a.educator_id', '=', 'd.id')
                ->where('d.role', '=', 'counsellor');
        })
        ->leftJoin('common.rm_users as f', 'd.rm_pm_id', '=', 'f.id')
        ->leftJoin('public.doctor as g', DB::raw('CAST(a.hcp_id AS INTEGER)'), '=', 'g.id')
        ->where('a.educator_id', $user_id);

    if ($fromDate) {
        $query->whereDate('a.date', '>=', $fromDate);
    }

    if ($toDate) {
        $query->whereDate('a.date', '<=', $toDate);
    }

    if ($doctorId) {
        $query->where('a.hcp_id', $doctorId);
    }

    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('a.patient_name', 'ILIKE', "%{$search}%")
              ->orWhere('a.mobile_number', 'ILIKE', "%{$search}%")
              ->orWhere('a.gender', 'ILIKE', "%{$search}%")
              ->orWhere('c.bmi', 'ILIKE', "%{$search}%")
              ->orWhere('d.full_name', 'ILIKE', "%{$search}%")
              ->orWhere('f.full_name', 'ILIKE', "%{$search}%")
              ->orWhere('g.city', 'ILIKE', "%{$search}%");
        });
    }
    // Count total before pagination
    $recordsTotal = $query->count();

    // Apply DataTables pagination, ordering, etc.
    $start = $request->input('start');
    $length = $request->input('length');
    $draw = $request->input('draw');
    $orderColumnIndex = $request->input('order.0.column');
    $orderDir = $request->input('order.0.dir', 'asc');

    $columns = [
        'a.date',               // 1
        'a.patient_name',       // 2
        'a.mobile_number',      // 3
        'a.gender',             // 4
        'c.bmi',                // 5
        'a.consent_form_file',  // 6
        'a.prescription_file',  // 7
        'd.full_name',          // 8
        'f.full_name',          // 9
        'g.city'                // 10
    ];

    if ($orderColumnIndex > 0 && isset($columns[$orderColumnIndex - 1])) {
        $query->orderBy($columns[$orderColumnIndex - 1], $orderDir);
    } else {
        // Default fallback (date desc)
        $query->orderBy('a.date', 'desc');
    }

    $data = $query->select(
        'a.date',
        'a.patient_name',
        'a.mobile_number',
        'a.gender',
        'c.bmi',
        'a.prescription_file',
        'a.consent_form_file',
        'd.full_name as educator_name',
        'f.full_name as rm_name',
        'g.city'
    )
    ->offset($start)
    ->limit($length)
    ->get();

    return response()->json([
        'draw' => intval($draw),
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsTotal, // Adjust if filters are added
        'data' => $data
    ]);
}
public function getpmPatientTable(Request $request)
{

    $fromDate = $request->input('fromDate');
    $toDate = $request->input('toDate');
    $doctorId = $request->input('doctorId');
    $campId = $request->input('campId');
    $user_id = $request->input('educator');
    $zone = $request->input('zone');
    $rm = $request->input('rm');
$search = $request->input('search.value');

    // Build base query
    $query = DB::table('public.patient_details as a')
        ->leftJoin('public.patient_medication_details as c', 'a.uuid', '=', 'c.uuid')
        ->leftJoin('common.users as d', function ($join) {
            $join->on('a.educator_id', '=', 'd.id')
                ->where('d.role', '=', 'counsellor');
        })
        ->leftJoin('common.rm_users as f', 'd.rm_pm_id', '=', 'f.id')
        ->leftJoin('public.doctor as g', DB::raw('CAST(a.hcp_id AS INTEGER)'), '=', 'g.id');

    if($user_id) {
            $query->where('a.educator_id', $user_id);
        }

    if ($fromDate) {
        $query->whereDate('a.date', '>=', $fromDate);
    }

    if ($toDate) {
        $query->whereDate('a.date', '<=', $toDate);
    }

    if ($doctorId) {
        $query->where('a.hcp_id', $doctorId);
    }

    if ($zone) {
        $query->where('f.zone_id', $zone);
    }
    if ($rm) {
        $query->where('d.rm_pm_id', $rm);
    }
if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('a.patient_name', 'ILIKE', "%{$search}%")
              ->orWhere('a.mobile_number', 'ILIKE', "%{$search}%")
              ->orWhere('a.gender', 'ILIKE', "%{$search}%")
              ->orWhere('b.blood_pressure', 'ILIKE', "%{$search}%")
              ->orWhere('c.bmi', 'ILIKE', "%{$search}%")
              ->orWhere('d.full_name', 'ILIKE', "%{$search}%")
              ->orWhere('f.full_name', 'ILIKE', "%{$search}%")
              ->orWhere('g.city', 'ILIKE', "%{$search}%");
        });
    }

    // Count total before pagination
    $recordsTotal = $query->count();

    // Apply DataTables pagination, ordering, etc.
    $start = $request->input('start');
    $length = $request->input('length');
    $draw = $request->input('draw');

    $orderColumnIndex = $request->input('order.0.column');
    $orderDir = $request->input('order.0.dir', 'desc'); // default desc
    $columns = [
        'a.date',               // 1
        'a.patient_name',       // 2
        'a.mobile_number',      // 3
        'a.gender',             // 4
        'b.blood_pressure',     // 5
        'c.bmi',                // 6
        'a.consent_form_file',  // 7
        'a.prescription_file',  // 8
        'd.full_name',          // 9
        'f.full_name',          // 10
        'g.city'                // 11
    ];

    if ($orderColumnIndex > 0 && isset($columns[$orderColumnIndex - 1])) {
        $query->orderBy($columns[$orderColumnIndex - 1], $orderDir);
    } else {
        $query->orderBy('a.date', 'desc'); // fallback
    }
    $data = $query->select(
        'a.date',
        'a.patient_name',
        'a.mobile_number',
        'a.gender',
        'b.blood_pressure',
        'c.bmi',
        'a.prescription_file',
        'a.consent_form_file',
        'd.full_name as educator_name',
        'f.full_name as rm_name',
        'g.city'
    )
    ->offset($start)
    ->limit($length)
    ->get();

    return response()->json([
        'draw' => intval($draw),
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsTotal, // Adjust if filters are added
        'data' => $data
    ]);
}
public function getrmPatientTable(Request $request)
{
    $rm_id =session()->get('id');
    $fromDate = $request->input('fromDate');
    $toDate = $request->input('toDate');
    $doctorId = $request->input('doctorId');
    $campId = $request->input('campId');
    $user_id = $request->input('educator');
    $search = $request->input('search.value');

    // Build base query
    $query = DB::table('public.patient_details as a')
        ->leftJoin('public.patient_medication_details as c', 'a.uuid', '=', 'c.uuid')
        ->leftJoin('common.users as d', function ($join) {
            $join->on('a.educator_id', '=', 'd.id')
                ->where('d.role', '=', 'counsellor');
        })
        ->leftJoin('common.rm_users as f', 'd.rm_pm_id', '=', 'f.id')
        ->leftJoin('public.doctor as g', DB::raw('CAST(a.hcp_id AS INTEGER)'), '=', 'g.id')
        ->whereNotNull('a.educator_id');

    if($user_id) {
            $query->where('a.educator_id', $user_id);
        }

    if ($fromDate) {
        $query->whereDate('a.date', '>=', $fromDate);
    }

    if ($toDate) {
        $query->whereDate('a.date', '<=', $toDate);
    }

    if ($doctorId) {
        $query->where('a.hcp_id', $doctorId);
    }
    if ($rm_id) {
        $query->where('d.rm_pm_id', $rm_id);
    }

    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('a.patient_name', 'ILIKE', "%{$search}%")
              ->orWhere('a.mobile_number', 'ILIKE', "%{$search}%")
              ->orWhere('a.gender', 'ILIKE', "%{$search}%")
              ->orWhere('c.bmi', 'ILIKE', "%{$search}%")
              ->orWhere('d.full_name', 'ILIKE', "%{$search}%")
              ->orWhere('f.full_name', 'ILIKE', "%{$search}%")
              ->orWhere('g.city', 'ILIKE', "%{$search}%");
        });
    }
    // Count total before pagination
    $recordsTotal = $query->count();

    // Apply DataTables pagination, ordering, etc.
    $start = $request->input('start');
    $length = $request->input('length');
    $draw = $request->input('draw');
    $orderColumnIndex = $request->input('order.0.column');
    $orderDir = $request->input('order.0.dir', 'desc'); // default desc
    $columns = [
        'a.date',               // 1
        'a.patient_name',       // 2
        'a.mobile_number',      // 3
        'a.gender',             // 4
        'c.bmi',                // 5
        'a.consent_form_file',  // 6
        'a.prescription_file',  // 7
        'd.full_name',          // 8
        'f.full_name',          // 9
        'g.city'                // 10
    ];

    if ($orderColumnIndex > 0 && isset($columns[$orderColumnIndex - 1])) {
        $query->orderBy($columns[$orderColumnIndex - 1], $orderDir);
    } else {
        $query->orderBy('a.date', 'desc'); // fallback
    }
    $data = $query->select(
        'a.date',
        'a.patient_name',
        'a.mobile_number',
        'a.gender',
        'c.bmi',
        'a.prescription_file',
        'a.consent_form_file',
        'd.full_name as educator_name',
        'f.full_name as rm_name',
        'g.city'
    )
    ->offset($start)
    ->limit($length)
    ->get();

    return response()->json([
        'draw' => intval($draw),
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsTotal, // Adjust if filters are added
        'data' => $data
    ]);
}
public function downloadEducatorPatientExcel(Request $request)
{
    // print_r($request);die;
    return Excel::download(
        new EducatorPatientExport(
            $request->fromDate,
            $request->toDate,
            $request->campId,
            $request->hcp
        ),
        'educator_patients.csv'
    );
}
public function downloadpmPatientExcel(Request $request)
{
    return Excel::download(
        new PmPatientExport(
            $request->fromDate,
            $request->toDate,
            $request->campId,
            $request->hcp,
            $request->educator,
            $request->rm,
            $request->zone
        ),
        'PatientList.csv'
    );
}
public function downloadrmPatientExcel(Request $request)
{
    // print_r($request);die;
    return Excel::download(
        new  RmReportExport(

            $request->fromDate,
            $request->toDate,
            $request->campId,
            $request->hcp,
            $request->educator,

        ),
        'PatientList.csv'
    );
}

    public function digitaleducator(Request $request)
    {
        $digitaleducator = Session::get('emp_id');

        $profileData = User::where('emp_id', $digitaleducator)->first();
        $profileImage = asset('uploads/logo/user_icon.jpg');


        if ($profileData && $profileData->profile_pic) {
            $profileImage = asset('uploads/' . $profileData->profile_pic);
        }

        return view('digitaleducator.dashboard', compact('profileData', 'profileImage'));
    }
    public function pm(Request $request)
    {
        $pm = Session::get('emp_id');

        $profileData = User::where('emp_id', $pm)->first();
        $profileImage = asset('uploads/logo/user_icon.jpg');


        if ($profileData && $profileData->profile_pic) {
            $profileImage = asset('uploads/' . $profileData->profile_pic);
        }
        return view('pm.dashboard', compact('profileData', 'profileImage'));
    }
    public function rm(Request $request)
    {
        $rm = Session::get('emp_id');

        $profileData = User::where('emp_id', $rm)->first();
        $profileImage = asset('uploads/logo/user_icon.jpg');


        if ($profileData && $profileData->profile_pic) {
            $profileImage = asset('uploads/' . $profileData->profile_pic);
        }
        return view('rm.dashboard', compact('profileData', 'profileImage'));
    }
    public function mis(Request $request)
    {
        $mis = Session::get('emp_id');

        $profileData = User::where('emp_id', $mis)->first();
        $profileImage = asset('uploads/logo/user_icon.jpg');


        if ($profileData && $profileData->profile_pic) {
            $profileImage = asset('uploads/' . $profileData->profile_pic);
        }
        return view('mis.dashboard', compact('profileData', 'profileImage'));
    }
    public function yogaeducator(Request $request)
    {
        $yogaeducator = Session::get('emp_id');

        $profileData = User::where('emp_id', $yogaeducator)->first();
        $profileImage = asset('uploads/logo/user_icon.jpg');


        if ($profileData && $profileData->profile_pic) {
            $profileImage = asset('uploads/' . $profileData->profile_pic);
        }
        return view('yogaeducator.dashboard', compact('profileData', 'profileImage'));
    }
}
