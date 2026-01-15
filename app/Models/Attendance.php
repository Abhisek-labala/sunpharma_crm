<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';

    protected $fillable = [
        'authenticatable_id',
        'authenticatable_type',
        'role',
        'date',
        'in_time',
        'out_time',
        'ip_address',
        'latitude',
        'longitude',
        'address',
        'state',
    ];

    public function authenticatable()
    {
        return $this->morphTo();
    }
}
