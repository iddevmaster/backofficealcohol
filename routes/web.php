<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchesController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TambonController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PrefixesController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [AuthController::class, 'login']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Route::get('/department', [DepartmentController::class, 'index'])->name('department.index')->middleware(['permission:create department']);
    // Route::resource('/departments', DepartmentController::class)->middleware([
    //     'index'   => 'permission:list departments'
    // ]);

    Route::get('/departments', [DepartmentController::class,'index'])
    ->middleware(['auth','permission:list departments'])
    ->name('departments.index');
    Route::get('/departments/create', [DepartmentController::class,'create'])
    ->middleware(['auth','permission:create departments'])
    ->name('departments.create');

        Route::POST('/departments', [DepartmentController::class,'store'])
    ->middleware(['auth','permission:store departments'])
    ->name('departments.store');

    Route::get('/departments/show', [DepartmentController::class,'show'])
    ->middleware(['auth','permission:show departments'])
    ->name('departments.show');

   Route::get('/departments/{id}/edit', [DepartmentController::class,'edit'])
    ->middleware(['auth','permission:edit departments'])
    ->name('departments.edit');

       Route::DELETE('/departments/{id}', [DepartmentController::class,'destroy'])
    ->middleware(['auth','permission:destroy departments'])
    ->name('departments.destroy');

    
    
    Route::resource('/branches', BranchesController::class)->middleware([
        'index'   => 'permission:list branches',
        'create'  => 'permission:create branches',
        'store'   => 'permission:create branches',
        'edit'    => 'permission:edit branches',
        'update'  => 'permission:edit branches',
        'show'    => 'permission:show branches',
        'destroy' => 'permission:delete branches',
    ]);
    Route::resource('organizations', OrganizationController::class)->middleware([
        'index'   => 'permission:list organizations',
        'create'  => 'permission:create organizations',
        'store'   => 'permission:create organizations',
        'edit'    => 'permission:edit organizations',
        'update'  => 'permission:edit organizations',
        'show'    => 'permission:show organizations',
        'destroy' => 'permission:delete organizations',
    ]);
    Route::resource('prefixes', PrefixesController::class)->middleware([
        'index'   => 'permission:list prefixes',
        'create'  => 'permission:create prefixes',
        'store'   => 'permission:create prefixes',
        'edit'    => 'permission:edit prefixes',
        'update'  => 'permission:edit prefixes',
        'show'    => 'permission:show prefixes',
        'destroy' => 'permission:delete prefixes',
    ]);
});



Route::get('/locations/amphurs/{province}', [LocationController::class, 'amphurs']);
Route::get('/locations/tambons/{amphur}',   [LocationController::class, 'tambons']);



require __DIR__.'/auth.php';
