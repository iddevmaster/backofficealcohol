<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //

      protected $fillable = ['name', 'guard_name'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions', 'permission_id', 'role_id');
    }

    public function models()
    {
        // ตัวอย่าง: ใช้คู่กับ User (หรือโมเดลอื่น) ผ่าน pivot polymorphic มือเอง
        return $this->morphedByMany(\App\Models\User::class, 'model', 'model_has_permissions', 'permission_id', 'model_id');
    }
}
