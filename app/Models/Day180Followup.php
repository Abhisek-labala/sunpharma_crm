<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day180Followup extends Model
{
    // Full table name with schema
    protected $table = 'public.day180_followup';

    // Primary key
    protected $primaryKey = 'id';

    // Enable timestamps
    public $timestamps = true;

    // Fillable attributes
    protected $fillable = [
        'patient_id',
        'feeling_now',
        'yoga_helpful',
        'yoga_feedback',
        'instructor_support',
        'instructor_feedback',
        'diet_impact',
        'diet_feedback',
        'dietician_access',
        'dietician_feedback',
        'overall_experience',
        'experience_remarks',
        'final_feedback',
        'callremark_180',
        'callconnect_subremark_180',
        'noresponse_subremark_180',
        'submitted_at',
        'created_at',
        'updated_at',
        'day180_ae_report'
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}

