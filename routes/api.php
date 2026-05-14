<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TambonController;
use App\Http\Controllers\FingerController;
use App\Http\Controllers\HistoriesController;
use App\Http\Controllers\Api\DeviceApiController;

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

// Device API — protected by Sanctum personal access token
Route::middleware('auth:sanctum')->prefix('device')->group(function () {
    Route::get('/employee/{org_id}/{emp_id}', [DeviceApiController::class, 'getEmployee']);
    Route::get('/employees/{org_id}',          [DeviceApiController::class, 'getEmployees']);
    Route::post('/scans/{org_id}',            [DeviceApiController::class, 'storeScan']);
    Route::post('/test',                      [DeviceApiController::class, 'storeTest']);
});