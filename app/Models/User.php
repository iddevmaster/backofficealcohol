<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\RoleName;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Traits\HasRoles; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Relations\BelongsTo;   // ✅ ต้อง use ของ Laravel

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

         protected $fillable = [
        'username','password','prefix_id','first_name','last_name','email',
        'role_id','dpm_id','brn_id','org_id','phone','status',
    ];


    protected $casts = [
        'status' => 'boolean',
    ];

    // แฮชรหัสผ่านอัตโนมัติเมื่อถูก set (กันกรณีส่งค่าเดิมมา)
    public function setPasswordAttribute($value)
    {
        if (!$value) return; // อย่าทับถ้าเป็นค่าว่าง (เช่นตอน update ไม่เปลี่ยน)
        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }

    // ชื่อเต็ม (optional helper)
    public function getFullNameAttribute(): string
    {
        return trim("{$this->prefix} {$this->first_name} {$this->last_name}");
    }
    protected $guard_name = 'web'; // (แนะนำ ระบุ guard ให้ตรง)


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

         public function organize(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'org_id', 'id');
    }




 
}
