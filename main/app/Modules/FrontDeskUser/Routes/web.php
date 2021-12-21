<?php

use App\Modules\FrontDeskUser\Http\Controllers\FrontDeskUserController;
use Illuminate\Support\Facades\Route;
use App\Modules\FrontDeskUser\Models\FrontDeskUser;

Route::prefix(FrontDeskUser::DASHBOARD_ROUTE_PREFIX)->name(FrontDeskUser::ROUTE_NAME_PREFIX)->group(function () {

  Route::middleware(['auth', 'verified'])->name('activation.')->group(function () {
    Route::get('activation-pending', [FrontDeskUserController::class,'activationPending'])->name('pending');
  });

  Route::middleware(['auth', 'activated', 'active'])->group(function () {
    Route::get('dashboard', [FrontDeskUserController::class,'index'])->name('dashboard')->defaults('menu', __e('Dashboard', 'accessDashboard,' . FrontDeskUser::class, 'home', 1, false, null, 1));
    if (config('app.can_update_profile')) {
      Route::get('profile', [FrontDeskUserController::class,'profile'])->name('profile')->defaults('menu', __e('Profile', 'updateProfile,' . FrontDeskUser::class, 'user', 8, false));
      Route::post('profile', [FrontDeskUserController::class,'updateAvatar']);
    }
  });

  Route::middleware('auth:' . collect(config('auth.guards'))->except(['web','api'])->keys()->implode(','))->group(function () {
    Route::get('', [FrontDeskUserController::class, 'getAllFrontDeskUsers'])->name('list')->defaults('menu', __e('Manage Front Desk Users', 'viewAny,' . FrontDeskUser::class, 'users', 2, false, 'Manage Users', 1));
    Route::put('{front_desk_user}/update', [FrontDeskUserController::class, 'updateFrontDeskUser'])->name('update');
    Route::put('{front_desk_user}/suspend', [FrontDeskUserController::class, 'suspendFrontDeskUser'])->name('suspend');
    Route::put('{front_desk_user}/unsuspend', [FrontDeskUserController::class, 'unsuspendFrontDeskUser'])->name('unsuspend');
    Route::put('{front_desk_user}/activate', [FrontDeskUserController::class, 'activateFrontDeskUserAccount'])->name('activate');
    Route::delete('{front_desk_user}/delete', [FrontDeskUserController::class, 'deleteFrontDeskUserAccount'])->name('delete');
  });
});
