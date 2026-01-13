<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compitetor extends Model
{
    // Table with schema name
    protected $table = 'common.compitetor';

    // Primary key
    protected $primaryKey = 'id';

    // Disable timestamps because you use custom columns
    public $timestamps = false;

    // Mass assignable fields
    protected $fillable = [
        'compitetor_name',
        'status',
        'created_at',
        'update_at',
    ];
}
