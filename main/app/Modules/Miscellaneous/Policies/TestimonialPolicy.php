<?php

namespace App\Modules\Miscellaneous\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestimonialPolicy
{
  use HandlesAuthorization;

  public function viewAny(User $user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot view testimonials.');
  }

  public function create(User $user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot create testimonials.');
  }

  public function delete(User $user)
  {
    return $user->isSuperAdmin() ? $this->allow() : $this->deny('You cannot create testimonials.');
  }
}
