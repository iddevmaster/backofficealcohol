<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Organization extends Model
{
    //

    use HasFactory, HasUuids;

    protected $fillable = ['org_id','name','logo','status'];

    protected $casts = [
        'status' => 'boolean',
    ];

    // ให้ column uuid หลักเป็น org_id (ไม่ใช่ id)
    public function uniqueIds(): array
    {
        return ['org_id'];
    }
}
