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
        return view('educator.patientform');
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
    public function createPatientInquiryPost(Request $request)
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
        $digitaleducatorid = User::where('id', $educatorId)->value('digital_educator_id');
        $hasPrescription = !empty($prescriptionFilenames);
        $hasConsent      = !empty($consentFilename);
        $hasPurchaseBill = !empty($purchasebillname);

        // Default Approved
        $approvedStatus = 'Approved';

        if ($hasPrescription || $hasConsent || $hasPurchaseBill) {
            $approvedStatus = 'Pending';
        }
        DB::beginTransaction();
        try {
            Patient::create([
                'uuid' => $uuid,
                'educator_id' => $educatorId,
                'digital_educator_id' => $digitaleducatorid,
                'camp_id' => $getOrNull('campId'),
                'hcp_id' => $request->input('hcp_name'),
                'patient_name' => $getOrNull('patient_name'),
                'age' => $getOrNull('age'),
                'mobile_number' => $getOrNull('mobile_number'),
                'gender' => $getOrNull('gender'),
                'medicine' => $medicineString,
                'patient_enrolled' => $getOrNull('patientEnrolled'),
                'patient_kit_enrolled' => $getOrNull('patient_kit_enrolled'),
                'compititor' => $request->filled('Compititor') ? implode(',', $request->input('Compititor')) : null,
                'consent_form_file' => $consentFilename ?: null,
                'prescription_file' => !empty($prescriptionFilenames) ? implode(',', $prescriptionFilenames) : null,
                'cipla_brand_prescribed' => $getOrNull('ciplaBrandPrescribed'),
                'cipla_brand_prescribed_no_option' => $getOrNull('prescribedselect'),
                'prescription_available' => $getOrNull('prescription_available'),
                'purchase_bill' => $purchasebillname ?: null,
                'date' => $currentDate,
                'approved_status' => $approvedStatus,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ]);

            PatientCardioDetail::create([
                'uuid' => $uuid,
                'date_of_discharge' => $getOrNull('date_of_discharge'),
                'blood_pressure' => $getOrNull('blood_pressure'),
                'urea' => $getOrNull('urea'),
                'lv_ef' => $getOrNull('lv_ef'),
                'heart_rate' => $getOrNull('heart_rate'),
                'nt_pro_bnp' => $getOrNull('nt_pro_bnp'),
                'egfr' => $getOrNull('egfr'),
                'potassium' => $getOrNull('potassium'),
                'sodium' => $getOrNull('sodium'),
                'uric_acid' => $getOrNull('uric_acid'),
                'creatinine' => $getOrNull('creatinine'),
                'crp' => $getOrNull('crp'),
                'uacr' => $getOrNull('uacr'),
                'iron' => $getOrNull('iron'),
                'hb' => $getOrNull('hb'),
                'ldl' => $getOrNull('ldl'),
                'hdl' => $getOrNull('hdl'),
                'triglycerid' => $getOrNull('triglycerid'),
                'total_cholesterol' => $getOrNull('total_cholesterol'),
                'hba1c' => $getOrNull('hba1c'),
                'sgot' => $getOrNull('sgot'),
                'sgpt' => $getOrNull('sgpt'),
                'vit_d' => $getOrNull('vit_d'),
                'anti_diabetic_therapy' => $getOrNull('anti_diabetic_therapy'),
                'sglt2_inhibitors' => $getOrNull('sglt2_inhibitors'),
                't3' => $getOrNull('t3'),
                't4' => $getOrNull('t4'),
                'date' => $currentDate,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ]);

            PatientMedicationDetail::create([
                'uuid' => $uuid,
                'arni' => $getOrNull('arni'),
                'b_blockers' => $getOrNull('b_blockers'),
                'mra' => $getOrNull('mra'),
                'arni_remark' => $getOrNull('arni_remark'),
                'b_blockers_remark' => $getOrNull('b_blockers_remark'),
                'mra_remark' => $getOrNull('mra_remark'),
                'remark' => $getOrNull('remark'),
                'weight' => $getOrNull('weight'),
                'height' => $getOrNull('height'),
                'waist_circumference_remark' => $getOrNull('waist_circumference_remark'),
                'bmi' => $getOrNull('bmi'),
                'waist_to_height_ratio' => $getOrNull('waist_to_height_ratio'),
                'vaccination' => $getOrNull('vaccination'),
                'influenza' => $getOrNull('influenza'),
                'pneumococcal' => $getOrNull('pneumococcal'),
                'cardiac_rehab' => $getOrNull('cardiac_rehab'),
                'nsaids_use' => $getOrNull('nsaids_use'),
                'patient_kit_given' => $getOrNull('patient_kit_given'),
                'exercise_30mins' => $getOrNull('exercise_30mins'),
                'food_habits' => $getOrNull('food_habits'),
                'sedentary_hours' => $getOrNull('sedentary_hours'),
                'type_2_dm' => $getOrNull('type_2_dm'),
                'hypertension' => $getOrNull('hypertension'),
                'dyslipidemia' => $getOrNull('dyslipidemia'),
                'pco' => $getOrNull('pco'),
                'knee_pain' => $getOrNull('knee_pain'),
                'asthma' => $getOrNull('asthma'),
                'adl_bathing' => $getOrNull('adl_bathing'),
                'adl_dressing' => $getOrNull('adl_dressing'),
                'adl_walking' => $getOrNull('adl_walking'),
                'adl_toileting' => $getOrNull('adl_toileting'),
                'date' => $currentDate,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'breakfast_days' => $getOrNull('breakfast_days')
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


    public function getPatientList(Request $request)
    {
        // echo 'g';die;
        $user_id = Auth::id();
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
        $query = DB::table('public.patient_details as a')
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
                'patient_enrolled' => $getOrNull('patientEnrolled'),
                'patient_kit_enrolled' => $getOrNull('patient_kit_enrolled'),
                'compititor' => $request->filled('Compititor') ? implode(',', $request->input('Compititor')) : null,
                'consent_form_file' => $consentFilename ?: null,
                'prescription_file' => !empty($prescriptionFilenames) ? implode(',', $prescriptionFilenames) : null,
                'cipla_brand_prescribed' => $getOrNull('ciplaBrandPrescribed'),
                'cipla_brand_prescribed_no_option' => $getOrNull('prescribedselect'),
                'prescription_available' => $getOrNull('prescription_available'),
                'purchase_bill' => $purchasebillname ?: null,
                'date' => $currentDate,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ]);

            PatientCardioDetail::create([
                'uuid' => $uuid,
                'date_of_discharge' => $getOrNull('date_of_discharge'),
                'blood_pressure' => $getOrNull('blood_pressure'),
                'urea' => $getOrNull('urea'),
                'lv_ef' => $getOrNull('lv_ef'),
                'heart_rate' => $getOrNull('heart_rate'),
                'nt_pro_bnp' => $getOrNull('nt_pro_bnp'),
                'egfr' => $getOrNull('egfr'),
                'potassium' => $getOrNull('potassium'),
                'sodium' => $getOrNull('sodium'),
                'uric_acid' => $getOrNull('uric_acid'),
                'creatinine' => $getOrNull('creatinine'),
                'crp' => $getOrNull('crp'),
                'uacr' => $getOrNull('uacr'),
                'iron' => $getOrNull('iron'),
                'hb' => $getOrNull('hb'),
                'ldl' => $getOrNull('ldl'),
                'hdl' => $getOrNull('hdl'),
                'triglycerid' => $getOrNull('triglycerid'),
                'total_cholesterol' => $getOrNull('total_cholesterol'),
                'hba1c' => $getOrNull('hba1c'),
                'sgot' => $getOrNull('sgot'),
                'sgpt' => $getOrNull('sgpt'),
                'vit_d' => $getOrNull('vit_d'),
                'anti_diabetic_therapy' => $getOrNull('anti_diabetic_therapy'),
                'sglt2_inhibitors' => $getOrNull('sglt2_inhibitors'),
                't3' => $getOrNull('t3'),
                't4' => $getOrNull('t4'),
                'date' => $currentDate,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ]);

            PatientMedicationDetail::create([
                'uuid' => $uuid,
                'arni' => $getOrNull('arni'),
                'b_blockers' => $getOrNull('b_blockers'),
                'mra' => $getOrNull('mra'),
                'arni_remark' => $getOrNull('arni_remark'),
                'b_blockers_remark' => $getOrNull('b_blockers_remark'),
                'mra_remark' => $getOrNull('mra_remark'),
                'remark' => $getOrNull('remark'),
                'weight' => $getOrNull('weight'),
                'height' => $getOrNull('height'),
                'waist_circumference_remark' => $getOrNull('waist_circumference_remark'),
                'bmi' => $getOrNull('bmi'),
                'waist_to_height_ratio' => $getOrNull('waist_to_height_ratio'),
                'vaccination' => $getOrNull('vaccination'),
                'influenza' => $getOrNull('influenza'),
                'pneumococcal' => $getOrNull('pneumococcal'),
                'cardiac_rehab' => $getOrNull('cardiac_rehab'),
                'nsaids_use' => $getOrNull('nsaids_use'),
                'patient_kit_given' => $getOrNull('patient_kit_given'),
                'exercise_30mins' => $getOrNull('exercise_30mins'),
                'food_habits' => $getOrNull('food_habits'),
                'sedentary_hours' => $getOrNull('sedentary_hours'),
                'type_2_dm' => $getOrNull('type_2_dm'),
                'hypertension' => $getOrNull('hypertension'),
                'dyslipidemia' => $getOrNull('dyslipidemia'),
                'pco' => $getOrNull('pco'),
                'knee_pain' => $getOrNull('knee_pain'),
                'asthma' => $getOrNull('asthma'),
                'adl_bathing' => $getOrNull('adl_bathing'),
                'adl_dressing' => $getOrNull('adl_dressing'),
                'adl_walking' => $getOrNull('adl_walking'),
                'adl_toileting' => $getOrNull('adl_toileting'),
                'date' => $currentDate,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
                'breakfast_days' => $getOrNull('breakfast_days')
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
