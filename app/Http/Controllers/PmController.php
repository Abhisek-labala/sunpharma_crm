<?php

namespace App\Http\Controllers;

use App\Exports\DailyReportExport;
use App\Exports\FeedbackReportExport;
use App\Http\Controllers\Controller;
use App\Models\Compitetor;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Camp;
use App\Models\City;
use App\Models\State;
use App\Exports\CampReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Patient;
use Auth;


class PmController extends Controller
{
    public function assignEducatorView()
    {
        // Your logic here
        return view('pm.assignEducator');
    }

    public function pmassignEducatorPost(Request $request)
    {
        $request->validate([
            'educator_id' => 'required|integer',
            'rm_id' => 'nullable|integer'
        ], [
            'educator_id.required' => 'Please select an educator'
        ]);

        try {
            $educatorId = $request->educator_id;
            $rmId = $request->rm_id;

            // Prepare update data
            $updateData = [
                'rm_pm_id' => $rmId == 0 ? null : $rmId,
                'updated_at' => now()
            ];

            // Update record in users table
            $result = DB::table('common.users')
                ->where('id', $educatorId)
                ->where('role', 'counsellor')
                ->update($updateData);

            if ($result) {
                $message = is_null($updateData['rm_pm_id'])
                    ? 'Counsellor successfully unassigned from RM'
                    : 'Counsellor successfully assigned to RM';

                return response()->json(['success' => true, 'message' => $message]);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to assign counsellor']);
            }
        } catch (\Exception $e) {
            Log::error('Assign Counsellor Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error']);
        }
    }

    public function assigndigiEducatorView()
    {
        return view('pm.assigndigiEducator');
    }

    public function pmassignDigitalEducatorPost(Request $request)
    {
        // Validate inputs
        $request->validate([
            'educator_id' => 'required|integer',
            'rm_id' => 'nullable|integer'
        ], [
            'educator_id.required' => 'Please select an counsellor'
        ]);

        try {
            $educatorId = $request->educator_id;
            $rmId = $request->rm_id;

            // Prepare update data
            $updateData = [
                'rm_pm_id' => $rmId == 0 ? null : $rmId,
                'updated_at' => now()
            ];

            // Update record in users table
            $result = DB::table('common.users')
                ->where('id', $educatorId)
                ->where('role', 'digitalcounsellor')
                ->update($updateData);

            if ($result) {
                $message = is_null($updateData['rm_pm_id'])
                    ? 'DigitalCounsellor successfully unassigned from RM'
                    : 'DigitalCounsellor successfully assigned to RM';

                return response()->json(['success' => true, 'message' => $message]);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to assign counsellor']);
            }
        } catch (\Exception $e) {
            Log::error('Assign DigitalCounsellor Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error']);
        }
    }

    public function assignHcpView()
    {
        return view('pm.assignHcp');
    }

    public function pmassignHcpPost(Request $request)
    {
        // Validate inputs
        $request->validate([
            'educator_id' => 'required|integer',
            'hcp_id' => 'required|integer'
        ], [
            'educator_id.required' => 'Please select an counsellor',
            'hcp_id.required' => 'Please select a doctor'
        ]);

        try {
            $educatorId = $request->educator_id;
            $hcpId = $request->hcp_id;

            // Prepare update data
            $updateData = [
                'educator_id' => $educatorId,
                'update_at' => now()
            ];

            // Update record in patient_details table
            $result = DB::table('public.doctor')
                ->where('id', $hcpId)
                ->update($updateData);

            if ($result) {
                return response()->json(['success' => true, 'message' => 'Doctor successfully assigned']);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to assign doctor']);
            }
        } catch (\Exception $e) {
            Log::error('Assign Doctor Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error']);
        }
    }

    public function assigndigital()
    {   // Join 3 tables via uuid


        return view('pm.assigndigital');
    }
    public function pmgetPatients(Request $request)
    {
        if (!session()->has('emp_id')) {
            return response()->json(['error' => 'Session expired'], 401);
        }

        try {
            // DataTables params
            $draw = intval($request->input('draw', 0));
            $start = intval($request->input('start', 0));
            $length = intval($request->input('length', 10));
            $searchValue = trim($request->input('search.value', ''));

            // Ordering
            $orderColumnIndex = intval($request->input('order.0.column', 0));
            $orderDir = strtoupper($request->input('order.0.dir', 'ASC')) === 'DESC' ? 'DESC' : 'ASC';

            // Columns must match DataTables frontend
            $columns = [
                'a.uuid',
                'a.patient_name',
                'a.gender',
                'a.age',
                'b.height',
                'b.weight',
                'c.name',
                'a.date',
                'd.full_name',
                'e.full_name'
            ];
            $orderBy = $columns[$orderColumnIndex] ?? $columns[0];

            // Base query
            $query = DB::table('public.patient_details as a')
                ->join('public.patient_medication_details as b', 'a.uuid', '=', 'b.uuid')
                ->join('public.doctor as c', 'a.hcp_id', '=', DB::raw('c.id::varchar'))
                ->join('common.users as d', 'a.educator_id', '=', 'd.id')
                ->leftJoin('common.users as e', 'a.digital_educator_id', '=', 'e.id')
                ->select(
                    'a.uuid',
                    'a.patient_name',
                    'a.gender',
                    'a.age',
                    'b.height',
                    'b.weight',
                    'c.name as doctor_name',
                    'a.date',

                    'd.full_name as educator_name',
                    DB::raw("COALESCE(e.full_name, 'N/A') as digital_educator")
                );

            // Search filter
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('a.patient_name', 'ilike', "%{$searchValue}%")
                        ->orWhere('c.name', 'ilike', "%{$searchValue}%")
                        ->orWhere('d.full_name', 'ilike', "%{$searchValue}%")
                        ->orWhere('e.full_name', 'ilike', "%{$searchValue}%");
                });
            }

            // Count filtered
            $recordsFiltered = $query->count();

            // Apply order + pagination
            $patients = $query
                ->orderBy($orderBy, $orderDir)
                ->skip($start)
                ->take($length)
                ->get();
            $patients = $patients->map(function ($item, $index) use ($start) {
                $item->sl_no = $start + $index + 1; // pagination-aware serial number
                return $item;
            });
            // Total without filter
            $recordsTotal = DB::table('public.patient_details')->count();

            // Response
            $response = [
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $patients
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Patients DataTable Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function assign_digitaleducator_post(Request $request)
    {
        // Handle digital educator post form
    }

    public function pmcreateEducatorView()
    {
        return view('pm.pmcreateEducator');
    }
    public function getEducators(Request $request)
    {

        // Check session (replace with Laravel auth check if needed)
        if (!session()->has('emp_id')) {
            return response()->json(['error' => 'Session expired'], 401);
        }

        try {
            // DataTables params
            $draw = intval($request->input('draw', 0));
            $start = intval($request->input('start', 0));
            $length = intval($request->input('length', 10));
            $searchValue = trim($request->input('search.value', ''));

            // Ordering
            $orderColumnIndex = intval($request->input('order.0.column', 0));
            $orderDir = strtoupper($request->input('order.0.dir', 'ASC')) === 'DESC' ? 'DESC' : 'ASC';

            // Column mapping (must match DataTables frontend order)
            $columns = [
                'educator.id',
                'educator.emp_id',
                'educator.full_name',
                'educator.email',
                'educator.password',
                'educator.mobile',
                'educator.city',
                'educator.state',
                'educator.address',
                'rm_name.name'
            ];
            $orderBy = $columns[$orderColumnIndex] ?? $columns[0];

            // Base query
            $query = DB::table('common.users as educator')
                ->leftJoin('common.rm_users as rm', 'rm.id', '=', 'educator.rm_pm_id')
                ->select(
                    'educator.id',
                    'educator.emp_id',
                    'educator.full_name',
                    'educator.email',
                    'educator.raw_password as password',
                    'educator.mobile',
                    'educator.city',
                    'educator.state',
                    'educator.address',
                    'rm.full_name as rm'
                    // DB::raw("COALESCE(rm_name.name, 'N/A') as rm")
                )
                ->where('educator.role', '=', 'counsellor');

            // Search
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('educator.full_name', 'ilike', "%{$searchValue}%")
                        ->orWhere('educator.email', 'ilike', "%{$searchValue}%")
                        ->orWhere('educator.emp_id', 'ilike', "%{$searchValue}%")
                        ->orWhere('educator.mobile', 'ilike', "%{$searchValue}%")
                        ->orWhere('educator.city', 'ilike', "%{$searchValue}%")
                        ->orWhere('educator.state', 'ilike', "%{$searchValue}%")
                        ->orWhere('educator.address', 'ilike', "%{$searchValue}%")
                        ->orWhere('rm.full_name', 'ilike', "%{$searchValue}%");

                });
            }

            // Count filtered records
            $recordsFiltered = $query->count();

            // Apply order and pagination
            $educators = $query
                ->orderBy($orderBy, $orderDir)
                ->skip($start)
                ->take($length)
                ->get();

            // Total count without search filter
            $recordsTotal = DB::table('common.users')
                ->where('role', '=', 'counsellor')
                ->count();

            // Format response
            $response = [
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $educators
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Counsellors DataTable Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
    public function getDigitalEducators(Request $request)
    {

        // Check session (replace with Laravel auth check if needed)
        if (!session()->has('emp_id')) {
            return response()->json(['error' => 'Session expired'], 401);
        }

        try {
            // DataTables params
            $draw = intval($request->input('draw', 0));
            $start = intval($request->input('start', 0));
            $length = intval($request->input('length', 10));
            $searchValue = trim($request->input('search.value', ''));

            // Ordering
            $orderColumnIndex = intval($request->input('order.0.column', 0));
            $orderDir = strtoupper($request->input('order.0.dir', 'ASC')) === 'DESC' ? 'DESC' : 'ASC';

            // Column mapping (must match DataTables frontend order)
            $columns = [
                'digital_educator.id',
                'digital_educator.full_name',
                'digital_educator.emp_id',
                'digital_educator.password',
                'rm_name.name'

            ];
            $orderBy = $columns[$orderColumnIndex] ?? $columns[0];

            // Base query
            $query = DB::table('common.users as digital_educator')
                ->leftJoin('common.rm_users as rm', 'rm.id', '=', 'digital_educator.rm_pm_id')
                ->select(
                    'digital_educator.id',
                    'digital_educator.emp_id',
                    'digital_educator.full_name',

                    'digital_educator.raw_password as password',

                    'rm.full_name as rm'
                    // DB::raw("COALESCE(rm_name.name, 'N/A') as rm")
                )
                ->where('digital_educator.role', '=', 'digitalcounsellor');

            // Search
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('digital_educator.full_name', 'ilike', "%{$searchValue}%")
                        ->orWhere('digital_educator.emp_id', 'ilike', "%{$searchValue}%")
                        ->orWhere('digital_educator.email', 'ilike', "%{$searchValue}%")
                        ->orWhere('digital_educator.mobile', 'ilike', "%{$searchValue}%")
                        ->orWhere('digital_educator.city', 'ilike', "%{$searchValue}%")
                        ->orWhere('digital_educator.state', 'ilike', "%{$searchValue}%")
                        ->orWhere('digital_educator.address', 'ilike', "%{$searchValue}%")
                        ->orWhere('rm.full_name', 'ilike', "%{$searchValue}%");

                });
            }

            // Count filtered records
            $recordsFiltered = $query->count();

            // Apply order and pagination
            $digital_educator = $query
                ->orderBy($orderBy, $orderDir)
                ->skip($start)
                ->take($length)
                ->get();

            // Total count without search filter
            $recordsTotal = DB::table('common.users')
                ->where('role', '=', 'digitalcounsellor')
                ->count();

            $response = [
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $digital_educator
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Digital Counsellors DataTable Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
    public function getrms(Request $request)
    {

        // Check session (replace with Laravel auth check if needed)
        if (!session()->has('emp_id')) {
            return response()->json(['error' => 'Session expired'], 401);
        }

        try {
            // DataTables params
            $draw = intval($request->input('draw', 0));
            $start = intval($request->input('start', 0));
            $length = intval($request->input('length', 10));
            $searchValue = trim($request->input('search.value', ''));

            // Ordering
            $orderColumnIndex = intval($request->input('order.0.column', 0));
            $orderDir = strtoupper($request->input('order.0.dir', 'ASC')) === 'DESC' ? 'DESC' : 'ASC';

            // Column mapping (must match DataTables frontend order)
            $columns = [
                'rm.id',
                'rm.emp_id',
                'rm.full_name',
                'rm.user_name',
                'rm.password',
                'rm.zone',
                'z.zone_name'

            ];
            $orderBy = $columns[$orderColumnIndex] ?? $columns[0];

            // Base query
            $query = DB::table('common.rm_users as rm')
                ->leftJoin('common.zones as z', 'rm.zone_id', '=', 'z.id')
                ->select(
                    'rm.id',
                    'rm.emp_id',
                    'rm.full_name',
                    'rm.user_name',
                    'rm.raw_password as password',
                    'rm.zone_id as zone',
                    'z.zone_name as zone_name'
                );


            // Search
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('rm.full_name', 'ilike', "%{$searchValue}%")
                        ->orWhere('rm.emp_id', 'ilike', "%{$searchValue}%")
                        ->orWhere('rm.user_name', 'ilike', "%{$searchValue}%");

                });
            }

            // Count filtered records
            $recordsFiltered = $query->count();

            // Apply order and pagination
            $digital_educator = $query
                ->orderBy($orderBy, $orderDir)
                ->skip($start)
                ->take($length)
                ->get();

            // Total count without search filter
            $recordsTotal = DB::table('common.rm_users')
                ->count();

            $response = [
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $digital_educator
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('RM DataTable Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function getDoctors(Request $request)
    {
        if (!session()->has('emp_id')) {
            return response()->json(['error' => 'Session expired'], 401);
        }

        try {
            $draw = intval($request->input('draw', 0));
            $start = intval($request->input('start', 0));
            $length = intval($request->input('length', 10));
            $searchValue = trim($request->input('search.value', ''));

            $orderColumnIndex = intval($request->input('order.0.column', 0));
            $orderDir = strtoupper($request->input('order.0.dir', 'ASC')) === 'DESC' ? 'DESC' : 'ASC';

            // Columns must match JS order
            $columns = [
                'doc.id',
                'doc.msl_code',
                'doc.name',
                'doc.city',
                'doc.state',
                'z.zone_name',
                'doc.speciality',
                'doc.first_visit',
                'u.full_name'
            ];

            $orderBy = $columns[$orderColumnIndex] ?? 'doc.id';

            // Base query
            $query = DB::table('public.doctor as doc')
                ->leftJoin('common.zones as z', 'z.id', '=', DB::raw("NULLIF(doc.zone, '')::integer"))
                ->leftJoin('common.users as u', function ($join) {
                    $join->on('u.id', '=', 'doc.educator_id')
                        ->where('u.role', '=', 'counsellor');
                })->select(
                    'doc.id',
                    'doc.msl_code',
                    'doc.name',
                    'doc.city',
                    'doc.state',
                    'z.zone_name as zone',
                    'doc.speciality',
                    'doc.first_visit',
                    'u.full_name as full_name'
                );

            // Search filter
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('doc.name', 'ilike', "%{$searchValue}%")
                        ->orWhere('doc.msl_code', 'ilike', "%{$searchValue}%")
                        ->orWhere('doc.city', 'ilike', "%{$searchValue}%")
                        ->orWhere('doc.state', 'ilike', "%{$searchValue}%")
                        ->orWhere('z.zone_name', 'ilike', "%{$searchValue}%")
                        ->orWhere('doc.speciality', 'ilike', "%{$searchValue}%")
                        ->orWhere('doc.first_visit', 'ilike', "%{$searchValue}%")
                        ->orWhere('u.full_name', 'ilike', "%{$searchValue}%");
                });
            }

            // Filtered count
            $recordsFiltered = (clone $query)->count();

            // Apply order + pagination
            $doctors = $query
                ->orderBy($orderBy, $orderDir)
                ->skip($start)
                ->take($length)
                ->get();

            // Total count without search
            $recordsTotal = DB::table('public.doctor as doc')
                ->leftJoin('common.users as u', 'u.id', '=', 'doc.educator_id')
                ->where('u.role', 'counsellor')
                ->count();

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $doctors
            ]);

        } catch (\Exception $e) {
            Log::error('Doctor DataTable Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function pmupdateRmPost(Request $request)
    {
        // Validate inputs
        $request->validate([
            'rm_id' => 'required|integer',
            'emp_id' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
            'zone_id' => 'required|integer'
        ]);

        DB::beginTransaction();

        try {
            $updateData = [
                'emp_id' => $request->emp_id,
                'full_name' => $request->name,
                'zone_id' => $request->zone_id,
                'updated_at' => now()
            ];

            // If password is provided, update it
            if (!empty($request->password)) {
                $updateData['password'] = hash('sha256', $request->password);
                $updateData['raw_password'] = $request->password; // ⚠️ better avoid storing raw password
            }

            DB::table('common.rm_users')
                ->where('id', $request->rm_id)
                ->update($updateData);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Regional Cordinator updated successfully',
                'id' => $request->rm_id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update RM Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => $e->getMessage() ?: 'Server error'
            ], 500);
        }
    }
    public function deleteDigiEducator($id)
    {
        try {
            // Example delete
            $deleted = DB::table('common.users')->where('id', $id)->where('role', 'digitalcounsellor')->delete();

            if ($deleted > 0) {
                return response()->json(['status' => true, 'message' => 'Digital Counsellor deleted successfully']);
            } else {
                return response()->json(['status' => false, 'message' => 'Digital Counsellor not found or already deleted']);
            }
        } catch (\Exception $e) {
            Log::error('Delete Digital Counsellor Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error']);
        }
    }
    public function deleteEducator($id)
    {
        try {
            // Example delete
            $deleted = DB::table('common.users')->where('id', $id)->where('role', 'counsellor')->delete();

            if ($deleted > 0) {
                return response()->json(['status' => true, 'message' => 'Counsellor deleted successfully']);
            } else {
                return response()->json(['status' => false, 'message' => 'Counsellor not found or already deleted']);
            }
        } catch (\Exception $e) {
            Log::error('Delete DigiEducator Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error']);
        }
    }
    public function deleteDoctor($id)
    {
        try {
            // Example delete
            $deleted = DB::table('public.doctor')->where('id', $id)->delete();

            if ($deleted > 0) {
                return response()->json(['status' => true, 'message' => 'Doctor deleted successfully']);
            } else {
                return response()->json(['status' => false, 'message' => 'Doctor not found or already deleted']);
            }
        } catch (\Exception $e) {
            Log::error('Delete Doctor Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error']);
        }
    }
    public function deleterm($id)
    {
        try {
            // Example delete
            $deleted = DB::table('common.rm_users')->where('id', $id)->delete();

            if ($deleted > 0) {
                return response()->json(['status' => true, 'message' => 'Regional Cordinator deleted successfully']);
            } else {
                return response()->json(['status' => false, 'message' => 'Regional Cordinator  not found or already deleted']);
            }
        } catch (\Exception $e) {
            Log::error('Regional Cordinator  provider Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error']);
        }
    }

    public function pmcreateHcpView()
    {
        return view('pm.pmcreateHcp');
    }
    public function pmcreateRmView()
    {
        return view('pm.pmcreateRm');
    }
    public function pmcreateDigitalEducatorView()
    {
        return view('pm.pmcreateDigitalEducator');
    }
    public function pmfeedback()
    {
        // Your logic here
        return view('pm.feedback');
    }
    public function pmcampReport()
    {
        // Your logic here
        return view('pm.campReport');
    }
    public function pmfeedbackReport()
    {
        return view('pm.feedbackReport');
    }
    public function getEducatorsname()
    {
        // Check session (replace with Laravel auth check if needed)
        if (!session()->has('emp_id')) {
            return response()->json(['error' => 'Session expired'], 401);
        }

        try {
            $educators = DB::table('common.users')
                ->where('role', 'counsellor')
                ->select('id', 'full_name')
                ->get();

            return response()->json($educators);
        } catch (\Exception $e) {
            Log::error('Get Counsellor Name Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
    public function getdigiEducatorsname()
    {
        // Check session (replace with Laravel auth check if needed)
        if (!session()->has('emp_id')) {
            return response()->json(['error' => 'Session expired'], 401);
        }

        try {
            $educators = DB::table('common.users')
                ->where('role', 'digitalcounsellor')
                ->select('id', 'full_name')
                ->get();

            return response()->json($educators);
        } catch (\Exception $e) {
            Log::error('Get Digital Counsellor Name Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
    public function attendanceReport()
    {
        return view('pm.attendance.report');
    }

    public function getAttendanceReportData(Request $request)
    {
        try {
            // DataTables params
            $draw = intval($request->input('draw', 0));
            $start = intval($request->input('start', 0));
            $length = intval($request->input('length', 10));
            $searchValue = trim($request->input('search.value', ''));
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
            $role = $request->input('role');

            // Ordering
            $orderColumnIndex = intval($request->input('order.0.column', 0));
            $orderDir = strtoupper($request->input('order.0.dir', 'DESC')) === 'ASC' ? 'ASC' : 'DESC';

            $columns = [
                'date',
                'role',
                'name',
                'in_time',
                'out_time',
                'location'
            ];
            $orderBy = $columns[$orderColumnIndex] ?? 'date';

            $query = \App\Models\Attendance::query();

            // Filters
            if ($startDate && $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            }
            if ($role) {
                $query->where('role', $role);
            }

            // Search (simple search)
            if (!empty($searchValue)) {
               $query->where(function($q) use ($searchValue) {
                   $q->where('date', 'like', "%{$searchValue}%")
                     ->orWhere('role', 'like', "%{$searchValue}%")
                     ->orWhere('ip_address', 'like', "%{$searchValue}%");
               });
            }
            
            $filteredCount = $query->count();

            // Pagination
            $attendances = $query->orderBy($orderBy === 'name' || $orderBy === 'location' ? 'date' : $orderBy, $orderDir)
                ->skip($start)
                ->take($length)
                ->with('authenticatable') // Eager load
                ->get();

            $data = $attendances->map(function($record) {
                $name = 'N/A';
                if ($record->authenticatable) {
                    $name = $record->authenticatable->full_name ?? $record->authenticatable->name ?? 'N/A';
                }
                
                return [
                    'date' => $record->date,
                    'role' => ucfirst($record->role),
                    'name' => $name,
                    'in_time' => $record->in_time,
                    'out_time' => $record->out_time ?? '-',
                    'location' => $record->address ?? ($record->latitude ? $record->latitude . ',' . $record->longitude : 'N/A'),
                    'ip_address' => $record->ip_address
                ];
            });

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => \App\Models\Attendance::count(),
                'recordsFiltered' => $filteredCount,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            Log::error('Attendance Report Data Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function exportAttendanceReport(Request $request)
    {
        $startDate = $request->input('startDate', Carbon::today()->toDateString());
        $endDate = $request->input('endDate', Carbon::today()->toDateString());
        $role = $request->input('role');

        return Excel::download(new \App\Exports\AttendanceExport($startDate, $endDate, $role), 'attendance_report.xlsx');
    }
    public function getrmsname()
    {
        // Check session (replace with Laravel auth check if needed)
        if (!session()->has('emp_id')) {
            return response()->json(['error' => 'Session expired'], 401);
        }

        try {
            $rms = DB::table('common.rm_users')
                ->select('id', 'full_name')
                ->get();

            return response()->json($rms);
        } catch (\Exception $e) {
            Log::error('Get RCs Name Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
    public function getDoctorsname()
    {
        // Check session (replace with Laravel auth check if needed)
        if (!session()->has('emp_id')) {
            return response()->json(['error' => 'Session expired'], 401);
        }

        try {
            $doctors = DB::table('public.doctor')
                ->select('id', 'name')
                ->get();

            return response()->json($doctors);
        } catch (\Exception $e) {
            Log::error('Get Doctors Name Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
    public function getCampDetails(Request $request)
    {
        if (!session()->has('emp_id')) {
            return response()->json(['error' => 'Session expired'], 401);
        }

        try {
            $draw = $request->input('draw');
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $search = $request->input('search.value');

            $query = DB::table('public.camp as c')
                ->leftJoin('common.users as u', 'u.id', '=', 'c.educator_id')
                ->select(
                    'c.id',
                    'u.emp_id as employee_id',
                    'u.full_name as first_name',
                    'c.hcp_name',
                    'c.in_time',
                    'c.out_time',
                    'c.remarks',
                    'c.execution_status',
                    'c.date'
                );

            // Filtering
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('u.full_name', 'ILIKE', "%{$search}%")
                        ->orWhere('u.emp_id', 'ILIKE', "%{$search}%")
                        ->orWhere('c.hcp_name', 'ILIKE', "%{$search}%")
                        ->orWhere('c.in_time', 'ILIKE', "%{$search}%")
                        ->orWhere('c.out_time', 'ILIKE', "%{$search}%")
                        ->orWhere('c.remarks', 'ILIKE', "%{$search}%")
                        ->orWhere('c.execution_status', 'ILIKE', "%{$search}%")
                        ->orWhere('c.date', 'ILIKE', "%{$search}%");
                });
            }

            // Clone query for count before adding offset/limit
            $totalRecords = (clone $query)->count();
            $orderColumnIndex = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir', 'asc');
            $columns = [
                'c.id',
                'u.emp_id',
                'u.full_name',
                'c.hcp_name',
                'c.in_time',
                'c.out_time',
                'c.remarks',
                'c.execution_status',
                'c.date'
            ];

            if ($orderColumnIndex !== null && isset($columns[$orderColumnIndex])) {
                $query->orderBy($columns[$orderColumnIndex], $orderDir);
            } else {
                $query->orderBy('c.id', 'desc'); // 👈 default initial order by ID (Sr No) DESC
            }
            $camps = $query
                ->offset($start)
                ->limit($length)
                ->get();

            // Add serial numbers
            $camps->transform(function ($camp, $index) use ($start) {
                $camp->sr = $start + $index + 1;
                return $camp;
            });

            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $camps
            ]);

        } catch (\Exception $e) {
            Log::error('Get Camp Details Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
    public function getFeedbackDetails(Request $request)
    {
        if (!session()->has('emp_id')) {
            return response()->json(['error' => 'Session expired'], 401);
        }

        try {
            $draw = $request->input('draw');
            $start = $request->input('start', 0);
            $length = $request->input('length', 10);
            $search = $request->input('search.value');
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            $digitalEducatorId = $request->input('digitalEducatorId');
            $educatorId = $request->input('educatorId');
            // Initial query building without select and group by
            $baseQuery = DB::table('public.patient_details as a')
                ->leftJoin('public.doctor as b', DB::raw('a.hcp_id::int'), '=', 'b.id')
                ->leftJoin('common.users as c', function ($join) {
                    $join->on(DB::raw('c.id'), '=', DB::raw('a.educator_id::int'))->where('c.role', '=', 'counsellor');
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
                ->where(function ($q) {
                                $q->whereNotNull('a.prescription_file')
                                ->orWhereNotNull('a.consent_form_file');
                });

            // Apply search and date range filtering
            $filteredQuery = (clone $baseQuery);
            if (!empty($search)) {
                $filteredQuery->where(function ($q) use ($search) {
                    $q->where('a.patient_name', 'ILIKE', "%{$search}%")
                        ->orWhere('a.mobile_number', 'ILIKE', "%{$search}%")
                        ->orWhere('b.name', 'ILIKE', "%{$search}%")
                        ->orWhere('c.full_name', 'ILIKE', "%{$search}%")
                        ->orWhere('f.created_at', 'ILIKE', "%{$search}%")
                        ->orWhere('g.created_at', 'ILIKE', "%{$search}%")
                        ->orWhere('h.created_at', 'ILIKE', "%{$search}%")
                        ->orWhere('i.created_at', 'ILIKE', "%{$search}%")
                        ->orWhere('j.created_at', 'ILIKE', "%{$search}%")
                        ->orWhere('k.created_at', 'ILIKE', "%{$search}%")
                        ->orWhere('l.created_at', 'ILIKE', "%{$search}%")
                        ->orWhere('m.created_at', 'ILIKE', "%{$search}%")
                        ->orWhere('n.created_at', 'ILIKE', "%{$search}%")
                        ->orWhere('d.full_name', 'ILIKE', "%{$search}%");
                });
            }

            if (!empty($fromDate) && !empty($toDate)) {
                $filteredQuery->where(function ($q) use ($fromDate, $toDate) {
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
                $filteredQuery->where('a.educator_id', $educatorId);
            }

            if (!empty($digitalEducatorId)) {
                $filteredQuery->where('a.digital_educator_id', $digitalEducatorId);
            }
            // Correctly get total and filtered counts using distinct patient IDs
            $totalRecords = (clone $baseQuery)->count(DB::raw('DISTINCT a.id'));
            $recordsFiltered = (clone $filteredQuery)->count(DB::raw('DISTINCT a.id'));

            // Now, build the full query with SELECT, GROUP BY, ORDER, and LIMIT
            $query = $filteredQuery->select(
                'a.id as patient_id',
                'a.patient_name',
                'a.mobile_number',
                'b.name as doctor_name',
                'c.full_name as educator_name',
                'd.full_name as digital_educator_name',
                DB::raw("CAST(a.created_at AS DATE) as created_at"),
                DB::raw("CAST((a.created_at + interval '3 days') AS DATE) AS day3_planned_date"),
                DB::raw("CAST(o.created_at AS DATE) as day3_actual_date"),
                'o.callremark_3 as day_3_remark',
                DB::raw("CASE WHEN o.callremark_3 = 'Call Connect' THEN o.callconnect_subremark_3 WHEN o.callremark_3 = 'No Response' THEN o.noresponse_subremark_3 END AS day_3_details_remark"),
                'o.ae_report',
                DB::raw("CAST((a.created_at + interval '7 days') AS DATE) AS day7_planned_date"),
                DB::raw("CAST(f.created_at AS DATE) as day7_actual_date"),
                'f.callremark_7 as day_7_remark',
                DB::raw("CASE WHEN f.callremark_7 = 'Call Connect' THEN f.callconnect_subremark_7 WHEN f.callremark_7 = 'No Response' THEN f.noresponse_subremark_7 END AS day_7_details_remark"),
                'f.day7_ae_report',
                DB::raw("CAST((a.created_at + interval '15 days') AS DATE) AS day15_planned_date"),
                DB::raw("CAST(g.created_at AS DATE) as day15_actual_date"),
                'g.callremark_15 as day_15_remark',
                DB::raw("CASE WHEN g.callremark_15 = 'Call Connect' THEN g.callconnect_subremark_15 WHEN g.callremark_15 = 'No Response' THEN g.noresponse_subremark_15 END AS day_15_details_remark"),
                'g.day15_ae_report',
                DB::raw("CAST((a.created_at + interval '30 days') AS DATE) AS day30_planned_date"),
                DB::raw("CAST(h.created_at AS DATE) as day30_actual_date"),
                'h.callremark_30 as day_30_remark',
                DB::raw("CASE WHEN h.callremark_30 = 'Call Connect' THEN h.callconnect_subremark_30 WHEN h.callremark_30 = 'No Response' THEN h.noresponse_subremark_30 END AS day_30_details_remark"),
                'h.day30_ae_report',
                DB::raw("CAST((a.created_at + interval '45 days') AS DATE) AS day45_planned_date"),
                DB::raw("CAST(i.created_at AS DATE) as day45_actual_date"),
                'i.callremark_45 as day_45_remark',
                DB::raw("CASE WHEN i.callremark_45 = 'Call Connect' THEN i.callconnect_subremark_45 WHEN i.callremark_45 = 'No Response' THEN i.noresponse_subremark_45 END AS day_45_details_remark"),
                'i.day45_ae_report',
                DB::raw("CAST((a.created_at + interval '60 days') AS DATE) AS day60_planned_date"),
                DB::raw("CAST(j.created_at AS DATE) as day60_actual_date"),
                'j.callremark_60 as day_60_remark',
                DB::raw("CASE WHEN j.callremark_60 = 'Call Connect' THEN j.callconnect_subremark_60 WHEN j.callremark_60 = 'No Response' THEN j.noresponse_subremark_60 END AS day_60_details_remark"),
                'j.day60_ae_report',
                DB::raw("CAST((a.created_at + interval '90 days') AS DATE) AS day90_planned_date"),
                DB::raw("CAST(k.created_at AS DATE) as day90_actual_date"),
                'k.callremark_90 as day_90_remark',
                DB::raw("CASE WHEN k.callremark_90 = 'Call Connect' THEN k.callconnect_subremark_90 WHEN k.callremark_90 = 'No Response' THEN k.noresponse_subremark_90 END AS day_90_details_remark"),
                'k.day90_ae_report',
                DB::raw("CAST((a.created_at + interval '120 days') AS DATE) AS day120_planned_date"),
                DB::raw("CAST(l.created_at AS DATE) as day120_actual_date"),
                'l.callremark_120 as day_120_remark',
                DB::raw("CASE WHEN l.callremark_120 = 'Call Connect' THEN l.callconnect_subremark_120 WHEN l.callremark_120 = 'No Response' THEN l.noresponse_subremark_120 END AS day_120_details_remark"),
                'l.day120_ae_report',
                DB::raw("CAST((a.created_at + interval '150 days') AS DATE) AS day150_planned_date"),
                DB::raw("CAST(m.created_at AS DATE) as day150_actual_date"),
                'm.callremark_150 as day_150_remark',
                DB::raw("CASE WHEN m.callremark_150 = 'Call Connect' THEN m.callconnect_subremark_150 WHEN m.callremark_150 = 'No Response' THEN m.noresponse_subremark_150 END AS day_150_details_remark"),
                'm.day150_ae_report',
                DB::raw("CAST((a.created_at + interval '180 days') AS DATE) AS day180_planned_date"),
                DB::raw("CAST(n.created_at AS DATE) as day180_actual_date"),
                'n.callremark_180 as day_180_remark',
                DB::raw("CASE WHEN n.callremark_180 = 'Call Connect' THEN n.callconnect_subremark_180 WHEN n.callremark_180 = 'No Response' THEN n.noresponse_subremark_180 END AS day_180_details_remark"),
                'n.day180_ae_report'
            )->groupBy(
                    'a.id',
                    'b.name',
                    'c.full_name',
                    'd.full_name',
                    'a.created_at',
                    'o.callremark_3',
                    'o.callconnect_subremark_3',
                    'o.noresponse_subremark_3',
                    'o.created_at',
                    'o.ae_report',
                    'f.callremark_7',
                    'f.callconnect_subremark_7',
                    'f.noresponse_subremark_7',
                    'f.created_at',
                    'f.day7_ae_report',
                    'g.callremark_15',
                    'g.callconnect_subremark_15',
                    'g.noresponse_subremark_15',
                    'g.created_at',
                    'g.day15_ae_report',
                    'h.callremark_30',
                    'h.callconnect_subremark_30',
                    'h.noresponse_subremark_30',
                    'h.created_at',
                    'h.day30_ae_report',
                    'i.callremark_45',
                    'i.callconnect_subremark_45',
                    'i.noresponse_subremark_45',
                    'i.created_at',
                    'i.day45_ae_report',
                    'j.callremark_60',
                    'j.callconnect_subremark_60',
                    'j.noresponse_subremark_60',
                    'j.created_at',
                    'j.day60_ae_report',
                    'k.callremark_90',
                    'k.callconnect_subremark_90',
                    'k.noresponse_subremark_90',
                    'k.created_at',
                    'k.day90_ae_report',
                    'l.callremark_120',
                    'l.callconnect_subremark_120',
                    'l.noresponse_subremark_120',
                    'l.created_at',
                    'l.day120_ae_report',
                    'm.callremark_150',
                    'm.callconnect_subremark_150',
                    'm.noresponse_subremark_150',
                    'm.created_at',
                    'm.day150_ae_report',
                    'n.callremark_180',
                    'n.callconnect_subremark_180',
                    'n.noresponse_subremark_180',
                    'n.created_at',
                    'n.day180_ae_report'
                );

            // Ordering
            $orderColumnIndex = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir', 'asc');

            $columns = [
                'a.id',
                'a.id',
                'a.patient_name',
                'a.mobile_number',
                'b.name',
                'c.full_name',
                'd.full_name',
                'a.created_at',
                'a.created_at',
                'o.created_at',
                'o.callremark_3',
                null,
                'o.ae_report',
                'a.created_at',
                'f.created_at',
                'f.callremark_7',
                null,
                'f.day7_ae_report',
                'a.created_at',
                'g.created_at',
                'g.callremark_15',
                null,
                'g.day15_ae_report',
                'a.created_at',
                'h.created_at',
                'h.callremark_30',
                null,
                'h.day30_ae_report',
                'a.created_at',
                'i.created_at',
                'i.callremark_45',
                null,
                'i.day45_ae_report',
                'a.created_at',
                'j.created_at',
                'j.callremark_60',
                null,
                'j.day60_ae_report',
                'a.created_at',
                'k.created_at',
                'k.callremark_90',
                null,
                'k.day90_ae_report',
                'a.created_at',
                'l.created_at',
                'l.callremark_120',
                null,
                'l.day120_ae_report',
                'a.created_at',
                'm.created_at',
                'm.callremark_150',
                null,
                'm.day150_ae_report',
                'a.created_at',
                'n.created_at',
                'n.callremark_180',
                null,
                'n.day180_ae_report'
            ];

            if ($orderColumnIndex !== null && isset($columns[$orderColumnIndex]) && $columns[$orderColumnIndex] !== null) {
                $query->orderBy($columns[$orderColumnIndex], $orderDir);
            } else {
                $query->orderBy('a.id', 'desc'); // Default order
            }

            // Pagination
            $camps = $query
                ->offset($start)
                ->limit($length)
                ->get();

            // Add serial numbers
            $camps->transform(function ($camp, $index) use ($start) {
                $camp->sr = $start + $index + 1;
                return $camp;
            });

            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $recordsFiltered,
                'data' => $camps
            ]);

        } catch (\Exception $e) {
            Log::error('Get Feedback Details Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }


    public function pmmonthlyCounseling()
    {


        $data = Patient::select(
            DB::raw("TO_CHAR(date, 'Month') as month"),
            DB::raw("COUNT(*) as count")
        )
            ->where('date', '>=', Carbon::now()->subMonths(4))

            ->groupBy(DB::raw("TO_CHAR(date, 'Month')"), DB::raw("DATE_PART('month', date)"))
            ->orderBy(DB::raw("DATE_PART('month', date)"))
            ->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function pmgenderDistribution()
    {

        // Brand medicines
        $brandCount = DB::table('public.patient_details as pin')
            ->leftJoin('common.users as e', 'e.id', '=', 'pin.educator_id')
            ->leftJoin('common.rm_users as rm', 'rm.id', '=', 'e.rm_pm_id')
            ->whereNotNull('medicine')
            ->count();

        // Non-brand medicines
        $nonBrandCount = DB::table('public.patient_details as pin')
            ->leftJoin('common.users as e', 'e.id', '=', 'pin.educator_id')
            ->leftJoin('common.rm_users as rm', 'rm.id', '=', 'e.rm_pm_id')
            ->whereNotNull('compititor')
            ->count();

        $data = [
            ['type' => 'Brand', 'count' => $brandCount],
            ['type' => 'Non-brand', 'count' => $nonBrandCount]
        ];

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function pmcampDistribution()
    {
        $user_id = Auth::id();

        $data = Camp::select('date', DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('count', 'desc')
            ->limit('7')
            ->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function pmbloodPressure(Request $request)
    {
        $days = (int) $request->query('days', 5); // force integer

        $data = DB::table('patient_cardio_details as a')
            ->leftJoin('patient_details as b', 'a.uuid', '=', 'b.uuid')
            ->selectRaw("
        a.date::date as date,
        AVG(
            CAST(
                NULLIF(
                    CASE
                        WHEN split_part(a.blood_pressure, '/', 1) ~ '^[0-9]+$'
                        THEN split_part(a.blood_pressure, '/', 1)
                        ELSE NULL
                    END,
                '') AS INTEGER
            )
        ) as systolic,
        AVG(
            CAST(
                NULLIF(
                    CASE
                        WHEN split_part(a.blood_pressure, '/', 2) ~ '^[0-9]+$'
                        THEN split_part(a.blood_pressure, '/', 2)
                        ELSE NULL
                    END,
                '') AS INTEGER
            )
        ) as diastolic
    ")
            ->whereRaw("a.date >= NOW() - (? || ' days')::interval", [$days])
            ->groupBy(DB::raw('a.date::date'))
            ->orderBy(DB::raw('a.date::date'), 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function pmobesityMetrics(Request $request)
    {
        $data = DB::table('public.patient_details as pin')
            ->leftJoin('common.users as e', function ($join) {
                $join->on('e.id', '=', 'pin.educator_id')
                    ->where('e.role', '=', 'counsellor');
            })
            ->leftJoin('public.doctor as h', function ($join) {
                $join->on(DB::raw('pin.hcp_id::text'), '=', DB::raw('h.id::text'))
                    ->on('e.id', '=', 'h.educator_id');
            })
            ->whereNotNull('medicine')

            ->select('h.name', DB::raw('COUNT(*) as count'))
            ->groupBy('h.name')
            ->orderBy('count', 'desc') // or 'asc' if you want ascending order
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }




    public function pmdoctorNotMetrics(Request $request)
    {


        $data = DB::table('public.patient_details as pin')
            ->leftJoin('common.users as e', function ($join) {
                $join->on('e.id', '=', 'pin.educator_id')
                    ->where('e.role', '=', 'counsellor');
            })
            ->leftJoin('public.doctor as h', function ($join) {
                $join->on(DB::raw('pin.hcp_id::text'), '=', DB::raw('h.id::text'))
                    ->on('e.id', '=', 'h.educator_id');
            })
            ->whereNull('medicine')

            ->select('h.name', DB::raw('COUNT(*) as count'))
            ->groupBy('h.name')
            ->orderBy('count', 'desc') // or 'asc' if you want ascending order
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function pmtopeducators()
    {
        $data = DB::table('common.users as u')
            ->select('u.full_name as educator_name', DB::raw('COUNT(p.uuid) as session_count'))
            ->leftJoin('patient_details as p', 'u.id', '=', 'p.educator_id')
            ->where('u.role', 'counsellor')
            ->whereNotNull('p.medicine')
            ->groupBy('u.id', 'u.full_name')
            ->orderBy('session_count', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function pmnoteducator(Request $request)
    {
        $limit = $request->input('limit', 5);

        $data = DB::table('common.users as u')
            ->select(
                'u.full_name as educator_name',
                DB::raw('COUNT(p.id) as session_count')
            )
            ->leftJoin('patient_details as p', 'u.id', '=', 'p.educator_id')
            ->where('u.role', 'counsellor')
            ->whereNull('p.medicine')
            ->groupBy('u.id', 'u.full_name')
            ->orderBy('session_count', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    // inside PmController (or RMController)

    private function generateUsername($name)
    {
        // Remove all spaces and special characters, convert to lowercase
        $cleanName = preg_replace('/[^A-Za-z0-9]/', '', $name);

        // Generate 5 random digits
        $randomDigits = mt_rand(10000, 99999);

        // Combine and return
        return strtolower($cleanName) . $randomDigits;
    }

    public function pmcreateRmPost(Request $request)
    {
        // Validate inputs
        $request->validate([
            'emp_id' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'zone_id' => 'required|integer'
        ]);

        DB::beginTransaction();

        try {
            // Generate username using helper
            $userName = $this->generateUsername($request->name);
            $hashedPassword = hash('sha256', $request->password);

            // Insert RM
            $rmId = DB::table('common.rm_users')->insertGetId([
                'emp_id' => $request->emp_id,
                'full_name' => $request->name,
                'user_name' => $userName, // generated username
                'password' => $hashedPassword,
                'raw_password' => $request->password, // ⚠️ consider removing
                'zone_id' => $request->zone_id,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Regional Cordinator created successfully',
                'id' => $rmId,
                'username' => $userName
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Create RC Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => $e->getMessage() ?: 'Server error'
            ], 500);
        }
    }

    public function pmcreateDoctorPost(Request $request)
    {
        // Validate inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'msl_code' => 'required|string|max:50',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zone' => 'required|integer',
            'speciality' => 'required|string|max:100',
            'first_vist' => 'required|date',
            'consent_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        DB::beginTransaction(); // start transaction

        try {
            $consentImagePath = null;

            // Handle file upload
            if ($request->hasFile('consent_image')) {
                $file = $request->file('consent_image');

                // Custom filename => msl_code-timestamp.ext
                $fileName = $request->msl_code . '-' . time() . '.' . $file->getClientOriginalExtension();

                $destination = public_path('uploads/doctor_consent');

                // Ensure directory exists
                if (!file_exists($destination)) {
                    mkdir($destination, 0777, true);
                }

                // Try to move file
                if (!$file->move($destination, $fileName)) {
                    throw new \Exception('File upload failed');
                }

                // Store relative path in DB
                $consentImagePath = 'uploads/doctor_consent/' . $fileName;
            }

            // Insert doctor only if file upload succeeded
            $doctor = Doctor::create([
                'name' => $request->name,
                'msl_code' => $request->msl_code,
                'city' => $request->city,
                'state' => $request->state,
                'zone' => $request->zone,
                'speciality' => $request->speciality,
                'first_visit' => $request->first_vist,
                'consent_form_file' => $consentImagePath,
                'status' => '1'
            ]);

            DB::commit(); // commit only if everything succeeds

            return response()->json([
                'status' => true,
                'message' => 'Doctor created successfully',
                'id' => $doctor->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack(); // rollback if file upload or insert fails
            Log::error('Create Doctor Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => $e->getMessage() ?: 'Server error'
            ], 500);
        }

    }


    public function pmcreateDigitalEducatorPost(Request $request)
    {
        // Validate inputs
        $request->validate([
            'emp_id' => 'required|string|max:50',
            'first_name' => 'required|string|max:255',
            'password' => 'required|string|min:6',

        ]);

        DB::beginTransaction();

        try {
            // Generate username using helper
            $userName = $this->generateUsername($request->first_name);
            $hashedPassword = hash('sha256', $request->password);

            // Insert digital educator
            $educatorId = DB::table('common.users')->insertGetId([
                'emp_id' => $request->emp_id,
                'full_name' => $request->first_name,
                'user_name' => $userName, // generated username
                'password' => $hashedPassword,
                'raw_password' => $request->password, // ⚠️ consider removing
                'role' => 'digitalcounsellor',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Digital Counsellor created successfully',
                'id' => $educatorId,
                'username' => $userName
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Create Digital Counsellor Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => $e->getMessage() ?: 'Server error'
            ], 500);
        }
    }
    public function pmupdateDigitalEducatorPost(Request $request)
    {
        // Validate inputs
        $request->validate([
            'educator_id' => 'required|integer',
            'emp_id' => 'required|string|max:50',
            'first_name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6', // password is optional on update
        ]);

        DB::beginTransaction();

        try {
            // Prepare update data
            $updateData = [
                'emp_id' => $request->emp_id,
                'full_name' => $request->first_name,
                'updated_at' => now(),
            ];

            // If password is provided, hash and update it
            if (!empty($request->password)) {
                $updateData['password'] = hash('sha256', $request->password);
                $updateData['raw_password'] = $request->password; // ⚠️ remove in production
            }

            // Update educator
            DB::table('common.users')
                ->where('id', $request->educator_id)

                ->where('role', 'digitalcounsellor') // safety check
                ->update($updateData);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Digital Counsellor updated successfully',
                'id' => $request->educator_id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update Digital Counsellor Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => $e->getMessage() ?: 'Server error'
            ], 500);
        }
    }

    public function pmcreateEducatorPost(Request $request)
    {
        $request->validate([
            'emp_id' => 'required|string|max:50',
            'first_name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:15',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        DB::beginTransaction(); // start transaction

        try {
            $profileImagePath = null;

            // Handle file upload
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');

                // Custom filename => msl_code-timestamp.ext
                $fileName = $request->emp_id . '-' . time() . '.' . $file->getClientOriginalExtension();

                $destination = public_path('uploads/Educator_profile_image');

                // Ensure directory exists
                if (!file_exists($destination)) {
                    mkdir($destination, 0777, true);
                }

                // Try to move file
                if (!$file->move($destination, $fileName)) {
                    throw new \Exception('File upload failed');
                }

                // Store relative path in DB
                $profileImagePath = 'uploads/Educator_profile_image/' . $fileName;
            }

            // Insert doctor only if file upload succeeded
            $userName = $this->generateUsername($request->first_name);
            $hashedPassword = hash('sha256', $request->password);

            // Insert digital educator
            $educatorId = DB::table('common.users')->insertGetId([
                'emp_id' => $request->emp_id,
                'full_name' => $request->first_name,
                'user_name' => $userName, // generated username
                'password' => $hashedPassword,
                'raw_password' => $request->password,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'city' => $request->city,
                'state' => $request->state,
                'address' => $request->address,
                'profile_pic' => $profileImagePath, // store file path
                'role' => 'counsellor',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();
            // commit only if everything succeeds

            return response()->json([
                'status' => true,
                'message' => 'Counsellor created successfully',
                'id' => $request->emp_id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack(); // rollback if file upload or insert fails
            Log::error('Create Counsellor Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => $e->getMessage() ?: 'Server error'
            ], 500);
        }
    }
    public function getState(Request $request)
    {

        $StateDetails = State::orderBy('state')
            ->get(['id', 'state']); // Assuming camp_name exists
        $options = '<option value="">-- Select --</option>';
        foreach ($StateDetails as $row) {
            $options .= '<option value="' . $row->id . '">' . $row->state . '</option>';
        }

        return response()->json($options);
    }
    public function getCity(Request $request)
    {
        $StateId = $request->input('state');
        $CityDetails = City::where('state_code', $StateId)
            ->orderBy('city_name')
            ->get(['city_code', 'city_name']); // Assuming camp_name exists
        $options = '<option value="">-- Select --</option>';
        foreach ($CityDetails as $row) {
            $options .= '<option value="' . $row->city_code . '">' . $row->city_name . '</option>';
        }

        return response()->json($options);

    }
    public function getDigitalEducatorspatient()
    {
        $educators = DB::table('common.users')
            ->select('id', 'full_name')
            ->where('role', 'digitalcounsellor')
            ->get();

        return response()->json($educators);
    }

    public function assignDigitalEducatorpatient(Request $request)
    {
        DB::table('public.patient_details')
            ->where('uuid', $request->uuid)
            ->update(['digital_educator_id' => $request->digital_educator_id]);

        return response()->json(['success' => true]);
    }
    public function campReportExcel()
    {
         try {
            return Excel::download(new CampReportExport, 'Camp_Report.csv');
        } catch (\Exception $e) {
            \Log::error('Camp Report Excel Error (MIS): ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'error' => 'Failed to generate camp report',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function downloadDailyReport(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        return Excel::download(
            new DailyReportExport($fromDate, $toDate),
            'DailyReport.csv'
        );
    }
    public function pmupdateEducatorPost(Request $request)
    {
        $request->validate([
            'educator_id' => 'required|integer|',
            'emp_id' => 'required|string|max:50',
            'first_name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6', // allow empty if not changing password
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:15',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048' // not mandatory for update
        ]);

        DB::beginTransaction();

        try {
            $educator = DB::table('common.users')->where('id', $request->educator_id)->first();

            if (!$educator) {
                throw new \Exception("Counsellor not found");
            }

            $profileImagePath = $educator->profile_pic; // keep old if no new upload

            // Handle file upload if new image provided
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $fileName = $request->emp_id . '-' . time() . '.' . $file->getClientOriginalExtension();

                $destination = public_path('uploads/Educator_profile_image');
                if (!file_exists($destination)) {
                    mkdir($destination, 0777, true);
                }

                if (!$file->move($destination, $fileName)) {
                    throw new \Exception('File upload failed');
                }

                // Delete old image if exists
                if ($educator->profile_pic && file_exists(public_path($educator->profile_pic))) {
                    @unlink(public_path($educator->profile_pic));
                }

                $profileImagePath = 'uploads/Educator_profile_image/' . $fileName;
            }

            // Handle password (only update if provided)
            $hashedPassword = $educator->password;
            $rawPassword = $educator->raw_password;

            if ($request->filled('password')) {
                $hashedPassword = hash('sha256', $request->password);
                $rawPassword = $request->password;
            }

            // Update educator
            DB::table('common.users')
                ->where('id', $request->educator_id)
                ->update([
                    'emp_id' => $request->emp_id,
                    'full_name' => $request->first_name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'city' => $request->city,
                    'state' => $request->state,
                    'address' => $request->address,
                    'profile_pic' => $profileImagePath,
                    'password' => $hashedPassword,
                    'raw_password' => $rawPassword,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Counsellor updated successfully',
                'id' => $request->educator_id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update Counsellor Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => $e->getMessage() ?: 'Server error'
            ], 500);
        }
    }
    public function getDoctorById($id, Request $request)
    {
        $doctor = Doctor::where('id', $id)->first();
        return response()->json([
            'status' => true,
            'message' => 'doctor data retrieved successfully',
            'data' => $doctor
        ]);
    }

    public function pmupdateDoctorPost(Request $request)
    {
        // Validate inputs
        $request->validate([
            'doctor_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'msl_code' => 'required|string|max:50',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zone' => 'required|integer',
            'speciality' => 'required|string|max:100',
            'first_vist' => 'required|date',
            'consent_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        DB::beginTransaction();

        try {
            $consentImagePath = null;

            // Handle file upload if provided
            if ($request->hasFile('consent_image')) {
                $file = $request->file('consent_image');
                $fileName = $request->msl_code . '-' . time() . '.' . $file->getClientOriginalExtension();
                $destination = public_path('uploads/doctor_consent');

                if (!file_exists($destination)) {
                    mkdir($destination, 0777, true);
                }

                if (!$file->move($destination, $fileName)) {
                    throw new \Exception('File upload failed');
                }

                $consentImagePath = 'uploads/doctor_consent/' . $fileName;

                // Delete old file (fetch from DB)
                $oldFile = DB::table('doctor')
                    ->where('id', $request->doctor_id)
                    ->value('consent_form_file');

                if ($oldFile && file_exists(public_path($oldFile))) {
                    @unlink(public_path($oldFile));
                }
            }

            // Build update data
            $updateData = [
                'name' => $request->name,
                'msl_code' => $request->msl_code,
                'city' => $request->city,
                'state' => $request->state,
                'zone' => $request->zone,
                'speciality' => $request->speciality,
                'first_visit' => $request->first_vist,
                'status' => '1',
                'update_at' => now()
            ];

            if ($consentImagePath) {
                $updateData['consent_form_file'] = $consentImagePath;
            }

            // Perform update
            DB::table('doctor')
                ->where('id', $request->doctor_id)
                ->update($updateData);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Doctor updated successfully',
                'id' => $request->doctor_id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update Doctor Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => $e->getMessage() ?: 'Server error'
            ], 500);
        }
    }
    public function medicinepage(Request $request)
    {
        return view('pm.medicine');
    }
    public function getMedicine(Request $request)
    {
        if (!session()->has('emp_id')) {
            return response()->json(['error' => 'Session expired'], 401);
        }

        try {
            // DataTables params
            $draw = intval($request->input('draw', 0));
            $start = intval($request->input('start', 0));
            $length = intval($request->input('length', 10));
            $searchValue = trim($request->input('search.value', ''));

            // Ordering
            $orderColumnIndex = intval($request->input('order.0.column', 0));
            $orderDir = strtoupper($request->input('order.0.dir', 'ASC')) === 'DESC' ? 'DESC' : 'ASC';

            // Map DataTables column index to database columns
            $columns = [
                0 => 'm.id',
                1 => 'm.medicine_name',
                2 => 'mh.header'
            ];
            $orderColumn = $columns[$orderColumnIndex] ?? 'm.id';

            // Base query
            $query = Medicine::from('common.medicines as m')
                ->leftJoin('common.medicine_headers as mh', 'm.medicine_header_id', '=', 'mh.id')
                ->select([
                    'm.id',
                    'm.medicine_name',
                    'm.medicine_header_id', // Added for edit form
                    'mh.header as medicine_header',
                    'm.status'
                ])
                ->where('m.status', '1');

            // Apply search filter
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('m.medicine_name', 'ilike', "%{$searchValue}%");
                    $q->where('mh.header', 'ilike', "%{$searchValue}%");
                });
            }

            // Count before pagination
            $recordsFiltered = $query->count();
            $recordsTotal = Medicine::from('common.medicines as m')
                ->where('m.status', '1')
                ->count();

            // Apply ordering and pagination
            $data = $query->orderBy($orderColumn, $orderDir)
                ->skip($start)
                ->take($length)
                ->get();

            // Return JSON in DataTables format
            return response()->json([
                "draw" => $draw,
                "recordsTotal" => $recordsTotal,
                "recordsFiltered" => $recordsFiltered,
                "data" => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function getMedicineHeaders(Request $request)
    {
        try {
            $headers = \DB::table('common.medicine_headers')
                ->select('id', 'header')
                ->orderBy('header', 'ASC')
                ->get();

            return response()->json([
                'status' => true,
                'data' => $headers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch medicine headers',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function storeMedicine(Request $request)
    {
        try {
            $validated = $request->validate([
                'medicine_name' => 'required|string|max:50',
                'medicine_header' => 'required|integer',
            ]);

            $medicine = new Medicine();
            $medicine->medicine_name = $validated['medicine_name'];
            $medicine->medicine_header_id = $validated['medicine_header'];
            $medicine->status = 1;
            $medicine->save();

            return response()->json([
                'status' => true,
                'message' => 'Medicine created successfully',
                'data' => $medicine
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function updateMedicine(Request $request)
    {
        try {
            $validated = $request->validate([
                'medicine_id' => 'required|integer',
                'medicine_name' => 'required|string|max:50',
                'medicine_header' => 'required|integer',
            ]);

            $medicine = Medicine::find($validated['medicine_id']);
            $medicine->medicine_name = $validated['medicine_name'];
            $medicine->medicine_header_id = $validated['medicine_header'];
            $medicine->save();

            return response()->json([
                'status' => true,
                'message' => 'Medicine updated successfully',
                'data' => $medicine
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function deleteMedicine($id)
    {
        if (!session()->has('emp_id')) {
            return response()->json(['status' => false, 'message' => 'Session expired'], 401);
        }

        try {
            $medicine = Medicine::find($id);

            if (!$medicine) {
                return response()->json([
                    'status' => false,
                    'message' => 'Medicine not found'
                ], 404);
            }

            // Soft delete (set status=0) instead of permanent delete
            $medicine->status = 0;
            $medicine->save();

            return response()->json([
                'status' => true,
                'message' => 'Medicine deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function compitetorpage(Request $request)
    {
        return view('pm.compitetor');
    }

    public function getCompitetor(Request $request)
    {
        if (!session()->has('emp_id')) {
            return response()->json(['error' => 'Session expired'], 401);
        }

        try {
            // DataTables params
            $draw = intval($request->input('draw', 0));
            $start = intval($request->input('start', 0));
            $length = intval($request->input('length', 10));
            $searchValue = trim($request->input('search.value', ''));

            // Ordering
            $orderColumnIndex = intval($request->input('order.0.column', 0));
            $orderDir = strtoupper($request->input('order.0.dir', 'ASC')) === 'DESC' ? 'DESC' : 'ASC';

            // Map DataTables column index to database columns
            $columns = [
                0 => 'c.id',
                1 => 'c.compitetor_name',
            ];
            $orderColumn = $columns[$orderColumnIndex] ?? 'c.id';

            // Base query
            $query = Medicine::from('common.compitetor as c')
                ->select([
                    'c.id',
                    'c.compitetor_name'
                ])
                ->where('c.status', '1');

            // Apply search filter
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('c.compitetor_name', 'ilike', "%{$searchValue}%");
                });
            }

            // Count before pagination
            $recordsFiltered = $query->count();
            $recordsTotal = Medicine::from('common.compitetor as c')
                ->where('c.status', '1')
                ->count();

            // Apply ordering and pagination
            $data = $query->orderBy($orderColumn, $orderDir)
                ->skip($start)
                ->take($length)
                ->get();

            // Return JSON in DataTables format
            return response()->json([
                "draw" => $draw,
                "recordsTotal" => $recordsTotal,
                "recordsFiltered" => $recordsFiltered,
                "data" => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function storeCompitetor(Request $request)
    {
        try {
            $validated = $request->validate([
                'compitetor_name' => 'required|string|max:50',
            ]);

            $compitetor = new Compitetor();
            $compitetor->compitetor_name = $validated['compitetor_name'];
            $compitetor->status = 1;
            $compitetor->save();

            return response()->json([
                'status' => true,
                'message' => 'compitetor created successfully',
                'data' => $compitetor
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function updateCompitetor(Request $request)
    {
        try {
            $validated = $request->validate([
                'compitetor_id' => 'required|integer',
                'compitetor_name' => 'required|string|max:50',
            ]);

            $compitetor = Compitetor::find($validated['compitetor_id']);
            $compitetor->compitetor_name = $validated['compitetor_name'];
            $compitetor->save();

            return response()->json([
                'status' => true,
                'message' => 'compitetor updated successfully',
                'data' => $compitetor
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function deleteCompitetor($id)
    {
        if (!session()->has('emp_id')) {
            return response()->json(['status' => false, 'message' => 'Session expired'], 401);
        }

        try {
            $compitetor = Compitetor::find($id);

            if (!$compitetor) {
                return response()->json([
                    'status' => false,
                    'message' => 'compitetor not found'
                ], 404);
            }

            // Soft delete (set status=0) instead of permanent delete
            $compitetor->status = 0;
            $compitetor->save();

            return response()->json([
                'status' => true,
                'message' => 'compitetor deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
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
    public function pmPatientList()
    {
        return view('pm.pmPatientList');
    }
    // In your controller
    public function getPatientList(Request $request)
    {
        // Get request parameters from DataTable
        $draw = $request->get('draw');
            $start = $request->get('start');
            $length = $request->get('length');
            $search = $request->get('search');
            $searchValue = $search['value'] ?? '';

            $order = $request->get('order');
            $orderColumn = $order[0]['column'] ?? 0;
            $orderDir = $order[0]['dir'] ?? 'asc';

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
            'a.date',
            'a.approved_status'
            ,'d.full_name','e.full_name','f.full_name'
        ];

        $orderColumnName = $columns[$orderColumn] ?? 'a.id';

        // Base query
        $query = DB::table('public.patient_details as a')
            ->leftJoin('public.patient_medication_details as c', 'a.uuid', '=', 'c.uuid')
            ->leftJoin('public.doctor as g', DB::raw('CAST(a.hcp_id AS INTEGER)'), '=', 'g.id')
            ->leftjoin('common.users as d', 'a.educator_id', '=', 'd.id')
            ->leftJoin('common.users as e', 'a.digital_educator_id', '=', 'e.id')
            ->leftJoin('common.rm_users as f', 'd.rm_pm_id', '=', 'f.id')
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
                'a.approved_status',
                'd.full_name as educator_name',
                'e.full_name as digital_educator_name',
                'f.full_name as rm_name'
            )
            ->whereNotNull('a.patient_name');
        // Get total records count
        $totalRecords = $query->count();

        // Apply search filter if provided
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('a.patient_name', 'ilike', "%{$searchValue}%")
                    ->orWhere('a.mobile_number', 'ilike', "%{$searchValue}%")
                    ->orWhere('g.name', 'ilike', "%{$searchValue}%")
                    ->orWhere('a.cipla_brand_prescribed', 'ilike', "%{$searchValue}%")
                    ->orWhere('h.camp_id', 'ilike', "%{$searchValue}%")
                    ->orWhere('a.gender', 'ilike', "%{$searchValue}%")
                    ->orWhere('a.age', 'ilike', "%{$searchValue}%")
                    ->orWhere('a.approved_status', 'ilike', "%{$searchValue}%")
                    ->orWhere('d.full_name', 'ilike', "%{$searchValue}%")
                    ->orWhere('e.full_name', 'ilike', "%{$searchValue}%")
                    ->orWhere('f.full_name', 'ilike', "%{$searchValue}%");
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
    public function feedbackReportExcel(Request $request)
    {
        $fromDate = $request->query('fromDate');
        $toDate = $request->query('toDate');
        $educatorId = $request->query('educatorId');
        $digitalEducatorId = $request->query('digitalEducatorId');

        return Excel::download(
            new FeedbackReportExport($fromDate, $toDate, $educatorId, $digitalEducatorId),
            'FeedbackReport.csv'
        );
    }
}
