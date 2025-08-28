<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Traits\HasRoles; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Relations\BelongsTo;   // ✅ ต้อง use ของ Laravel

class Role extends Model
{
    //

    protected $fillable = ['name', 'guard_name', 'org_id'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id', 'permission_id');
    }

    public function models()
    {
        return $this->morphedByMany(\App\Models\User::class, 'model', 'model_has_roles', 'role_id', 'model_id');
    }

    public function organize(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'org_id', 'id');
    }
}
