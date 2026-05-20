<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnonymousTest extends Model
{
    protected $fillable = [
        'org_id',
        'device_id',
        'user_id',
        'scan_type',
        'result',
        'value',
        'scanned_at',
        'image_path',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
        'value' => 'float',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id', 'id');
    }
}
