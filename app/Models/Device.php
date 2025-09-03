<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // << เพิ่มบรรทัดนี้

class Device extends Model
{
 use HasFactory; // << และบรรทัดนี้

    protected $fillable = [
        'model','serial_num','ip_address','sensor_sn','sensor_body_sn',
        'pi_mac_address','created_date','latitude','longitude',
        'tested_count','last_calibration','status',
    ];

    protected $casts = [
        'created_date'     => 'datetime',
        'last_calibration' => 'date',
        'latitude'         => 'float',
        'longitude'        => 'float',
        'tested_count'     => 'integer',
        'status'           => 'integer',
    ];
}
