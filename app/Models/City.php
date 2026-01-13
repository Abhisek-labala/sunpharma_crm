<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    // If you're using Laravel 8+ and need mass assignment
    protected $fillable = [
        'city_name',
        'city_code',
        'state_code',
    ];

    // Specify the actual table name with schema
    protected $table = 'common.cities';

    // If primary key is not "id" or is non-incrementing, specify it
    protected $primaryKey = 'id';

    // Laravel assumes timestamps; disable them if not present
    public $timestamps = false;
}
