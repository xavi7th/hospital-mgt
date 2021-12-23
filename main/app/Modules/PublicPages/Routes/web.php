<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PublicPages\Http\Controllers\PublicPagesController;

Route::prefix('')->group(function () {
  Route::get('/', [PublicPagesController::class, 'index'])->name('app.home')->defaults('menu', __e('Home', null, 'fa-user', 1, false, 'Home', 1));
});
