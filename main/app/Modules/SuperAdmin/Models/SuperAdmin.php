<?php

namespace App\Modules\SuperAdmin\Models;

use App\Models\User;
use App\Modules\UserAuth\Traits\IsStaff;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\SuperAdmin\Database\Factories\SuperAdminFactory;

class SuperAdmin extends User
{
  use HasFactory, IsStaff, SoftDeletes;

  const ROUTE_NAME_PREFIX = 'superadmins.';
  const DASHBOARD_ROUTE_PREFIX = 'super-admins';

  protected $table = 'staff';

  public function getIsActiveAttribute()
  {
    return true;
  }

  protected static function newFactory()
  {
    return SuperAdminFactory::new();
  }
}
