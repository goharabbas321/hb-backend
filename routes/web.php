<?php

use App\Http\Controllers\ApiToken\ApiTokenController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Middleware\CheckUserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:120,1'])->group(function () {
    // Handles the request to send verification
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->withNotify([['success', __('messages.verify_email.email_success')]]);
    })->middleware(['auth', 'throttle:20,1'])->name('verification.send');

    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), CheckUserStatus::class])->group(function () {
        Route::middleware(['verified'])->group(function () {
            // Api Token Management
            Route::prefix('/user/api-tokens')->name('api-tokens.')->group(function () {
                Route::get('/', [ApiTokenController::class, 'index'])->middleware(['can:read_api'])->name('index');
                Route::post('/', [ApiTokenController::class, 'store'])->middleware(['can:create_api'])->name('store');
                Route::put('/{token}', [ApiTokenController::class, 'update'])->middleware(['can:update_api'])->name('update');
                Route::delete('/{token}', [ApiTokenController::class, 'destroy'])->middleware(['can:delete_api'])->name('destroy');
            });
        });

        // Profile
        Route::prefix('/users/profile')->name('profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'show'])->middleware(['can:read_profile'])->name('show');
            Route::put('/{user}', [ProfileController::class, 'update'])->middleware(['can:update_profile'])->name('update');
            Route::put('/change_password/{user}', [ProfileController::class, 'changePassword'])->middleware(['can:update_password'])->name('change_password');
            Route::delete('/logout-other-sessions', [ProfileController::class, 'logoutOtherSessions'])->middleware(['can:logout_sessions'])->name('logout-other-sessions');
        });
        Route::post('/users/profile/two-factor-enable', [ProfileController::class, 'enable'])->middleware(['can:enable_2fa'])->name('two-factor.enable');
        Route::post('/users/profile/two-factor-disable', [ProfileController::class, 'disable'])->middleware(['can:disable_2fa'])->name('two-factor.disable');
    });
});
