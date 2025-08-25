<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Amphurs;
use App\Models\Tambon;

class TambonController extends Controller
{
    //

       public function getProvinces()
    {
        $provinces = Province::all();
         return response()->json($provinces, 200); // 200 is the HTTP status code
    }
    public function getAmphoes()
    {
         $amphurs = Amphurs::all();
         return response()->json($amphurs, 200); // 200 is the HTTP status code
        return $amphoes;
    }
    public function getTambons(Request $request)
    {
        $datas = [];
        $tambons = Tambon::all();

        $datas = $tambons->map(function($t) {
    return (object)[
        'id'   => $t->id,
        'tambon_code' => $t->tambon_code,
        'name' => $t->name,
        'amphur_id' => $t->amphur_id,
        'province_id' => $t->province_id,
        'tambon_status' => $t->tambon_status,
        'created_at' => $t->created_at,
        'updated_at' => $t->updated_at,
    ];
})->all();
        return $datas;
        }

}
