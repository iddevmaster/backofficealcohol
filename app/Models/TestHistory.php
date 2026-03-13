<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestHistory extends Model
{
    //

      protected $table = 'test_histories';

       protected $fillable = ['id',
        'tester_id','device_sn','alcohol_level','testing_image','testing_date','created_date','updated_at','org_id'
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'tester_id', 'id');
    }
}
