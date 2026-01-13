<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\Doctor;
use App\Models\Patient;
use Auth;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use DB;
class EducatorController extends Controller
{
    // ANALYTICS PAGE
    public function analytics()
    {
        return view('educator.analytics');
    }
    public function monthlyCounseling()
    {
        $user_id = Auth::id();

        $data = Patient::select(
            DB::raw("TO_CHAR(date, 'Month') as month"),
            DB::raw("COUNT(*) as count")
        )
            ->where('date', '>=', Carbon::now()->subMonths(4))
            ->where('educator_id', $user_id)
            ->groupBy(DB::raw("TO_CHAR(date, 'Month')"), DB::raw("DATE_PART('month', date)"))
            ->orderBy(DB::raw("DATE_PART('month', date)"))
            ->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function genderDistribution()
    {
        $user_id = Auth::id();

        $data = Patient::select('gender', DB::raw('COUNT(*) as count'))
            ->where('educator_id', $user_id)
            ->groupBy('gender')
            ->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function campDistribution()
    {
        $user_id = Auth::id();

        $data = Camp::where('educator_id', $user_id)
            ->select('date', DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('count', 'desc')
            ->limit('7')
            ->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function bloodPressure(Request $request)
    {
        $user_id = Auth::id();
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
            ->where('b.educator_id', $user_id)
            ->whereRaw("a.date >= NOW() - (? || ' days')::interval", [$days])
            ->groupBy(DB::raw('a.date::date'))
            ->orderBy(DB::raw('a.date::date'), 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function obesityMetrics(Request $request)
    {
        $user_id = Auth::id();
        $days = (int) $request->query('days', 5); // force integer

        $data = DB::table('patient_medication_details as A')
            ->leftJoin('patient_details as B', 'A.uuid', '=', 'B.uuid')
            ->select(
                DB::raw('DATE("A"."date") as date'),
                DB::raw("AVG(CAST(NULLIF(\"A\".\"bmi\", 'Na') AS NUMERIC)) as bmi"),
                DB::raw("AVG(CAST(NULLIF(\"A\".\"waist_to_height_ratio\", 'Na') AS NUMERIC)) as whr")
            )
            ->where('A.date', '>=', DB::raw("NOW() - INTERVAL '$days days'"))
            ->where('B.educator_id', '=', $user_id)
            ->groupBy(DB::raw('DATE("A"."date")'))
            ->orderBy('date')
            ->limit(5)
            ->get();

        return response()->json(['success' => true, 'data' => $data]);
    }


    public function doctorMetrics(Request $request)
    {
        $user_id = Auth::id();

        $data = DB::table('public.patient_details as pin')
            ->leftJoin('common.users as e', function ($join) {
                $join->on('e.id', '=', 'pin.educator_id')
                    ->where('e.role', '=', 'educator');
            })
            ->leftJoin('public.doctor as h', function ($join) {
                $join->on(DB::raw('pin.hcp_id::text'), '=', DB::raw('h.id::text'))
                    ->on('e.id', '=', 'h.educator_id');
            })
            ->whereNotNull('medicine')
            ->where('pin.educator_id', $user_id)
            ->select('h.name', DB::raw('COUNT(*) as count'))
            ->groupBy('h.name')
            ->orderBy('h.name')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }


    public function doctorNotMetrics(Request $request)
    {
        $user_id = Auth::id();

        $data = DB::table('public.patient_details as pin')
            ->leftJoin('common.users as e', function ($join) {
                $join->on('e.id', '=', 'pin.educator_id')
                    ->where('e.role', '=', 'educator');
            })
            ->leftJoin('public.doctor as h', function ($join) {
                $join->on(DB::raw('pin.hcp_id::text'), '=', DB::raw('h.id::text'))
                    ->on('e.id', '=', 'h.educator_id');
            })
            ->whereNull('medicine')
            ->where('pin.educator_id', $user_id)
            ->select('h.name', DB::raw('COUNT(*) as count'))
            ->groupBy('h.name')
            ->orderBy('h.name')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    //CAMP PAGE
    public function camp(Request $request)
    {
        return view('educator.camp');
    }
    public function getDoctors()
    {
        $educatorId = Auth::id(); // Cleaner than Auth::user()->id

        $doctors = Doctor::select('id', 'name')
            ->where('educator_id', $educatorId)
            ->get();

        return response()->json($doctors);
    }


    public function getHCLDetails(Request $request)
    {
        $doctor = DB::table('doctors')->where('id', $request->doctor_id)->first();
        if ($doctor) {
            return response()->json([
                'status' => 'success',
                'msl_code' => $doctor->msl_code,
                'city' => $doctor->city,
                'speciality' => $doctor->speciality
            ]);
        }
        return response()->json(['status' => 'error']);
    }

    public function getOngoingCamp()
    {
        $educatorId = Auth::user()->id;
        $date = now()->toDateString();

        $campData = Camp::where('educator_id', $educatorId)
            ->whereDate('date', $date)
            ->whereNotNull('in_time')
            ->whereNull('out_time')
            ->first();

        return response()->json($campData);
    }

    public function stopCamp(Request $request)
    {
        $request->validate([
            'camp_id' => 'required|integer',
            'remarks' => 'nullable|string|max:255'
        ]);

        $educatorId = Auth::id(); // Assuming educator_id is the logged-in user ID
        $campId = $request->camp_id;
        $remarks = $request->remarks;

        $campData = Camp::where('educator_id', $educatorId)
            ->where('id', $campId)
            ->first();

        if (!$campData) {
            return response()->json(['message' => 'Invalid Details'], 400);
        }

        Camp::where('id', $campId)
            ->update([
                'out_time' => now()->setTimezone('Asia/Kolkata'),
                'remarks' => $remarks
            ]);

        return response()->json(['message' => 'Your Camp is End Now']);
    }

    public function startCamp(Request $request)
    {
        $request->validate([
            'camp_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'doctor_name' => 'required|string|max:255'
        ]);

        $educatorId = Auth::id();
        $date = now()->toDateString();

        $existingCamp = Camp::where('educator_id', $educatorId)
            ->whereDate('date', $date)
            ->whereNotNull('in_time')
            ->whereNull('out_time')
            ->first();

        if ($existingCamp) {
            return response()->json(['message' => 'Please Close Previous Camp'], 400);
        }

        Camp::insert([
            'educator_id' => $educatorId,
            'date' => $date,
            'in_time' => now()->setTimezone('Asia/Kolkata'),
            'camp_id' => $request->camp_id,
            'hcp_id' => $request->doctor_id,
            'hcp_name' => $request->doctor_name
        ]);

        return response()->json(['message' => 'Your Camp is Start']);
    }

    public function executed(Request $request)
    {
        $request->validate([
            'camp_id' => 'required|integer',
            'execution_status' => 'required|string|max:50'
        ]);

        $educatorId = Auth::id();
        $camp = Camp::where('educator_id', $educatorId)
            ->where('id', $request->camp_id)
            ->first();

        if (!$camp) {
            return response()->json(['message' => 'Camp is NOT Started'], 400);
        }

        Camp::where('id', $request->camp_id)
            ->update([
                'execution_status' => $request->execution_status
            ]);

        return response()->json(['message' => 'Your Execution Status is Updated']);
    }

    public function notExecuted(Request $request)
    {
        $request->validate([
            'camp_id' => 'required|integer',
            'execution_status' => 'required|string|max:50',
            'remarks' => 'nullable|string|max:255'
        ]);

        $educatorId = Auth::id();
        $camp = Camp::where('educator_id', $educatorId)
            ->where('id', $request->camp_id)
            ->first();

        if (!$camp) {
            return response()->json(['message' => 'Camp is NOT Started'], 400);
        }

        Camp::where('id', $request->camp_id)
            ->update([
                'execution_status' => $request->execution_status,
                'remarks' => $request->remarks
            ]);

        return response()->json(['message' => 'Your Execution Status is Updated']);
    }

    public function uploadDocuments(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'patient_name' => 'required|string|max:255',
            'consent_form' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'purchase_bill' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'prescription_file.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf'
        ]);

        $patient = Patient::findOrFail($request->patient_id);

        $allowedImageExt = ['jpg', 'jpeg', 'png'];
        $prescriptionFilenames = [];
        $consentFilename = null;
        $purchaseBillFilename = null;

        // === Consent Form ===
        if ($request->hasFile('consent_form')) {
            $file = $request->file('consent_form');
            $extension = strtolower($file->getClientOriginalExtension());

            if (in_array($extension, $allowedImageExt)) {
                // Convert to webp
                $consentFilename = 'consent/' . 'consent_' . time() . '_' . Str::random(10) . '.webp';
                $image = Image::make($file)
                    ->resize(1024, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('webp', 75);
                Storage::disk('private')->put($consentFilename, (string) $image);
            } else {
                // Store pdf as-is
                $consentFilename = 'consent/' . time() . '_' . Str::random(10) . '_' . $file->getClientOriginalName();
                Storage::disk('private')->putFileAs('consent', $file, basename($consentFilename));
            }

            $patient->consent_form_file = $consentFilename;
        }

        // === Purchase Bill ===
        if ($request->hasFile('purchase_bill')) {
            $file = $request->file('purchase_bill');
            $extension = strtolower($file->getClientOriginalExtension());

            if (in_array($extension, $allowedImageExt)) {
                $purchaseBillFilename = 'purchasebill/' . 'bill_' . time() . '_' . Str::random(10) . '.webp';
                $image = Image::make($file)
                    ->resize(1024, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('webp', 75);
                Storage::disk('private')->put($purchaseBillFilename, (string) $image);
            } else {
                $purchaseBillFilename = 'purchasebill/' . time() . '_' . Str::random(10) . '_' . $file->getClientOriginalName();
                Storage::disk('private')->putFileAs('purchasebill', $file, basename($purchaseBillFilename));
            }

            $patient->purchase_bill = $purchaseBillFilename;
        }

        // === Prescription Files ===
        if ($request->hasFile('prescription_file')) {
            foreach ($request->file('prescription_file') as $file) {
                $extension = strtolower($file->getClientOriginalExtension());

                if (in_array($extension, $allowedImageExt)) {
                    $filename = 'prescription/' . 'rx_' . time() . '_' . Str::random(10) . '.webp';
                    $image = Image::make($file)
                        ->resize(1024, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->encode('webp', 75);
                    Storage::disk('private')->put($filename, (string) $image);
                } else {
                    $filename = 'prescription/' . time() . '_' . Str::random(10) . '_' . $file->getClientOriginalName();
                    Storage::disk('private')->putFileAs('prescription', $file, basename($filename));
                }

                $prescriptionFilenames[] = $filename;
            }

            $patient->prescription_file = implode(',', $prescriptionFilenames);
        }

        // === Save DB ===
        $patient->approved_status = 'Pending';
        $patient->patient_name = $request->patient_name; // Update patient name
        $patient->save();

        return response()->json([
            'success' => true,
            'message' => 'Documents uploaded successfully',
            'data' => [
                'consent_form' => $consentFilename,
                'purchase_bill' => $purchaseBillFilename,
                'prescriptions' => $prescriptionFilenames
            ]
        ]);
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
    }

}
