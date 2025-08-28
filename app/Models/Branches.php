<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;   // ✅ ต้อง use ของ Laravel

class Branches extends Model
{
    /** @use HasFactory<\Database\Factories\BranchesFactory> */
    use HasFactory;


        protected $fillable = [
        'brn_id', 'name', 'address',
        'tambon_id', 'amphur_id', 'province_id',
        'org_id',
    ];


    
      public function organize(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'org_id', 'id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

        public function amphur(): BelongsTo
    {
        return $this->belongsTo(Amphurs::class, 'amphur_id', 'id');
    }

        public function tambon(): BelongsTo
    {
        return $this->belongsTo(Tambon::class, 'tambon_id', 'id');
    }
}
