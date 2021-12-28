<?php

use App\Modules\Appointment\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/{date?}', [AppointmentController::class, 'index'])->name('index');
    Route::post('{patient}/create', [AppointmentController::class, 'store'])->name('create')->middleware('auth:front_desk_user');
    Route::put('{appointment}/post-for-vitals', [AppointmentController::class, 'postForVitals'])->name('post_for_vitals');
    Route::delete('{appointment}/cancel', [AppointmentController::class, 'destroy'])->name('delete');
});
