<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branches extends Model
{
    /** @use HasFactory<\Database\Factories\BranchesFactory> */
    use HasFactory;


        protected $fillable = [
        'brn_id', 'name', 'address',
        'tambon_id', 'amphur_id', 'province_id',
        'org_id',
    ];
}
