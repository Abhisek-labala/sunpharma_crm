<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    // Table with schema
    protected $table = 'common.medicines';

    // Primary key
    protected $primaryKey = 'id';

    // Disable automatic timestamps (since you're using custom `update_at`)
    public $timestamps = false;

    // Mass assignable attributes
    protected $fillable = [
        'medicine_name',
        'medicine_header_id',
        'created_at',
        'update_at',
        'status',
    ];

    // (Optional) Define relationship to MedicineHeader
    public function header()
    {
        return $this->belongsTo(MedicineHeader::class, 'medicine_header_id', 'id');
    }
}
