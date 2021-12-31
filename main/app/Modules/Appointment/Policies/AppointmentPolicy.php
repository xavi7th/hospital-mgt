<?php

namespace App\Modules\Appointment\Policies;

use App\Models\User;
use App\Modules\Appointment\Models\Appointment;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
{
  use HandlesAuthorization;

  public function viewAny(User $user)
  {
    return $user->isFrontDeskUser() ? $this->allow() : $this->deny('You cannot view registered appointments.');
  }

  public function view(User $user)
  {
    return false ? $this->allow() : $this->deny('You cannot create this appointment\'s details.');
  }

  public function create(User $user)
  {
    return $user->isFrontDeskUser() ? $this->allow() : $this->deny('You cannot create appointments.');
  }

  public function postForVitals(User $user, Appointment $appointment)
  {
    return $user->isFrontDeskUser() && is_null($appointment->posted_at) ? $this->allow() : $this->deny('You cannot post this appointment for vitals.');
  }

  public function delete(User $user, Appointment $appointment)
  {
    return $user->isFrontDeskUser() && is_null($appointment->nurse_id) ? $this->allow() : $this->deny('You cannot delete this appointment.');
  }

}
