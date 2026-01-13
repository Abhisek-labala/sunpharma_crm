<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day45Followup extends Model
{
    // Table name with schema
    protected $table = 'public.day45_followup';

    // Primary key
    protected $primaryKey = 'id';

    // Enable Laravel's default timestamps
    public $timestamps = true;

    // Mass assignable columns
    protected $fillable = [
        'patient_id',
        'day45_meds',
        'day45_meds_reason',
        'day45_doctor',
        'day45_doctor_reason',
        'day45_bp',
        'day45_bp_value',
        'day45_bp_remarks',
        'day45_weight',
        'day45_breathless',
        'day45_yoga_schedule',
        'day45_yoga_schedule_reason',
        'day45_yoga_tried',
        'day45_yoga_difficult',
        'day45_yoga_difficult_reason',
        'day45_yoga_required',
        'day45_yoga_planned_date',
        'day45_yoga_required_reason',
        'callremark_45',
        'callconnect_subremark_45',
        'noresponse_subremark_45',
        'submitted_at',
        'created_at',
        'updated_at',
        'day45_ae_report'
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
