<?php

namespace App\Modules\UserAuth\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Providers\RouteServiceProvider;

class EmailVerificationNotificationController extends Controller
{

  /**
   * Send a new email verification notification.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    if (Gate::allows('verify-email')) {
      if ($request->user()->hasVerifiedEmail()) {
        return redirect()->intended(RouteServiceProvider::HOME);
      }

      $request->user()->sendEmailVerificationNotification();

      return back()->withFlash(['success'=> 'A new verification link has been sent to the email address you provided during registration.']);
    }
  }
}
