<?php

use Illuminate\Support\Facades\Route;
use App\Modules\UserAuth\Http\Controllers\AuthenticationController;

Route::name('auth.')->group(function () {

  Route::middleware('guest:' . collect(config('auth.guards'))->keys()->implode(','))->group(function (){
    Route::get('/login', [AuthenticationController::class, 'create'])->name('login')->defaults('menu', __e('Login', null, 'fa-user', 0, true));
    Route::post('/login', [AuthenticationController::class, 'store']);
  });
});

Route::middleware('auth:' . collect(config('auth.guards'))->keys()->implode(','))->group(function (){


  Route::get('/logout', [AuthenticationController::class, 'redirectToLogin']);
  Route::post('/logout', [AuthenticationController::class, 'destroy'])->name('auth.logout');
});
