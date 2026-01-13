<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DigiFeedbackReportExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $fromDate;
    protected $toDate;
    protected $educatorId;
    protected $digitalEducatorId;

    public function __construct($fromDate, $toDate, $educatorId, $digitalEducatorId)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->educatorId = $educatorId;
        $this->digitalEducatorId = $digitalEducatorId;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = DB::table('public.patient_details as a')
            ->leftJoin('public.doctor as b', DB::raw('a.hcp_id::int'), '=', 'b.id')
            ->leftJoin('common.users as c', function ($join) {
                $join->on(DB::raw('c.id'), '=', DB::raw('a.educator_id::int'))->where('c.role', '=', 'educator');
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
            ->where('a.patient_enrolled', '=', 'Yes')
                ->where(function ($q) {
                                $q->whereNotNull('a.prescription_file')
                                ->orWhereNotNull('a.consent_form_file');
                });

        // Apply all filters
        if (!empty($this->fromDate) && !empty($this->toDate)) {
            $query->where(function ($q) {
                $q->whereBetween('o.created_at', [$this->fromDate, $this->toDate])
                    ->orWhereBetween('f.created_at', [$this->fromDate, $this->toDate])
                    ->orWhereBetween('g.created_at', [$this->fromDate, $this->toDate])
                    ->orWhereBetween('h.created_at', [$this->fromDate, $this->toDate])
                    ->orWhereBetween('i.created_at', [$this->fromDate, $this->toDate])
                    ->orWhereBetween('j.created_at', [$this->fromDate, $this->toDate])
                    ->orWhereBetween('k.created_at', [$this->fromDate, $this->toDate])
                    ->orWhereBetween('l.created_at', [$this->fromDate, $this->toDate])
                    ->orWhereBetween('m.created_at', [$this->fromDate, $this->toDate])
                    ->orWhereBetween('n.created_at', [$this->fromDate, $this->toDate]);
            });
        }

        if (!empty($this->educatorId)) {
            $query->where('a.educator_id', $this->educatorId);
        }

        if (!empty($this->digitalEducatorId)) {
            $query->where('a.digital_educator_id', $this->digitalEducatorId);
        }

        $query->select(
            'a.id as patient_id',
            'a.patient_name',
            'a.mobile_number',
            'b.name as doctor_name',
            'c.full_name as educator_name',
            'd.full_name as digital_educator_name',
            DB::raw("CAST(a.created_at AS DATE) as created_at"),
            DB::raw("CAST((a.created_at + interval '3 days') AS DATE) AS day3_planner_date"),
            DB::raw("CAST(o.created_at AS DATE) as day3_actual_date"),
            'o.callremark_3 as day_3_remark',
            DB::raw("CASE WHEN o.callremark_3 = 'Call Connect' THEN o.callconnect_subremark_3 WHEN o.callremark_3 = 'No Response' THEN o.noresponse_subremark_3 END AS day_3_details_remark"),
            'o.ae_report',
            DB::raw("CAST((a.created_at + interval '7 days') AS DATE) AS day7_planner_date"),
            DB::raw("CAST(f.created_at AS DATE) as day7_actual_date"),
            'f.callremark_7 as day_7_remark',
            DB::raw("CASE WHEN f.callremark_7 = 'Call Connect' THEN f.callconnect_subremark_7 WHEN f.callremark_7 = 'No Response' THEN f.noresponse_subremark_7 END AS day_7_details_remark"),
            'f.day7_ae_report',
            DB::raw("CAST((a.created_at + interval '15 days') AS DATE) AS day15_planner_date"),
            DB::raw("CAST(g.created_at AS DATE) as day15_actual_date"),
            'g.callremark_15 as day_15_remark',
            DB::raw("CASE WHEN g.callremark_15 = 'Call Connect' THEN g.callconnect_subremark_15 WHEN g.callremark_15 = 'No Response' THEN g.noresponse_subremark_15 END AS day_15_details_remark"),
            'g.day15_ae_report',
            DB::raw("CAST((a.created_at + interval '30 days') AS DATE) AS day30_planner_date"),
            DB::raw("CAST(h.created_at AS DATE) as day30_actual_date"),
            'h.callremark_30 as day_30_remark',
            DB::raw("CASE WHEN h.callremark_30 = 'Call Connect' THEN h.callconnect_subremark_30 WHEN h.callremark_30 = 'No Response' THEN h.noresponse_subremark_30 END AS day_30_details_remark"),
            'h.day30_ae_report',
            DB::raw("CAST((a.created_at + interval '45 days') AS DATE) AS day45_planner_date"),
            DB::raw("CAST(i.created_at AS DATE) as day45_actual_date"),
            'i.callremark_45 as day_45_remark',
            DB::raw("CASE WHEN i.callremark_45 = 'Call Connect' THEN i.callconnect_subremark_45 WHEN i.callremark_45 = 'No Response' THEN i.noresponse_subremark_45 END AS day_45_details_remark"),
            'i.day45_ae_report',
            DB::raw("CAST((a.created_at + interval '60 days') AS DATE) AS day60_planner_date"),
            DB::raw("CAST(j.created_at AS DATE) as day60_actual_date"),
            'j.callremark_60 as day_60_remark',
            DB::raw("CASE WHEN j.callremark_60 = 'Call Connect' THEN j.callconnect_subremark_60 WHEN j.callremark_60 = 'No Response' THEN j.noresponse_subremark_60 END AS day_60_details_remark"),
            'j.day60_ae_report',
            DB::raw("CAST((a.created_at + interval '90 days') AS DATE) AS day90_planner_date"),
            DB::raw("CAST(k.created_at AS DATE) as day90_actual_date"),
            'k.callremark_90 as day_90_remark',
            DB::raw("CASE WHEN k.callremark_90 = 'Call Connect' THEN k.callconnect_subremark_90 WHEN k.callremark_90 = 'No Response' THEN k.noresponse_subremark_90 END AS day_90_details_remark"),
            'k.day90_ae_report',
            DB::raw("CAST((a.created_at + interval '120 days') AS DATE) AS day120_planner_date"),
            DB::raw("CAST(l.created_at AS DATE) as day120_actual_date"),
            'l.callremark_120 as day_120_remark',
            DB::raw("CASE WHEN l.callremark_120 = 'Call Connect' THEN l.callconnect_subremark_120 WHEN l.callremark_120 = 'No Response' THEN l.noresponse_subremark_120 END AS day_120_details_remark"),
            'l.day120_ae_report',
            DB::raw("CAST((a.created_at + interval '150 days') AS DATE) AS day150_planner_date"),
            DB::raw("CAST(m.created_at AS DATE) as day150_actual_date"),
            'm.callremark_150 as day_150_remark',
            DB::raw("CASE WHEN m.callremark_150 = 'Call Connect' THEN m.callconnect_subremark_150 WHEN m.callremark_150 = 'No Response' THEN m.noresponse_subremark_150 END AS day_150_details_remark"),
            'm.day150_ae_report',
            DB::raw("CAST((a.created_at + interval '180 days') AS DATE) AS day180_planner_date"),
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

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Patient ID',
            'Patient Name',
            'Mobile Number',
            'Doctor Name',
            'Educator Name',
            'Digital Educator Name',
            'Created At',
            'Day 3 Planner Date',
            'Day 3 Actual Date',
            'Day 3 Remark',
            'Day 3 Details Remark',
            'Day 3 AE Report',
            'Day 7 Planner Date',
            'Day 7 Actual Date',
            'Day 7 Remark',
            'Day 7 Details Remark',
            'Day 7 AE Report',
            'Day 15 Planner Date',
            'Day 15 Actual Date',
            'Day 15 Remark',
            'Day 15 Details Remark',
            'Day 15 AE Report',
            'Day 30 Planner Date',
            'Day 30 Actual Date',
            'Day 30 Remark',
            'Day 30 Details Remark',
            'Day 30 AE Report',
            'Day 45 Planner Date',
            'Day 45 Actual Date',
            'Day 45 Remark',
            'Day 45 Details Remark',
            'Day 45 AE Report',
            'Day 60 Planner Date',
            'Day 60 Actual Date',
            'Day 60 Remark',
            'Day 60 Details Remark',
            'Day 60 AE Report',
            'Day 90 Planner Date',
            'Day 90 Actual Date',
            'Day 90 Remark',
            'Day 90 Details Remark',
            'Day 90 AE Report',
            'Day 120 Planner Date',
            'Day 120 Actual Date',
            'Day 120 Remark',
            'Day 120 Details Remark',
            'Day 120 AE Report',
            'Day 150 Planner Date',
            'Day 150 Actual Date',
            'Day 150 Remark',
            'Day 150 Details Remark',
            'Day 150 AE Report',
            'Day 180 Planner Date',
            'Day 180 Actual Date',
            'Day 180 Remark',
            'Day 180 Details Remark',
            'Day 180 AE Report',
        ];
    }
}
