<?php

namespace App\Modules\CaseNote\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CaseNotePolicy
{
  use HandlesAuthorization;


  public function viewAny(User $user)
  {
    return $user->isDoctor() || $user->isNurse() ? $this->allow() : $this->deny('You cannot view registered case notes.');
  }

  public function view(User $user)
  {
    return false? $this->allow() : $this->deny('You cannot create this case note\'s details.');
  }

  public function create(User $user)
  {
    return $user->isDoctor() ? $this->allow() : $this->deny('You cannot create case notes.');
  }
}
