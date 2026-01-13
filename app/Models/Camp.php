<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Camp extends Model
{
    // Table name (with public schema explicitly if needed)
    protected $table = 'public.camp';

    // Primary key
    protected $primaryKey = 'id';

    // Use Laravel's timestamps (column names match)
    public $timestamps = true;

    // Fillable fields
    protected $fillable = [
        'name',
        'educator_id',
        'hcp_id',
        'hcp_name',
        'date',
        'in_time',
        'out_time',
        'camp_id',
        'remarks',
        'execution_status',
        'created_at',
        'updated_at',
    ];
}
