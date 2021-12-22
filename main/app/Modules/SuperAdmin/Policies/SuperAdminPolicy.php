<?php

namespace App\Modules\SuperAdmin\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SuperAdminPolicy
{
  use HandlesAuthorization;

  public function accessDashboard(User $user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot access admin dashboard.');
  }
}
