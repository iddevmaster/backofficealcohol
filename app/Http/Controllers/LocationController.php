<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Amphurs;
use App\Models\Province;
use App\Models\Tambon;

class LocationController extends Controller
{
    //

     public function amphurs(Province $province)
    {
        
        return Amphurs::where('province_id', $province->id)
            ->orderBy('name')
            ->get(['id','name']);
    }

    public function tambons(Amphurs $amphur)
    {
        return Tambon::where('amphur_id', $amphur->id)
            ->orderBy('name')
            ->get(['id','name']);
    }

    public static function provincesForForm()
    {
        return Province::orderBy('name')->get(['id','name']);
    }
}
