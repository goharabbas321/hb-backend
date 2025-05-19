<?php

use Illuminate\Support\Facades\Route;
use Modules\Medical\Http\Controllers\API\AppointmentController;
use Modules\Medical\Http\Controllers\API\HospitalController;
use Modules\Medical\Http\Controllers\API\AppointmentAvailabilityController;

// Appointment availability check - doesn't require authentication
// This needs to be outside any prefix group to match the URL in the JS fetch
Route::match(['get', 'post'], 'check-appointment-availability', [AppointmentAvailabilityController::class, 'check'])
    ->name('appointments.check-availability');

// Get appointment count for a specific hospital and date - used for auto-booking hospitals
Route::match(['get', 'post'], 'get-appointment-count', [AppointmentAvailabilityController::class, 'getCount'])
    ->name('appointments.get-count');

// Public routes - accessible without authentication
Route::prefix('v1')->group(function () {
    // Hospital routes
    Route::get('hospitals', [HospitalController::class, 'index'])->name('hospitals.index');
    Route::get('hospitals/{id}', [HospitalController::class, 'show'])->name('hospitals.show');
});

// API routes for appointment form
Route::get('hospitals/{hospital}/specializations', [HospitalController::class, 'getSpecializations']);
Route::get('hospitals/{hospital}/specializations/{specialization}/available-dates', [AppointmentAvailabilityController::class, 'getAvailableDates']);

// Protected appointment routes - require authentication
Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    // Appointment routes
    Route::apiResource('appointments', AppointmentController::class);
});

// Test route for debugging parameter handling
Route::match(['get', 'post'], 'test-params', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Log::info('Received parameters in test-params route', [
        'all_params' => $request->all(),
        'method' => $request->method(),
        'hospital_id' => $request->input('hospital_id'),
        'date' => $request->input('date'),
        'specialization_id' => $request->input('specialization_id'),
        'specialization_id_type' => gettype($request->input('specialization_id')),
        'has_specialization_id' => $request->has('specialization_id'),
        'content_type' => $request->header('Content-Type')
    ]);

    return response()->json([
        'success' => true,
        'received_params' => [
            'all' => $request->all(),
            'hospital_id' => $request->input('hospital_id'),
            'date' => $request->input('date'),
            'specialization_id' => $request->input('specialization_id'),
            'specialization_id_type' => gettype($request->input('specialization_id'))
        ]
    ]);
});
