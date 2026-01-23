<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\Compitetor;
use App\Models\Doctor;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\PatientCardioDetail;
use App\Models\PatientMedicationDetail;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use File;
use Illuminate\Http\Request;
use Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class PatientController extends Controller
{
    public function patientform(Request $request)
    {
        return redirect()->route('educator.patient.step1');
    }

    public function step1View(Request $request, $uuid = null)
    {
        $data = [];
        if($uuid) {
            $data['patient'] = Patient::where('uuid', $uuid)->first();
            $data['uuid'] = $uuid;
        }
        return view('educator.patientform_step1', $data);
    }

    public function step2View($uuid)
    {
        $patient = Patient::where('uuid', $uuid)->firstOrFail();
        return view('educator.patientform_step2', ['patient' => $patient, 'uuid' => $uuid]);
    }

    public function step3View($uuid)
    {
        $patient = Patient::where('uuid', $uuid)->firstOrFail();
        $medication = PatientMedicationDetail::where('uuid', $uuid)->first();
        return view('educator.patientform_step3', ['patient' => $patient, 'medication' => $medication, 'uuid' => $uuid]);
    }

    public function step4View($uuid)
    {
        $patient = Patient::where('uuid', $uuid)->firstOrFail();
        return view('educator.patientform_step4', ['patient' => $patient, 'uuid' => $uuid]);
    }

    public function patientlist()
    {
        return view('educator.patientlist');

    }
    public function getcampid(Request $request)
    {
        $user_id = Auth::id();
        $today = Carbon::now('Asia/Kolkata')->toDateString();
        $campid = Camp::where('educator_id', $user_id)
            ->whereNotNull('in_time')
            ->whereNull('out_time')
            ->whereDate('in_time', $today)
            ->orderBy('id', 'desc')
            ->select('id as camp_id')
            ->first();
        return response([
            'campId' => $campid
        ]);
    }
    public function gethcpnames(Request $request)
    {
        $user_id = Auth::id();
        $data = Doctor::where('educator_id', $user_id)->select('id', 'name')->get();

        return response([
            'data' => $data
        ]);
    }
    public function gethcpnamesall(Request $request)
    {
        $user_id = Auth::id();
         $data = Doctor::select('id', 'name')
        ->orderBy('name', 'asc') // ascending order by name
        ->get();

        return response([
            'data' => $data
        ]);
    }
    public function getHCLDetails(Request $request)
    {
        $user_id = Auth::id();
        $doctor_id = $request->input('doctor_id');
        $data = Doctor::where('educator_id', $user_id)
            ->where('id', $doctor_id)
            ->get();
        return response([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function getHCLDetailsall(Request $request)
    {
        $user_id = Auth::id();
        $doctor_id = $request->input('doctor_id');
        $data = Doctor::where('id', $doctor_id)
            ->get();
        return response([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function getCompetitors(Request $request)
    {
        $compitetor = Compitetor::where('status', '1')->get();

        return response([
            'data' => $compitetor,
        ]);

    }
    public function getMedicines(Request $request)
    {
        $medicines = Medicine::where('status', '1')->get();

        return response([
            'data' => $medicines,
        ]);
    }
    public function saveStep1(Request $request)
    {
        try {
            $educatorId = Auth::id();
            $uuid = $request->input('patient_uuid');
            $digitaleducatorid = User::where('id', $educatorId)->value('digital_educator_id');

            if (!$uuid) {
                $uuid = Str::uuid();
                $patient = new Patient();
                $patient->uuid = $uuid;
                $patient->created_at = now();
            } else {
                $patient = Patient::where('uuid', $uuid)->firstOrFail();
            }

            $patient->educator_id = $educatorId;
            $patient->digital_educator_id = $digitaleducatorid;
            $patient->camp_id = $request->input('campId');
            $patient->hcp_id = $request->input('hcp_name');
            $patient->date = now()->format('Y-m-d');
            $patient->save();

            return response()->json(['success' => true, 'uuid' => $uuid]);
        } catch (\Exception $e) {
             return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function saveStep2(Request $request)
    {
         try {
            $uuid = $request->input('patient_uuid');
            if (!$uuid) return response()->json(['success' => false, 'message' => 'UUID missing'], 400);

            $patient = Patient::where('uuid', $uuid)->firstOrFail();
            $patient->patient_name = $request->input('patient_name');
            $patient->mobile_number = $request->input('mobile_number');
            $patient->age = $request->input('age');
            $patient->gender = $request->input('gender');
            $patient->patient_city = $request->input('patient_city');
            $patient->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
             return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function saveStep3(Request $request)
    {
        try {
            $uuid = $request->input('patient_uuid');
            if (!$uuid) return response()->json(['success' => false, 'message' => 'UUID missing'], 400);

            $details = PatientMedicationDetail::firstOrNew(['uuid' => $uuid]);
            $details->weight = $request->input('weight');
            $details->height = $request->input('height');
            $details->waist_circumference = $request->input('waist_circumference');
            $details->bmi = $request->input('bmi');
            $details->waist_to_height_ratio = $request->input('w_htr');
            $details->metabolic_age = $request->input('metabolic_age');
            $details->co_morbidities = $request->input('co_morbidities');
            $details->remark = $request->input('additional_notes');
            $details->date = now()->format('Y-m-d');
            
            if (!$details->exists) {
                $details->created_at = now();
            }
            $details->update_at = now();
            $details->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
             return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function createPatientInquiryPost(Request $request)
    {
        $educatorId = Auth::id();
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        
        $ciplaPrescribed = $request->input('sunpharma_prescribed', 'No'); // Changed input name from frontend
        $patientEnrolled = $request->input('patientEnrolled', 'No');
        $prescription_available = $request->input('prescription_available', 'No'); // Frontend doesn't seem to send this explicitly in step 4 block? Checking form...
        
        $brandPrescribed = $request->input('brand_prescribed');
        $competitorBrand = $request->input('competitor_brand');
        
        $prescriptionFilenames = [];
        $consentFilename = null;
        $purchasebillname = null;
        
        // Handling File Uploads
        if ($request->hasFile('prescription_file')) { // New field name
            $file = $request->file('prescription_file');
            $extension = strtolower($file->getClientOriginalExtension());
             if (in_array($extension, $allowedExtensions)) {
                $filename = time() . '_' . Str::random(10) . '.webp';
                $image = Image::make($file)->resize(1024, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('webp', 75);
                Storage::disk('private')->put('prescription/' . $filename, (string) $image);
                $prescriptionFilenames[] = 'prescription/' . $filename;
             }
        }
        
        if ($request->hasFile('consent_form')) { // New field name
             $file = $request->file('consent_form');
             $extension = strtolower($file->getClientOriginalExtension());
             if (in_array($extension, $allowedExtensions)) {
                $filename = 'consent/' . 'Consent_' . time() . '_' . Str::random(10) . '.webp';
                $image = Image::make($file)->resize(1024, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('webp', 75);
                Storage::disk('private')->put($filename, (string) $image);
                $consentFilename = $filename;
             }
        }

        // ---------- DB Insert/Update ----------
        $uuid = $request->input('patient_uuid');
        if (!$uuid) {
            // Should not happen if wizard flow is followed, but fallback
            $uuid = Str::uuid();
        }
        
        $currentDate = now()->format('Y-m-d');
        $timestamp = now()->toDateTimeString();
        $digitaleducatorid = User::where('id', $educatorId)->value('digital_educator_id');
        
        $hasPrescription = !empty($prescriptionFilenames);
        $hasConsent      = !empty($consentFilename);
        
        // Default Approved Logic
        $approvedStatus = 'Approved';
        if ($hasPrescription || $hasConsent) {
            $approvedStatus = 'Pending';
        }

        DB::beginTransaction();
        try {
            $patient = Patient::updateOrCreate(
                ['uuid' => $uuid],
                [
                    'educator_id' => $educatorId,
                    'digital_educator_id' => $digitaleducatorid,
                    'cipla_brand_prescribed' => $ciplaPrescribed, // Note: DB column might be cipla_brand_prescribed
                    'medicine' => $brandPrescribed,
                    'compititor' => $competitorBrand,
                    'prescription_file' => !empty($prescriptionFilenames) ? implode(',', $prescriptionFilenames) : null,
                    'consent_form_file' => $consentFilename,
                    'approved_status' => $approvedStatus,
                    'date' => $currentDate,
                    'date' => $currentDate,
                ]
            );

            PatientMedicationDetail::updateOrCreate(
                ['uuid' => $uuid],
                [
                    'date' => $currentDate,
                    'update_at' => $timestamp
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Patient information submitted successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function getPatientList(Request $request)
    {
        // If this is not an AJAX request, return the view
        if (!$request->ajax() && !$request->expectsJson()) {
            return view('educator.patientlist');
        }

        // AJAX request - return JSON data for DataTable
        $user_id = Auth::id();
        $draw = $request->get('draw', 1);
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $search = $request->get('search', []);
        $searchValue = $search['value'] ?? '';

        $order = $request->get('order', []);
        $orderColumn = $order[0]['column'] ?? 0;
        $orderDir = $order[0]['dir'] ?? 'desc';

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
        $query = DB::table('public.patient_details as a')
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
                'c.height',
                'c.weight',
                'a.cipla_brand_prescribed',
                'h.camp_id',
                'g.name as doctor_name',
            )
            ->where('a.educator_id', $user_id)
            ->whereNotNull('a.patient_name');

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
    public function DigitalcreatePatientInquiryPost(Request $request)
    {
        $educatorId = Auth::id();
         $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp']; // added webp
        $uploadDirs = ['prescription', 'consent', 'purchasebill'];

        $ciplaPrescribed = $request->input('ciplaBrandPrescribed', 'No');
        $patientEnrolled = $request->input('patientEnrolled', 'No');
        $prescription_available = $request->input('prescription_available', 'No');
        $medicineString = null;
        $prescriptionFilenames = [];
        $consentFilename = '';
        $purchasebillname = '';

        // Helper for optional inputs
        $getOrNull = fn($key) => $request->has($key) ? $request->input($key) : null;

        // ---------- Handle Prescription & Consent ----------
        if ($ciplaPrescribed == 'Yes' && $patientEnrolled == 'Yes' && $prescription_available == 'Yes') {
            if (!$request->hasFile('fileToUpload')) {
                return response()->json(['success' => false, 'message' => "Please upload Prescription."], 422);
            }
            if (!$request->hasFile('consentForm')) {
                return response()->json(['success' => false, 'message' => "Please upload Consent Form."], 422);
            }

            // Prescription images
            foreach ($request->file('fileToUpload') as $file) {
                $extension = strtolower($file->getClientOriginalExtension());
                if (!in_array($extension, $allowedExtensions)) {
                    return response()->json(['success' => false, 'message' => "Invalid prescription file format: {$file->getClientOriginalName()}"], 422);
                }

                // Convert to WebP and resize
                $filename = time() . '_' . Str::random(10) . '.webp';
                $image = Image::make($file)->resize(1024, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('webp', 75);

                Storage::disk('private')->put('prescription/' . $filename, (string) $image);
                $prescriptionFilenames[] = 'prescription/' . $filename;
            }

            // Consent Form
            $consentFile = $request->file('consentForm');
            $extension = strtolower($consentFile->getClientOriginalExtension());
            if (!in_array($extension, $allowedExtensions)) {
                return response()->json(['success' => false, 'message' => 'Invalid consent form file format.'], 422);
            }

            $consentFilename = 'consent/' . 'Consent_' . time() . '_' . Str::random(10) . '.webp';
            $image = Image::make($consentFile)->resize(1024, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('webp', 75);
            Storage::disk('private')->put($consentFilename, (string) $image);

            if ($request->filled('medicine')) {
                $medicineString = implode(',', $request->input('medicine'));
            }
        } elseif ($ciplaPrescribed == 'Yes' && $patientEnrolled == 'Yes' && $prescription_available == 'No') {
            if ($request->filled('medicine')) {
                $medicineString = implode(',', $request->input('medicine'));
            }
        } elseif ($ciplaPrescribed == 'Yes' && $patientEnrolled == 'No' && $prescription_available == 'No') {
            if ($request->hasFile('consentForm')) {
                return response()->json(['success' => false, 'message' => 'Consent form not required. Please remove it.'], 422);
            }
            if ($request->filled('medicine')) {
                $medicineString = implode(',', $request->input('medicine'));
            }
        } elseif ($ciplaPrescribed == 'Yes' && $patientEnrolled == 'No' && $prescription_available == 'Yes') {
            if (!$request->hasFile('fileToUpload')) {
                return response()->json(['success' => false, 'message' => "Please upload Prescription."], 422);
            }

            foreach ($request->file('fileToUpload') as $file) {
                $extension = strtolower($file->getClientOriginalExtension());
                if (!in_array($extension, $allowedExtensions)) {
                    return response()->json(['success' => false, 'message' => "Invalid prescription file format: {$file->getClientOriginalName()}"], 422);
                }

                $filename = time() . '_' . Str::random(10) . '.webp';
                $image = Image::make($file)->resize(1024, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('webp', 75);

                Storage::disk('private')->put('prescription/' . $filename, (string) $image);
                $prescriptionFilenames[] = 'prescription/' . $filename;
            }

            if ($request->hasFile('consentForm')) {
                return response()->json(['success' => false, 'message' => 'Consent form not required. Please remove it.'], 422);
            }

            if ($request->filled('medicine')) {
                $medicineString = implode(',', $request->input('medicine'));
            }
        }

        // ---------- Handle Purchase Bill ----------
        $prescribedselect = $request->input('prescribedselect', 'No');
        if ($prescribedselect === 'Purchase Bill Available') {
            if (!$request->hasFile('purchasebill')) {
                return response()->json(['success' => false, 'message' => "Please upload purchasebill."], 422);
            }

            $purchasebillFile = $request->file('purchasebill');
            $purchasebillname = 'purchasebill/' . 'purchasebill_' . time() . '_' . Str::random(10) . '.webp';
            $image = Image::make($purchasebillFile)->resize(1024, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('webp', 75);

            Storage::disk('private')->put($purchasebillname, (string) $image);
        }

        // ---------- DB Insert ----------
        $uuid = Str::uuid();
        $currentDate = now()->format('Y-m-d');
        $timestamp = now()->toDateTimeString(); // same as format('Y-m-d H:i:s')
        DB::beginTransaction();
        try {
            Patient::create([
                'uuid' => $uuid,
                'digital_educator_id' => $educatorId,
                'camp_id' => $request->input('campId'),
                'hcp_id' => $request->input('hcp_name'),
                'patient_name' => $getOrNull('patient_name'),
                'age' => $getOrNull('age'),
                'mobile_number' => $getOrNull('mobile_number'),
                'gender' => $getOrNull('gender'),
                'medicine' => $medicineString,
                'compititor' => $request->filled('Compititor') ? implode(',', $request->input('Compititor')) : null,
                'consent_form_file' => $consentFilename ?: null,
                'prescription_file' => !empty($prescriptionFilenames) ? implode(',', $prescriptionFilenames) : null,
                'cipla_brand_prescribed' => $getOrNull('ciplaBrandPrescribed'),
                'date' => $currentDate,
                'created_at' => $timestamp
            ]);

            PatientMedicationDetail::create([
                'uuid' => $uuid,
                'weight' => $getOrNull('weight'),
                'height' => $getOrNull('height'),
                'waist_circumference' => $getOrNull('waist_circumference'),
                'bmi' => $getOrNull('bmi'),
                'waist_to_height_ratio' => $getOrNull('waist_to_height_ratio'),
                'metabolic_age' => $getOrNull('metabolic_age'),
                'co_morbidities' => $getOrNull('co_morbidities'),
                'remark' => $getOrNull('remark'),
                'date' => $currentDate,
                'created_at' => $timestamp,
                'update_at' => $timestamp
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Patient information submitted successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded files if transaction fails
            foreach (array_merge($prescriptionFilenames, [$consentFilename, $purchasebillname]) as $file) {
                if ($file && Storage::disk('private')->exists($file)) {
                    Storage::disk('private')->delete($file);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
