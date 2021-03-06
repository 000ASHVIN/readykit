<?php

use App\Http\Controllers\Admin\AdminAreasController;
use App\Http\Controllers\Admin\AdminBranchesController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminHouseLotsController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminWaterReadingController;
use App\Http\Controllers\App\Settings\SettingsApiController;
use App\Http\Controllers\Core\Auth\User\UserPasswordController;
use App\Http\Controllers\Core\LanguageController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\InstallDemoDataController;
use App\Http\Controllers\SymlinkController;
use App\Http\Middleware\PermissionMiddleware;
use App\Http\Controllers\Core\Auth\User\LoginController;
use App\Http\Controllers\User\BranchController;
use App\Http\Controllers\User\HouseLotController;
use App\Http\Controllers\User\WaterTankReadingsController;
use App\Models\Core\Auth\Role;
use Illuminate\Support\Facades\Artisan;

// Route::get('create-user-role',function(){
//     $role = Role::create(['name'=>'site_officer']);
//     dd($role);
// });
// Route::get('test',function(){
//     $test = 'demo';
//     return view('report.water_reading_info',compact('test'));
// });

Route::get('/forget-password', [UserPasswordController::class, 'passwordReset']);
Route::get('user/registration', [\App\Http\Controllers\Core\Auth\User\RegistrationController::class, 'index']);

Route::group(['middleware' => 'guest', 'prefix' => 'user'], function () {
    include_route_files(__DIR__ . '/user/');
});

Route::group(['middleware' => 'guest', 'prefix' => 'admin/users'], function () {
    include_route_files(__DIR__ . '/login/');
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'as' => 'core.'], function () {
    include_route_files(__DIR__ . '/core/');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'authorize']], function () {
    include  __DIR__ . '/additional.php';
});


Route::get('login', [LoginController::class, 'show'])
    ->name('users.login.index');

Route::post('login', [LoginController::class, 'login'])
    ->name('users.login');

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard.index');
    Route::get('reports', [AdminDashboardController::class, 'reports'])->name('admin.dashboard.reports');
    Route::get('get-roles', [AdminUsersController::class, 'getRoles'])->name('admin.get-roles');
});

Route::middleware(['auth','is_admin'])->prefix('admin')->group(function () {
    Route::get('users', [AdminUsersController::class, 'index'])->name('admin.users.index');
    Route::get('users/create', [AdminUsersController::class, 'create_view'])->name('admin.users.create-view');
    Route::post('users/create', [AdminUsersController::class, 'create'])->name('admin.users.create');
    Route::get('get-users',[AdminUsersController::class, 'getUsersList'])->name('get.admin.users');
    Route::get('get-users-for-form', [AdminUsersController::class, 'getUsersForFormList'])->name('get.admin.users.for.form');
    Route::get('users/{id}/edit',[AdminUsersController::class,'edit'])->name('admin.user-edit');
    Route::post('users/{id}/update', [AdminUsersController::class, 'update'])->name('admin.user-update');
    Route::get('users/{id}/delete', [AdminUsersController::class, 'delete'])->name('admin.user-delete');
    Route::get('get-user/{id}',[AdminUsersController::class,'getUser']);

    Route::get('users/list', [AdminUsersController::class, 'getListAjax'])->name('admin.users.list');
});
Route::middleware(['auth','is_admin'])->prefix('admin')->group(function () {
    Route::get('branches', [AdminBranchesController::class, 'index'])->name('admin.branches.index');
    Route::get('branches/create', [AdminBranchesController::class, 'create_view'])->name('admin.branches.create-view');
    Route::post('branches/create', [AdminBranchesController::class, 'create'])->name('admin.branch.create');
    Route::get('get-branches', [AdminBranchesController::class, 'getBranchesList'])->name('get.admin.branches');
    Route::get('get-branches-for-form', [AdminBranchesController::class, 'getBranchesForFormList'])->name('get.admin.branches.for.form');
    Route::get('branches/{id}/edit', [AdminBranchesController::class, 'edit'])->name('admin.branch-edit');
    Route::post('branches/{id}/update', [AdminBranchesController::class, 'update'])->name('admin.branch-update');
    Route::get('branches/{id}/delete', [AdminBranchesController::class, 'delete'])->name('admin.branch-delete');

    Route::get('branches/list', [AdminBranchesController::class, 'getListAjax'])->name('admin.branches.list');
});
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('areas', [AdminAreasController::class, 'index'])->name('admin.areas.index');
    Route::get('areas/create', [AdminAreasController::class, 'create_view'])->name('admin.areas.create-view');
    Route::post('areas/create', [AdminAreasController::class, 'create'])->name('admin.area.create');
    Route::get('get-areas', [AdminAreasController::class, 'getAreasList'])->name('get.admin.areas');
    Route::get('get-areas-for-form', [AdminAreasController::class, 'getAreasForFormList'])->name('get.admin.areas.for.form');
    Route::get('areas/{id}/edit', [AdminAreasController::class, 'edit'])->name('admin.area-edit');
    Route::post('areas/{id}/update', [AdminAreasController::class, 'update'])->name('admin.area-update');
    Route::get('areas/{id}/delete', [AdminAreasController::class, 'delete'])->name('admin.area-delete');

    Route::get('areas/list', [AdminAreasController::class, 'getListAjax'])->name('admin.areas.list');
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('houselots', [AdminHouseLotsController::class, 'index'])->name('admin.houselots.index');
    Route::get('houselots/create', [AdminHouseLotsController::class, 'create_view'])->name('admin.houselots.create-view');
    Route::post('houselots/create', [AdminHouseLotsController::class, 'create'])->name('admin.houselots.create');
    Route::get('get-houselots', [AdminHouseLotsController::class, 'getHouseLotsList'])->name('get.admin.houselots');
    Route::get('houselots/{id}/edit', [AdminHouseLotsController::class, 'edit'])->name('admin.houselot-edit');
    Route::post('houselots/{id}/update', [AdminHouseLotsController::class, 'update'])->name('admin.houselot-update');
    Route::get('houselots/{id}/delete', [AdminHouseLotsController::class, 'delete'])->name('admin.houselot-delete');

    Route::get('houselots/list', [AdminHouseLotsController::class, 'getListAjax'])->name('admin.houselots.list');
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('get-all-export-data',[AdminWaterReadingController::class,'getAllExportData'])->name('admin.get_export_data');
    Route::post('get-all-export-data-by-date',[AdminWaterReadingController::class,'getExportByDate'])->name('admin.get_export_data_date');

    Route::get('water_readings', [AdminWaterReadingController::class, 'index'])->name('admin.water_readings.index');
    Route::get('water_readings/{branch_id}/branch', [AdminWaterReadingController::class, 'getReadingsByBranch'])->name('admin.water_readings.branch');
    Route::get('water_readings/create', [AdminWaterReadingController::class, 'create_view'])->name('admin.water_readings.create-view');
    Route::post('water_readings/create', [AdminWaterReadingController::class, 'create'])->name('admin.water_readings.create');
    Route::get('get-water_readings', [AdminWaterReadingController::class, 'getWaterReadingsList'])->name('get.admin.water_readings');
    Route::get('water_readings/{id}/edit', [AdminWaterReadingController::class, 'edit'])->name('admin.water_reading-edit');
    Route::post('water_readings/{id}/update', [AdminWaterReadingController::class, 'update'])->name('admin.water_reading-update');
    Route::get('water_readings/{id}/delete', [AdminWaterReadingController::class, 'delete'])->name('admin.water_reading-delete');
    Route::get('get-reading-info/{id}',[AdminWaterReadingController::class,'getReadingInfo'])->name('admin.get_reading_info');

    Route::get('water_readings/list/{branch_id?}', [AdminWaterReadingController::class, 'customgetWaterReadinLinst'])->name('admin.water_readings.list');

    Route::get('water_readings/datatable', [AdminWaterReadingController::class, 'datatable'])->name('admin.water_readings.datatable');
    Route::get('water_readings/branch/list', [AdminWaterReadingController::class, 'getData'])->name('admin.water_readings.branch.list');
    Route::post('water_readings/branch/export/{branch_id}',[AdminWaterReadingController::class,'exportDataByBranchAndDate'])->name('admin.water_readings.branch.export');
    Route::get('water_readings/branch/export/{branch_id}/all',[AdminWaterReadingController::class,'exportDataByBranchAll'])->name('admin.water_readings.branch.export');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/',[WaterTankReadingsController::class,'create_view'])->name('user.water-tank.reading');
    Route::post('create-reading',[WaterTankReadingsController::class,'create'])->name('create.reading');
    Route::get('/get-branch/{id}',[BranchController::class,'getBranch']);
    Route::get('/get-serialnum/{id}', [HouseLotController::class, 'getSerialNum']);
    Route::get('show-reading/{id}',[WaterTankReadingsController::class,'showReading'])->name('show-reading');
    Route::get('edit-reading/{id}', [WaterTankReadingsController::class, 'editReading'])->name('edit-reading');
    Route::post('update-reading/{id}', [WaterTankReadingsController::class, 'update'])->name('update.reading');

    Route::get('branch/{id}/house_lots', [BranchController::class, 'getHouseLotsList'])->name('branch.houselot.list');
    Route::get('water_readings/{serial_no}/last', [WaterTankReadingsController::class, 'getLastReading'])->name('water_readings.last');
});

/**
 * This route is only for user dashboard
 * And for some additional route
 */
//auth()->loginUsingId(1);

Route::get('/get-basic-setting-data', [SettingsApiController::class, 'getBasicSettingData']);
Route::group(['middleware' => ['auth', 'authorize']], function () {
    include_route_files(__DIR__ . '/app/');
});

Route::get("doc/core/components", [DocumentationController::class,'index']);
Route::get("doc/core/components/{component_name}", [DocumentationController::class,'show']);



// Switch between the included languages
Route::get('lang/{lang}', [LanguageController::class, 'swap'])->name('language.change');

// available languages
Route::get('languages', [LanguageController::class, 'index'])->name('languages.index');

/*
 * All login related route will be go there
 * Only guest user can access this route
 */



/**
 * This route is only for brand redirection
 * And for some additional route
 */


Route::any('install-demo-data', [InstallDemoDataController::class, 'run'])
    ->name('install-demo-data');

Route::any('symlink', [SymlinkController::class, 'run'])
    ->name('storage.symlink');
/**
 * Backend Routes
 * Namespaces indicate folder structure
 * All your route in sub file must have a name with not more than 2 index
 * Example: brand.index or dashboard
 * See @var PermissionMiddleware for more information
 */

Route::get('call/migrate', function() {
    Artisan::call('migrate');
    echo "done";
});

Route::get('call/migrate/rollback', function() {
    Artisan::call('migrate:rollback');
    echo "done";
});

 Route::get('call/migrate/fresh', function() {
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');
    echo "done";
 });

 Route::get('storage/link', function() {
    Artisan::call('storage:link');
    echo "done";
 });
Route::get('vendor-publish',function(){
    Artisan::call('vendor:publish');
    echo "done";
});
