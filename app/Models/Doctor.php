<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'public.doctor'; // Explicitly set schema-qualified table name
    protected $primaryKey = 'id';
    public $timestamps = false; // because update_at is custom and created_at is used but updated_at is misspelled

    protected $fillable = [
        'msl_code',
        'name',
        'state',
        'city',
        'status',
        'zone',
        'speciality',
        'first_visit',
        'educator_id',
        'consent_form_file',
        'created_at',
        'update_at',
    ];

    // Optional: Define relationship with Educator if you have that model
    public function educator()
    {
        return $this->belongsTo(User::class, 'educator_id');
    }

    // Optional: Define relationship with Zone if zone_id links to a zone table
    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }
}
