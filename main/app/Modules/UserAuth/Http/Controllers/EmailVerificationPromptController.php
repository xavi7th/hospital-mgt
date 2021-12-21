<?php

namespace App\Modules\UserAuth\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Providers\RouteServiceProvider;

class EmailVerificationPromptController extends Controller
{
  /**
   * Display the email verification prompt.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return mixed
   */
  public function __invoke(Request $request)
  {
    if (Gate::allows('verify-email')) {
      return $request->user()->hasVerifiedEmail()
        ? redirect()->intended(RouteServiceProvider::HOME)
        : Inertia::render('UserAuth::VerifyEmail')->withViewData([
          'title' => 'Email Verification Needed'
        ]);
    }
  }
}
