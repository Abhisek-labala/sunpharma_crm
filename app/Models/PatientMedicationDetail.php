<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientMedicationDetail extends Model
{
    use HasFactory;

    protected $table = 'patient_medication_details';

    protected $primaryKey = 'id';

    public $timestamps = false; // Because you use `created_at` and `update_at` (not `updated_at`)

    protected $fillable = [
        'uuid',
        'arni',
        'b_blockers',
        'mra',
        'arni_remark',
        'b_blockers_remark',
        'mra_remark',
        'remark',
        'weight',
        'height',
        'waist_circumference_remark',
        'bmi',
        'waist_to_height_ratio',
        'vaccination',
        'influenza',
        'pneumococcal',
        'cardiac_rehab',
        'nsaids_use',
        'patient_kit_given',
        'exercise_30mins',
        'breakfast_days',
        'food_habits',
        'sedentary_hours',
        'type_2_dm',
        'hypertension',
        'dyslipidemia',
        'pco',
        'knee_pain',
        'asthma',
        'adl_bathing',
        'adl_dressing',
        'adl_walking',
        'adl_toileting',
        'date',
        'created_at',
        'update_at'
    ];

    // Define relationship with PatientDetail model
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'uuid', 'uuid');
    }
}
