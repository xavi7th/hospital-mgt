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

  public function verify(User $user)
  {
    return $user->isFrontDeskUser() && ! $user->hasVerifiedEmail() ? $this->allow() : $this->deny('Your email is already verified.');
  }

  public function acceptTerms(User $user)
  {
    return config('app.must_accept_terms') && $user->isFrontDeskUser() && ! $user->hasAcceptedTerms() ? $this->allow() : $this->deny('Your have accepted our trading terms already. Please visit your dashboard instead.');
  }

  public function uploadID(User $user)
  {
    return config('app.must_upload_id') && $user->isFrontDeskUser() && ! $user->hasUploadedId() ? $this->allow() : $this->deny('Your have verified your account already. Please visit your dashboard instead.');
  }

  public function awaitActivation(User $user)
  {
    return config('app.must_activate_users') && $user->isFrontDeskUser() && $user->hasUploadedId() && ! $user->isAaccountActivated() ? $this->allow() : $this->deny('Your account has been verified by our financial team already. Please visit your dashboard instead.');
  }

}
