<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day3Followup extends Model
{
    // Table name with schema
    protected $table = 'public.day3_followup';

    // Primary key
    protected $primaryKey = 'id';

    // Enable Laravel's timestamps (since created_at and updated_at are present)
    public $timestamps = true;

    // Mass assignable fields
    protected $fillable = [
        'patient_id',
        'day3_meds',
        'day3_meds_reason',
        'day3_sugar',
        'day3_sugar_reason',
        'day3_bp',
        'day3_bp_reason',
        'day3_fluid',
        'day3_fluid_reason',
        'day3_support',
        'callremark_3',
        'callconnect_subremark_3',
        'noresponse_subremark_3',
        'created_at',
        'updated_at',
        'ae_report',
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
