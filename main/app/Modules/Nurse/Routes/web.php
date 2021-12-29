<?php

use App\Modules\Nurse\Models\Nurse;
use Illuminate\Support\Facades\Route;
use App\Modules\Nurse\Http\Controllers\NurseController;


Route::prefix('nurses')->name('nurses.')->group(function () {
  Route::middleware(['auth', 'activated', 'active'])->group(function () {
    Route::get('dashboard', [NurseController::class,'index'])->name('dashboard')->defaults('menu', __e('Dashboard', 'accessDashboard,' . Nurse::class, 'home', 1, false, null, 1));

    if (config('app.can_update_profile')) {
      Route::get('profile', [NurseController::class,'profile'])->name('profile')->defaults('menu', __e('Profile', 'updateProfile,' . Nurse::class, 'user', 8, false));
      Route::post('profile', [NurseController::class,'updateAvatar']);
    }
  });

  Route::middleware('auth:' . collect(config('auth.guards'))->except(['web','api'])->keys()->implode(','))->group(function () {
    Route::get('', [NurseController::class, 'getAllNurses'])->name('index')->defaults('menu', __e('Manage Nurses', 'viewAny,' . Nurse::class, 'users', 2, false, 'Manage Users', 1));
    Route::post('create', [NurseController::class, 'store'])->name('create');
    Route::put('{nurse}/update', [NurseController::class, 'update'])->name('update');
    Route::put('{nurse}/suspend', [NurseController::class, 'suspend'])->name('suspend');
    Route::put('{nurse}/unsuspend', [NurseController::class, 'unsuspend'])->name('unsuspend');
    Route::put('{nurse}/activate', [NurseController::class, 'activate'])->name('activate');
    Route::delete('{nurse}/delete', [NurseController::class, 'delete'])->name('delete');
  });
});
