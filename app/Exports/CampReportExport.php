<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CampReportExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        try {
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
                ->orderBy('c.date', 'desc')
                ->get();
        } catch (\Exception $e) {
            \Log::error('Camp Report Export Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return collect([]); // Return empty collection on error
        }
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
