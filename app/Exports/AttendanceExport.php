<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class AttendanceExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $startDate;
    protected $endDate;
    protected $role;

    public function __construct($startDate, $endDate, $role = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->role = $role;
    }

    public function query()
    {
        $query = Attendance::query()
            ->with('authenticatable') // Eager load the user/rm
            ->whereBetween('date', [$this->startDate, $this->endDate]);

        if ($this->role) {
            $query->where('role', $this->role);
        }

        return $query->orderBy('date', 'desc');
    }

    public function headings(): array
    {
        return [
            'Date',
            'Role',
            'Name',
            'Employee ID',
            'In Time',
            'Out Time',
            'IP Address',
            'Location (Lat, Long)',
            'Address',
            'State',
        ];
    }

    public function map($attendance): array
    {
        $name = 'N/A';
        $empId = 'N/A';

        if ($attendance->authenticatable) {
            $name = $attendance->authenticatable->full_name ?? $attendance->authenticatable->name ?? 'N/A';
            $empId = $attendance->authenticatable->emp_id ?? 'N/A';
        }

        return [
            $attendance->date,
            ucfirst($attendance->role),
            $name,
            $empId,
            $attendance->in_time,
            $attendance->out_time,
            $attendance->ip_address,
            ($attendance->latitude && $attendance->longitude) ? "{$attendance->latitude}, {$attendance->longitude}" : 'N/A',
            $attendance->address,
            $attendance->state,
        ];
    }
}
