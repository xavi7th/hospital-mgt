<?php

namespace App\Modules\UserAuth\Http\Controllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Modules\UserAuth\Http\Requests\RegistrationRequest;

class RegistrationController extends Controller
{

  public function create()
  {
    return Inertia::render('UserAuth::Register')->withViewData([
      'title' => 'New Registration'
    ]);
  }

  public function store(RegistrationRequest $request)
  {
    $request->register();

    session()->flash('flash', ['success' => 'Account created. A verification link has been sent to your email. Click the link to verify your account.']);

    return Inertia::location(route('auth.login'));
  }
}
