<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day60FollowUp extends Model
{
    // Table name (with schema)
    protected $table = 'public.day60_followup';

    // Primary key
    protected $primaryKey = 'id';

    // Enable Laravel's automatic timestamps
    public $timestamps = true;

    // Fillable fields
    protected $fillable = [
        'patient_id',
        'day60_meds',
        'day60_meds_reason',
        'day60_bp',
        'day60_bp_value',
        'day60_rbs',
        'day60_rbs_value',
        'day60_weight',
        'day60_hba1c',
        'day60_hba1c_value',
        'day60_hba1c_last',
        'day60_challenges',
        'day60_challenges_reason',
        'day60_monitor',
        'day60_monitor_reason',
        'day60_water',
        'day60_urine',
        'day60_questions',
        'day60_help',
        'day60_doctor',
        'day60_doctor_reason',
        'day60_yoga_remark',
        'callremark_60',
        'callconnect_subremark_60',
        'noresponse_subremark_60',
        'created_at',
        'updated_at',
        'day60_ae_report'
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
