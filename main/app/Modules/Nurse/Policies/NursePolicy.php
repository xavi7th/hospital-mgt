<?php

namespace App\Modules\Nurse\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NursePolicy
{
  use HandlesAuthorization;


  public function accessDashboard(User $user)
  {
    return $user->isNurse() ? $this->allow() : $this->deny('You cannot view nurse\'s dashboard.');
  }

  public function viewAny(User $user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot view registered nurses.');
  }

  public function create(User $user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot create nurses.');
  }

  public function activate(User $user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot activate nurses.');
  }

  public function suspend(User $user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot suspend nurses.');
  }

  public function unsuspend(User $user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot unsuspend nurses.');
  }

  public function delete(User $user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot delete nurses.');
  }
}
