<?php

use App\Modules\Doctor\Models\Doctor;
use Illuminate\Support\Facades\Route;
use App\Modules\Doctor\Http\Controllers\DoctorController;


Route::prefix('doctors')->name('doctors.')->group(function () {
  Route::middleware(['auth', 'activated', 'active'])->group(function () {
    Route::get('dashboard', [DoctorController::class,'index'])->name('dashboard')->defaults('menu', __e('Dashboard', 'accessDashboard,' . Doctor::class, 'home', 1, false, null, 1));

    if (config('app.can_update_profile')) {
      Route::get('profile', [DoctorController::class,'profile'])->name('profile')->defaults('menu', __e('Profile', 'updateProfile,' . Doctor::class, 'user', 8, false));
      Route::post('profile', [DoctorController::class,'updateAvatar']);
    }
  });

  Route::middleware('auth:' . collect(config('auth.guards'))->except(['web','api'])->keys()->implode(','))->group(function () {
    Route::get('', [DoctorController::class, 'getAllDoctors'])->name('index')->defaults('menu', __e('Manage Doctors', 'viewAny,' . Doctor::class, 'users', 2, false, 'Manage Users', 1));
    Route::post('create', [DoctorController::class, 'store'])->name('create');
    Route::put('{doctor}/update', [DoctorController::class, 'update'])->name('update');
    Route::put('{doctor}/suspend', [DoctorController::class, 'suspend'])->name('suspend');
    Route::put('{doctor}/unsuspend', [DoctorController::class, 'unsuspend'])->name('unsuspend');
    Route::put('{doctor}/activate', [DoctorController::class, 'activate'])->name('activate');
    Route::delete('{doctor}/delete', [DoctorController::class, 'delete'])->name('delete');
  });
});
