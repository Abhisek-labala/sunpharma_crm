<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day7Followup extends Model
{
    // Table name (with schema)
    protected $table = 'public.day7_followup';

    // Primary key
    protected $primaryKey = 'id';

    // Enable automatic timestamps
    public $timestamps = true;

    // Fillable columns
    protected $fillable = [
        'patient_id',
        'day7_meds',
        'day7_meds_reason',
        'day7_doctor',
        'day7_doctor_reason',
        'day7_bp',
        'day7_bp_value',
        'day7_bp_remarks',
        'day7_weight',
        'day7_breathless',
        'day7_yoga_schedule',
        'day7_yoga_schedule_reason',
        'day7_yoga_tried',
        'day7_yoga_difficult',
        'day7_yoga_difficult_reason',
        'day7_yoga_required',
        'day7_yoga_planned_date',
        'day7_yoga_required_reason',
        'callremark_7',
        'callconnect_subremark_7',
        'noresponse_subremark_7',
        'submitted_at',
        'created_at',
        'updated_at',
        'day7_ae_report'
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
