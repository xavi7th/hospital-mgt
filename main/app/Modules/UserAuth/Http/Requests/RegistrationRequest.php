<?php

namespace App\Modules\UserAuth\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Registered;
use App\Modules\FrontDeskUser\Models\FrontDeskUser;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class RegistrationRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  protected function prepareForValidation(): void
  {
    $first_name = Str::of($this->full_name)->beforeLast(" ")->__toString();
    $last_name = Str::of($this->full_name)->afterLast(" ")->__toString();
    $this->merge([
      'first_name' => $first_name,
      'last_name' => $last_name,
      'enc_pw' => $this->password
    ]);
  }

  public function rules():array
  {
    return [
      'first_name' => 'required|string|max:50',
      'last_name' => 'required|string|max:50',
      'email' => 'required|string|email|max:100|unique:front_desk_users',
      'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
      'phone' => 'required|string|max:50',
      'avatar' => 'nullable|image',
      'country' => 'nullable|string|max:50',
      'acc_type' => 'nullable|string|max:30',
      'acc_type_color' => 'nullable|string|max:30',
      'currency' => 'nullable|string|max:5',
      'enc_pw' => ''
    ];
  }

  /**
   * Attempt to create the user account
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function register(): FrontDeskUser
  {
    RateLimiter::hit($this->throttleKey());

    $this->ensureIsNotRateLimited();

    try {
      $front_desk_user = FrontDeskUser::create($this->validated());
    } catch (\Throwable $th) {
      logger()->critical($th);
      throw ValidationException::withMessages([
        'email' => 'There was an error creating your account.',
      ]);
    }

    event(new Registered($front_desk_user));

    return $front_desk_user;
  }

  /**
   * Ensure the registration request is not rate limited.
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function ensureIsNotRateLimited(): void
  {
    if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
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

  public function throttleKey(): string
  {
    return Str::lower($this->userAgent()) . '|' . $this->ip();
  }

  public function validated(): array
  {
    if ($this->hasFile('avatar')) {
      return array_merge((collect(parent::validated())->except('avatar'))->all(), [
        'avatar_url' => compress_image_upload('avatar', 'user-avatars/', 'user-avatars/thumbs/', 1920, true, 200)['thumb_url'],
      ]);
    } else {
      return parent::validated();
    }
  }
}
