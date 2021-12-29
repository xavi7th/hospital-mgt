<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Miscellaneous\Http\Controllers\MiscellaneousController;

Route::middleware(['auth', 'unactivated'])->name('activation.')->group(function () {
  Route::get('activation-pending', [MiscellaneousController::class,'activationPending'])->name('pending');
});
