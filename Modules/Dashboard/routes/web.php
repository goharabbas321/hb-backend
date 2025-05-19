<?php

use App\Http\Middleware\CheckUserStatus;
use Illuminate\Support\Facades\Route;
use Modules\Dashboard\Http\Controllers\DashboardController;

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
                // Dashboard
                Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            });
        });
    }
);
