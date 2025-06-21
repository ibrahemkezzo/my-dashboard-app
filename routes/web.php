<?php

use App\Http\Controllers\Abilities\PermissionController;
use App\Http\Controllers\Abilities\RoleController;
use App\Http\Controllers\Abilities\UserController;
use App\Http\Controllers\Files\FileManagerController;
use App\Http\Controllers\Files\MediaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::post('media/single', [MediaController::class, 'storeSingle'])->name('media.storeSingle');
    Route::post('media/multiple', [MediaController::class, 'storeMultiple'])->name('media.storeMultiple');
    Route::put('media/{mediaId}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('media/{mediaId}', [MediaController::class, 'destroy'])->name('media.destroy');
});

Route::middleware(['auth', 'role:super-admin'])->group(function () {
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    Route::resource('roles', RoleController::class);
    Route::post('roles/{id}/permissions', [RoleController::class, 'assignPermissions'])->name('roles.assign-permissions');
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);
    Route::get('users/{user}/roles', [UserController::class, 'editRoles'])->name('users.editRoles');
    Route::post('users/{user}/roles', [UserController::class, 'assignRoles'])->name('users.assign-roles');
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::get('file-manager', [FileManagerController::class, 'index'])->name('file-manager.index');
    Route::delete('file-manager/{media}', [FileManagerController::class, 'destroy'])->name('file-manager.destroy');
});
