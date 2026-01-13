<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    // Table with schema
    protected $table = 'common.zones';

    // Primary key
    protected $primaryKey = 'id';

    // Disable Laravel's default timestamps since you're using custom timestamp columns
    public $timestamps = false;

    // Mass assignable fields
    protected $fillable = [
        'zone_name',
        'created_at',
        'update_at',
    ];
}
