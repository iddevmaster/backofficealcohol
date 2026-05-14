<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceScan extends Model
{
    protected $fillable = [
        'employee_id',
        'org_id',
        'device_id',
        'scan_type',
        'result',
        'scanned_at',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id', 'id');
    }
}
