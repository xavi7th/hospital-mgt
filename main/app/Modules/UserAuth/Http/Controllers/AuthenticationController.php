<?php

namespace App\Modules\UserAuth\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\UserAuth\Http\Requests\LoginRequest;

class AuthenticationController extends Controller
{
  /**
  * Display the login view.
  *
  * @return \Illuminate\View\View
  */
  public function create()
  {
    return Inertia::render('UserAuth::Login',[
      'can_reset_password' => Route::has('password.request'),
      'status' => session('status'),
    ])->withViewData([
      'title' => 'Login to Dashboard'
    ]);
  }

  /**
  * Handle an incoming authentication request.
  *
  * @return \Illuminate\Http\RedirectResponse
  */
  public function store(LoginRequest $request)
  {
    $request->authenticate();
    $request->session()->regenerate();

    $path = session()->pull('url.intended', route(auth()->guard($request->getAuthenticatedGuard())->user()->dashboardRoute()));

    session()->reflash();

    return  request()->header('X-Inertia') ? Inertia::location($path) : redirect()->intended($path);
  }

  public function redirectToLogin(Request $request)
  {
    return request()->header('X-Inertia') ? Inertia::location(route('auth.login')) : redirect('/');
  }

  /**
  * Destroy an authenticated session.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\RedirectResponse
  */
  public function destroy(Request $request)
  {
    $request->user()->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return request()->header('X-Inertia') ? Inertia::location(route('auth.login')) : redirect('/login');
  }
}
