<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'common.users';

    protected $primaryKey = 'id';

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'emp_id',
        'full_name',
        'email',
        'user_name',
        'password',
        'raw_password',
        'mobile',
        'city',
        'state',
        'address',
        'profile_pic',
        'rm_pm_id',
        'zone_id',
        'role',
        'digital_educator_id',
    ];

    protected $hidden = [
        'password',
        'raw_password',
    ];

    // Define any relationships if needed (example)

}
