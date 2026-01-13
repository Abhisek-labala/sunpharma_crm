<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DailyReportExport implements FromCollection, WithHeadings
{
    protected $fromDate;
    protected $toDate;

    public function __construct($fromDate, $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    public function collection()
    {
        return DB::table('public.patient_details as pin')
    ->leftJoin('common.users as e', 'pin.educator_id', '=', 'e.id')
    ->leftJoin('public.doctor as dn', DB::raw('CAST(pin.hcp_id AS INTEGER)'), '=', 'dn.id')
    ->leftJoin('common.rm_users as rm', 'e.rm_pm_id', '=', 'rm.id')
    ->selectRaw("
        pin.date,
        dn.msl_code,
        dn.city AS hq,
        dn.state AS state_name,
        rm.full_name AS rm_name,
        dn.name AS doctor_name,
        e.full_name AS educator_name,
        e.emp_id AS employee_id,
        COUNT(pin.id) AS total_patient,
        SUM(CASE WHEN cipla_brand_prescribed = 'Yes' THEN 1 ELSE 0 END) AS total_rx,
        SUM(CASE WHEN patient_enrolled = 'Yes' THEN 1 ELSE 0 END) AS patient_enrolled,
        SUM(CASE WHEN POSITION('Arnicor' IN medicine) > 0 THEN 1 ELSE 0 END) AS \"arnicor(Innova)\",
        SUM(CASE WHEN POSITION('Dytor' IN medicine) > 0 THEN 1 ELSE 0 END) AS \"dytor(Magna)\",
        SUM(CASE WHEN POSITION('Dytor Plus' IN medicine) > 0 THEN 1 ELSE 0 END) AS \"dytor_plus(Magna)\",
        SUM(CASE WHEN POSITION('Empacip' IN medicine) > 0 THEN 1 ELSE 0 END) AS \"empacip(Ascend)\"
    ")
    ->when($this->fromDate, function ($q) {
        $q->whereDate('pin.date', '>=', $this->fromDate);
    })
    ->when($this->toDate, function ($q) {
        $q->whereDate('pin.date', '<=', $this->toDate);
    })
    ->groupBy([
        'pin.date',
        'dn.msl_code',
        'dn.city',
        'dn.state',
        'rm.full_name',
        'dn.name',
        'e.full_name',
        'e.emp_id'
    ])
    ->orderBy('pin.date', 'ASC')
    ->get();
    }

    public function headings(): array
    {
        return [
            'Date',
            'MSL Code',
            'HQ',
            'State',
            'RM Name',
            'Doctor Name',
            'Educator Name',
            'Employee ID',
            'Total Patients',
            'Total Rx',
            'Patient Enrolled',
            'Arnicor (Innova)',
            'Dytor (Magna)',
            'Dytor Plus (Magna)',
            'Empacip (Ascend)',
        ];
    }
}
