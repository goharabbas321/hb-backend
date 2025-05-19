<?php

use App\Http\Middleware\CheckUserStatus;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\PermissionController;
use Modules\User\Http\Controllers\RoleController;
use Modules\User\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['throttle:120,1'])->group(
    function () {
        Route::middleware(['auth:sanctum', config('jetstream.auth_session'), CheckUserStatus::class])->group(function () {
            Route::middleware(['verified'])->group(function () {
                // Users
                Route::prefix('/users')->name('users.')->group(function () {
                    Route::get('/', [UserController::class, 'index'])->middleware(['can:read_users'])->name('index');
                    Route::get('/create', [UserController::class, 'create'])->middleware(['can:create_users'])->name('create');
                    Route::post('/store', [UserController::class, 'store'])->middleware(['can:create_users'])->name('store');
                    Route::get('/show/{user}', [UserController::class, 'show'])->middleware(['can:read_users'])->name('show');
                    Route::get('/{user}/edit', [UserController::class, 'edit'])->middleware(['can:update_users'])->name('edit');
                    Route::put('/{user}', [UserController::class, 'update'])->middleware(['can:update_users'])->name('update');
                    Route::delete('/{user}', [UserController::class, 'destroy'])->middleware(['can:delete_users'])->name('destroy');
                    Route::post('/bulk-action', [UserController::class, 'bulkAction'])->middleware(['can:delete_users'])->name('bulk_action');
                    Route::post('/data/{id}', [UserController::class, 'getData'])->middleware(['can:read_users'])->name('data');
                });

                // Roles
                Route::prefix('/roles')->name('roles.')->group(function () {
                    Route::get('/', [RoleController::class, 'index'])->middleware(['can:read_roles'])->name('index');
                    Route::get('/create', [RoleController::class, 'create'])->middleware(['can:create_roles'])->name('create');
                    Route::post('/store', [RoleController::class, 'store'])->middleware(['can:create_roles'])->name('store');
                    Route::get('/{role}/edit', [RoleController::class, 'edit'])->middleware(['can:update_roles'])->name('edit');
                    Route::put('/{role}', [RoleController::class, 'update'])->middleware(['can:update_roles'])->name('update');
                    Route::delete('/{role}', [RoleController::class, 'destroy'])->middleware(['can:delete_roles'])->name('destroy');
                    Route::post('/data/{id}', [RoleController::class, 'getData'])->middleware(['can:read_roles'])->name('data');
                });

                // Permissions
                Route::prefix('/permissions')->name('permissions.')->group(function () {
                    Route::get('/', [PermissionController::class, 'index'])->middleware(['can:read_permissions'])->name('index');
                    Route::get('/create', [PermissionController::class, 'create'])->middleware(['can:create_permissions'])->name('create');
                    Route::post('/store', [PermissionController::class, 'store'])->middleware(['can:create_permissions'])->name('store');
                    Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->middleware(['can:update_permissions'])->name('edit');
                    Route::put('/{permission}', [PermissionController::class, 'update'])->middleware(['can:update_permissions'])->name('update');
                    Route::delete('/{permission}', [PermissionController::class, 'destroy'])->middleware(['can:delete_permissions'])->name('destroy');
                    Route::post('/data/{id}', [PermissionController::class, 'getData'])->middleware(['can:read_permissions'])->name('data');
                });
            });
        });
    }
);
