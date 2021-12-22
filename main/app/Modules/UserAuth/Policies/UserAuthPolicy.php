<?php

namespace App\Modules\UserAuth\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * This policy is registered via a Gate in the UserAuthenticationServiceProvider::class
 */
class UserAuthPolicy
{
  use HandlesAuthorization;

  public function awaitActivation(User $user)
  {
    return config('app.must_activate_users') && $user->isFrontDeskUser() && $user->hasUploadedId() && ! $user->isAaccountActivated() ? $this->allow() : $this->deny('Your account has been verified by our financial team already. Please visit your dashboard instead.');
  }

}
