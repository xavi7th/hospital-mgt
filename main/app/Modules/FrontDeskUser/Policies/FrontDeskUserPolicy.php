<?php

namespace App\Modules\FrontDeskUser\Policies;

use App\Models\User;
use App\Modules\FrontDeskUser\Models\FrontDeskUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class FrontDeskUserPolicy
{
  use HandlesAuthorization;

  public function accessDashboard(User $user)
  {
    return $user->isFrontDeskUser() ? $this->allow() : $this->deny('You cannot view user dashboard.');
  }

  public function viewAny(User $user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot view registered users.');
  }

  public function view(User $user, FrontDeskUser $front_desk_user)
  {
    return $user->isSuperAdmin() || $user->is($front_desk_user) ? $this->allow() : $this->deny('You cannot this user\'s details.');
  }

  public function create(User $user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot create app users.');
  }

  public function update(User $user, FrontDeskUser $front_desk_user)
  {
    return $user->isSuperAdmin() || $user->is($front_desk_user) ? $this->allow() : $this->deny('You cannot update this user profile.');
  }

  public function updateProfile(User $user)
  {
    return config('app.can_update_profile') && $user->isFrontDeskUser() ? $this->allow() : $this->deny('You cannot update your profile details.');
  }

  public function suspend(User $user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot suspend users.');
  }

  public function unsuspend(User $user, FrontDeskUser $front_desk_user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot suspend users.');
  }

  public function activate(User $user)
  {
    return config('app.must_activate_users') && $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot activate suspended users.');
  }

  public function delete(User $user)
  {
    return config('app.can_delete_users') && $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot delete users.');
  }
}
