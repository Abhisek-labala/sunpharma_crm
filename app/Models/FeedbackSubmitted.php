<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackSubmitted extends Model
{
    protected $table = 'public.feedback_submitted'; // schema-qualified
    protected $primaryKey = 'id';
    public $timestamps = false; // table has no created_at or updated_at

    protected $fillable = [
        'day',
        'patient_id',
    ];

    // Define relationship to Patient model
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
