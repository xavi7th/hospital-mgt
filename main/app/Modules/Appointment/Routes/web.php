<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Nurse\Http\Controllers\VitalsController;
use App\Modules\Appointment\Http\Controllers\AppointmentController;

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

Route::prefix('appointments')->name('appointments.')->group(function() {
    Route::get('/{date?}', [AppointmentController::class, 'index'])->name('index')->middleware('auth:front_desk_user');
    Route::post('{patient}/create', [AppointmentController::class, 'store'])->name('create')->middleware('auth:front_desk_user');
    Route::put('{appointment}/post-for-vitals', [AppointmentController::class, 'postForVitals'])->name('post_for_vitals')->middleware('auth:front_desk_user');
    Route::delete('{appointment}/cancel', [AppointmentController::class, 'destroy'])->name('delete')->middleware('auth:front_desk_user');


    Route::post('{appointment}/vitals/create', [VitalsController::class, 'store'])->name('vitals.create')->middleware('auth:nurse');
  });
