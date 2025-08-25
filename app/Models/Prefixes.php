<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prefixes extends Model
{
    /** @use HasFactory<\Database\Factories\PrefixesFactory> */
    use HasFactory;

     protected $fillable = ['name'];
}
