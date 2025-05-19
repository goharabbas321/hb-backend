<?php

use App\Http\Middleware\CheckUserStatus;
use Illuminate\Support\Facades\Route;
use Modules\Medical\Http\Controllers\AppointmentController;
use Modules\Medical\Http\Controllers\CityController;
use Modules\Medical\Http\Controllers\DoctorController;
use Modules\Medical\Http\Controllers\FacilityController;
use Modules\Medical\Http\Controllers\HospitalController;
use Modules\Medical\Http\Controllers\MedicalController;
use Modules\Medical\Http\Controllers\SpecializationController;

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
                // Medical Dashboard
                Route::get('/medical', [MedicalController::class, 'index'])->middleware(['can:read_hospitals'])->name('medical.index');

                // Hospitals
                Route::prefix('/hospitals')->name('hospitals.')->group(function () {
                    Route::get('/', [HospitalController::class, 'index'])->middleware(['can:read_hospitals'])->name('index');
                    Route::get('/create', [HospitalController::class, 'create'])->middleware(['can:create_hospitals'])->name('create');
                    Route::post('/store', [HospitalController::class, 'store'])->middleware(['can:create_hospitals'])->name('store');
                    Route::get('/show/{hospital}', [HospitalController::class, 'show'])->middleware(['can:read_hospitals'])->name('show');
                    Route::get('/{hospital}/edit', [HospitalController::class, 'edit'])->middleware(['can:update_hospitals'])->name('edit');
                    Route::put('/{hospital}', [HospitalController::class, 'update'])->middleware(['can:update_hospitals'])->name('update');
                    Route::delete('/{hospital}', [HospitalController::class, 'destroy'])->middleware(['can:delete_hospitals'])->name('destroy');
                    Route::post('/bulk-action', [HospitalController::class, 'bulkAction'])->middleware(['can:delete_hospitals'])->name('bulk_action');
                    Route::post('/data/{id}', [HospitalController::class, 'getData'])->middleware(['can:read_hospitals'])->name('data');
                });

                // Doctors
                Route::prefix('/doctors')->name('doctors.')->group(function () {
                    Route::get('/', [DoctorController::class, 'index'])->middleware(['can:read_doctors'])->name('index');
                    Route::get('/create', [DoctorController::class, 'create'])->middleware(['can:create_doctors'])->name('create');
                    Route::post('/store', [DoctorController::class, 'store'])->middleware(['can:create_doctors'])->name('store');
                    Route::get('/show/{doctor}', [DoctorController::class, 'show'])->middleware(['can:read_doctors'])->name('show');
                    Route::get('/{doctor}/edit', [DoctorController::class, 'edit'])->middleware(['can:update_doctors'])->name('edit');
                    Route::put('/{doctor}', [DoctorController::class, 'update'])->middleware(['can:update_doctors'])->name('update');
                    Route::delete('/{doctor}', [DoctorController::class, 'destroy'])->middleware(['can:delete_doctors'])->name('destroy');
                    Route::post('/bulk-action', [DoctorController::class, 'bulkAction'])->middleware(['can:delete_doctors'])->name('bulk_action');
                    Route::post('/data/{id}', [DoctorController::class, 'getData'])->middleware(['can:read_doctors'])->name('data');
                });

                // Specializations
                Route::prefix('/specializations')->name('specializations.')->group(function () {
                    Route::get('/', [SpecializationController::class, 'index'])->middleware(['can:read_specializations'])->name('index');
                    Route::get('/create', [SpecializationController::class, 'create'])->middleware(['can:create_specializations'])->name('create');
                    Route::post('/store', [SpecializationController::class, 'store'])->middleware(['can:create_specializations'])->name('store');
                    Route::get('/{specialization}/edit', [SpecializationController::class, 'edit'])->middleware(['can:update_specializations'])->name('edit');
                    Route::put('/{specialization}', [SpecializationController::class, 'update'])->middleware(['can:update_specializations'])->name('update');
                    Route::delete('/{specialization}', [SpecializationController::class, 'destroy'])->middleware(['can:delete_specializations'])->name('destroy');
                    Route::post('/bulk-action', [SpecializationController::class, 'bulkAction'])->middleware(['can:delete_specializations'])->name('bulk_action');
                    Route::post('/data/{id}', [SpecializationController::class, 'getData'])->middleware(['can:read_specializations'])->name('data');
                });

                // Facilities
                Route::prefix('/facilities')->name('facilities.')->group(function () {
                    Route::get('/', [FacilityController::class, 'index'])->middleware(['can:read_facilities'])->name('index');
                    Route::get('/create', [FacilityController::class, 'create'])->middleware(['can:create_facilities'])->name('create');
                    Route::post('/store', [FacilityController::class, 'store'])->middleware(['can:create_facilities'])->name('store');
                    Route::get('/{facility}/edit', [FacilityController::class, 'edit'])->middleware(['can:update_facilities'])->name('edit');
                    Route::put('/{facility}', [FacilityController::class, 'update'])->middleware(['can:update_facilities'])->name('update');
                    Route::delete('/{facility}', [FacilityController::class, 'destroy'])->middleware(['can:delete_facilities'])->name('destroy');
                    Route::post('/bulk-action', [FacilityController::class, 'bulkAction'])->middleware(['can:delete_facilities'])->name('bulk_action');
                    Route::post('/data/{id}', [FacilityController::class, 'getData'])->middleware(['can:read_facilities'])->name('data');
                });

                // Cities
                Route::prefix('/cities')->name('cities.')->group(function () {
                    Route::get('/', [CityController::class, 'index'])->middleware(['can:read_cities'])->name('index');
                    Route::get('/create', [CityController::class, 'create'])->middleware(['can:create_cities'])->name('create');
                    Route::post('/store', [CityController::class, 'store'])->middleware(['can:create_cities'])->name('store');
                    Route::get('/{city}/edit', [CityController::class, 'edit'])->middleware(['can:update_cities'])->name('edit');
                    Route::put('/{city}', [CityController::class, 'update'])->middleware(['can:update_cities'])->name('update');
                    Route::delete('/{city}', [CityController::class, 'destroy'])->middleware(['can:delete_cities'])->name('destroy');
                    Route::post('/bulk-action', [CityController::class, 'bulkAction'])->middleware(['can:delete_cities'])->name('bulk_action');
                    Route::post('/data/{id}', [CityController::class, 'getData'])->middleware(['can:read_cities'])->name('data');
                });

                // Appointments
                Route::prefix('/appointments')->name('appointments.')->group(function () {
                    Route::get('/', [AppointmentController::class, 'index'])->middleware(['can:read_appointments'])->name('index');
                    Route::get('/create', [AppointmentController::class, 'create'])->middleware(['can:create_appointments'])->name('create');
                    Route::post('/store', [AppointmentController::class, 'store'])->middleware(['can:create_appointments'])->name('store');
                    Route::get('/show/{appointment}', [AppointmentController::class, 'show'])->middleware(['can:read_appointments'])->name('show');
                    Route::get('/{appointment}/edit', [AppointmentController::class, 'edit'])->middleware(['can:update_appointments'])->name('edit');
                    Route::put('/{appointment}', [AppointmentController::class, 'update'])->middleware(['can:update_appointments'])->name('update');
                    Route::delete('/{appointment}', [AppointmentController::class, 'destroy'])->middleware(['can:delete_appointments'])->name('destroy');
                    Route::post('/bulk-action', [AppointmentController::class, 'bulkAction'])->middleware(['can:delete_appointments'])->name('bulk_action');
                    Route::post('/data/{id}', [AppointmentController::class, 'getData'])->middleware(['can:read_appointments'])->name('data');
                });
            });
        });
    }
);
