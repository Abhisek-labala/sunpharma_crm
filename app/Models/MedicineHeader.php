<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineHeader extends Model
{
    // Table name with schema
    protected $table = 'common.medicine_headers';

    // Primary key
    protected $primaryKey = 'id';

    // Disable Laravel's default timestamps
    public $timestamps = false;

    // Mass assignable fields
    protected $fillable = [
        'header',
        'created_at',
        'update_at',
    ];
}
