<?php

use App\Http\Controllers\Abilities\PermissionController;
use App\Http\Controllers\Abilities\RoleController;
use App\Http\Controllers\Abilities\UserController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ReportsController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\VisitTimeController;
use App\Http\Controllers\Files\FileManagerController;
use App\Http\Controllers\Files\MediaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    // 'auth:sanctum',
    // config('jetstream.auth_session'),
    // 'verified',
])->group(function () {
    Route::get('/jetstream/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});



//route for dashboard

Route::middleware(['auth'])->group(function () {

});

Route::group([
    'middleware' => ['auth', 'role:super-admin'],
    'as'=>'dashboard.',  //pefor(pre) each name route
    'prefix'=>'dashboard', //pefor(pre) each path route
],function () {

    //route for dashboard main page

    Route::get('/',[DashboardController::class,'index'])->name('index');

    // route for roles

    Route::resource('roles', RoleController::class);
    Route::post('roles/{id}/permissions', [RoleController::class, 'assignPermissions'])->name('roles.assign-permissions');

    //route for permissions

    Route::resource('permissions', PermissionController::class);

    //route for manage users

    Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    Route::resource('users', UserController::class);
    Route::get('users/{user}/roles', [UserController::class, 'editRoles'])->name('users.editRoles');
    Route::post('users/{user}/roles', [UserController::class, 'assignRoles'])->name('users.assign-roles');
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

    //route for file manager

    Route::post('media/single', [MediaController::class, 'storeSingle'])->name('media.storeSingle');
    Route::post('media/multiple', [MediaController::class, 'storeMultiple'])->name('media.storeMultiple');
    Route::put('media/{mediaId}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('media/{mediaId}', [MediaController::class, 'destroy'])->name('media.destroy');
    Route::get('file-manager', [FileManagerController::class, 'index'])->name('file-manager.media');
    Route::delete('file-manager/{media}', [FileManagerController::class, 'destroy'])->name('file-manager.destroy');
    Route::get('file-manager/folder/{folder}', [FileManagerController::class, 'showFolder'])->name('file-manager.folder');

    //route for settings website

    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/general', [SettingsController::class, 'updateGeneral'])->name('settings.updateGeneral');
    Route::post('settings/about-us', [SettingsController::class, 'updateAboutUs'])->name('settings.updateAboutUs');
    Route::post('settings/contact-us', [SettingsController::class, 'updateContactUs'])->name('settings.updateContactUs');
    Route::post('settings/services', [SettingsController::class, 'storeService'])->name('settings.storeService');
    Route::put('settings/services/{service}', [SettingsController::class, 'updateService'])->name('settings.updateService');
    Route::delete('settings/services/{service}', [SettingsController::class, 'destroyService'])->name('settings.destroyService');
    Route::post('settings/faq', [SettingsController::class, 'updateFaqSettings'])->name('settings.updateFaq');
    Route::post('settings/privacy', [SettingsController::class, 'updatePrivacySettings'])->name('settings.updatePrivacy');
    Route::post('settings/terms', [SettingsController::class, 'updateTermsSettings'])->name('settings.updateTerms');

    //route for reportes and analystic

    Route::post('/visits/time', [VisitTimeController::class, 'updateTime'])->name('visits.time');
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
    Route::get('/user-activity-report', [ReportsController::class, 'userActivityReport'])->name('user-activity-report');



});
