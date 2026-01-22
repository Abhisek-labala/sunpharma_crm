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
        'weight',
        'height',
        'waist_circumference',
        'bmi',
        'waist_to_height_ratio',
        'metabolic_age',
        'co_morbidities',
        'remark',
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
