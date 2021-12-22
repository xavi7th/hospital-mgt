<?php

namespace App\Modules\SuperAdmin\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\FrontDeskUser\Models\FrontDeskUser;
use App\Modules\SuperAdmin\Models\SuperAdmin;

class SuperAdminController extends Controller
{
  public function index(Request $request)
  {
    $this->authorize('accessDashboard', SuperAdmin::class);

    return Inertia::render('SuperAdmin::SuperAdminDashboard', self::getDashboardStatistics())->withViewData([
      'title' => 'Super Admin Dashboard',
      'metaDesc' => ' This page is ...'
    ]);
  }


  static function getDashboardStatistics()
  {
    return [
      'statistics' => fn () => [
        'total_users_count' => (int)FrontDeskUser::count(),
        'unverified_users_count' => (int) FrontDeskUser::unverified()->count(),
      ]
    ];
  }
}
