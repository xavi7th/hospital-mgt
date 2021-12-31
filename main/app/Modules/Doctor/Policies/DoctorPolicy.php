<?php

namespace App\Modules\Doctor\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DoctorPolicy
{
  use HandlesAuthorization;

  public function accessDashboard(User $user)
  {
    return $user->isDoctor() ? $this->allow() : $this->deny('You cannot view doctor\'s dashboard.');
  }

  public function viewAny(User $user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot view registered doctors.');
  }

  public function create(User $user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot create doctors.');
  }

  public function activate(User $user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot activate doctors.');
  }

  public function suspend(User $user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot suspend doctors.');
  }

  public function delete(User $user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot delete doctors.');
  }

}
