<?php

use App\Modules\SuperAdmin\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\SuperAdmin;

Route::middleware(['auth:super_admin'])->prefix(SuperAdmin::DASHBOARD_ROUTE_PREFIX)->name(SuperAdmin::ROUTE_NAME_PREFIX)->group(function () {
  Route::get('/', [SuperAdminController::class, 'index'])->name('dashboard');
});
