<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrgDevice extends Model
{
    use HasFactory;

    protected $table = 'org_devices';

    protected $fillable = [
        'name',
        'serial_num',
        'brn_id',
        'org_id',
        'note',
        'public_pwd',
    ];

    /**
     * Get the organization that owns the device.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'org_id', 'id');
    }

    /**
     * Get the branch that owns the device.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branches::class, 'brn_id', 'id');
    }
}
