<?php

namespace App\Modules\UserAuth\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class UserAuthenticationServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array
   */
  protected $policies = [
    // 'App\Models\Model' => 'App\Policies\ModelPolicy',
  ];

  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot()
  {
    Gate::define('verify-email', 'App\Modules\UserAuth\Policies\UserAuthPolicy@verify');
    Gate::define('accept-terms', 'App\Modules\UserAuth\Policies\UserAuthPolicy@acceptTerms');
    Gate::define('upload-id', 'App\Modules\UserAuth\Policies\UserAuthPolicy@uploadID');
    Gate::define('await-verification', 'App\Modules\UserAuth\Policies\UserAuthPolicy@awaitActivation');
  }
}
