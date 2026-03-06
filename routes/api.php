<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TambonController;
use App\Http\Controllers\FingerController;

Route::get('/provinces', [TambonController::class , 'getProvinces' ]);
Route::get('/amphoes', [TambonController::class , 'getAmphoes' ]);
Route::get('/tambons', [TambonController::class , 'getTambons' ]);

Route::get('/filteremploy', [FingerController::class , 'filteredUsers' ]);
