<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducatorAttendance extends Model
{
    use HasFactory;

    protected $table = 'educator_attendances';

    protected $fillable = [
        'educator_id',
        'date',
        'in_time',
        'out_time',
        'ip_address',
        'latitude',
        'longitude',
        'address',
        'state'
    ];

    public function educator()
    {
        return $this->belongsTo(User::class, 'educator_id');
    }
}
