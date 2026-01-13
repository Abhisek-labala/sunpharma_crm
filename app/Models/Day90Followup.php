<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day90Followup extends Model
{
    // Use the correct table name with schema
    protected $table = 'public.day90_followup';

    // Primary key
    protected $primaryKey = 'id';

    // Enable Laravel timestamps (created_at, updated_at)
    public $timestamps = true;

    // Fillable fields
    protected $fillable = [
        'patient_id',
        'day90_meds',
        'day90_meds_reason',
        'day90_doctor',
        'day90_doctor_reason',
        'day90_bp',
        'day90_bp_value',
        'day90_bp_remarks',
        'day90_weight',
        'day90_breathless',
        'day90_yoga_schedule',
        'day90_yoga_schedule_reason',
        'day90_yoga_tried',
        'day90_yoga_difficult',
        'day90_yoga_difficult_reason',
        'day90_yoga_required',
        'day90_yoga_planned_date',
        'day90_yoga_required_reason',
        'callremark_90',
        'callconnect_subremark_90',
        'noresponse_subremark_90',
        'submitted_at',
        'created_at',
        'updated_at',
        'day90_ae_report'
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
