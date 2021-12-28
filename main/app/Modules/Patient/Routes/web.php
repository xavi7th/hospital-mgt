<?php

use App\Modules\Patient\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::prefix('patients')->name('patients.')->group(function() {
    Route::get('/', [PatientController::class, 'index'])->name('index');
    Route::post('/create', [PatientController::class, 'store'])->name('create');

    Route::get('{patient}', [PatientController::class, 'show'])->name('show');
});
