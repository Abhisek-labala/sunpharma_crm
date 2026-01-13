<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day15Followup extends Model
{
    // Table with schema name
    protected $table = 'public.day15_followup';

    // Primary key
    protected $primaryKey = 'id';

    // Enable Laravel's automatic timestamps
    public $timestamps = true;

    // Mass assignable fields
    protected $fillable = [
        'patient_id',
        'day15_meds',
        'day15_meds_reason',
        'day15_stock',
        'day15_changes',
        'day15_bp',
        'day15_bp_value',
        'day15_weight',
        'day15_rbs',
        'day15_rbs_value',
        'day15_rbs_reason',
        'day15_fluid',
        'day15_urine',
        'day15_breathless',
        'day15_yoga',
        'day15_yoga_reason',
        'callremark_15',
        'callconnect_subremark_15',
        'noresponse_subremark_15',
        'submitted_at',
        'created_at',
        'updated_at',
        'day15_ae_report'
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
