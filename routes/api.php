<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TambonController;
use App\Http\Controllers\FingerController;

Route::get('/provinces', [TambonController::class , 'getProvinces' ]);
Route::get('/amphoes', [TambonController::class , 'getAmphoes' ]);
Route::get('/tambons', [TambonController::class , 'getTambons' ]);

Route::get('/filteremploy', [FingerController::class , 'filteredUsers' ]);

Route::get('/filteremphm', [FingerController::class , 'filteredUsersFromHm' ]);
Route::post('/savefinger', [FingerController::class , 'saveFinger' ]);
Route::post('/delall', [FingerController::class , 'delfingerall' ]);

Route::post('/delallone', [FingerController::class , 'delfingerone' ]);


Route::post('/em/checkfinger', [FingerController::class , 'checkFinger' ]);
Route::get('/testacl', [HistoriesController::class , 'filteredUsersTest' ]);