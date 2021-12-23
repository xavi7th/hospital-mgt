<?php

use App\Modules\Patient\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::prefix('patients')->name('patients.')->group(function() {
    Route::get('/', [PatientController::class, 'index'])->name('show');
    Route::post('/create', [PatientController::class, 'store'])->name('create');
});
