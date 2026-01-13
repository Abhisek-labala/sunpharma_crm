<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day120FollowUp extends Model
{
    // Define the table with schema
    protected $table = 'public.day120_followup';

    // Primary key
    protected $primaryKey = 'id';

    // Enable created_at and updated_at
    public $timestamps = true;

    // Mass assignable fields
    protected $fillable = [
        'patient_id',
        'day120_meds',
        'day120_meds_reason',
        'day120_bp',
        'day120_bp_value',
        'day120_rbs',
        'day120_rbs_value',
        'day120_weight',
        'day120_hba1c',
        'day120_hba1c_value',
        'day120_hba1c_last',
        'day120_challenges',
        'day120_challenges_reason',
        'day120_monitor',
        'day120_monitor_reason',
        'day120_water',
        'day120_urine',
        'day120_questions',
        'day120_help',
        'day120_doctor',
        'day120_doctor_reason',
        'day120_yoga_remark',
        'callremark_120',
        'callconnect_subremark_120',
        'noresponse_subremark_120',
        'created_at',
        'updated_at',
        'day120_ae_report'
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
