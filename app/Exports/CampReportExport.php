<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CampReportExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return DB::table('public.camp as c')
            ->leftJoin('common.users as u', 'u.id', '=', 'c.educator_id')
            ->select(
                'c.id',
                'u.emp_id as employee_id',
                'u.full_name',
                'c.hcp_name',
                'c.in_time',
                'c.out_time',
                'c.remarks',
                'c.execution_status',
                'c.date'
            )
            ->orderBy('c.date', 'desc');
    }

    public function headings(): array
    {
        return [
            'Camp ID',
            'Employee ID',
            'Counsellor Name',
            'Doctor Name',
            'In Time',
            'Out Time',
            'Remarks',
            'Execution Status',
            'Date'
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->employee_id,
            $row->full_name,
            $row->hcp_name,
            $row->in_time,
            $row->out_time,
            $row->remarks,
            $row->execution_status,
            $row->date,
        ];
    }
}
