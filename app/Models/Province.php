<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    //
    protected $table = 'province';

     protected $fillable = ['id','code','name','status','created_at','updated_at'];
}
