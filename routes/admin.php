<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{DashboardController,UserController,EmployerController,
IndustryController,FuncationalAreaController,RoleController,PermissionController,
CandidateController,IndustriesTypeController,LanguagController,SkillController,JobController};

//******************************************************************************************* */
//                                 Admin Main Route
//******************************************************************************************* */

Route::resource('users',UserController::class);
Route::resource('employers',EmployerController::class);
Route::resource('industry-type',IndustriesTypeController::class);
Route::resource('industries',IndustryController::class);
Route::resource('functional-areas',FuncationalAreaController::class);
Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class);
Route::resource('candidates',CandidateController::class);
Route::resource('languages',LanguagController::class);
Route::resource('skills',SkillController::class);
Route::resource('jobs',JobController::class);

//******************************************************************************************* */
//                                 Extra Route
//******************************************************************************************* */

Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard.index');
Route::get('/', [DashboardController::class,'dashboard'])->name('dashboard');
Route::get('/user/{name}', [UserController::class, 'user_list'])->name('user_list');
Route::post('/user/update-status', [UserController::class, 'updateStatus'])->name('users.updateStatus');
Route::name('roles.')->prefix('role')->group(function ($router) {
    Route::resource('/permission', PermissionController::class);
    Route::get('/permissions', [PermissionController::class, 'permissions'])->name('permissions');
    Route::get('/assing-permission', [PermissionController::class, 'assing_permission'])->name('assing_permission');
    Route::get('/role-permission', [PermissionController::class,'role_permission'])->name('role_permission');
});
