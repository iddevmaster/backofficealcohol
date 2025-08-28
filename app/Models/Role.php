<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
}
