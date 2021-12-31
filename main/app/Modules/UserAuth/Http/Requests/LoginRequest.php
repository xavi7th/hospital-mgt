<?php

namespace App\Modules\UserAuth\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
  private $authCheck = false;
  private $authGuard;

  /**
  * Determine if the user is authorized to make this request.
  *
  * @return bool
  */
  public function authorize()
  {
    return true;
  }

  /**
  * Get the validation rules that apply to the request.
  *
  * @return array
  */
  public function rules()
  {
    return [
      'email' => 'required|string|email',
      'password' => 'required|string',
    ];
  }

  /**
  * Attempt to authenticate the request's credentials.
  *
  * @return void
  *
  * @throws \Illuminate\Validation\ValidationException
  */
  public function authenticate()
  {
    $this->ensureIsNotRateLimited();

    if (! $this->attemptLogin()) {
      RateLimiter::hit($this->throttleKey());

      throw ValidationException::withMessages([
        'email' => __('auth.failed'),
      ]);
    }

    RateLimiter::clear($this->throttleKey());
  }

  /**
  * Ensure the login request is not rate limited.
  *
  * @return void
  *
  * @throws \Illuminate\Validation\ValidationException
  */
  public function ensureIsNotRateLimited()
  {
    if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
      return;
    }

    event(new Lockout($this));

    $seconds = RateLimiter::availableIn($this->throttleKey());

    throw ValidationException::withMessages([
      'email' => trans('auth.throttle', [
        'seconds' => $seconds,
        'minutes' => ceil($seconds / 60),
      ]),
    ]);
  }

  /**
  * Attempt to log the user into the one of the available guards.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return bool
  */
  protected function attemptLogin(): bool
  {
    collect(config('auth.guards'))->except(['api', 'web'])->each(function ($details, $guard) {
      if (Auth::guard($guard)->attempt($this->only($this->username(), 'password'), $this->boolean('remember'))) {
        $this->authCheck = true;
        $this->authGuard = $guard;
        return false;
      }
    });

    if ($this->authCheck && ! Auth::guard($this->authGuard)->user()->isSuperAdmin() && ! Auth::guard($this->authGuard)->user()->is_active) {
      $this->authGuard = false;

      Auth::guard($this->authGuard)->user()->logout();

      throw ValidationException::withMessages([
        'email' => 'Account Suspended! Contact your account administrator.',
      ]);
    }

    return $this->authCheck;
  }

  /**
  * Get the rate limiting throttle key for the request.
  *
  * @return string
  */
  public function throttleKey()
  {
    return Str::lower($this->input('email')).'|'.$this->ip();
  }

  /**
  * Get the login username to be used by the controller.
  *
  * @return string
  */
  public function username()
  {
    return 'email';
  }

  public function getAuthenticatedGuard()
  {
    return $this->authGuard;
  }
}
