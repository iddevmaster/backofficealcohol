<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fingerprints extends Model
{
    //

        //
    protected $table = 'fingerprints';

    protected $fillable = ['id','emp_id','finger_no','fingerprint_code','note','timestamp','created_at','updated_at'];
}
