<?php

namespace App\Modules\UserAuth\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use App\Modules\FrontDeskUser\Models\FrontDeskUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Modules\UserAuth\Providers\UserAuthenticationServiceProvider;

class UserAuthServiceProvider extends ServiceProvider
{
  /**
   * @var string $moduleName
   */
  protected $moduleName = 'UserAuth';

  /**
   * @var string $moduleNameLower
   */
  protected $moduleNameLower = 'userauth';

  /**
   * Boot the application events.
   *
   * @return void
   */
  public function boot()
  {
    // $this->registerTranslations();
    // $this->registerConfig();
    $this->registerViews();
    $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    $this->registerEmailVerificationUrl();

    /**
     * Used to register policies
     */
    $this->app->register(UserAuthenticationServiceProvider::class);
  }

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    $this->app->register(RouteServiceProvider::class);
  }

  /**
   * Register config.
   *
   * @return void
   */
  protected function registerConfig()
  {
    $this->publishes([
      module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
    ], 'config');
    $this->mergeConfigFrom(
      module_path($this->moduleName, 'Config/config.php'),
      $this->moduleNameLower
    );
  }

  /**
   * Register views.
   *
   * @return void
   */
  public function registerViews()
  {
    $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

    $sourcePath = module_path($this->moduleName, 'Resources/views');

    $this->publishes([
      $sourcePath => $viewPath
    ], ['views', $this->moduleNameLower . '-module-views']);

    $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
  }

  /**
   * Register translations.
   *
   * @return void
   */
  public function registerTranslations()
  {
    $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

    if (is_dir($langPath)) {
      $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
    } else {
      $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
    }
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return [];
  }

  private function getPublishableViewPaths(): array
  {
    $paths = [];
    foreach (Config::get('view.paths') as $path) {
      if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
        $paths[] = $path . '/modules/' . $this->moduleNameLower;
      }
    }
    return $paths;
  }

  private function registerEmailVerificationUrl()
  {
    VerifyEmail::createUrlUsing(function (FrontDeskUser $front_desk_user) {
      return URL::temporarySignedRoute('frontdeskusers.verification.verify', now()->addMinutes(config('auth.verification.expire', 60)),[
        'id' => $front_desk_user->getKey(),
        'hash' => sha1($front_desk_user->getEmailForVerification()),
      ]);
    });

    // ResetPassword::createUrlUsing(function ($user, string $token) {
    //   $url = url(route('auth.password.reset', [
    //     'token' => $token,
    //     'email' => $user->getEmailForPasswordReset(),
    // ], false));

    //   return $url;
    // });
  }
}
