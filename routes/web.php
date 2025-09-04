<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchesController;
use App\Http\Controllers\BranchesUserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentUserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\TambonController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\OrganizationUserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PrefixesController;
use App\Http\Controllers\PrefixesUserController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\UsersByUsersController;
use App\Http\Controllers\EmployeesController;
use App\Models\Branches;
use App\Models\Department;

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


    // Department แยก route
    Route::get('/departments', [DepartmentUserController::class,'index'])
    ->middleware(['auth','permission:list departments'])
    ->name('departmentsUser.index');
    Route::get('/departments/create', [DepartmentUserController::class,'create'])
    ->middleware(['auth','permission:create departments'])
    ->name('departmentsUser.create');

    Route::POST('/departments', [DepartmentUserController::class,'store'])
    ->middleware(['auth','permission:store departments'])
    ->name('departmentsUser.store');

    Route::get('/departments/show', [DepartmentUserController::class,'show'])
    ->middleware(['auth','permission:show departments'])
    ->name('departmentsUser.show');

   Route::get('/departments/{department}/edit', [DepartmentUserController::class,'edit'])
    ->middleware(['auth','permission:edit departments'])
    ->name('departmentsUser.edit');

   Route::put('departments/{department}', [DepartmentUserController::class, 'update'])
    ->middleware(['auth','permission:update departments'])
    ->name('departmentsUser.update');

    Route::DELETE('/departments/{id}', [DepartmentUserController::class,'destroy'])
    ->middleware(['auth','permission:destroy departments'])
    ->name('departmentsUser.destroy');

// Branches แยก route
    Route::get('/branches', [BranchesUserController::class,'index'])
    ->middleware(['auth','permission:list branches'])
    ->name('branchesUser.index');
    Route::get('/branches/create', [BranchesUserController::class,'create'])
    ->middleware(['auth','permission:create branches'])
    ->name('branchesUser.create');

    Route::POST('/branches', [BranchesUserController::class,'store'])
    ->middleware(['auth','permission:store branches'])
    ->name('branchesUser.store');

    Route::get('/branches/show', [BranchesUserController::class,'show'])
    ->middleware(['auth','permission:show branches'])
    ->name('branchesUser.show');

   Route::get('/branches/{branch}/edit', [BranchesUserController::class,'edit'])
    ->middleware(['auth','permission:edit branches'])
    ->name('branchesUser.edit');

   Route::put('branches/{department}', [BranchesUserController::class, 'update'])
    ->middleware(['auth','permission:update branches'])
    ->name('branchesUser.update');

    Route::DELETE('/branches/{id}', [BranchesUserController::class,'destroy'])
    ->middleware(['auth','permission:destroy branches'])
    ->name('branchesUser.destroy');


    //   Route::resource('/roles', RoleUserController::class)->names('roles');



    Route::get('/roles', [RoleUserController::class,'index'])
    ->middleware(['auth','permission:list branches'])
    ->name('rolesUser.index');
    Route::get('/roles/create', [RoleUserController::class,'create'])
    ->name('rolesUser.create');

    Route::POST('/roles', [RoleUserController::class,'store'])
    ->middleware(['auth','permission:store branches'])
    ->name('rolesUser.store');

    Route::get('/roles/show/{role}', [RoleUserController::class,'show'])
    ->middleware(['auth','permission:show branches'])
    ->name('rolesUser.show');

   Route::get('/roles/{role}/edit', [RoleUserController::class,'edit'])
    ->middleware(['auth','permission:edit branches'])
    ->name('rolesUser.edit');

   Route::put('roles/{role}', [RoleUserController::class, 'update'])
    ->middleware(['auth','permission:update branches'])
    ->name('rolesUser.update');

    Route::DELETE('/roles/{id}', [RoleUserController::class,'destroy'])
    ->middleware(['auth','permission:destroy branches'])
    ->name('rolesUser.destroy');



        Route::get('/usersUser', [UsersByUsersController::class,'index'])
    ->middleware(['auth','permission:list branches'])
    ->name('usersUser.index');
    Route::get('/usersUser/create', [UsersByUsersController::class,'create'])
    ->middleware(['auth','permission:create branches'])
    ->name('usersUser.create');

    Route::POST('/usersUser', [UsersByUsersController::class,'store'])
    ->middleware(['auth','permission:store branches'])
    ->name('usersUser.store');

    Route::get('/usersUser/show', [UsersByUsersController::class,'show'])
    ->middleware(['auth','permission:show branches'])
    ->name('usersUser.show');

   Route::get('/usersUser/{user}/edit', [UsersByUsersController::class,'edit'])
    ->middleware(['auth','permission:edit branches'])
    ->name('usersUser.edit');

   Route::put('usersUser/{user}', [UsersByUsersController::class, 'update'])
    ->middleware(['auth','permission:update branches'])
    ->name('usersUser.update');

    Route::DELETE('/usersUser/{id}', [UsersByUsersController::class,'destroy'])
    ->middleware(['auth','permission:destroy branches'])
    ->name('usersUser.destroy');

    // Route::resource('/branches', BranchesUserController::class);
    // Route::resource('/organizations', OrganizationUserController::class);
    // Route::resource('/prefixes', PrefixesUserController::class);

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
    Route::resource('/admin/devices', DeviceController::class)->names('devices');
    // Route::resource('/admin/roles', RoleController::class);

    Route::get('/admin/access', [RoleController::class,'dashboard'])->name('access.dashboard');
    Route::resource('/admin/roles', RoleController::class)->names('admin.roles');
    Route::resource('/admin/permissions', PermissionController::class);
    Route::resource('/admin/employees', EmployeesController::class);


Route::get('/api/orgs/{org}/branches', fn($org) =>
    Branches::where('org_id',$org)->orderBy('name')->get(['id','name'])
)->middleware(['web','auth'])->name('api.org.branches');

Route::get('/api/branches/{brn}/departments', function ($brn) {
    // กรองให้ชัด: dept ต้องอยู่ใต้ branch นี้
    return Department::where('brn_id',$brn)->orderBy('name')->get(['id','name']);
})->middleware(['web','auth'])->name('api.branch.departments');

});



require __DIR__.'/auth.php';
