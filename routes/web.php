<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchesController;
use App\Http\Controllers\BranchesUserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentUserController;
use App\Http\Controllers\TambonController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\OrganizationUserController;
use App\Http\Controllers\PrefixesController;
use App\Http\Controllers\PrefixesUserController;
use App\Http\Controllers\UsersController;

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


    Route::get('/departments', [DepartmentUserController::class,'index'])
    ->middleware(['auth','permission:list departments'])
    ->name('departments.index');
    Route::get('/departments/create', [DepartmentUserController::class,'create'])
    ->middleware(['auth','permission:create departments'])
    ->name('departments.create');

    Route::POST('/departments', [DepartmentUserController::class,'store'])
    ->middleware(['auth','permission:store departments'])
    ->name('departments.store');

    Route::get('/departments/show', [DepartmentUserController::class,'show'])
    ->middleware(['auth','permission:show departments'])
    ->name('departments.show');

   Route::get('/departments/{id}/edit', [DepartmentUserController::class,'edit'])
    ->middleware(['auth','permission:edit departments'])
    ->name('departments.edit');

       Route::DELETE('/departments/{id}', [DepartmentUserController::class,'destroy'])
    ->middleware(['auth','permission:destroy departments'])
    ->name('departments.destroy');





    Route::resource('/branches', BranchesUserController::class);
    Route::resource('/organizations', OrganizationUserController::class);
    Route::resource('/prefixes', PrefixesUserController::class);

});



Route::get('/locations/amphurs/{province}', [LocationController::class, 'amphurs']);
Route::get('/locations/tambons/{amphur}',   [LocationController::class, 'tambons']);



Route::middleware('auth')->group(function () {



       Route::resource('/admin/departments', DepartmentController::class)->middleware([
        'index'   => 'permission:list departments',
        'create'  => 'permission:create departments',
        'store'   => 'permission:store departments',
        'edit'    => 'permission:edit departments',
        'update'  => 'permission:update departments',
        'show'    => 'permission:show departments',
        'destroy' => 'permission:delete departments',
    ]);


            Route::resource('/admin/branches', BranchesController::class)->middleware([
        'index'   => 'permission:list branches',
        'create'  => 'permission:create branches',
        'store'   => 'permission:create branches',
        'edit'    => 'permission:edit branches',
        'update'  => 'permission:edit branches',
        'show'    => 'permission:show branches',
        'destroy' => 'permission:delete branches',
    ]);
    Route::resource('/admin/organizations', OrganizationController::class)->middleware([
        'index'   => 'permission:list organizations',
        'create'  => 'permission:create organizations',
        'store'   => 'permission:create organizations',
        'edit'    => 'permission:edit organizations',
        'update'  => 'permission:edit organizations',
        'show'    => 'permission:show organizations',
        'destroy' => 'permission:delete organizations',
    ]);
    Route::resource('/admin/prefixes', PrefixesController::class)->middleware([
        'index'   => 'permission:list prefixes',
        'create'  => 'permission:create prefixes',
        'store'   => 'permission:create prefixes',
        'edit'    => 'permission:edit prefixes',
        'update'  => 'permission:edit prefixes',
        'show'    => 'permission:show prefixes',
        'destroy' => 'permission:delete prefixes',
    ]);

    Route::resource('/admin/users', UsersController::class);


});



require __DIR__.'/auth.php';
