<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;   // ✅ ต้อง use ของ Laravel


class Department extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory;

        protected $fillable = [
        'dpm_id',
        'name',
        'brn_id',
    ];


        public function branches(): BelongsTo
    {
        return $this->belongsTo(Branches::class, 'brn_id', 'id');
    }
}
