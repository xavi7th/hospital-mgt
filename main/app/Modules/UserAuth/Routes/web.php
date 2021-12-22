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
  });
});

Route::middleware('auth:' . collect(config('auth.guards'))->keys()->implode(','))->group(function (){


  Route::get('/logout', [AuthenticationController::class, 'redirectToLogin']);
  Route::post('/logout', [AuthenticationController::class, 'destroy'])->name('auth.logout');
});
