<?php

namespace App\Modules\FrontDeskUser\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyActiveFrontDeskUsers
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    if ($request->user()->isFrontDeskUser() && ! $request->user()->is_active) {

      $request->user()->logout();

      return redirect()->route('auth.login')->withFlash(['error' => 'Your account has been suspended.']);
    }
    return $next($request);
  }
}
