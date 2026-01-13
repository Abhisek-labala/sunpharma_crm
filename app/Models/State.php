<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    // Table with schema name
    protected $table = 'common.states';

    // Primary key
    protected $primaryKey = 'id';

    // Disable Laravel's default timestamps (since not present in DB)
    public $timestamps = false;

    // Mass assignable fields
    protected $fillable = [
        'state',
        'zone',
        'country',
    ];
}
