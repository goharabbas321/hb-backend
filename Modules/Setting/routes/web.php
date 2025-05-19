<?php

use App\Http\Middleware\CheckUserStatus;
use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\LanguageController;
use Modules\Setting\Http\Controllers\ModuleController;
use Modules\Setting\Http\Controllers\SettingController;

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
        // Locale
        Route::get('/lang/{locale}', [LanguageController::class, 'swap'])->name('language.swap');

        // Clear Cache:
        Route::get('/clear-cache', [SettingController::class, 'clearCache'])->name('clear.cache');

        // Arabic Number
        Route::post('/amount/arabic', [SettingController::class, 'getArabicAmount'])->name('get.arabic.amount');

        Route::middleware(['auth:sanctum', config('jetstream.auth_session'), CheckUserStatus::class])->group(function () {
            Route::middleware(['verified'])->group(function () {
                // Settings
                Route::prefix('/settings')->name('settings.')->group(function () {
                    Route::get('/', [SettingController::class, 'index'])->middleware(['can:read_settings'])->name('index');
                    Route::put('/general_settings', [SettingController::class, 'updateGeneralSettings'])->middleware(['can:update_settings'])->name('update');
                    Route::get('/activity-logs', [SettingController::class, 'activityLogs'])->middleware(['can:read_logs'])->name('logs');
                    Route::post('/logs/data/{id}', [SettingController::class, 'getLogsData'])->middleware(['can:read_logs'])->name('logs.data');
                    // Modules
                    Route::prefix('/modules')->name('modules.')->group(function () {
                        Route::get('/', [ModuleController::class, 'index'])->middleware(['can:manage_modules'])->name('index');
                        Route::put('/module_update/{name}', [ModuleController::class, 'update'])->middleware(['can:manage_modules'])->name('update');
                    });
                    Route::get('/create-backup', [SettingController::class, 'createBackup'])->middleware(['can:create_backups'])->name('backups.index');
                });
            });
        });
    }
);
