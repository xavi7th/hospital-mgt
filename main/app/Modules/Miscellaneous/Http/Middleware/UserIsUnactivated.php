<?php

namespace App\Modules\Miscellaneous\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserIsUnactivated
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
    if (config('app.must_activate_users') && $request->user()->isAccountActivated() ) {
      return redirect()->route($request->user()->dashboardRoute());
    }
    return $next($request);
  }
}
