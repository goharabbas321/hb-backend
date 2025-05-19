<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    //Route::apiResource('user', UserController::class)->names('user');
});

Route::middleware('auth:sanctum')->get('/test', function (Request $request) {
    return response()->json([
        'message' => 'Authenticated',
        'user' => $request->user()
    ]);
});
