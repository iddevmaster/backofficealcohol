<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devieslog extends Model
{
    //

     protected $table = 'deviceslog';

        protected $fillable = ['id',
        'tested_count','serial_num','ip_address','latitude','longitude','created_date','updated_at'
    ];

    // protected $casts = [
    //     'created_date'     => 'datetime',
    //     'last_calibration' => 'date',
    //     'latitude'         => 'float',
    //     'longitude'        => 'float',
    //     'tested_count'     => 'integer',
    //     'status'           => 'integer',
    // ];
}
