<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day150Followup extends Model
{
    // Table with schema
    protected $table = 'public.day150_followup';

    // Primary key
    protected $primaryKey = 'id';

    // Use timestamps
    public $timestamps = true;

    // Fillable fields
    protected $fillable = [
        'patient_id',
        'day150_meds',
        'day150_meds_reason',
        'day150_stock',
        'day150_changes',
        'day150_bp',
        'day150_bp_value',
        'day150_weight',
        'day150_rbs',
        'day150_rbs_value',
        'day150_rbs_reason',
        'day150_fluid',
        'day150_urine',
        'day150_breathless',
        'day150_yoga',
        'day150_yoga_reason',
        'callremark_150',
        'callconnect_subremark_150',
        'noresponse_subremark_150',
        'submitted_at',
        'created_at',
        'updated_at',
        'day150_ae_report'
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
