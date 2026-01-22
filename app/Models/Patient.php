<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'public.patient_details'; // schema-qualified
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'educator_id',
        'digital_educator_id',
        'camp_id',
        'hcp_id',
        'patient_name',
        'age',
        'mobile_number',
        'gender',
        'medicine',
        'medicine_header',
        'compititor',
        'consent_form_file',
        'prescription_file',
        'cipla_brand_prescribed',
        'date',
        'approved_status',
        'patient_city',
        'created_at'
    ];

    // Example relationships
    public function feedbacks()
    {
        return $this->hasMany(FeedbackSubmitted::class, 'patient_id');
    }

    public function day180Followup()
    {
        return $this->hasOne(Day180Followup::class, 'patient_id');
    }

    public function cardioDetails()
{
    return $this->hasMany(PatientCardioDetail::class, 'uuid', 'uuid');
}

}
