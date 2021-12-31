<?php

use Illuminate\Support\Facades\Route;
use App\Modules\CaseNote\Http\Controllers\CaseNoteController;

Route::prefix('case-notes')->name('casenotes.')->group(function() {
  Route::get('{appointment}', [CaseNoteController::class, 'index'])->name('index')->middleware('auth:doctor,nurse');
  Route::post('{appointment}/create', [CaseNoteController::class, 'store'])->name('create')->middleware('auth:doctor');
  Route::put('{case_note}', [CaseNoteController::class, 'show'])->name('show')->middleware('auth:doctor,nurse');
});
