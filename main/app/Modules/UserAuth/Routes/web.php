<?php

use Illuminate\Support\Facades\Route;
use App\Modules\UserAuth\Http\Controllers\NewPasswordController;
use App\Modules\UserAuth\Http\Controllers\RegistrationController;
use App\Modules\UserAuth\Http\Controllers\AuthenticationController;
use App\Modules\UserAuth\Http\Controllers\PasswordResetLinkController;

Route::name('auth.')->group(function () {

  Route::middleware('guest:' . collect(config('auth.guards'))->keys()->implode(','))->group(function (){
    Route::get('/register', [RegistrationController::class, 'create'])->name('register')->defaults('menu', __e('Register', null, 'fa-user', 0, true));
    Route::post('/register', [RegistrationController::class, 'store']);

    Route::get('/login', [AuthenticationController::class, 'create'])->name('login')->defaults('menu', __e('Login', null, 'fa-user', 0, true));
    Route::post('/login', [AuthenticationController::class, 'store']);

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request')->defaults('menu', __e('Forgot Password', null, 'fa-user', 0, true));
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset')->defaults('menu', __e('Reset Password', null, 'fa-user', 0, true));
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
  });
});

Route::middleware('auth:' . collect(config('auth.guards'))->keys()->implode(','))->group(function (){

  // Route::prefix(FrontDeskUser::DASHBOARD_ROUTE_PREFIX)->name(FrontDeskUser::ROUTE_NAME_PREFIX)->group(function () {
  //   Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice')->defaults('menu', __e('Verify Email', 'verify-email', 'fa-user', 0, true));
  //   Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify')->defaults('menu', __e('Attempt Verification', 'verify-email', 'fa-user', 0, true));
  //   Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware(['throttle:6,1'])->name('verification.send');

  //   Route::get('/confirm-password', [ConfirmPasswordController::class, 'show'])->name('password.confirm')->defaults('menu', __e('Confirm Password', null, 'fa-user', 0, true));
  //   Route::post('/confirm-password', [ConfirmPasswordController::class, 'store']);

  // });

  Route::get('/logout', [AuthenticationController::class, 'redirectToLogin']);
  Route::post('/logout', [AuthenticationController::class, 'destroy'])->name('auth.logout');
});
