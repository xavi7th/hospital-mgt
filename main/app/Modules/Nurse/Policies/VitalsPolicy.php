<?php

namespace App\Modules\Nurse\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class VitalsPolicy
{
  use HandlesAuthorization;

  public function viewAny(User $user)
  {
    return false ? $this->allow() : $this->deny('You cannot view registered vital signs.');
  }

  public function view(User $user)
  {
    return false ? $this->allow() : $this->deny('You cannot create this vital sign\'s details.');
  }

  public function create(User $user)
  {
    return $user->isNurse() ? $this->allow() : $this->deny('You cannot create vital signs.');
  }
}
