<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Employee extends Model
{
    //

        use SoftDeletes;

    protected $fillable = [
        'emp_id','prefix','first_name','last_name','phone','image',
        'fingerprint_registered','status','dpm_id','brn_id','org_id',
    ];

    protected $casts = [
        'fingerprint_registered' => 'boolean',
        'status'                 => 'boolean',
    ];

    // Relations
    public function department() { return $this->belongsTo(\App\Models\Department::class, 'dpm_id'); }
    public function Branches()     { return $this->belongsTo(\App\Models\Branches::class, 'brn_id'); }
    public function organization(){ return $this->belongsTo(\App\Models\Organization::class, 'org_id'); }

    // Helpers
    public function getFullNameAttribute(): string
    {
        return trim("{$this->prefix} {$this->first_name} {$this->last_name}");
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }
}
