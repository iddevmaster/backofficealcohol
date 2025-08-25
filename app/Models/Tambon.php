<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tambon extends Model
{
    //
    protected $table = 'tambon';

         protected $fillable = ['id','tambon_code','name','amphur_id','province_id','tambon_status','created_at','updated_at'];
}
