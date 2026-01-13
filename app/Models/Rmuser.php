<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rmuser extends Model
{
    // Table name (with schema explicitly specified)
    protected $table = 'common.rm_users';

    // Primary key
    protected $primaryKey = 'id';

    // Use Laravel's timestamps
    public $timestamps = true;

    // Fillable fields
    protected $fillable = [
        'emp_id',
        'full_name',
        'email',
        'user_name',
        'password',
        'raw_password',
        'mobile',
        'zone_id',
        'created_at',
        'updated_at',
    ];
}
