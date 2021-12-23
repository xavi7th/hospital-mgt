<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class HandleInertiaRequests extends Middleware
{
  /**
   * The root template that's loaded on the first page visit.
   *
   * @see https://inertiajs.com/server-side-setup#root-template
   * @var string
   */
  protected $rootView = 'publicpages::app';

  /**
   * Determines the current asset version.
   *
   * @see https://inertiajs.com/asset-versioning
   * @param  \Illuminate\Http\Request  $request
   * @return string|null
   */
  public function version(Request $request)
  {
    if (file_exists($manifest = public_path('mix-manifest.json'))) {
      return md5_file($manifest);
    }

    return parent::version($request);
  }

  /**
   * Defines the props that are shared by default.
   *
   * @see https://inertiajs.com/shared-data
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function share(Request $request)
  {
    return array_merge(parent::share($request), [
      'app' => fn () => [
        'name' => config('app.name'),
        'whatsapp' => config('app.whatsapp'),
        'address' => config('app.address'),
        'phone' => config('app.phone'),
        'email' => config('app.email'),
        'facebook' => config('app.facebook'),
        'instagram' => config('app.instagram'),
        'twitter' => config('app.twitter'),
        'opening_days' => config('app.opening_days'),
        'opening_hours' => config('app.opening_hours'),
      ],
      'isInertiaRequest' => (bool)request()->header('X-Inertia'),
      'authuser' => fn (Request $request) => $request->user() ? collect($request->user())->merge(request()->user()->getUserType()) : (object)[],
      'flash' => fn () => Session::get('flash') ?? (object)[],
    ]);
  }

  /**
   * Sets the root template that's loaded on the first page visit.
   *
   * @see https://inertiajs.com/server-side-setup#root-template
   * @param Request $request
   * @return string
   */
  public function rootView(Request $request): string
  {
    //! Don't return appuser blade for auth user when on public pages
    if ($request->user()  && ! Str::contains(Route::currentRouteName(), 'app.')) {
      return strtolower($request->user()->getType()) . '::app';
    }
     elseif (Str::contains(Route::currentRouteName(), 'auth')) {
      return 'userauth::app';
    }
     else {
      return $this->rootView;
    }
  }

  /**
   * Resolves and prepares validation errors in such
   * a way that they are easier to use client-side.
   *
   * @param  Request  $request
   * @return object
   */
  public function resolveValidationErrors(Request $request): object
  {
    if (!$request->session()->has('errors') && !$request->session()->has('flash.error')) {
      return (object) [];
    }

    if ($request->session()->has('errors')) {
      return (object) collect($request->session()->get('errors')->getBags())->map(function ($bag) {
        return (object) collect($bag->messages())->map(function ($errors) {
          return $errors[0];
        })->toArray();
      })->pipe(function ($bags) use ($request) {
        if ($bags->has('default') && $request->header('x-inertia-error-bag')) {
          return [$request->header('x-inertia-error-bag') => $bags->get('default')];
        } elseif ($bags->has('default')) {
          return $bags->get('default');
        } else {
          return $bags->toArray();
        }
      });
    } elseif ($request->session()->has('flash.error')) {
      return (object) $request->session()->get('flash');
    }
  }
}
