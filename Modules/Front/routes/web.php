<?php

use Illuminate\Support\Facades\Route;
use Modules\Front\Http\Controllers\FrontController;

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

Route::middleware(['throttle:120,1'])->group(function () {
    // Main Page Route
    Route::get('/', [FrontController::class, 'index'])->name('home.index');
});
