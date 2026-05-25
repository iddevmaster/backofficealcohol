<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestHistory extends Model
{
    //

    protected $table = 'test_histories';

    protected $fillable = [
        'id',
        'tester_id',
        'device_sn',
        'alcohol_level',
        'result',
        'testing_image',
        'testing_date',
        'org_id',
        'brn_id',
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'tester_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branches::class, 'brn_id', 'id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id', 'id');
    }
}
