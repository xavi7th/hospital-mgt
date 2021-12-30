<?php

namespace App\Modules\Patient\Policies;

use App\Models\User;
use App\Modules\Patient\Models\Patient;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientPolicy
{
  use HandlesAuthorization;

  public function viewAny(User $user)
  {
    return $user->isFrontDeskUser() ? $this->allow() : $this->deny('You cannot view registered patients.');
  }

  public function takePatientsVitals(User $user)
  {
    return $user->isNurse() ? $this->allow() : $this->deny('You cannot view take patients vital signs.');
  }

  public function view(User $user, Patient $patient)
  {
    return false ? $this->allow() : $this->deny('You cannot view this patient\'s details.');
  }

  public function create(User $user)
  {
    return $user->isFrontDeskUser() ? $this->allow() : $this->deny('You cannot create patients.');
  }
}
