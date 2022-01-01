<?php

use App\Modules\Patient\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::prefix('patients')->name('patients.')->group(function() {
    Route::get('/', [PatientController::class, 'index'])->name('index')->middleware('auth:' . collect(config('auth.guards'))->except(['web','api'])->keys()->implode(','));
    Route::post('/create', [PatientController::class, 'store'])->name('create')->middleware('auth:front_desk_user');
    Route::get('{patient}', [PatientController::class, 'show'])->name('show')->middleware('auth:front_desk_user');
});
