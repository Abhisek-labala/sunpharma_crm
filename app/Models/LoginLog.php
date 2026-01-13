<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $table = 'login_logs';

    protected $fillable = [
        'email',
        'username',
        'emp_id',
        'role',
        'time',
        'ip',
    ];

    public $timestamps = false; // because 'time' is our custom timestamp
}
