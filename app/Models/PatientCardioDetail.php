<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientCardioDetail extends Model
{
    protected $table = 'public.patient_cardio_details';
    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'date_of_discharge',
        'blood_pressure',
        'urea',
        'lv_ef',
        'heart_rate',
        'nt_pro_bnp',
        'egfr',
        'potassium',
        'sodium',
        'uric_acid',
        'creatinine',
        'crp',
        'uacr',
        'iron',
        'hb',
        'ldl',
        'hdl',
        'triglycerid',
        'total_cholesterol',
        'hba1c',
        'sgot',
        'sgpt',
        'vit_d',
        'sglt2_inhibitors',
        'hypertension_angina_ckd',
        'anti_diabetic_therapy',
        't3',
        't4',
        'date',
    ];

    // Relationship to Patient by UUID
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'uuid', 'uuid');
    }
}
