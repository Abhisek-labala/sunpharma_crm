<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PmPatientExport implements FromCollection, WithHeadings, WithMapping
{
    protected $fromDate, $toDate, $campId, $hcp, $educator, $rm, $zone;

    public function __construct($fromDate, $toDate, $campId, $hcp, $educator, $rm, $zone)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->campId = $campId;
        $this->hcp = $hcp;
        $this->educator = $educator;
        $this->rm = $rm;
        $this->zone = $zone;
    }
protected function calculateMaxPrescriptionFiles()
    {
        $query = DB::table('public.patient_details as a')
        ->leftJoin('common.users as d', function ($join) {
            $join->on('a.educator_id', '=', 'd.id')
                ->where('d.role', '=', 'counsellor');
        })
        ->leftJoin('common.rm_users as f', 'd.rm_pm_id', '=', 'f.id');

        if ($this->fromDate) {
            $query->whereDate('a.date', '>=', $this->fromDate);
        }
        if ($this->toDate) {
            $query->whereDate('a.date', '<=', $this->toDate);
        }
        if ($this->hcp) {
            $query->where('a.hcp_id', $this->hcp);
        }
        if ($this->educator != '') {
            $query->where('a.educator_id', $this->educator);
        }
        if ($this->rm != '') {
            $query->where('d.rm_pm_id', $this->rm);
        }
        if ($this->zone != '') {
            $query->where('f.zone_id', $this->zone);
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
        $query = DB::table('public.patient_details as a')
            ->leftJoin('public.patient_medication_details as c', 'a.uuid', '=', 'c.uuid')
            ->leftJoin('common.users as d', function ($join) {
                $join->on('a.educator_id', '=', 'd.id')
                    ->where('d.role', '=', 'counsellor');
            })
            ->leftJoin('common.rm_users as f', 'd.rm_pm_id', '=', 'f.id')
            ->leftJoin('public.doctor as g', DB::raw('CAST(a.hcp_id AS INTEGER)'), '=', 'g.id')
            ->whereNotNull('a.educator_id');

        // Dynamic filters
        if (!empty($this->fromDate)) {
            $query->whereDate('a.date', '>=', $this->fromDate);
        }

        if (!empty($this->toDate)) {
            $query->whereDate('a.date', '<=', $this->toDate);
        }

        if (!empty($this->hcp)) {
            $query->where('a.hcp_id', $this->hcp);
        }

        if (!empty($this->educator)) {
            $query->where('a.educator_id', $this->educator);
        }

        if (!empty($this->rm)) {
            $query->where('d.rm_pm_id', $this->rm);
        }

        if (!empty($this->zone)) {
            $query->where('f.zone_id', $this->zone);
        }

        $data = $query->select([
            'a.id',
            'd.full_name as educator_name',
            'a.approved_status',
            'd.emp_id',
            'f.full_name as rm_name',
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
            'a.compititor',
            'a.consent_form_file',
            'a.prescription_file',
            'a.cipla_brand_prescribed',
            'a.date',
            'c.weight',
            'c.height',
            'c.waist_circumference',
            'c.bmi',
            'c.waist_to_height_ratio',
            'c.metabolic_age',
            'c.co_morbidities',
            'c.remark',
        ])->orderBy('a.date','desc')->get();

         return $data->map(function ($row) {
            $row->consent_form_file = $row->consent_form_file ? url("/private-file/{$row->consent_form_file}") : '';

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
            $row->emp_id,
            $row->educator_name,
            $row->rm_name,
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
            $row->compititor,
            $row->consent_form_file ? '=HYPERLINK("' . $row->consent_form_file . '", "View File")' : '',
           ...$prescriptionLinks,
            $row->cipla_brand_prescribed,
            $row->date,
            $row->approved_status,
            $row->weight,
            $row->height,
            $row->waist_circumference,
            $row->bmi,
            $row->waist_to_height_ratio,
            $row->metabolic_age,
            $row->co_morbidities,
            $row->remark,
        ];
    }

    public function headings(): array
    {
        $this->calculateMaxPrescriptionFiles();

        $headings = [
            'Patient Id','EMP Id',
            'Counsellor Name',  'RC Name', 'Doctor Code', 'Doctor Name', 'Speciality', 'City', 'State',
            'Patient Name', 'Age', 'Mobile Number', 'Gender', 'Medicine', 'Competitor', 'Consent Form File'
        ];

        // Add dynamic prescription headings
        for ($i = 1; $i <= $this->maxPrescriptionFiles; $i++) {
            $headings[] = "Prescription $i";
        }
         $headings = array_merge($headings, [
            'Brand Prescribed', 'Date','RC Approved Status','Weight', 'Height',
            'Waist Circumference', 'BMI', 'Waist to Height Ratio', 'Metabolic Age', 'Co-morbidities', 'Remark'
        ]);
         return $headings;
    }
}
