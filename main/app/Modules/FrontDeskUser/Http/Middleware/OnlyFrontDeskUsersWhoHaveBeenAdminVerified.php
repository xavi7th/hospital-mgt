<?php

namespace App\Modules\FrontDeskUser\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyFrontDeskUsersWhoHaveBeenAdminVerified
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
    if (config('app.must_activate_users') && $request->user()->isFrontDeskUser() && $request->user()->hasUploadedId() && ! $request->user()->isAaccountActivated() ) {
      return redirect()->route('frontdeskusers.activation.pending');
    }
    return $next($request);
  }
}
