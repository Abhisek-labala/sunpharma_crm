<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day30Followup extends Model
{
    // Table name with schema
    protected $table = 'public.day30_followup';

    // Primary key
    protected $primaryKey = 'id';

    // Use Laravel's timestamps (created_at & updated_at present)
    public $timestamps = true;

    // Mass assignable fields
    protected $fillable = [
        'patient_id',
        'day30_meds',
        'day30_meds_reason',
        'day30_stock',
        'day30_changes',
        'day30_bp',
        'day30_bp_value',
        'day30_weight',
        'day30_rbs',
        'day30_rbs_value',
        'day30_rbs_reason',
        'day30_fluid',
        'day30_urine',
        'day30_breathless',
        'day30_yoga',
        'day30_yoga_reason',
        'callremark_30',
        'callconnect_subremark_30',
        'noresponse_subremark_30',
        'submitted_at',
        'created_at',
        'updated_at',
        'day30_ae_report'
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
