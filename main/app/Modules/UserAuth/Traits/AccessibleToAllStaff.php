<?php

namespace App\Modules\UserAuth\Traits;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

trait AccessibleToAllStaff
{
  use AuthorizesRequests;

  public function __construct()
  {
    $this->middleware('auth:' . collect(config('auth.guards'))->keys()->implode(','));
  }
}
