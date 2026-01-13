<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EducatorPatientExport implements FromCollection, WithHeadings, WithMapping
{
   protected $fromDate;
    protected $toDate;
    protected $campId;
    protected $hcp;

   public function __construct($fromDate, $toDate, $campId, $hcp)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->campId = $campId;
        $this->hcp = $hcp;
    }

    protected function calculateMaxPrescriptionFiles()
    {
        $user_id = Auth::id();
        $query = DB::table('public.patient_details as a')
            ->where('a.educator_id', $user_id);

        if ($this->fromDate) {
            $query->whereDate('a.date', '>=', $this->fromDate);
        }
        if ($this->toDate) {
            $query->whereDate('a.date', '<=', $this->toDate);
        }
        if ($this->hcp) {
            $query->where('a.hcp_id', $this->hcp);
        }
        $filesData = $query->pluck('a.prescription_file');
        $max = 1;
        foreach ($filesData as $prescription_file) {
            if ($prescription_file) {
                $files = array_map('trim', explode(',', $prescription_file));
                $count = count($files);
                if ($count > $max) {
                    $max = $count;
                }
            }
        }
        $this->maxPrescriptionFiles = $max;
    }

    public function collection()
    {
        $this->calculateMaxPrescriptionFiles();

        $user_id = Auth::id();
                $query = DB::table('public.patient_details as a')
            ->leftJoin('public.patient_cardio_details as b', 'a.uuid', '=', 'b.uuid')
            ->leftJoin('public.patient_medication_details as c', 'a.uuid', '=', 'c.uuid')
            ->leftJoin('common.users as d', function ($join) {
                $join->on('a.educator_id', '=', 'd.id')
                    ->where('d.role', '=', 'educator');
            })
            ->leftJoin('common.rm_users as f', 'd.rm_pm_id', '=', 'f.id')
            ->leftJoin('public.doctor as g', DB::raw('CAST(a.hcp_id AS INTEGER)'), '=', 'g.id')
            ->leftJoin('public.camp as h', 'h.id', '=', 'a.camp_id')
            ->whereNotNull('a.patient_name')
            ->where('a.educator_id', $user_id);

        if ($this->fromDate) {
            $query->whereDate('a.date', '>=', $this->fromDate);
        }
        if ($this->toDate) {
            $query->whereDate('a.date', '<=', $this->toDate);
        }
        if ($this->hcp) {
            $query->where('a.hcp_id', $this->hcp);
        }

        $data = $query->select(
            'a.id',
            'd.full_name as educator_name',
            'a.approved_status',
            'd.emp_id',
            'f.full_name as rm_name',
            'h.camp_id',
            'g.msl_code',
            'g.name as doctor_name',
            'g.speciality',
            'g.city',
            'g.state',
            'a.patient_name',
            'a.age',
            'a.mobile_number',
            'a.gender',
            'a.medicine',
            'a.patient_enrolled',
            'a.patient_kit_enrolled',
            'a.compititor',
            'a.consent_form_file',
            'a.prescription_file',
            'a.cipla_brand_prescribed',
            'a.cipla_brand_prescribed_no_option',
            'a.prescription_available',
            'a.purchase_bill',
            'a.date',
            'b.date_of_discharge',
            'b.blood_pressure',
            'b.urea',
            'b.lv_ef',
            'b.heart_rate',
            'b.nt_pro_bnp',
            'b.egfr',
            'b.potassium',
            'b.sodium',
            'b.uric_acid',
            'b.creatinine',
            'b.crp',
            'b.uacr',
            'b.iron',
            'b.hb',
            'b.ldl',
            'b.hdl',
            'b.triglycerid',
            'b.total_cholesterol',
            'b.hba1c',
            'b.sgot',
            'b.sgpt',
            'b.vit_d',
            'b.sglt2_inhibitors',
            'b.hypertension_angina_ckd',
            'b.anti_diabetic_therapy',
            'b.t3',
            'b.t4',
            'c.arni',
            'c.b_blockers',
            'c.mra',
            'c.arni_remark',
            'c.b_blockers_remark',
            'c.mra_remark',
            'c.remark',
            'c.weight',
            'c.height',
            'c.waist_circumference_remark',
            'c.bmi',
            'c.waist_to_height_ratio',
            'c.vaccination',
            'c.influenza',
            'c.pneumococcal',
            'c.cardiac_rehab',
            'c.nsaids_use',
            'c.patient_kit_given',
            'c.exercise_30mins',
            'c.food_habits',
            'c.sedentary_hours',
            'c.type_2_dm',
            'c.hypertension',
            'c.dyslipidemia',
            'c.pco',
            'c.knee_pain',
            'c.asthma',
            'c.adl_bathing',
            'c.adl_dressing',
            'c.adl_walking',
            'c.adl_toileting',
        )
        ->orderBy('a.date','desc')->get();

        // Map URLs for files
         return $data->map(function ($row) {
            $row->consent_form_file = $row->consent_form_file ? url("/private-file/{$row->consent_form_file}") : '';
            $row->purchase_bill = $row->purchase_bill ? url("/private-file/{$row->purchase_bill}") : '';

            if ($row->prescription_file) {
                $files = array_filter(array_map('trim', explode(',', $row->prescription_file)));
                $row->prescription_file = array_map(fn($f) => url("/private-file/{$f}"), $files);
            } else {
                $row->prescription_file = [];
            }
            return $row;
        });
    }

    public function map($row): array
    {
        // Prepare prescription file columns
        $prescriptionLinks = [];
        for ($i = 0; $i < $this->maxPrescriptionFiles; $i++) {
            if (!empty($row->prescription_file[$i])) {
                $prescriptionLinks[] = '=HYPERLINK("' . $row->prescription_file[$i] . '","View File")';
            } else {
                $prescriptionLinks[] = '';
            }
        }

        return [
            $row->id,
            $row->educator_name,
            $row->emp_id,
            $row->rm_name,
            $row->camp_id,
            $row->msl_code,
            $row->doctor_name,
            $row->speciality,
            $row->city,
            $row->state,
            $row->patient_name,
            $row->age,
            $row->mobile_number,
            $row->gender,
            $row->medicine,
            $row->patient_enrolled,
            $row->patient_kit_enrolled,
            $row->compititor,
            $row->consent_form_file ? '=HYPERLINK("' . $row->consent_form_file . '","View File")' : '',
            // Dynamic prescription columns
            ...$prescriptionLinks,
            $row->cipla_brand_prescribed,
            $row->cipla_brand_prescribed_no_option,
            $row->prescription_available,
            $row->purchase_bill ? '=HYPERLINK("' . $row->purchase_bill . '","View File")' : '',
            $row->date,
            $row->approved_status,
            $row->date_of_discharge,
            $row->blood_pressure,
            $row->urea,
            $row->lv_ef,
            $row->heart_rate,
            $row->nt_pro_bnp,
            $row->egfr,
            $row->potassium,
            $row->sodium,
            $row->uric_acid,
            $row->creatinine,
            $row->crp,
            $row->uacr,
            $row->iron,
            $row->hb,
            $row->ldl,
            $row->hdl,
            $row->triglycerid,
            $row->total_cholesterol,
            $row->hba1c,
            $row->sgot,
            $row->sgpt,
            $row->vit_d,
            $row->sglt2_inhibitors,
            $row->hypertension_angina_ckd,
            $row->anti_diabetic_therapy,
            $row->t3,
            $row->t4,
            $row->arni,
            $row->b_blockers,
            $row->mra,
            $row->arni_remark,
            $row->b_blockers_remark,
            $row->mra_remark,
            $row->remark,
            $row->weight,
            $row->height,
            $row->waist_circumference_remark,
            $row->bmi,
            $row->waist_to_height_ratio,
            $row->vaccination,
            $row->influenza,
            $row->pneumococcal,
            $row->cardiac_rehab,
            $row->nsaids_use,
            $row->patient_kit_given,
            $row->exercise_30mins,
            $row->food_habits,
            $row->sedentary_hours,
            $row->type_2_dm,
            $row->hypertension,
            $row->dyslipidemia,
            $row->pco,
            $row->knee_pain,
            $row->asthma,
            $row->adl_bathing,
            $row->adl_dressing,
            $row->adl_walking,
            $row->adl_toileting,
        ];
    }

    public function headings(): array
    {
        $this->calculateMaxPrescriptionFiles();

        $headings = [
            'Patient ID','Educator Name', 'EMP Id', 'RM Name', 'Camp', 'MSL Code', 'Doctor Name', 'Speciality', 'City', 'State',
            'Patient Name', 'Age', 'Mobile Number', 'Gender', 'Medicine', 'Patient Enrolled',
            'Patient Kit Enrolled', 'Competitor', 'Consent Form File'
        ];

        // Add dynamic prescription headings
        for ($i = 1; $i <= $this->maxPrescriptionFiles; $i++) {
            $headings[] = "Prescription $i";
        }

        $headings = array_merge($headings, [
            'Cipla Brand Prescribed', 'Cipla Brand Prescribed No Option', 'Prescription Available', 'Purchase Bill', 'Date','RM Approved Status',
            'Date of Discharge', 'Blood Pressure', 'Urea', 'LV EF', 'Heart Rate', 'NT Pro BNP', 'eGFR',
            'Potassium', 'Sodium', 'Uric Acid', 'Creatinine', 'CRP', 'UACR', 'Iron', 'Hb', 'LDL', 'HDL',
            'Triglyceride', 'Total Cholesterol', 'HbA1c', 'SGOT', 'SGPT', 'Vitamin D', 'SGLT2 Inhibitors',
            'Hypertension Angina CKD', 'Anti Diabetic Therapy', 'T3', 'T4', 'ARNI', 'Beta Blockers', 'MRA',
            'ARNI Remark', 'Beta Blockers Remark', 'MRA Remark', 'General Remark', 'Weight', 'Height',
            'Waist Circumference Remark', 'BMI', 'Waist to Height Ratio', 'Vaccination', 'Influenza',
            'Pneumococcal', 'Cardiac Rehab', 'NSAIDs Use', 'Patient Kit Given', 'Exercise 30 Mins', 'Food Habits',
            'Sedentary Hours', 'Type 2 DM', 'Hypertension', 'Dyslipidemia', 'PCO', 'Knee Pain', 'Asthma',
            'ADL Bathing', 'ADL Dressing', 'ADL Walking', 'ADL Toileting'
        ]);
        return $headings;
    }
}
