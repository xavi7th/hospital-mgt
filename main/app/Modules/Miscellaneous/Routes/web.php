<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Miscellaneous\Http\Controllers\MiscellaneousController;

Route::middleware(['auth:' . collect(config('auth.guards'))->except(['web','api'])->keys()->implode(','), 'unactivated'])->name('activation.')->group(function () {
  Route::get('activation-pending', [MiscellaneousController::class,'activationPending'])->name('pending');
});
