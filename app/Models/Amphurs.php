<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amphurs extends Model
{
    //
    protected $table = 'amphurs';

    protected $fillable = ['id','amphur_code','name','amphur_id','status','created_at','updated_at'];

    
}
